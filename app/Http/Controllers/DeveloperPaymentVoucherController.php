<?php

namespace App\Http\Controllers;

use App\Models\PaymentVoucher;
use Barryvdh\DomPDF\Facade\Pdf;

class DeveloperPaymentVoucherController extends Controller
{
    public function downloadPdf(PaymentVoucher $paymentVoucher)
    {
        $paymentVoucher->load([
            'invoice.user',
            'invoice.project',
            'claim.user',
            'claim.category',
            'reviewer',
        ]);

        $userId = auth()->id();

        $ownsInvoiceVoucher =
            $paymentVoucher->invoice &&
            $paymentVoucher->invoice->user_id === $userId;

        $ownsClaimVoucher =
            $paymentVoucher->claim &&
            $paymentVoucher->claim->user_id === $userId;

        abort_unless(
            $ownsInvoiceVoucher || $ownsClaimVoucher,
            403
        );

        $pdf = Pdf::loadView(
            'admin.payment-vouchers.pdf',
            compact('paymentVoucher')
        )->setPaper('a4', 'portrait');

        return $pdf->stream(
            'Payment-Voucher-' .
            $paymentVoucher->voucher_code .
            '.pdf'
        );
    }
}