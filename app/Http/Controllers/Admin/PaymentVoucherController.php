<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\Claim;
use App\Models\Invoice;
use App\Models\PaymentVoucher;
use App\Models\CashFlowCategory;
use App\Models\CashFlowChangeLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentVoucherController extends Controller
{
    /* Payment Voucher Management List */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        /*
        * Invoice requests.
        */
        $invoiceQuery = Invoice::with([
            'user',
            'project',
        ])
            ->whereIn('status', [
                'Submitted',
                'Approved',
                'Rejected',
            ]);

        /*
        * Claim requests.
        */
        $claimQuery = Claim::with([
            'user',
            'category',
        ])
            ->whereIn('status', [
                'Submitted',
                'Approved',
                'Rejected',
            ]);

        /*
        * Counts include both invoices and claims.
        */
        $counts = [
            'all' => (clone $invoiceQuery)->count()
                +
                (clone $claimQuery)->count(),

            'submitted' => (clone $invoiceQuery)
                ->where('status', 'Submitted')
                ->count()
                +
                (clone $claimQuery)
                    ->where('status', 'Submitted')
                    ->count(),

            'approved' => (clone $invoiceQuery)
                ->where('status', 'Approved')
                ->count()
                +
                (clone $claimQuery)
                    ->where('status', 'Approved')
                    ->count(),

            'rejected' => (clone $invoiceQuery)
                ->where('status', 'Rejected')
                ->count()
                +
                (clone $claimQuery)
                    ->where('status', 'Rejected')
                    ->count(),
        ];

        /*
        * Apply selected status to invoices.
        */
        $invoices = $invoiceQuery
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

        /*
        * Apply selected status to claims.
        */
        $claims = $claimQuery
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
            compact(
                'invoices',
                'claims',
                'status',
                'counts'
            )
        );
    }

    /* View One Invoice Request */

    public function showInvoice(Invoice $invoice): View
    {
        /* Draft invoices must never appearin the admin review section. */

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

        return view('admin.payment-vouchers.show-invoice', compact('invoice'));
    }

    /* View One Claim Request */
    public function showClaim(Claim $claim): View
    {
        $claim->load([
            'user',
            'category',
            'reviewer',
            'paymentVoucher.reviewer',
        ]);

        return view('admin.payment-vouchers.show-claim', compact('claim'));
    }

    /* Approve Submitted Claim */
    public function approveClaim(Request $request, Claim $claim) 
    {
        /* Only submitted claim can be approved. */
        abort_unless($claim->status === 'Submitted', 403);

        $request->validate([
            'notes' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $claimCategory = CashFlowCategory::where(
            'category_name',
            'Staff Claims'
        )
        ->where(
            'cash_flow_type',
            'Cash Out'
        )
        ->firstOrFail();


        DB::transaction(function () use (
            $request,
            $claim,
            $claimCategory
        ) {

            $claim->update([
                'status' => 'Approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'review_notes' => $request->notes,
            ]);


            $cashFlow = CashFlow::create([
                'logged_by' =>
                    auth()->id(),

                'flowcategory_id' =>
                    $claimCategory->id,

                'transaction_code' =>
                    $this->generateCashFlowCode(),

                'type' =>
                    'Cash Out',

                'subject' =>
                    $claim->claim_code
                    . ' - '
                    . $claim->claim_subject,

                'transaction_date' =>
                    now()->toDateString(),

                'other_category' =>
                    null,

                'amount' =>
                    $claim->amount,

                'description' =>
                    'Approved staff claim '
                    . $claim->claim_code,
            ]);

            CashFlowChangeLog::create([
                'cash_flow_id' =>
                    $cashFlow->id,

                'changed_by' =>
                    auth()->id(),

                'action' =>
                    'Created',

                'description' =>
                    'Cash flow transaction automatically created from approved claim '
                    . $claim->claim_code
                    . '.',

                'snapshot' => [
                    'transaction_code' =>
                        $cashFlow->transaction_code,

                    'subject' =>
                        $cashFlow->subject,

                    'type' =>
                        $cashFlow->type,

                    'category' =>
                        $claimCategory->category_name,

                    'other_category' =>
                        $cashFlow->other_category,

                    'transaction_date' =>
                        $cashFlow->transaction_date?->format('Y-m-d'),

                    'amount' =>
                        $cashFlow->amount,

                    'description' =>
                        $cashFlow->description,

                    'logged_by' =>
                        auth()->user()->username
                        ?? auth()->user()->fullname
                        ?? 'Admin',
                ],
            ]);
        });

        return redirect()->route('admin.payment-vouchers.claims.show', $claim)
            ->with('success', 'Claim approved and recorded in cash flow successfully.');
    }

    /* Reject Submitted Claim */
    public function rejectClaim(Request $request, Claim $claim)
    {
        /* Only Submitted claims can be rejected. */
        abort_unless($claim->status === 'Submitted', 403);

        $request->validate([
            'notes' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        $claim->update([
            'status' => 'Rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => $request->notes,
        ]);

        return redirect()->route('admin.payment-vouchers.claims.show', $claim)
            ->with('success', 'Claim rejected successfully.');
    }

    /* Generate Payment Voucher For Claim */
    public function generateClaimVoucher(Claim $claim)
    {
        /* Voucher can only be generated for an approved claim. */
        abort_unless($claim->status === 'Approved', 403);

        /* Prevent duplicate vouchers. */
        abort_if($claim->paymentVoucher()->exists(), 403, 'A payment voucher has already been generated for this claim.');

        PaymentVoucher::create([
            'reviewed_by' => $claim->reviewed_by,

            'invoice_id' => null,
            'claim_id' => $claim->id,

            'voucher_code' => $this->generateVoucherCode(),

            'amount' => $claim->amount,

            'payment_method' => 'Bank Transfer',

            'notes' => $claim->review_notes,

            'status' => 'Generated',

            'reviewed_at' => $claim->reviewed_at,

            'generated_at' => now(),
        ]);

        return redirect()->route('admin.payment-vouchers.claims.show', $claim)
            ->with('success', 'Payment voucher generated successfully.');
    }

    /* Approve Submitted Invoice */

    public function approveInvoice( Request $request, Invoice $invoice) 
    {
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


        $invoiceCategory = CashFlowCategory::where(
            'category_name',
            'Project Payment'
        )
        ->where(
            'cash_flow_type',
            'Cash Out'
        )
        ->firstOrFail();


        DB::transaction(function () use (
            $request,
            $invoice,
            $invoiceCategory
        ) {

            $invoice->update([
                'status' => 'Approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'review_notes' => $request->notes,
            ]);


            $cashFlow = CashFlow::create([
                'logged_by' =>
                    auth()->id(),

                'flowcategory_id' =>
                    $invoiceCategory->id,

                'transaction_code' =>
                    $this->generateCashFlowCode(),

                'type' =>
                    'Cash Out',

                'subject' =>
                    $invoice->invoice_code
                    . ' - '
                    . $invoice->subject,

                'transaction_date' =>
                    now()->toDateString(),

                'other_category' =>
                    null,

                'amount' =>
                    $invoice->grand_total,

                'description' =>
                    $invoice->description,
            ]);

            CashFlowChangeLog::create([
                'cash_flow_id' =>
                    $cashFlow->id,

                'changed_by' =>
                    auth()->id(),

                'action' =>
                    'Created',

                'description' =>
                    'Cash flow transaction automatically created from approved invoice '
                    . $invoice->invoice_code
                    . '.',

                'snapshot' => [
                    'transaction_code' =>
                        $cashFlow->transaction_code,

                    'subject' =>
                        $cashFlow->subject,

                    'type' =>
                        $cashFlow->type,

                    'category' =>
                        $invoiceCategory->category_name,

                    'other_category' =>
                        $cashFlow->other_category,

                    'transaction_date' =>
                        $cashFlow->transaction_date?->format('Y-m-d'),

                    'amount' =>
                        $cashFlow->amount,

                    'description' =>
                        $cashFlow->description,

                    'logged_by' =>
                        auth()->user()->username
                        ?? auth()->user()->fullname
                        ?? 'Admin',
                ],
            ]);
        });


        return redirect()
            ->route(
                'admin.payment-vouchers.invoices.show',
                $invoice
            )
            ->with(
                'success',
                'Invoice approved and recorded in cash flow successfully.'
            );
    }

    /* Reject Submitted Invoice */

    public function rejectInvoice(
        Request $request,
        Invoice $invoice
    ) {
        /* Only Submitted invoices are allowed to be rejected. */

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

    public function generateVoucher(Invoice $invoice)
    {
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

        PaymentVoucher::create([
            'reviewed_by' => $invoice->reviewed_by,
            'invoice_id' => $invoice->id,
            'claim_id' => null,

            'voucher_code' => $this->generateVoucherCode(),

            'amount' => $invoice->grand_total,

            'payment_method' => 'Bank Transfer',
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

    private function generateCashFlowCode(): string
    {
        $lastTransaction = CashFlow::whereNotNull('transaction_code')
            ->orderByDesc('id')
            ->first();

        if (!$lastTransaction) {
            $nextNumber = 1;
        } else {
            $lastNumber = (int) str_replace(
                'CF-',
                '',
                $lastTransaction->transaction_code
            );

            $nextNumber = $lastNumber + 1;
        }

        return 'CF-' . str_pad(
            $nextNumber,
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    /* Generate Unique Payment Voucher Number */

    private function generateVoucherCode(): string
    {
        $year = now()->format('Y');

        $nextNumber = (PaymentVoucher::max('id') ?? 0) + 1;

        do {
            $code = 'PV-'.
                $year.
                '-'.
                str_pad(
                    $nextNumber,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

            $nextNumber++;
        } while (
            PaymentVoucher::where('voucher_code', $code)->exists()
        );

        return $code;
    }

    public function downloadPdf(PaymentVoucher $paymentVoucher)
    {
        $paymentVoucher->load([
            'invoice.user',
            'invoice.project',
            'claim.user',
            'claim.category',
            'reviewer',
        ]);

        $pdf = Pdf::loadView(
            'admin.payment-vouchers.pdf',
            compact('paymentVoucher')
        )->setPaper('a4', 'portrait');

        return $pdf->stream('Payment-Voucher-'.$paymentVoucher->id.'.pdf');

    }
}
