<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Claim Review</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /*PAGE*/

        .page {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px 24px 64px;
            box-sizing: border-box;
        }

        .breadcrumb {
            font-size: 12px;
            color: #98A2B3;
            margin-bottom: 3px;
        }

        .breadcrumb .current {
            color: #667085;
        }

        .top-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 12px;
        }

        .title-area {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .title-status-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 27px;
            line-height: 1.05;
            margin: 0;
            font-weight: 800;
            color: #101828;
        }

        .back-link {
            font-size: 12px;
            color: #475467;
            text-decoration: none;
        }

        .back-link:hover {
            color: #2B6FFF;
        }

        .btn-download-page {
            background: #0BA5EC;
            color: white;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            padding: 9px 22px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            cursor: pointer;
        }

        .btn-download-page:hover {
            background: #0096D6;
        }


        /*STATUS*/

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 4px 12px;
            font-size: 10px;
            font-weight: 600;
        }

        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-submitted {
            color: #0B5C88;
            background: #D7F0FF;
        }

        .status-approved {
            color: #0B7A47;
            background: #BDF4D4;
        }

        .status-rejected {
            color: #B42318;
            background: #FFD0D5;
        }


        /*MAIN LAYOUT*/

        .detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(300px, .85fr);
            gap: 16px;
            align-items: start;
        }

        .left-column,
        .right-column {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }


        /*PANELS*/

        .panel {
            background: #fff;
            border-radius: 10px;
            border: 1px solid #5B8CFF;
            box-shadow: 0 6px 10px rgba(37, 99, 235, 0.18);
            overflow: hidden;
        }

        .panel-title {
            font-size: 15px;
            font-weight: 700;
            color: #101828;
            padding: 12px 14px;
            border-bottom: 1px solid #D0D5DD;
        }


        /*CLAIM INFORMATION*/

        .claim-info-body {
            padding: 12px 18px 16px;
            min-height: 235px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 40px;
            row-gap: 16px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .info-label {
            font-size: 12px;
            color: #98A2B3;
            font-weight: 600;
        }

        .info-value {
            font-size: 13px;
            color: #101828;
            line-height: 1.4;
        }

        .description-block {
            margin-top: 28px;
        }

        .description-text {
            margin: 3px 0 0;
            font-size: 13px;
            color: #101828;
            line-height: 1.45;
        }


        /*RECEIPT*/

        .receipt-body {
            padding: 14px 18px 17px;
        }

        .receipt-row {
            border: 1px solid #D0D5DD;
            background: #F9FAFB;
            border-radius: 7px;
            min-height: 62px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .receipt-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .receipt-icon {
            width: 30px;
            height: 34px;
            border-radius: 6px;
            background: #EAF1FF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .receipt-icon svg {
            width: 17px;
            height: 17px;
            stroke: #5B8CFF;
            fill: none;
        }

        .receipt-file-info {
            min-width: 0;
        }

        .receipt-name {
            font-size: 10px;
            color: #101828;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 260px;
        }

        .receipt-meta {
            margin-top: 2px;
            font-size: 9px;
            color: #98A2B3;
        }

        .receipt-actions {
            display: flex;
            gap: 14px;
        }

        .receipt-actions a {
            color: #2B6FFF;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }

        .receipt-actions a:hover {
            text-decoration: underline;
        }

        /*PAYMENT VOUCHER*/

        .voucher-body {
            padding: 14px 14px 12px;
            min-height: 175px;
            display: flex;
            flex-direction: column;
        }

        .voucher-empty {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #98A2B3;
            font-size: 12px;
            min-height: 140px;
        }

        .voucher-row {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            padding: 7px 0;
            border-bottom: 1px solid #EAECF0;
            font-size: 12px;
        }

        .voucher-row .label {
            color: #667085;
        }

        .voucher-row .value {
            color: #101828;
            font-weight: 500;
            text-align: right;
        }

        .voucher-field {
            display: flex;
            flex-direction: column;
            gap: 7px;
            margin-top: 10px;
            margin-bottom: 12px;
        }

        .voucher-field label {
            font-size: 12px;
            font-weight: 600;
            color: #344054;
        }

        .voucher-field select {
            width: 100%;
            height: 34px;
            border: 1px solid #D0D5DD;
            border-radius: 5px;
            padding: 0 9px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            outline: none;
            background: #fff;
        }

        .voucher-field select:focus {
            border-color: #2B6FFF;
        }

        .amount-block {
            text-align: center;
            margin: 14px 0;
        }

        .amount-label {
            font-size: 13px;
            color: #667085;
            letter-spacing: .03em;
            margin-bottom: 5px;
        }

        .amount-value {
            font-size: 26px;
            font-weight: 800;
            color: #101828;
        }

        .voucher-actions {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }


        /*BUTTONS*/

        .btn {
            width: 100%;
            box-sizing: border-box;
            min-height: 31px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 5px;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-generate {
            background: #019BEF;
            color: white;
            border: 1px solid #019BEF;
        }

        .btn-generate:hover {
            background: #008DD9;
        }

        .btn-outline-blue {
            background: white;
            color: #019BEF;
            border: 1px solid #019BEF;
        }

        .btn-outline-blue:hover {
            background: #F0F9FF;
        }


        /*ADMIN REVIEW*/

        .review-panel {
            border-color: #D0D5DD;
        }

        .review-body {
            padding: 10px 12px 12px;
        }

        .review-errors {
            background: #FEF3F2;
            border: 1px solid #FDA29B;
            color: #B42318;
            padding: 8px 10px;
            border-radius: 5px;
            font-size: 10px;
            margin-bottom: 8px;
        }

        .review-helper {
            font-size: 10px;
            color: #98A2B3;
            margin-bottom: 7px;
        }

        .review-notes {
            width: 100%;
            min-height: 105px;
            box-sizing: border-box;
            resize: vertical;
            border: 1px solid #98A2B3;
            background: #fff;
            padding: 8px 9px;
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            color: #101828;
            outline: none;
        }

        .review-notes:focus {
            border-color: #2B6FFF;
            box-shadow: 0 0 0 2px rgba(43, 111, 255, .10);
        }

        .review-notes-readonly {
            background: #F9FAFB;
            color: #667085;
            cursor: default;
        }

        .review-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 7px;
            margin-top: 7px;
        }

        .btn-approve {
            background: white;
            border: 1px solid #12B76A;
            color: #12B76A;
        }

        .btn-approve:hover {
            background: #ECFDF3;
        }

        .btn-approved {
            background: #12B76A;
            border-radius: 5px;
            border: 1px solid #12B76A;
            color: white;
            cursor: not-allowed;
            opacity: 1;
        }

        .btn-reject {
            background: white;
            border: 1px solid #F04438;
            color: #F04438;
        }

        .btn-reject:hover {
            background: #FEF3F2;
        }

        .review-btn-disabled {
            opacity: .55;
            cursor: not-allowed;
        }


        /*REJECTED VOUCHER*/

        .rejected-state {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .rejected-icon {
            font-size: 68px;
            line-height: .8;
            font-weight: 300;
            color: #FF9A9F;
            margin-bottom: 12px;
        }

        .rejected-title {
            font-size: 15px;
            font-weight: 700;
            color: #475467;
            margin-bottom: 12px;
        }

        .rejected-details {
            width: 100%;
            margin-top: 5px;
        }


        /*RESPONSIVE*/

        @media(max-width:900px) {

            .detail-layout {
                grid-template-columns: 1fr;
            }

            .top-row {
                flex-direction: column;
            }
        }

        @media(max-width:600px) {

            .info-grid {
                grid-template-columns: 1fr;
            }

            .page {
                width: 100%;
                padding-left: 14px;
                padding-right: 14px;
            }
        }
    </style>

</head>


<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')


    <div class="stage">
        <div class="page">


            {{-- HEADER --}}

            <div class="breadcrumb">
                Submitted Claims &gt;
                <span class="current">{{ $claim->claim_code }}</span>
            </div>

            <div class="top-row">
                <div class="title-area">
                    <div class="title-status-row">
                        <h1 class="page-title">{{ $claim->title }}</h1>

                        <span
                            class="status-badge

                    @if ($claim->status === 'Approved') status-approved

                    @elseif ($claim->status === 'Rejected')
                        status-rejected

                    @else
                        status-submitted @endif">

                            {{ $claim->status }}

                        </span>

                    </div>


                    <a href="{{ route('admin.payment-vouchers.index') }}" class="back-link">← Back to Payment Voucher
                        Management</a>
                </div>


                <button type="button" class="btn-download-page">↓ Download PDF</button>
            </div>


            <div class="detail-layout">


                {{-- LEFT COLUMN --}}

                <div class="left-column">

                    {{-- CLAIM INFORMATION --}}
                    <div class="panel">

                        <div class="panel-title">Claim Information</div>
                        <div class="claim-info-body">
                            <div class="info-grid">
                                <div class="info-item">

                                    <span class="info-label">Submitted By</span>
                                    <span class="info-value">

                                        {{ $claim->user?->fullname ?? ($claim->user?->username ?? 'Unknown Developer') }}

                                    </span>
                                </div>

                                <div class="info-item">
                                    <span class="info-label">Claim ID</span>
                                    <span class="info-value">{{ $claim->claim_code }}</span>
                                </div>



                                <div class="info-item">
                                    <span class="info-label">Amount</span>
                                    <span class="info-value">

                                        RM
                                        {{ number_format($claim->amount, 2) }}

                                    </span>
                                </div>


                                <div class="info-item">
                                    <span class="info-label">Date Submitted</span>
                                    <span class="info-value">

                                        {{ $claim->submitted_at ? $claim->submitted_at->format('j F Y') : '-' }}

                                    </span>
                                </div>


                                <div class="info-item">
                                    <span class="info-label">Claim Title</span>
                                    <span class="info-value">{{ $claim->title }}</span>
                                </div>



                                <div class="info-item">
                                    <span class="info-label">Category</span>
                                    <span class="info-value">

                                        {{ $claim->category?->category_name ?? '-' }}

                                    </span>
                                </div>

                                @if ($claim->category?->category_name === 'Other' && $claim->other_category)
                                    <div class="info-item">
                                        <span class="info-label">Specify Category</span>
                                        <span class="info-value">{{ $claim->other_category }}</span>
                                    </div>
                                @endif


                            </div>



                            <div class="description-block">
                                <span class="info-label">Description
                                </span>

                                <p class="description-text">

                                    {{ $claim->description ?: 'No description provided.' }}

                                </p>
                            </div>

                        </div>

                    </div>



                    {{-- UPLOADED RECEIPT --}}
                    <div class="panel">

                        <div class="panel-title">Uploaded Receipt</div>
                        <div class="receipt-body">
                            <div class="receipt-row">
                                <div class="receipt-left">
                                    <div class="receipt-icon">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M6 2h8l4 4v16H6z" />
                                            <path d="M14 2v5h5" />
                                        </svg>
                                    </div>


                                    <div class="receipt-file-info">

                                        <div class="receipt-name">
                                            {{ basename($claim->receipt) }}
                                        </div>


                                        <div class="receipt-meta">Uploaded
                                            {{ $claim->submitted_at ? $claim->submitted_at->format('j M Y') : '-' }}
                                        </div>
                                    </div>
                                </div>



                                <div class="receipt-actions">
                                    <a href="{{ asset('storage/' . $claim->receipt) }}" ntarget="_blank">View</a>
                                    <a href="{{ asset('storage/' . $claim->receipt) }}" download>Download</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                {{-- RIGHT COLUMN --}}

                <div class="right-column">

                    {{-- SUBMITTED --}}

                    @if ($claim->status === 'Submitted')


                        <div class="panel">
                            <div class="panel-title">Payment Voucher</div>
                            <div class="voucher-body">
                                <div class="voucher-empty">
                                    Payment voucher will be available after the claim is approved.
                                </div>
                            </div>
                        </div>



                        <div class="panel review-panel">
                            <div class="panel-title">Admin Review</div>
                            <div class="review-body">


                                @if ($errors->any())

                                    <div class="review-errors">

                                        @foreach ($errors->all() as $error)
                                            <div>
                                                {{ $error }}
                                            </div>
                                        @endforeach

                                    </div>

                                @endif



                                <div class="review-helper">
                                    Notes are optional when approving, but required when rejecting a claim.
                                </div>



                                <textarea id="review-notes" class="review-notes" placeholder="Notes from Admin...">{{ old('notes') }}</textarea>
                                <div class="review-actions">


                                    <form action="{{ route('admin.payment-vouchers.claims.approve', $claim) }}"
                                        method="POST" class="review-form">

                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="notes" class="review-note-value">
                                        <button type="submit" class="btn btn-approve">Approve Claim</button>
                                    </form>



                                    <form action="{{ route('admin.payment-vouchers.claims.reject', $claim) }}"
                                        method="POST" class="review-form">

                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="notes" class="review-note-value">
                                        <button type="submit" class="btn btn-reject">Reject Claim</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @endif




                    {{-- APPROVED - NO VOUCHER YET --}}

                    @if ($claim->status === 'Approved' && !$claim->paymentVoucher)
                        <div class="panel">
                            <div class="panel-title">Payment Voucher</div>
                            <div class="voucher-body">

                                <div class="voucher-row">
                                    <span class="label">Linked Claim</span>
                                    <span class="value">{{ $claim->claim_code }}</span>
                                </div>



                                <div class="voucher-row">
                                    <span class="label">Approved By</span>
                                    <span class="value">

                                        {{ $claim->reviewer?->fullname ?? ($claim->reviewer?->username ?? 'Admin') }}

                                    </span>
                                </div>


                                <div class="voucher-row">

                                    <span class="label">Approved Date</span>
                                    <span class="value">

                                        {{ $claim->reviewed_at ? $claim->reviewed_at->format('j F Y') : '-' }}

                                    </span>
                                </div>

                                <form action="{{ route('admin.payment-vouchers.claims.generate', $claim) }}"
                                    method="POST">

                                    @csrf

                                    <div class="amount-block">

                                        <div class="amount-label">AMOUNT PAYABLE</div>
                                        <div class="amount-value">

                                            RM
                                            {{ number_format($claim->amount, 2) }}

                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-generate">Generate Payment Voucher</button>
                                </form>
                            </div>
                        </div>



                        <div class="panel review-panel">
                            <div class="panel-title">Admin Review</div>
                            <div class="review-body">


                                <textarea class="review-notes review-notes-readonly" readonly placeholder="No review notes provided.">{{ $claim->review_notes }}</textarea>

                                <div class="review-actions">
                                    <button type="button" class="btn-approved" disabled>Approved</button>
                                    <button type="button" class="btn btn-reject review-btn-disabled" disabled>Reject
                                        Claim</button>
                                </div>

                            </div>
                        </div>
                    @endif




                    {{-- APPROVED - VOUCHER EXISTS --}}

                    @if ($claim->status === 'Approved' && $claim->paymentVoucher)
                        @php
                            $voucher = $claim->paymentVoucher;
                        @endphp



                        <div class="panel">

                            <div class="panel-title">Payment Voucher</div>
                            <div class="voucher-body">
                                <div class="voucher-row">
                                    <span class="label">Voucher Number</span>
                                    <span class="value">{{ $voucher->voucher_code }}</span>
                                </div>

                                <div class="voucher-row">
                                    <span class="label">Linked Claim</span>
                                    <span class="value">{{ $claim->claim_code }}</span>
                                </div>



                                <div class="voucher-row">
                                    <span class="label">Approved By</span>
                                    <span class="value">

                                        {{ $voucher->reviewer?->fullname ?? ($voucher->reviewer?->username ?? 'Admin') }}

                                    </span>
                                </div>



                                <div class="voucher-row">
                                    <span class="label">Approved Date</span>
                                    <span class="value">

                                        {{ $voucher->reviewed_at ? $voucher->reviewed_at->format('j F Y') : '-' }}

                                    </span>
                                </div>

                                <div class="voucher-row">
                                    <span class="label">Payment Method </span>
                                    <span class="value">{{ $voucher->payment_method }}</span>
                                </div>



                                <div class="amount-block">
                                    <div class="amount-label">AMOUNT PAYABLE</div>
                                    <div class="amount-value">

                                        RM
                                        {{ number_format($voucher->amount, 2) }}

                                    </div>
                                </div>

                                <div class="voucher-actions">
                                    <button type="button" class="btn btn-outline-blue">Email Payment Voucher</button>
                                    <a href="{{ route('admin.payment-vouchers.pdf', $voucher) }}"
                                        class="btn btn-outline-blue">Download Voucher PDF</a>
                                </div>
                            </div>
                        </div>



                        <div class="panel review-panel">
                            <div class="panel-title">Admin Review</div>
                            <div class="review-body">


                                <textarea class="review-notes review-notes-readonly" readonly placeholder="No review notes provided.">{{ $claim->review_notes }}</textarea>
                                <div class="review-actions">
                                    <button type="button" class="btn-approved" disabled>Approved</button>
                                    <button type="button" class="btn btn-reject review-btn-disabled" disabled>Reject
                                        Claim</button>
                                </div>
                            </div>
                        </div>
                    @endif




                    {{-- REJECTED --}}

                    @if ($claim->status === 'Rejected')
                        <div class="panel">
                            <div class="panel-title">Payment Voucher</div>
                            <div class="voucher-body">
                                <div class="rejected-state">

                                    <div class="rejected-icon">×</div>
                                    <div class="rejected-title">Claim Rejected</div>
                                    <div class="rejected-details">
                                        <div class="voucher-row">

                                            <span class="label">Reviewed By</span>
                                            <span class="value">
                                                {{ $claim->reviewer?->fullname ?? ($claim->reviewer?->username ?? 'Admin') }}
                                            </span>
                                        </div>



                                        <div class="voucher-row">
                                            <span class="label">Review Date</span>
                                            <span class="value">

                                                {{ $claim->reviewed_at ? $claim->reviewed_at->format('j F Y') : '-' }}

                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel review-panel">
                            <div class="panel-title">Admin Review</div>
                            <div class="review-body">

                                <textarea class="review-notes review-notes-readonly" readonly placeholder="No review notes provided.">{{ $claim->review_notes }}</textarea>

                                <div class="review-actions">

                                    <button type="button" class="btn btn-approve review-btn-disabled"
                                        disabled>Approve Claim</button>
                                    <button type="button" class="btn btn-reject review-btn-disabled" disabled>Reject
                                        Claim</button>

                                </div>
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const reviewNotes =
                document.getElementById(
                    'review-notes'
                );

            const reviewForms =
                document.querySelectorAll(
                    '.review-form'
                );


            if (!reviewNotes) {
                return;
            }


            reviewForms.forEach(
                function(form) {

                    form.addEventListener(
                        'submit',
                        function() {

                            const hiddenNotes =
                                form.querySelector(
                                    '.review-note-value'
                                );


                            hiddenNotes.value =
                                reviewNotes.value;

                        }
                    );

                }
            );

        });
    </script>


</body>

</html>
