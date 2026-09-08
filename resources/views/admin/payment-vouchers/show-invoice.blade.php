<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice Review</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<style>

  /* ---------- Page layout ---------- */

  .page{
    width:90%;
    max-width:1400px;
    margin:0 auto;
    padding:28px 24px 64px;
    box-sizing:border-box;
}

  .breadcrumb{
    font-size:13px;
    color:#98A2B3;
    margin-bottom:6px;
  }

  .breadcrumb .current{
    color:#101828;
    font-weight:700;
  }

  .page-header-row{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
  }

  .title-row{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:2px;
  }

  .page-title{
    font-size:28px;
    font-weight:800;
    margin:0;
  }

  .status-pill{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:4px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
  }

  .status-pill::before{
    content:"";
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
  }

  .status-submitted{
    background:#D1E9FF;
    color:#175CD3;
  }

  .status-approved{
    background:#D3F8DF;
    color:#1A7F37;
  }

  .status-rejected{
    background:#FEE4E2;
    color:#B42318;
  }

  .back-link{
    display:inline-block;
    font-size:13px;
    color:#101828;
    text-decoration:none;
  }

  .back-link:hover{
    text-decoration:underline;
  }

  .btn-download{
    background:#019BEF;
    color:white;
    border:none;
    padding:9px 18px;
    border-radius:5px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    display:inline-flex;
    align-items:center;
    gap:8px;
    white-space:nowrap;
    margin-top:2px;
  }

  .btn-download svg{
    width:14px;
    height:14px;
    fill:white;
  }

  .btn-download:hover{
    background:#1f5ae0;
  }

  .columns{
    display:grid;
    grid-template-columns:1.7fr 1fr;
    gap:26px;
    align-items:start;
    margin-top:16px;
}

  .card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    box-shadow:0 20px 50px rgba(43,111,255,0.18);
  }

  /* ---------- Invoice card ---------- */

  .card-header{
    padding:18px 24px;
    border-bottom:1px solid #E4E7EC;
  }

  .card-header h2{
    font-size:17px;
    font-weight:700;
    margin:0;
  }

  .card-body{
    padding:20px 24px 26px;
  }

  .meta-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-bottom:20px;
  }

  .meta-block{
    margin-bottom:16px;
  }

  .meta-block:last-child{
    margin-bottom:0;
  }

  .meta-label{
    font-size:12px;
    color:#98A2B3;
    margin-bottom:4px;
  }

  .meta-value{
    font-size:14px;
    color:#101828;
    line-height:1.5;
  }

  hr.divider{
    border:none;
    border-top:1px solid #E4E7EC;
    margin:0 0 20px;
  }

  .section-label{
    font-size:15px;
    font-weight:700;
    margin:0 0 12px;
  }

  .items-table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:16px;
  }

  .items-table th{
    text-align:left;
    font-size:12px;
    font-weight:700;
    color:#98A2B3;
    padding:0 8px 10px 0;
    border-bottom:1px solid #E4E7EC;
  }

  .items-table th.align-right,
  .items-table td.align-right{
    text-align:right;
  }

  .items-table td{
    font-size:13px;
    color:#101828;
    padding:10px 8px 10px 0;
    border-bottom:1px solid #F2F4F7;
  }

  .summary-lines{
    width:100%;
    max-width:none;
    margin-left:0;
    margin-bottom:20px;
    margin-top:24px;
  }

  .summary-line{
    display:flex;
    justify-content:space-between;
    width:100%;
    font-size:13px;
    color:#98A2B3;
    padding:7px 0;
  }

  .summary-line.total{
    font-weight:700;
    font-size:15px;
    color:#101828;
    border-top:1px solid #E4E7EC;
    margin-top:4px;
    padding-top:12px;
  }

  .doc-row{
    display:flex;
    align-items:center;
    gap:12px;
    background:#F5F8FF;
    border-radius:10px;
    padding:12px 16px;
  }

  .doc-icon{
    width:34px;
    height:34px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:white;
    border:1px solid #D0D5DD;
    border-radius:8px;
  }

  .doc-icon svg{
    width:16px;
    height:16px;
    fill:#667085;
  }

  .doc-info{
    flex:1;
  }

  .doc-name{
    font-size:13px;
    font-weight:600;
    color:#101828;
  }

  .doc-meta{
    font-size:11px;
    color:#98A2B3;
  }

  .doc-actions{
    display:flex;
    gap:14px;
  }

  .doc-actions a{
    font-size:13px;
    font-weight:600;
    color:#2B6FFF;
    text-decoration:none;
  }

  .doc-actions a:hover{
    text-decoration:underline;
  }

  /* ---------- Right column ---------- */

  .right-col{
    display:flex;
    flex-direction:column;
    gap:14px;
  }

  /* Payment voucher card */
  .voucher-body{
    padding:18px 24px 16px;
}

  .voucher-row{
    display:flex;
    justify-content:space-between;
    font-size:13px;
    padding:8px 0;
    border-bottom:1px solid #F2F4F7;
  }

  .voucher-row .label{
    color:#98A2B3;
  }

  .voucher-row .value{
    color:#101828;
    font-weight:600;
    text-align:right;
  }

  .voucher-empty{
    min-height:140px;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    color:#98A2B3;
    font-size:13px;
  }

  .voucher-field{
    display:flex;
    flex-direction:column;
    gap:8px;
    margin-bottom:14px;
  }

  .voucher-field label{
    font-size:13px;
    font-weight:600;
  }

  .voucher-field select{
    width:100%;
    padding:9px 12px;
    border:1px solid #D0D5DD;
    border-radius:5px;
    font-family:'Inter',system-ui,sans-serif;
  }

  .amount-block{
    text-align:center;
    margin:18px 0 18px;
  }

  .amount-label{
    font-size:12px;
    color:#667085;
    letter-spacing:0.05em;
    margin-bottom:6px;
  }

  .amount-value{
    font-size:30px;
    font-weight:800;
    color:#101828;
  }

  .voucher-actions{
    display:flex;
    flex-direction:column;
    gap:6px;
 }

  .btn{
    border-radius:5px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    padding:8px 16px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    width:100%;
 }

  .btn svg{
    width:14px;
    height:14px;
  }

  .btn-generate{
    background:#019BEF;
    color:white;
    border:none;
  }

  .btn-generate:hover{
    background:#1f5ae0;
  }

  .btn-outline-blue{
    background:white;
    color:#019BEF;
    border:1px solid #019BEF;
  }

  .btn-outline-blue svg{
    fill:#019BEF;
  }

  .btn-outline-blue:hover{
    background:#EFF4FF;
  }

  /* Admin review card */
  .review-errors{
    background:#FEF3F2;
    border:1px solid #FDA29B;
    color:#B42318;
    padding:10px 12px;
    border-radius:6px;
    font-size:12px;
    margin-bottom:12px;
  }

  .review-section-label{
    font-size:13px;
    font-weight:600;
    color:#344054;
    margin-bottom:6px;
  }

  .review-helper{
    font-size:11px;
    color:#98A2B3;
    margin-bottom:10px;
  }

  .review-notes{
    width:100%;
    min-height:120px;
    padding:12px 14px;
    font-size:13px;
    font-family:'Inter',system-ui,sans-serif;
    color:#101828;
    border:1px solid #D0D5DD;
    border-radius:6px;
    resize:vertical;
    outline:none;
    margin-bottom:14px;
    box-sizing:border-box;
    background:#fff;
  }

  .review-notes:focus{
    border-color:#2B6FFF;
    box-shadow:0 0 0 3px rgba(43,111,255,0.12);
  }

  .review-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
  }

  .review-notes-readonly{
    background:#F9FAFB;
    color:#667085;
    cursor:default;
  }

  .review-btn-disabled{
    opacity:0.55;
    cursor:not-allowed;
  } 

  .review-btn-disabled:hover{
    background:inherit;
  }

  .btn-approve,
  .btn-reject{
    min-height:40px;
  }

  .btn-approve{
    background:white;
    color:#12B76A;
    border:1px solid #12B76A;
  }

  .btn-approve:hover{
    background:#ECFDF3;
  }

  .btn-reject{
    background:white;
    color:#F04438;
    border:1px solid #F04438;
  }

  .btn-reject:hover{
    background:#FEF3F2;
  }

</style>
</head>
<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

<div class="stage">
<div class="page">

  <div class="breadcrumb">Submitted Invoices &gt;
    <span class="current">{{ $invoice->invoice_code }}</span>
    </div>

    <div class="page-header-row">

        <div>

            <div class="title-row">

                <h1 class="page-title">
                    Invoice {{ $invoice->invoice_code }}
                </h1>

                <span class="status-pill
                    @if ($invoice->status === 'Submitted')
                        status-submitted
                    @elseif ($invoice->status === 'Approved')
                        status-approved
                    @elseif ($invoice->status === 'Rejected')
                        status-rejected
                    @endif
                ">
                    {{ $invoice->status }}
                </span>

            </div>

            <a
                class="back-link"
                href="{{ route('admin.payment-vouchers.index') }}"
            >
                &larr; Back to Payment Voucher Management
            </a>

        </div>

        <button
            class="btn-download"
            type="button"
        >
            Download PDF
        </button>

    </div>

  <div class="columns">

    <!-- Invoice Details -->
    <div class="card">
      <div class="card-header">
        <h2>Invoice Details</h2>
      </div>

      <div class="card-body">

        <div class="meta-grid">

            <div>

                <div class="meta-block">
                    <div class="meta-label">
                        Billed By:
                    </div>

                    <div class="meta-value">
                        {{
                            $invoice->user?->fullname
                            ?? $invoice->user?->username
                            ?? 'Unknown Developer'
                        }}

                        @if ($invoice->user?->address)
                            <br>
                            {{ $invoice->user->address }}
                        @endif
                    </div>
                </div>

                <div class="meta-block">
                    <div class="meta-label">
                        Project Name
                    </div>

                    <div class="meta-value">
                        {{ $invoice->project?->name ?? '-' }}
                    </div>
                </div>

                <div class="meta-block">
                    <div class="meta-label">
                        Invoice Subject
                    </div>

                    <div class="meta-value">
                        {{ $invoice->subject }}
                    </div>
                </div>

            </div>

            <div>

                <div class="meta-block">
                    <div class="meta-label">
                        Invoice ID
                    </div>

                    <div class="meta-value">
                        {{ $invoice->invoice_code }}
                    </div>
                </div>

                <div class="meta-block">
                    <div class="meta-label">
                        Date Issued
                    </div>

                    <div class="meta-value">
                        {{ $invoice->created_at?->format('F j, Y') ?? '-' }}
                    </div>
                </div>

            </div>

        </div>

        <div class="meta-block">
            <div class="meta-label">
                Invoice Description
            </div>

            <div class="meta-value">
                {{ $invoice->description ?: '-' }}
            </div>
        </div>

        <hr class="divider" style="margin-top:20px;">

        <h3 class="section-label">Invoice Details</h3>

        <table class="items-table">
          <thead>
            <tr>
              <th>Items/ Services</th>
              <th class="align-right">Quantity</th>
              <th class="align-right">Unit Price</th>
              <th class="align-right">Total</th>
            </tr>
          </thead>
          <tbody>

            @foreach ($invoice->items as $item)

                <tr>

                    <td>
                        {{ $item->item_name }}
                    </td>

                    <td class="align-right">
                        {{ $item->quantity }}
                    </td>

                    <td class="align-right">
                        RM {{ number_format($item->unit_price, 2) }}
                    </td>

                    <td class="align-right">
                        RM {{ number_format($item->total_price, 2) }}
                    </td>

                </tr>

            @endforeach

        </tbody>
        </table>

        <div class="summary-lines">

    <div class="summary-line">
        <span>Subtotal</span>
        <span>
            RM {{ number_format($invoice->subtotal, 2) }}
        </span>
        </div>

        <div class="summary-line">
            <span>
                Tax ({{ (float) $invoice->tax_percentage }}%)
            </span>

            <span>
                RM {{ number_format($invoice->tax_amount, 2) }}
            </span>
        </div>

        <div class="summary-line">
            <span>Discount</span>

            <span>
                RM {{ number_format($invoice->discount_amount ?? 0, 2) }}
            </span>
        </div>

        <div class="summary-line total">
            <span>Grand Total</span>

            <span>
                RM {{ number_format($invoice->grand_total, 2) }}
            </span>
        </div>

    </div>

        <h3 class="section-label">
    Supporting Document
</h3>

@if ($invoice->attachment)

    <div class="doc-row">

        <span class="doc-icon">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6Zm4 18H6V4h7v5h5v11Z"/></svg>
        </span>

                <div class="doc-info">
                    <div class="doc-name">{{ basename($invoice->attachment) }}</div>
                </div>

                <div class="doc-actions">

                    <a href="{{ asset('storage/' . $invoice->attachment) }}" target="_blank">View</a>

                    <a href="{{ asset('storage/' . $invoice->attachment) }}" download>Download</a>

                </div>

            </div>

        @else

            <div class="meta-value">No supporting document attached.</div>

        @endif

      </div>
    </div>

    <!-- Right column: Payment Voucher + Admin Review -->
    <div class="right-col">


    {{-- =========================================
         SUBMITTED
         ========================================= --}}
    @if ($invoice->status === 'Submitted')

        {{-- Payment Voucher unavailable --}}
        <div class="card">

            <div class="card-header">
                <h2>Payment Voucher</h2>
            </div>

            <div class="voucher-body">

                <div class="voucher-empty">
                    Payment voucher will be available after
                    the invoice is approved.
                </div>

            </div>

        </div>


        {{-- Admin Review --}}
        <div class="card">

            <div class="card-header">
                <h2>Admin Review</h2>
            </div>


                <div class="voucher-body">

                    @if ($errors->any())

                        <div class="review-errors">

                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach

                        </div>

                    @endif


                    <div class="review-section-label">
                        Review Notes
                    </div>

                    <div class="review-helper">
                        Notes are optional when approving, but required when rejecting an invoice.
                    </div>


                    <textarea
                        class="review-notes"
                        id="review-notes"
                        placeholder="Enter review notes..."
                    >{{ old('notes') }}</textarea>


                    <div class="review-actions">

                        <form
                            action="{{ route('admin.payment-vouchers.invoices.approve', $invoice) }}"
                            method="POST"
                            class="review-form"
                        >
                            @csrf
                            @method('PUT')

                            <input
                                type="hidden"
                                name="notes"
                                class="review-note-value"
                            >

                            <button
                                class="btn btn-approve"
                                type="submit"
                            >
                                Approve Invoice
                            </button>
                        </form>


                        <form
                            action="{{ route('admin.payment-vouchers.invoices.reject', $invoice) }}"
                            method="POST"
                            class="review-form"
                        >
                            @csrf
                            @method('PUT')

                            <input
                                type="hidden"
                                name="notes"
                                class="review-note-value"
                            >

                            <button
                                class="btn btn-reject"
                                type="submit"
                            >
                                Reject Invoice
                            </button>
                        </form>

                    </div>

                </div>

        </div>

    @endif



    {{-- =========================================
         APPROVED - NO VOUCHER YET
         ========================================= --}}
    @if (
        $invoice->status === 'Approved'
        && !$invoice->paymentVoucher
    )

        <div class="card">

            <div class="card-header">
                <h2>Payment Voucher</h2>
            </div>

            <div class="voucher-body">

                <form
                    action="{{ route(
                        'admin.payment-vouchers.invoices.generate',
                        $invoice
                    ) }}"
                    method="POST"
                >
                    @csrf

                    <div class="voucher-field">

                        <label for="payment_method">
                            Payment Method
                        </label>

                        <select
                            id="payment_method"
                            name="payment_method"
                            required
                        >
                            <option value="">
                                Select Payment Method
                            </option>

                            <option value="Bank Transfer">
                                Bank Transfer
                            </option>

                            <option value="Cash">
                                Cash
                            </option>

                            <option value="Cheque">
                                Cheque
                            </option>

                            <option value="Online Payment">
                                Online Payment
                            </option>

                            <option value="Other">
                                Other
                            </option>

                        </select>

                    </div>

                    <div class="amount-block">

                        <div class="amount-label">
                            AMOUNT PAYABLE
                        </div>

                        <div class="amount-value">
                            RM {{ number_format(
                                $invoice->grand_total,
                                2
                            ) }}
                        </div>

                    </div>

                    <button
                        class="btn btn-generate"
                        type="submit"
                    >
                        Generate Payment Voucher
                    </button>

                </form>

            </div>

        </div>


        {{-- Completed Admin Review --}}
        <div class="card">

            <div class="card-header">
                <h2>Admin Review</h2>
            </div>

            <div class="voucher-body">

                <div class="review-section-label">
                    Review Notes
                </div>

                <textarea
                    class="review-notes review-notes-readonly"
                    readonly
                    placeholder="No review notes provided."
                >{{ $invoice->review_notes }}</textarea>

                <div class="review-actions">

                    <button
                        class="btn btn-approve review-btn-disabled"
                        type="button"
                        disabled
                    >
                        Approve Invoice
                    </button>

                    <button
                        class="btn btn-reject review-btn-disabled"
                        type="button"
                        disabled
                    >
                        Reject Invoice
                    </button>

                </div>

            </div>

        </div>

    @endif



    {{-- =========================================
         APPROVED - VOUCHER EXISTS
         ========================================= --}}
    @if (
        $invoice->status === 'Approved'
        && $invoice->paymentVoucher
    )

        @php
            $voucher = $invoice->paymentVoucher;
        @endphp


        <div class="card">

            <div class="card-header">
                <h2>Payment Voucher</h2>
            </div>

            <div class="voucher-body">

                <div class="voucher-row">

                    <span class="label">
                        Voucher Number
                    </span>

                    <span class="value">
                        {{ $voucher->voucher_code }}
                    </span>

                </div>


                <div class="voucher-row">

                    <span class="label">
                        Linked Invoice
                    </span>

                    <span class="value">
                        {{ $invoice->invoice_code }}
                    </span>

                </div>


                <div class="voucher-row">

                    <span class="label">
                        Approved By
                    </span>

                    <span class="value">

                        {{
                            $voucher->reviewer?->fullname
                            ?? $voucher->reviewer?->username
                            ?? 'Admin'
                        }}

                    </span>

                </div>


                <div class="voucher-row">

                    <span class="label">
                        Approved Date
                    </span>

                    <span class="value">

                        {{
                            $voucher->reviewed_at
                                ? $voucher->reviewed_at
                                    ->format('F j, Y')
                                : '-'
                        }}

                    </span>

                </div>


                <div class="voucher-row">

                    <span class="label">
                        Payment Method
                    </span>

                    <span class="value">
                        {{ $voucher->payment_method }}
                    </span>

                </div>


                <div class="amount-block">

                    <div class="amount-label">
                        AMOUNT PAYABLE
                    </div>

                    <div class="amount-value">

                        RM {{ number_format(
                            $voucher->amount,
                            2
                        ) }}

                    </div>

                </div>


                <div class="voucher-actions">

                    <button
                        class="btn btn-outline-blue"
                        type="button"
                    >
                        Email Payment Voucher
                    </button>

                    <button
                        class="btn btn-outline-blue"
                        type="button"
                    >
                        Download Voucher PDF
                    </button>

                </div>

            </div>

        </div>


        {{-- Completed Admin Review --}}
        <div class="card">

            <div class="card-header">
                <h2>Admin Review</h2>
            </div>

            <div class="voucher-body">

                <div class="review-section-label">
                    Review Notes
                </div>

                <textarea
                    class="review-notes review-notes-readonly"
                    readonly
                    placeholder="No review notes provided."
                >{{ $invoice->review_notes }}</textarea>

                <div class="review-actions">

                    <button
                        class="btn btn-approve review-btn-disabled"
                        type="button"
                        disabled
                    >
                        Approve Invoice
                    </button>

                    <button
                        class="btn btn-reject review-btn-disabled"
                        type="button"
                        disabled
                    >
                        Reject Invoice
                    </button>

                </div>

            </div>

        </div>

    @endif



    {{-- =========================================
         REJECTED
         ========================================= --}}
    @if ($invoice->status === 'Rejected')

        <div class="card">

            <div class="card-header">
                <h2>Payment Voucher</h2>
            </div>

            <div class="voucher-body">

                <div class="voucher-empty">
                    No payment voucher is available
                    because this invoice was rejected.
                </div>

            </div>

        </div>


        <div class="card">

            <div class="card-header">
                <h2>Admin Review</h2>
            </div>

            <div class="voucher-body">

                <div class="review-result">

                    <div class="meta-label">
                        Review Status
                    </div>

                    <div class="meta-value">
                        Rejected
                    </div>

                </div>


                <div class="review-result">

                    <div class="meta-label">
                        Reviewed Date
                    </div>

                    <div class="meta-value">

                        {{
                            $invoice->reviewed_at
                                ? $invoice->reviewed_at
                                    ->format('F j, Y')
                                : '-'
                        }}

                    </div>

                </div>


                <textarea
                    class="review-notes"
                    readonly
                >{{ $invoice->review_notes }}</textarea>

            </div>

        </div>

    @endif


    </div>

  </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const reviewNotes =
        document.getElementById('review-notes');

    const reviewForms =
        document.querySelectorAll('.review-form');

    if (!reviewNotes) {
        return;
    }

    reviewForms.forEach(function (form) {

        form.addEventListener('submit', function () {

            const hiddenNotes =
                form.querySelector('.review-note-value');

            hiddenNotes.value =
                reviewNotes.value;

        });

    });

});
</script>

</body>
</html>