<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\ClaimCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DeveloperClaimController extends Controller
{
    /* Claim List */

    public function index(Request $request): View
    {
        $user = auth()->user();

        $status = $request->query('status');

        $baseQuery = Claim::with(['category'])
            ->where('user_id', $user->id);

        $counts = [
            'all' => (clone $baseQuery)->count(),

            'submitted' => (clone $baseQuery)
                ->where('status', 'Submitted')
                ->count(),

            'approved' => (clone $baseQuery)
                ->where('status', 'Approved')
                ->count(),

            'rejected' => (clone $baseQuery)
                ->where('status', 'Rejected')
                ->count(),
        ];

        $claims = $baseQuery
            ->when($status, function ($query, $status) {

                if (in_array($status, [
                    'Submitted',
                    'Approved',
                    'Rejected',
                ])) {
                    $query->where('status', $status);
                }

            })
            ->latest('submitted_at')
            ->get();

        return view(
            'developer.claims.index',
            compact(
                'claims',
                'status',
                'counts'
            )
        );
    }

    /* Create Claim Page */

    public function create(): View
    {
        /* Only active claim categories. */
        $categories = ClaimCategory::where(
            'is_active',
            true
        )
            ->orderBy('category_name')
            ->get();

        /* Preview Claim ID */
        $claimCode = $this->generateClaimCode();

        return view(
            'developer.claims.create',
            compact('categories', 'claimCode')
        );
    }

    /* Store Claim */

    public function store(Request $request)
    {
        $user = auth()->user();

        $selectedCategory = ClaimCategory::where('id', $request->category_id)
            ->where('is_active', true)
            ->first();

        $isOtherCategory =
            $selectedCategory && $selectedCategory->category_name === 'Other';

        $validated = $request->validate([
            'category_id' => [
                'required',
                'exists:claim_categories,id',
            ],

            'other_category' => [
                Rule::requiredIf($isOtherCategory),
                'nullable',
                'string',
                'max:100',
            ],

            'title' => [
                'required',
                'string',
                'max:200',
            ],

            'amount' => [
                'required',
                'numeric',
                'min:0.01',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'receipt' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],
        ]);

        /*
         * Make sure category is active.
         */
        $category = ClaimCategory::where(
            'id',
            $validated['category_id']
        )
            ->where('is_active', true)
            ->firstOrFail();

        /*
         * Upload receipt.
         */
        $receiptPath = $request
            ->file('receipt')
            ->store(
                'claim-receipts',
                'public'
            );

        /*
         * Create Claim.
         */
        Claim::create([
            'user_id' => $user->id,

            'category_id' => $category->id,

            'other_category' => $category->category_name === 'Other'
                ? $validated['other_category']
                : null,

            'claim_code' => $this->generateClaimCode(),

            'title' => $validated['title'],

            'amount' => $validated['amount'],

            'receipt' => $receiptPath,

            'description' => $validated['description'] ?? null,

            'status' => 'Submitted',

            'submitted_at' => now(),

            'reviewed_by' => null,

            'reviewed_at' => null,
        ]);

        return redirect()
            ->route('developer.claims.index')
            ->with(
                'success',
                'Claim submitted successfully.'
            );
    }

    /* View Claim */

    public function show(Claim $claim): View
    {
        $user = auth()->user();

        /*
         * Developer can only view
         * their own claim.
         */
        abort_unless(
            $claim->user_id === $user->id,
            403
        );

        $claim->load([
            'user',
            'category',
            'reviewer',
            'paymentVoucher',
        ]);

        return view(
            'developer.claims.show',
            compact('claim')
        );
    }

    /* Delete Claim */

    public function destroy(Claim $claim)
    {
        $user = auth()->user();

        /* Developer can only delete their own claim. */
        abort_unless(
            $claim->user_id === $user->id,
            403
        );

        /* don't allow deleting claims that Admin has already reviewed. */
        abort_unless(
            $claim->status === 'Submitted',
            403
        );

        /* Prevent deletion if it has already been reviewed. */
        abort_if(
            $claim->reviewed_at !== null,
            403
        );

        /* Remove stored receipt. */
        if ($claim->receipt) {
            Storage::disk('public')
                ->delete($claim->receipt);
        }

        $claim->delete();

        return redirect()
            ->route('developer.claims.index')
            ->with(
                'success',
                'Claim deleted successfully.'
            );
    }

    /* Generate Claim Code */

    private function generateClaimCode(): string
    {
        $lastClaim = Claim::orderByDesc('id')
            ->first();

        $nextNumber = $lastClaim
            ? $lastClaim->id + 1
            : 1;

        do {
            $code = 'CLM-'.str_pad(
                $nextNumber,
                4,
                '0',
                STR_PAD_LEFT
            );

            $nextNumber++;

        } while (
            Claim::where(
                'claim_code',
                $code
            )->exists()
        );

        return $code;
    }
}
