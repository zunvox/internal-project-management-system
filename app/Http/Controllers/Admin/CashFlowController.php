<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\CashFlowCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CashFlowController extends Controller
{
    /* Cash Flow Management List */
    public function index(Request $request): View
    {
        $type = $request->query('type');

        $baseQuery = CashFlow::with([
            'loggedBy',
            'category',
        ]);

        $counts = [
            'all' => (clone $baseQuery)->count(),

            'cash_in' => (clone $baseQuery)
                ->where('type', 'Cash In')
                ->count(),

            'cash_out' => (clone $baseQuery)
                ->where('type', 'Cash Out')
                ->count(),
        ];

        if (in_array($type, ['Cash In', 'Cash Out'])) 
        {
            $baseQuery->where('type', $type);
        }

        /* Grand Total across ALL pages */
        $totalCashIn = (clone $baseQuery)
            ->where('type', 'Cash In')
            ->sum('amount');

        $totalCashOut = (clone $baseQuery)
            ->where('type', 'Cash Out')
            ->sum('amount');

        $grandTotal = $totalCashIn - $totalCashOut;

        /* Only paginate after calculating total */
        $cashFlows = $baseQuery
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $categories = CashFlowCategory::where('is_active', true)
            ->orderBy('category_name')
            ->get();

        return view(
            'admin.cash-flows.index',
            compact(
                'cashFlows',
                'counts',
                'categories',
                'type',
                'grandTotal'
            )
        );
    }

    /* Display Add Transaction page */
    public function create(): View
    {
        $categories = CashFlowCategory::where(
            'is_active',
            true
        )
            ->orderBy('cash_flow_type')
            ->orderBy('category_name')
            ->get();

        return view('admin.cash-flows.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                'in:Cash In,Cash Out',
            ],

            'flowcategory_id' => [
                'required',
                'exists:cash_flow_categories,id',
            ],

            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'transaction_date' => [
                'required',
                'date',
            ],

            'other_category' => [
                'nullable',
                'string',
                'max:100',
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
        ]);

        $category = CashFlowCategory::findOrFail(
            $validated['flowcategory_id']
        );

        $isOtherCategory = in_array(
            $category->category_name,
            [
                'Other Income',
                'Other Expense',
            ]
        );

        /* Make sure selected category matches the Cash In / Cash Out type. */
        if ($category->cash_flow_type !== $validated['type']) {

            return back()
                ->withInput()
                ->withErrors([
                    'flowcategory_id' => 'The selected category does not match the transaction type.',
                ]);
        }

        $cashFlow = CashFlow::create([
            'logged_by' => auth()->id(),

            'flowcategory_id' => $validated['flowcategory_id'],

            'transaction_code' => $this->generateTransactionCode(),

            'type' => $validated['type'],

            'subject' => $validated['subject'],

            'transaction_date' => $validated['transaction_date'],

            'other_category' => $isOtherCategory
                    ? $validated['other_category']
                    : null,

            'amount' => $validated['amount'],

            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('admin.cash-flows.index')
            ->with(
                'success',
                'Cash flow transaction recorded successfully.'
            );
    }

    public function show(CashFlow $cashFlow): View
    {
        $cashFlow->load([
            'loggedBy',
            'category',
        ]);

        return view('admin.cash-flows.show', compact('cashFlow'));
    }

    public function edit(CashFlow $cashFlow): View
    {
        $categories = CashFlowCategory::where('is_active', true)
            ->orderBy('cash_flow_type')
            ->orderBy('category_name')
            ->get();

        return view('admin.cash-flows.edit', compact('cashFlow', 'categories')
        );
    }

    public function update(Request $request, CashFlow $cashFlow)
    {
        $validated = $request->validate([
            'type' => [
                'required',
                'in:Cash In,Cash Out',
            ],

            'flowcategory_id' => [
                'required',
                'exists:cash_flow_categories,id',
            ],

            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'transaction_date' => [
                'required',
                'date',
            ],

            'other_category' => [
                'nullable',
                'string',
                'max:100',
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
        ]);

        $category = CashFlowCategory::findOrFail(
            $validated['flowcategory_id']
        );

        $isOtherCategory = in_array(
            $category->category_name,
            [
                'Other Income',
                'Other Expense',
            ]
        );

        /* Prevent a Cash In category from being used for Cash Out, and other way around. */
        if ($category->cash_flow_type !== $validated['type']) {

            return back()
                ->withInput()
                ->withErrors([
                    'flowcategory_id' => 'The selected category does not match the transaction type.',
                ]);
        }

        $cashFlow->update([
            'flowcategory_id' => $validated['flowcategory_id'],

            'type' => $validated['type'],

            'subject' => $validated['subject'],

            'transaction_date' => $validated['transaction_date'],

            'other_category' => $isOtherCategory
                    ? $validated['other_category']
                    : null,

            'amount' => $validated['amount'],

            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route(
                'admin.cash-flows.show',
                $cashFlow
            )
            ->with(
                'success',
                'Transaction updated successfully.'
            );
    }

    public function destroy(CashFlow $cashFlow)
    {
        $cashFlow->delete();

        return redirect()
            ->route('admin.cash-flows.index')
            ->with(
                'success',
                'Cash flow transaction deleted successfully.'
            );
    }

    private function generateTransactionCode(): string
    {
        $lastTransaction = CashFlow::whereNotNull('transaction_code')
            ->orderByDesc('id')
            ->first();

        if (! $lastTransaction) {
            $nextNumber = 1;
        } else {
            $lastNumber = (int) str_replace(
                'CF-',
                '',
                $lastTransaction->transaction_code
            );

            $nextNumber = $lastNumber + 1;
        }

        return 'CF-'.str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    public function report(Request $request): View
    {
        $period = $request->query('period', 'weekly');

        switch ($period) {

            case 'weekly':

                if ($request->filled('week')) {
                    [$year, $week] =
                        explode(
                            '-W',
                            $request->week
                        );

                    $from = Carbon::now()
                        ->setISODate(
                            (int) $year,
                            (int) $week
                        )
                        ->startOfWeek()
                        ->startOfDay();

                    $to = $from->copy()
                        ->endOfWeek()
                        ->endOfDay();
                } else {
                    $from = Carbon::now()
                        ->startOfWeek()
                        ->startOfDay();

                    $to = Carbon::now()
                        ->endOfWeek()
                        ->endOfDay();
                }

                break;

            case 'monthly':

                if ($request->filled('month')) {
                    $selectedMonth =
                        Carbon::createFromFormat(
                            'Y-m',
                            $request->month
                        );

                    $from = $selectedMonth
                        ->copy()
                        ->startOfMonth()
                        ->startOfDay();

                    $to = $selectedMonth
                        ->copy()
                        ->endOfMonth()
                        ->endOfDay();
                } else {
                    $from = Carbon::now()
                        ->startOfMonth()
                        ->startOfDay();

                    $to = Carbon::now()
                        ->endOfMonth()
                        ->endOfDay();
                }

                break;

            case 'yearly':

                $selectedYear =
                    (int) $request->query(
                        'year',
                        now()->year
                    );

                $from = Carbon::create(
                    $selectedYear,
                    1,
                    1
                )->startOfDay();

                $to = Carbon::create(
                    $selectedYear,
                    12,
                    31
                )->endOfDay();

                break;

            case 'custom':

                $from = $request->filled('from')
                    ? Carbon::parse($request->from)->startOfDay()
                    : Carbon::now()->startOfMonth();

                $to = $request->filled('to')
                    ? Carbon::parse($request->to)->endOfDay()
                    : Carbon::now()->endOfMonth();

                break;

            default:

                $period = 'weekly';

                $from = Carbon::now()
                    ->startOfWeek()
                    ->startOfDay();

                $to = Carbon::now()
                    ->endOfWeek()
                    ->endOfDay();

                break;
        }

        /* Opening Balance */

        $previousTransactions = CashFlow::where(
            'transaction_date',
            '<',
            $from->toDateString()
        )->get();

        $openingCashIn = $previousTransactions
            ->where('type', 'Cash In')
            ->sum('amount');

        $openingCashOut = $previousTransactions
            ->where('type', 'Cash Out')
            ->sum('amount');

        $openingBalance =
            $openingCashIn - $openingCashOut;

        /* Transactions Inside Report Period */

        $cashFlows = CashFlow::with([
            'category',
            'loggedBy',
        ])
            ->whereBetween(
                'transaction_date',
                [
                    $from->toDateString(),
                    $to->toDateString(),
                ]
            )
            ->orderBy('transaction_date')
            ->orderBy('id')
            ->get();

        $totalCashIn = $cashFlows
            ->where('type', 'Cash In')
            ->sum('amount');

        $totalCashOut = $cashFlows
            ->where('type', 'Cash Out')
            ->sum('amount');

        $netCashFlow =
            $totalCashIn - $totalCashOut;

        /* Running Balance */

        $runningBalance = $openingBalance;

        $reportRows = $cashFlows->map(
            function ($cashFlow) use (&$runningBalance) {

                if ($cashFlow->type === 'Cash In') {
                    $runningBalance += $cashFlow->amount;
                } else {
                    $runningBalance -= $cashFlow->amount;
                }

                return [
                    'cashFlow' => $cashFlow,
                    'balance' => $runningBalance,
                ];
            }
        );

        $allCashFlows = CashFlow::with([
            'category',
        ])
            ->orderBy('transaction_date')
            ->orderBy('id')
            ->get();

        $allCashFlowsForJs = $allCashFlows->map(function ($cashFlow) {

            return [
                'id' => $cashFlow->id,

                'transaction_code' => $cashFlow->transaction_code,

                'subject' => $cashFlow->subject,

                'type' => $cashFlow->type,

                'transaction_date' => $cashFlow->transaction_date
                    ->format('Y-m-d'),

                'amount' => (float) $cashFlow->amount,

                'category' => $cashFlow->category?->category_name,

                'other_category' => $cashFlow->other_category,
            ];

        })->values();

        $closingBalance = $runningBalance;

        return view(
            'admin.cash-flows.report',
            compact(
                'period',
                'from',
                'to',
                'reportRows',
                'openingBalance',
                'totalCashIn',
                'totalCashOut',
                'netCashFlow',
                'closingBalance',
                'allCashFlowsForJs'
            )
        );
    }
}
