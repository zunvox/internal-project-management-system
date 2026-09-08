<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\PaymentVoucher;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentVoucherController extends Controller
{
    /*Payment Voucher Management List*/
    
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $baseQuery = Invoice::with([
            'user',
            'project',
        ])
        ->whereIn('status', [
            'Submitted',
            'Approved',
            'Rejected',
        ]);

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

    $invoices = $baseQuery
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
            'admin.payment-vouchers.index',
            compact('invoices', 'status', 'counts')
        );
    }


    /*View One Invoice Request*/

    public function showInvoice(Invoice $invoice): View
    {
        /*Draft invoices must never appearin the admin review section.*/

        abort_if(
            $invoice->status === 'Draft',
            404
        );

        $invoice->load([
            'user',
            'project',
            'items',
            'paymentVoucher.reviewer',
        ]);

        return view(
            'admin.payment-vouchers.show-invoice',
            compact('invoice')
        );
    }


    /*Approve Submitted Invoice*/

    public function approveInvoice(
        Request $request,
        Invoice $invoice
    ) {
        /*Only Submitted invoices are allowed to be approved.*/

        abort_unless(
            $invoice->status === 'Submitted',
            403
        );

        $request->validate([
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $invoice->update([
            'status' => 'Approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => $request->notes,
        ]);

        return redirect()
            ->route(
                'admin.payment-vouchers.invoices.show',
                $invoice
            )
            ->with(
                'success',
                'Invoice approved successfully.'
            );
    }


    /*Reject Submitted Invoice*/

    public function rejectInvoice(
        Request $request,
        Invoice $invoice
    ) {
        /* Only Submitted invoices are allowed to be rejected.*/

        abort_unless(
            $invoice->status === 'Submitted',
            403
        );

        $request->validate([
            'notes' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $invoice->update([
            'status' => 'Rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => $request->notes,
        ]);

        return redirect()
            ->route(
                'admin.payment-vouchers.invoices.show',
                $invoice
            )
            ->with(
                'success',
                'Invoice rejected successfully.'
            );
    }

    /* Generate Payment Voucher */

    public function generateVoucher(
        Request $request,
        Invoice $invoice
    ) {
        // Voucher can only be generated for an approved invoice
        abort_unless(
            $invoice->status === 'Approved',
            403
        );

        // Prevent more than one voucher for the same invoice
        abort_if(
            $invoice->paymentVoucher()->exists(),
            403,
            'A payment voucher has already been generated for this invoice.'
        );

        $validated = $request->validate([
            'payment_method' => [
                'required',
                'in:Bank Transfer,Cash,Cheque,Online Payment,Other',
            ],
        ]);

        PaymentVoucher::create([
            'reviewed_by' => $invoice->reviewed_by,
            'invoice_id' => $invoice->id,
            'claim_id' => null,

            'voucher_code' => $this->generateVoucherCode(),

            'amount' => $invoice->grand_total,

            'payment_method' => $validated['payment_method'],
            'notes' => $invoice->review_notes,

            'status' => 'Generated',

            'reviewed_at' => $invoice->reviewed_at,
            'generated_at' => now(),
        ]);

        return redirect()
            ->route(
                'admin.payment-vouchers.invoices.show',
                $invoice
            )
            ->with(
                'success',
                'Payment voucher generated successfully.'
            );
    }

    /* Generate Unique Payment Voucher Number */

    private function generateVoucherCode(): string
    {
        $year = now()->format('Y');

        $nextNumber = (PaymentVoucher::max('id') ?? 0) + 1;

        do {
            $code = 'PV-' .
                $year .
                '-' .
                str_pad(
                    $nextNumber,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

            $nextNumber++;
        }
        while (
            PaymentVoucher::where('voucher_code', $code)->exists()
        );

        return $code;
    }
}