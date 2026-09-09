<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Claim Details</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">

<style>

.page{
    width:90%;
    max-width:1400px;
    margin:0 auto;
    padding:28px 24px 64px;
    box-sizing:border-box;
}

.breadcrumb{
    font-size:12px;
    color:#98A2B3;
    margin-bottom:3px;
}

.breadcrumb a{
    color:#101828;
    text-decoration:none;
    font-weight:600;
}

.breadcrumb a:hover{
    color:#2B6FFF;
}

.top-row{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    margin-bottom:12px;
}

.title-area{
    display:flex;
    flex-direction:column;
    gap:4px;
}

.title-status-row{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.page-title{
    font-size:27px;
    line-height:1.05;
    margin:0;
    font-weight:800;
    color:#101828;
}

.back-link{
    font-size:12px;
    color:#475467;
    text-decoration:none;
}

.back-link:hover{
    color:#2B6FFF;
}

.status-badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    border-radius:999px;
    padding:4px 12px;
    font-size:10px;
    font-weight:600;
}

.status-badge::before{
    content:'';
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
}

.status-submitted{
    color:#0B5C88;
    background:#D7F0FF;
}

.status-approved{
    color:#0B7A47;
    background:#BDF4D4;
}

.status-rejected{
    color:#B42318;
    background:#FFD0D5;
}

.btn-download-page{
    background:#0BA5EC;
    color:white;
    border:none;
    text-decoration:none;
    border-radius:5px;
    padding:9px 22px;
    font-size:12px;
    font-weight:600;
    white-space:nowrap;
}

.btn-download-page:hover{
    background:#0096D6;
}

.detail-layout{
    display:grid;
    grid-template-columns:minmax(0, 1.55fr) minmax(280px, .9fr);
    gap:16px;
    align-items:start;
}

.left-column,
.right-column{
    display:flex;
    flex-direction:column;
    gap:14px;
}

.panel{
    background:#fff;
    border-radius:10px;
    border:1px solid #5B8CFF;
    box-shadow:0 6px 10px rgba(37,99,235,0.18);
    overflow:hidden;
}

.panel-title{
    font-size:15px;
    font-weight:700;
    color:#101828;
    padding:12px 14px;
    border-bottom:1px solid #D0D5DD;
}

.claim-info-body{
    padding:12px 18px 16px;
}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    column-gap:40px;
    row-gap:16px;
}

.info-item{
    display:flex;
    flex-direction:column;
    gap:3px;
}

.info-label{
    font-size:12px;
    color:#98A2B3;
    font-weight:600;
}

.info-value{
    font-size:13px;
    color:#101828;
    line-height:1.4;
}

.description-block{
    margin-top:14px;
}

.description-text{
    margin:3px 0 0;
    font-size:13px;
    color:#101828;
    line-height:1.45;
}

.receipt-body{
    padding:14px 18px 17px;
}

.receipt-row{
    border:1px solid #D0D5DD;
    background:#F9FAFB;
    border-radius:7px;
    min-height:62px;
    padding:8px 12px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
}

.receipt-left{
    display:flex;
    align-items:center;
    gap:12px;
    min-width:0;
}

.receipt-icon{
    width:30px;
    height:34px;
    border-radius:6px;
    background:#EAF1FF;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
}

.receipt-icon svg{
    width:17px;
    height:17px;
    stroke:#5B8CFF;
    fill:none;
}

.receipt-file-info{
    min-width:0;
}

.receipt-name{
    font-size:10px;
    color:#101828;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    max-width:260px;
}

.receipt-meta{
    margin-top:2px;
    font-size:9px;
    color:#98A2B3;
}

.view-receipt{
    color:#2B6FFF;
    text-decoration:none;
    font-size:10px;
    font-weight:600;
    white-space:nowrap;
}

.voucher-panel .panel-title{
    background:#C7EDFF;
}

.voucher-body{
    min-height:225px;
    display:flex;
    flex-direction:column;
}

.voucher-state{
    flex:1;
    padding:66px 10px 10px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
}

.pending-dots{
    display:flex;
    gap:13px;
    margin-bottom:12px;
}

.pending-dots span{
    width:17px;
    height:17px;
    background:#D0D5DD;
    border-radius:50%;
}

.state-title{
    font-size:15px;
    font-weight:700;
    color:#475467;
    margin-bottom:16px;
}

.rejected-icon{
    font-size:80px;
    line-height:.7;
    font-weight:300;
    color:#FF9A9F;
    margin:6px 0 14px;
}

.rejected-title{
    font-size:16px;
    font-weight:700;
    color:#475467;
    margin-bottom:12px;
}

.voucher-details{
    padding:7px 10px 10px;
}

.voucher-row{
    display:flex;
    justify-content:space-between;
    gap:16px;
    padding:7px 0;
    border-bottom:1px solid #EAECF0;
    font-size:9px;
}

.voucher-row:last-of-type{
    border-bottom:none;
}

.voucher-row span{
    color:#667085;
}

.voucher-row strong{
    color:#101828;
    font-weight:500;
    text-align:right;
}

.btn-unavailable{
    width:88%;
    margin-top:auto;
    border:1px solid #98A2B3;
    border-radius:6px;
    background:#D0D5DD;
    color:#667085;
    padding:7px 10px;
    font-size:11px;
    cursor:not-allowed;
}

.btn-download-voucher{
    display:block;
    width:88%;
    box-sizing:border-box;
    margin:18px auto 0;
    text-align:center;
    background:#0BA5EC;
    color:white;
    text-decoration:none;
    border-radius:5px;
    padding:8px 12px;
    font-size:11px;
    font-weight:600;
}

.btn-download-voucher:hover{
    background:#0096D6;
}

.notes-panel{
    border-color:#D0D5DD;
}

.notes-body{
    padding:10px 12px 12px;
}

.notes-textarea{
    width:100%;
    min-height:88px;
    box-sizing:border-box;
    resize:none;
    border:1px solid #98A2B3;
    background:#F9FAFB;
    padding:9px 10px;
    font-family:'Inter',sans-serif;
    font-size:10px;
    color:#101828;
}

.btn-new-entry{
    display:block;
    width:48%;
    margin:8px 0 0 auto;
    box-sizing:border-box;
    text-align:center;
    background:#26B8EE;
    color:#fff;
    text-decoration:none;
    padding:7px 12px;
    border-radius:5px;
    font-size:11px;
    font-weight:500;
}

@media (max-width:900px){
    .detail-layout{
        grid-template-columns:1fr;
    }

    .top-row{
        flex-direction:column;
    }

    .info-grid{
        column-gap:20px;
    }
}

@media (max-width:600px){
    .info-grid{
        grid-template-columns:1fr;
    }

    .page{
        width:100%;
        padding-left:14px;
        padding-right:14px;
    }
}
</style>
</head>

<body>

@include('admin.partials.admin-topbar')
@include('admin.partials.admin-nav')

<div class="stage">
<div class="page">

    <div class="breadcrumb">
        <a href="{{ route('developer.claims.index') }}">
            My Claims
        </a>
        &gt;
        {{ $claim->claim_code }}
    </div>

    <div class="top-row">

        <div class="title-area">

            <div class="title-status-row">

                <h1 class="page-title">
                    {{ $claim->title }}
                </h1>

                <span
                    class="status-badge
                    @if ($claim->status === 'Approved')
                        status-approved
                    @elseif ($claim->status === 'Rejected')
                        status-rejected
                    @else
                        status-submitted
                    @endif"
                >
                    {{ $claim->status }}
                </span>

            </div>

            <a href="{{ route('developer.claims.index') }}" class="back-link">← Back to My Claims</a>

        </div>

        <a href="#" class="btn-download-page">↓ Download PDF</a>

    </div>


    <div class="detail-layout">
        <div class="left-column">
            <div class="panel">

                <div class="panel-title">Claim Information</div>
                <div class="claim-info-body">
                    <div class="info-grid">

                        <div class="info-item">
                            <span class="info-label">Submitted By</span>

                            <span class="info-value">
                                {{ $claim->user->name ?? '-' }}
                            </span>
                        </div>


                        <div class="info-item">
                            <span class="info-label">Claim ID</span>
                            <span class="info-value"> {{ $claim->claim_code }}</span>
                        </div>


                        <div class="info-item">
                            <span class="info-label">Amount </span>

                            <span class="info-value">RM {{ number_format($claim->amount, 2) }}</span>
                        </div>


                        <div class="info-item">
                            <span class="info-label">Date Submitted</span>
                            <span class="info-value">{{ $claim->submitted_at?->format('d F Y') ?? '-' }}</span>
                        </div>


                        <div class="info-item">
                            <span class="info-label">Claim Title</span>
                            <span class="info-value">
                                {{ $claim->title }}
                            </span>
                        </div>


                        <div class="info-item">
                            <span class="info-label">Category</span>
                            <span class="info-value">{{ $claim->category->category_name ?? '-' }}</span>
                        </div>


                        @if (
                            optional($claim->category)->category_name === 'Other'
                            && $claim->other_category
                        )
                            <div class="info-item">
                                <span class="info-label">
                                    Specify Category
                                </span>

                                <span class="info-value">
                                    {{ $claim->other_category }}
                                </span>
                            </div>
                        @endif

                    </div>


                    <div class="description-block">
                        <span class="info-label">Description</span>
                        <p class="description-text">
                            {{ $claim->description ?: 'No description provided.' }}
                        </p>

                    </div>
                </div>
            </div>


            <div class="panel">

                <div class="panel-title">Uploaded Receipt</div>
                <div class="receipt-body">
                    <div class="receipt-row">

                        <div class="receipt-left">

                            <div class="receipt-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M6 2h8l4 4v16H6z"/>
                                    <path d="M14 2v5h5"/>
                                </svg>
                            </div>

                            <div class="receipt-file-info">

                                <div class="receipt-name">
                                    {{ basename($claim->receipt) }}
                                </div>

                                <div class="receipt-meta">
                                    Uploaded
                                    {{ $claim->submitted_at?->format('d M Y') ?? '-' }}
                                </div>

                            </div>

                        </div>


                        <a
                            href="{{ asset('storage/' . $claim->receipt) }}"
                            target="_blank"
                            class="view-receipt"
                        >
                            View Receipt →
                        </a>

                    </div>

                </div>

            </div>

        </div>


        <div class="right-column">

            <div class="panel voucher-panel">

                <div class="panel-title">
                    Payment Voucher
                </div>


                <div class="voucher-body">

                    @if ($claim->status === 'Submitted')

                        <div class="voucher-state">

                            <div class="pending-dots">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div class="state-title">
                                Approval pending...
                            </div>

                            <button
                                type="button"
                                class="btn-unavailable"
                                disabled
                            >
                                Download Unavailable
                            </button>

                        </div>


                    @elseif ($claim->status === 'Rejected')

                        <div class="voucher-state">

                            <div class="rejected-icon">
                                ×
                            </div>

                            <div class="rejected-title">
                                Claim Rejected
                            </div>


                            <div style="width:100%;">

                                <div class="voucher-row">
                                    <span>
                                        Reviewed By
                                    </span>

                                    <strong>
                                        {{ $claim->reviewer?->name ?? '-' }}
                                    </strong>
                                </div>

                                <div class="voucher-row">
                                    <span>
                                        Review Date
                                    </span>

                                    <strong>
                                        {{ $claim->reviewed_at?->format('d F Y') ?? '-' }}
                                    </strong>
                                </div>

                            </div>


                            <button
                                type="button"
                                class="btn-unavailable"
                                disabled
                            >
                                Download Unavailable
                            </button>

                        </div>


                    @elseif (
                        $claim->status === 'Approved'
                        && $claim->paymentVoucher
                    )

                        <div class="voucher-details">

                            <div class="voucher-row">
                                <span>
                                    Voucher Number
                                </span>

                                <strong>
                                    {{ $claim->paymentVoucher->voucher_code ?? '-' }}
                                </strong>
                            </div>


                            <div class="voucher-row">
                                <span>
                                    Linked Claim
                                </span>

                                <strong>
                                    {{ $claim->claim_code }}
                                </strong>
                            </div>


                            <div class="voucher-row">
                                <span>
                                    Approved By
                                </span>

                                <strong>
                                    {{ $claim->reviewer?->name ?? '-' }}
                                </strong>
                            </div>


                            <div class="voucher-row">
                                <span>
                                    Approved Date
                                </span>

                                <strong>
                                    {{ $claim->reviewed_at?->format('d F Y') ?? '-' }}
                                </strong>
                            </div>


                            <div class="voucher-row">
                                <span>
                                    Payment Method
                                </span>

                                <strong>
                                    {{ $claim->paymentVoucher->payment_method ?? '-' }}
                                </strong>
                            </div>


                            <a
                                href="#"
                                class="btn-download-voucher"
                            >
                                ↓ Download Voucher PDF
                            </a>

                        </div>


                    @else

                        <div class="voucher-state">

                            <div class="state-title">
                                Voucher unavailable
                            </div>

                            <button
                                type="button"
                                class="btn-unavailable"
                                disabled
                            >
                                Download Unavailable
                            </button>

                        </div>

                    @endif

                </div>

            </div>


            <div class="panel notes-panel">

                <div class="panel-title">
                    Notes
                </div>

                <div class="notes-body">

                    <textarea
                        class="notes-textarea"
                        readonly
                        placeholder="Notes from Admin..."
                    >{{ $claim->paymentVoucher?->notes ?? '' }}</textarea>


                    @if ($claim->status === 'Rejected')

                        <a
                            href="{{ route('developer.claims.create') }}"
                            class="btn-new-entry"
                        >
                            New Entry
                        </a>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>
</div>

</body>
</html>