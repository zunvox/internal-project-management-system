<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DeveloperInvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();

        $status = $request->query('status');

        $baseQuery = Invoice::with([
            'project',
        ])
            ->where('user_id', $user->id);

        $counts = [
            'all' => (clone $baseQuery)->count(),

            'draft' => (clone $baseQuery)
                ->where('status', 'Draft')
                ->count(),

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

        $invoices = $baseQuery
            ->when($status, function ($query, $status) {

                if (in_array($status, [
                    'Draft',
                    'Submitted',
                    'Approved',
                    'Rejected',
                ])) {
                    $query->where('status', $status);
                }

            })
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view(
            'developer.invoices.index',
            compact(
                'invoices',
                'status',
                'counts'
            )
        );
    }

    public function create(): View
    {
        $user = auth()->user();

        $projects = Project::whereHas('assignedUsers', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
            ->whereIn('status', ['Ongoing', 'Completed', 'On Hold'])
            ->orderBy('name')
            ->get();

        return view('developer.invoices.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'project_id' => [
                'required',
                'exists:projects,id',
            ],

            'subject' => [
                'required',
                'string',
                'max:200',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'status' => [
                'required',
                'in:Draft,Submitted',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.item_name' => [
                'required',
                'string',
                'max:200',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'tax_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'discount_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        /* Assigned developers to the selected project */

        $project = Project::where('id', $validated['project_id'])
            ->whereHas('assignedUsers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->whereIn('status', ['Ongoing', 'Completed', 'On Hold'])
            ->firstOrFail();

        /* Calculate invoice total */

        $subtotal = 0;

        foreach ($validated['items'] as $item) {
            $quantity = (float) $item['quantity'];
            $unitPrice = (float) $item['unit_price'];

            $totalPrice = $quantity * $unitPrice;

            $subtotal += $totalPrice;
        }

        $taxPercentage = (float) $validated['tax_percentage'];
        $taxAmount = $subtotal * ($taxPercentage / 100);
        $discountAmount = $validated['discount_amount'] ?? 0;

        $grandTotal = $subtotal + $taxAmount - $discountAmount;
        $grandTotal = max($grandTotal, 0);

        /* Upload supporting document */

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('invoice-attachments', 'public');
        }

        /* Save invoice */

        DB::transaction(function () use (
            $validated,
            $user,
            $project,
            $subtotal,
            $taxPercentage,
            $taxAmount,
            $discountAmount,
            $grandTotal,
            $attachmentPath,
        ) {
            $invoice = Invoice::create([
                'user_id' => $user->id,
                'project_id' => $project->id,
                'invoice_code' => $this->generateInvoiceCode(),
                'subject' => $validated['subject'],
                'description' => $validated['description'] ?? null,
                'attachment' => $attachmentPath,
                'status' => $validated['status'],
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'tax_percentage' => $taxPercentage,
                'discount_amount' => $discountAmount,
                'grand_total' => $grandTotal,
                'submitted_at' => $validated['status'] === 'Submitted'
                ? now()
                : null,
            ]);

            foreach ($validated['items'] as $item) {
                $totalPrice = $item['quantity'] * $item['unit_price'];

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $totalPrice,
                ]);
            }
        });

        return redirect()
            ->route('developer.invoices.index')
            ->with(
                'success',
                $validated['status'] === 'Draft'
                ? 'Invoice saved as draft successfully.'
                : 'Invoice submitted successfully.'
            );
    }

    public function show(Invoice $invoice): View
    {
        $user = auth()->user();

        abort_unless($invoice->user_id === $user->id, 403);

        $invoice->load([
            'user',
            'project',
            'items',
            'paymentVoucher',
        ]);

        return view(
            'developer.invoices.show',
            compact('invoice')
        );
    }

    public function edit(Invoice $invoice): View
    {
        $user = auth()->user();

        abort_unless($invoice->user_id === $user->id, 403);

        abort_unless($invoice->status === 'Draft', 403);

        $projects = Project::whereHas('assignedUsers', function ($query) use ($user) {
            $query->where(
                'users.id',
                $user->id
            );
        })
            ->orderBy('name')
            ->get();

        $invoice->load('items');

        return view(
            'developer.invoices.edit',
            compact(
                'invoice',
                'projects'
            )
        );
    }

    public function update(Request $request, Invoice $invoice)
    {
        $user = auth()->user();

        // Developer can only update their own invoice
        abort_unless($invoice->user_id === $user->id, 403);

        // Only Draft invoices can be edited
        abort_unless($invoice->status === 'Draft', 403);

        $validated = $request->validate([
            'project_id' => [
                'required',
                'exists:projects,id',
            ],

            'subject' => [
                'required',
                'string',
                'max:200',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:5120',
            ],

            'remove_attachment' => [
                'nullable',
                'boolean',
            ],

            'status' => [
                'required',
                'in:Draft,Submitted',
            ],

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.item_name' => [
                'required',
                'string',
                'max:200',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'tax_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'discount_amount' => [
                'nullable',
                'numeric',
                'min:0',
            ],
        ]);

        // Make sure developer is assigned to selected project
        $project = Project::where('id', $validated['project_id'])
            ->whereHas('assignedUsers', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->firstOrFail();

        // Calculate subtotal
        $subtotal = 0;

        foreach ($validated['items'] as $item) {
            $quantity = (float) $item['quantity'];
            $unitPrice = (float) $item['unit_price'];

            $totalPrice = $quantity * $unitPrice;

            $subtotal += $totalPrice;
        }

        // Calculate tax
        $taxPercentage = (float) $validated['tax_percentage'];

        $taxAmount = $subtotal * ($taxPercentage / 100);

        // Calculate discount
        $discountAmount =
            (float) ($validated['discount_amount'] ?? 0);

        // Calculate grand total
        $grandTotal =
            $subtotal
            + $taxAmount
            - $discountAmount;

        // Prevent negative total
        $grandTotal = max($grandTotal, 0);

        // Keep existing attachment by default
        $attachmentPath = $invoice->attachment;

        // User wants to remove the current attachment
        if ($request->boolean('remove_attachment')) {

            if ($invoice->attachment) {
                Storage::disk('public')
                    ->delete($invoice->attachment);
            }

            $attachmentPath = null;
        }

        // User uploads a new attachment
        if ($request->hasFile('attachment')) {

            if ($attachmentPath) {
                Storage::disk('public')
                    ->delete($attachmentPath);
            }

            $attachmentPath = $request
                ->file('attachment')
                ->store('invoice-attachments', 'public');
        }

        DB::transaction(function () use (
            $invoice,
            $validated,
            $project,
            $subtotal,
            $taxPercentage,
            $taxAmount,
            $discountAmount,
            $grandTotal,
            $attachmentPath
        ) {

            // Update invoice
            $invoice->update([
                'project_id' => $project->id,
                'subject' => $validated['subject'],
                'description' => $validated['description'] ?? null,
                'attachment' => $attachmentPath,
                'status' => $validated['status'],
                'subtotal' => $subtotal,
                'tax_percentage' => $taxPercentage,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'grand_total' => $grandTotal,

                'submitted_at' => $validated['status'] === 'Submitted'
                        ? now()
                        : null,
            ]);

            // Delete the old item rows
            $invoice->items()->delete();

            // Save the edited item rows
            foreach ($validated['items'] as $item) {

                $quantity = (float) $item['quantity'];
                $unitPrice = (float) $item['unit_price'];

                $totalPrice = $quantity * $unitPrice;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $totalPrice,
                ]);
            }
        });

        if ($validated['status'] === 'Draft') {
            return redirect()
                ->route('developer.invoices.index', $invoice)
                ->with('success', 'Invoice draft saved successfully.');
        }

        return redirect()
            ->route('developer.invoices.index')
            ->with('success', 'Invoice submitted successfully.');
    }

    /* Delete an invoice */

    public function destroy(Invoice $invoice)
    {
        $user = auth()->user();

        abort_unless($invoice->user_id === $user->id, 403);

        /* Only draft can be deleted */

        abort_unless($invoice->status === 'Draft', 403);

        if ($invoice->attachment) {
            Storage::disk('public')
                ->delete($invoice->attachment);
        }

        $invoice->items()->delete();
        $invoice->delete();

        return redirect()
            ->route('developer.invoices.index')
            ->with(
                'success',
                'Invoice deleted successfully.'
            );
    }

    /* Generate unique invoice number */

    private function generateInvoiceCode(): string
    {
        $lastInvoice = Invoice::orderByDesc('id')->first();

        $nextNumber = $lastInvoice
            ? $lastInvoice->id + 1
            : 1;

        do {
            $code = 'INV-'.str_pad(
                $nextNumber,
                4,
                '0',
                STR_PAD_LEFT
            );

            $nextNumber++;
        } while (
            Invoice::where('invoice_code', $code)->exists()
        );

        return $code;
    }
}
