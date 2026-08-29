<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentVoucherController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Payment Voucher Management List
    |--------------------------------------------------------------------------
    |
    | For now this displays invoice requests only.
    | Claims will be added later.
    |
    */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $invoices = Invoice::with([
            'user',
            'project',
        ])
        ->whereIn('status', [
            'Submitted',
            'Approved',
            'Rejected',
        ])
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
            compact('invoices', 'status')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | View One Invoice Request
    |--------------------------------------------------------------------------
    */
    public function showInvoice(Invoice $invoice): View
    {
        /*
         * Draft invoices must never appear
         * in the admin review section.
         */
        abort_if(
            $invoice->status === 'Draft',
            404
        );

        $invoice->load([
            'user',
            'project',
            'items',
            'paymentVoucher',
        ]);

        return view(
            'admin.payment-vouchers.show-invoice',
            compact('invoice')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Approve Submitted Invoice
    |--------------------------------------------------------------------------
    */
    public function approveInvoice(
        Request $request,
        Invoice $invoice
    ) {
        /*
         * Only Submitted invoices
         * are allowed to be approved.
         */
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


    /*
    |--------------------------------------------------------------------------
    | Reject Submitted Invoice
    |--------------------------------------------------------------------------
    */
    public function rejectInvoice(
        Request $request,
        Invoice $invoice
    ) {
        /*
         * Only Submitted invoices
         * are allowed to be rejected.
         */
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
}