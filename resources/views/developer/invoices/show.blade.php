<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice Details</title>
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
    padding:10px 20px;
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
    grid-template-columns:1.6fr 1fr;
    gap:24px;
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

  .invoice-card-header{
    padding:18px 24px;
    border-bottom:1px solid #E4E7EC;
  }

  .invoice-card-header h2{
    font-size:18px;
    font-weight:700;
    margin:0;
  }

  .invoice-card-body{
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

  .doc-download{
    font-size:13px;
    font-weight:600;
    color:#2B6FFF;
    text-decoration:none;
  }

  .doc-download:hover{
    text-decoration:underline;
  }

  /* ---------- Payment voucher card ---------- */

  .voucher-header{
    background:#D1E9FF;
    border-radius:14px 14px 0 0;
    padding:16px 24px;
  }

  .voucher-header h2{
    font-size:17px;
    font-weight:700;
    color:#175CD3;
    margin:0;
  }

  .voucher-body{
    padding:18px 24px 22px;
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

  .amount-block{
    text-align:center;
    margin:20px 0 18px;
  }

  .amount-label{
    font-size:12px;
    color:#98A2B3;
    letter-spacing:0.05em;
    margin-bottom:6px;
  }

  .amount-value{
    font-size:30px;
    font-weight:800;
    color:#101828;
  }

  .voucher-notes{
    width:100%;
    min-height:80px;
    padding:12px 14px;
    font-size:13px;
    font-family:'Inter',system-ui,sans-serif;
    color:#101828;
    border:1px solid #D0D5DD;
    border-radius:10px;
    resize:vertical;
    background:white;
    margin-bottom:18px;
  }

  .voucher-notes::placeholder{
    color:#98A2B3;
  }

  .btn-voucher-pdf{
    width:100%;
    background:#019BEF;
    color:white;
    border:none;
    padding:11px;
    border-radius:5px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
  }

  .btn-voucher-pdf svg{
    width:14px;
    height:14px;
    fill:white;
  }

  .btn-voucher-pdf:hover{
    background:#1f5ae0;
  }

  .voucher-pending{
    min-height:300px;
    display:flex;
    flex-direction:column;
    align-items:center;
    text-align:center;
    padding:36px 18px 12px;
  }

  .pending-dots{
      display:flex;
      gap:10px;
      margin-top:auto;
      margin-bottom:14px;
  }

  .pending-dots span{
      width:14px;
      height:14px;
      border-radius:50%;
      background:#D0D5DD;
  }

  .pending-text{
      font-size:16px;
      font-weight:700;
      color:#475467;
      margin-bottom:0;
  }

  .pending-subtext{
      font-size:12px;
      color:#98A2B3;
      margin-bottom:22px;
  }

  .btn-voucher-pdf.disabled{
      margin-top:auto;
      width:100%;
      background:#D0D5DD;
      color:#667085;
      cursor:not-allowed;
      box-shadow:none;
  }

  .btn-voucher-pdf.disabled:hover{
      background:#D0D5DD;
  }

  .voucher-rejected{
      min-height:300px;
      display:flex;
      flex-direction:column;
      justify-content:center;
  }

  .rejected-title{
      font-size:18px;
      font-weight:700;
      color:#B42318;
      text-align:center;
      margin-bottom:8px;
  }

  .rejected-message{
      font-size:13px;
      color:#667085;
      text-align:center;
      margin-bottom:20px;
  }

  .rejection-notes{
      background:#FEF3F2;
      border:1px solid #FDA29B;
      border-radius:10px;
      padding:14px;
      margin-bottom:18px;
  }

  .rejection-notes-label{
      font-size:12px;
      font-weight:700;
      color:#B42318;
      margin-bottom:6px;
  }

  .rejection-notes-content{
      font-size:13px;
      color:#344054;
      line-height:1.5;
  }

</style>
</head>
<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

  <div class="stage">
    <div class="page">
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

          <a class="back-link" href="{{ route('developer.invoices.index') }}">&larr; Back to My Invoices</a>

      </div>


      <button class="btn-download" type="button">
          <svg viewBox="0 0 24 24"><path d="M5 20h14v-2H5v2ZM19 9h-4V3H9v6H5l7 7 7-7Z"/></svg>
          Download PDF</button>

    </div>

  <div class="columns">

    <!-- Invoice card -->
    <div class="card">
      <div class="invoice-card-header">
        <h2>{{ $invoice->subject }}</h2>
      </div>

      <div class="invoice-card-body">

        <div class="meta-grid">
          <div>
            <div class="meta-block">
    <div class="meta-label">Billed By:</div>
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
              <div class="meta-label">Project Name</div>
              <div class="meta-value">{{ $invoice->project?->name ?? '-' }}</div>
            </div>
            <div class="meta-block">
              <div class="meta-label">Invoice Subject</div>
              <div class="meta-value">{{ $invoice->subject }}</div>
            </div>
          </div>

          <div>
            <div class="meta-block">
              <div class="meta-label">Invoice ID</div>
              <div class="meta-value">{{ $invoice->invoice_code }}</div>
            </div>
            <div class="meta-block">
              <div class="meta-label">Date Issued</div>
              <div class="meta-value">{{ $invoice->created_at?->format('F j, Y') ?? '-' }}</div>
            </div>
          </div>
        </div>

        <div class="meta-block">
          <div class="meta-label">Invoice Description</div>
          <div class="meta-value">{{ $invoice->description ?: '-' }}</div>
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

                      <td>{{ $item->item_name }}</td>

                      <td class="align-right">{{ $item->quantity }}</td>

                      <td class="align-right">RM {{ number_format($item->unit_price, 2) }}</td>

                      <td class="align-right">RM {{ number_format($item->total_price, 2) }}</td>

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

        <h3 class="section-label">Supporting Document</h3>

        @if ($invoice->attachment)

            <div class="doc-row">

                <span class="doc-icon">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6Zm4 18H6V4h7v5h5v11Z"/></svg>
                </span>

                <div class="doc-info">

                    <div class="doc-name">{{ basename($invoice->attachment) }}</div>

                </div>

                <a class="doc-download" href="{{ asset('storage/' . $invoice->attachment) }}" target="_blank">View</a>

            </div>

        @else

            <div class="meta-value">No supporting document attached.</div>

        @endif

      </div>
    </div>

    <!-- Payment Voucher card -->
    <div class="card">

        <div class="voucher-header">
            <h2>Payment Voucher</h2>
        </div>

        <div class="voucher-body">

            @if ($invoice->status === 'Submitted')

                <div class="voucher-pending">

                    <div class="pending-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="pending-text">
                        Approval pending...
                    </div>

                    <button
                        class="btn-voucher-pdf disabled"
                        type="button"
                        disabled
                    >
                        Download Unavailable
                    </button>

                </div>


            @elseif ($invoice->status === 'Approved' && !$invoice->paymentVoucher)

                <div class="voucher-pending">

                    <div class="pending-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>

                    <div class="pending-text">
                        Invoice approved.
                    </div>

                    <div class="pending-subtext">
                        Waiting for payment voucher generation.
                    </div>

                    <button
                        class="btn-voucher-pdf disabled"
                        type="button"
                        disabled
                    >
                        Download Unavailable
                    </button>

                </div>


            @elseif ($invoice->status === 'Approved' && $invoice->paymentVoucher)

                @php
                    $voucher = $invoice->paymentVoucher;
                @endphp

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
                                ? $voucher->reviewed_at->format('F j, Y')
                                : '-'
                        }}
                    </span>
                </div>

                <div class="voucher-row">
                    <span class="label">
                        Payment Method
                    </span>

                    <span class="value">
                        {{ $voucher->payment_method ?? '-' }}
                    </span>
                </div>

                <div class="amount-block">

                    <div class="amount-label">
                        AMOUNT PAYABLE
                    </div>

                    <div class="amount-value">
                        RM {{ number_format($voucher->amount, 2) }}
                    </div>

                </div>

                <textarea
                    class="voucher-notes"
                    readonly
                >{{ $voucher->notes ?? $invoice->review_notes ?? '' }}</textarea>

                <button
                    class="btn-voucher-pdf"
                    type="button"
                >
                    <svg viewBox="0 0 24 24">
                        <path d="M5 20h14v-2H5v2ZM19 9h-4V3H9v6H5l7 7 7-7Z"/>
                    </svg>

                    Download Voucher PDF
                </button>


            @elseif ($invoice->status === 'Rejected')

                <div class="voucher-rejected">

                    <div class="rejected-title">
                        Invoice Rejected
                    </div>

                    <div class="rejected-message">
                        This invoice was rejected by the admin.
                    </div>

                    @if ($invoice->review_notes)

                        <div class="rejection-notes">

                            <div class="rejection-notes-label">
                                Admin Notes
                            </div>

                            <div class="rejection-notes-content">
                                {{ $invoice->review_notes }}
                            </div>

                        </div>

                    @endif

                    <button
                        class="btn-voucher-pdf disabled"
                        type="button"
                        disabled
                    >
                        Download Unavailable
                    </button>

                </div>

            @endif

        </div>

    </div>

  </div>
</div>
</div>
</div>

</body>
</html>