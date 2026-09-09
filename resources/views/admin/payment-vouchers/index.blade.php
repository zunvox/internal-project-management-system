<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Voucher Management</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>

body{
    font-family:'Inter',system-ui,sans-serif;
}

/* ---------- Page ---------- */

body{
    margin:0;
    display:flex;
    flex-direction:column;
    font-family:'Inter',system-ui,sans-serif;
    color:black;
    min-height: 100vh;
}
  
.page{
    width:90%;
    max-width:1400px;
    margin:0 auto;
    padding:28px 24px 64px;
    box-sizing:border-box;
}

.page-title{
    font-size:26px;
    font-weight:800;
    margin:0 0 14px;
    color:#101828;
}

/* ---------- Filter / Tabs Row ---------- */

.filter-row{
    display:flex;
    align-items:center;
    min-height:38px;
    margin-bottom:16px;
    border-bottom:1px solid #E4E7EC;
    border-top:1px solid #E4E7EC;
}

/* Type dropdown */

.type-filter{
    min-width:135px;
    height:36px;
    border:none;
    border-right:1px solid #E4E7EC;
    background:#F2F4F7;
    padding:0 14px;
    font-family:'Inter',system-ui,sans-serif;
    font-size:13px;
    color:#101828;
    outline:none;
    cursor:pointer;
}


/* Tabs */

.status-tabs{
    display:flex;
    align-items:stretch;
    height:36px;
}

.status-tab{
    display:flex;
    align-items:center;
    gap:4px;
    padding:0 18px;
    text-decoration:none;
    font-size:13px;
    font-weight:500;
    color:#344054;
    border-bottom:3px solid transparent;
    transition:0.15s ease;
    white-space:nowrap;
}

.status-tab:hover{
    background:#F9FAFB;
}

.status-tab.active{
    border-bottom-color:#7F9CF5;
    background:#EEF4FF;
}

/* Count circle */

.tab-count{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:17px;
    height:17px;
    padding:0 4px;
    border-radius:999px;
    background:#A6E9FA;
    color:#175CD3;
    font-size:9px;
    font-weight:600;
    box-sizing:border-box;
}

/* Search */

.search-field{
    position:relative;
    min-width:220px;
    margin-left:auto;
    margin-right:8px;
}

.search-field svg{
    position:absolute;
    left:7px;
    top:50%;
    transform:translateY(-50%);
    width:14px;
    height:14px;
    fill:#98A2B3;
}

.search-field input{
    width:100%;
    height:20px;
    box-sizing:border-box;
    padding:2px 8px 2px 22px;
    font-size:10px;
    font-family:'Inter',system-ui,sans-serif;
    border:1px solid #BFC4CC;
    border-radius:7px;
    outline:none;
    background:white;
}

.search-field input::placeholder{
    color:#98A2B3;
}

/* ---------- Table Card ---------- */

.voucher-card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    padding:20px 28px 12px;
    box-shadow:0 5px 10px rgba(43,111,255,0.28);
    overflow:hidden;
}

.table-wrapper{
    width:100%;
    overflow-x:auto;
}

.voucher-table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

.voucher-table th{
    text-align:left;
    font-size:16px;
    font-weight:700;
    color:#101828;
    padding:8px 8px;
    border-bottom:1px solid #D0D5DD;
}

.voucher-table td{
    font-size:14px;
    color:#344054;
    padding:10px 8px;
    border-bottom:1px solid #D0D5DD;
    vertical-align:middle;
}

/* Column widths */

.col-id{
    width:14%;
}

.col-subject{
    width:22%;
}

.col-developer{
    width:18%;
}

.col-date{
    width:18%;
}

.col-amount{
    width:14%;
}

.col-status{
    width:10%;
}

.col-action{
    width:4%;
    text-align:center;
}

/* ---------- Status Pills ---------- */

.status-pill{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:72px;
    padding:3px 10px;
    border-radius:999px;
    font-size:9px;
    font-weight:500;
    box-sizing:border-box;
}

.status-submitted{
    background:#175D84;
    color:white;
}

.status-approved{
    background:#86EFA4;
    color:#166534;
}

.status-rejected{
    background:#FF7474;
    color:white;
}

/* ---------- Action Button ---------- */

.action-link{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    width:24px;
    height:24px;
    border:1px solid #D0D5DD;
    border-radius:4px;
    text-decoration:none;
    background:white;
    transition:0.15s ease;
}

.action-link:hover{
    background:#F2F4F7;
    border-color:#98A2B3;
}

.action-link svg{
    width:15px;
    height:15px;
    stroke:#344054;
    fill:none;
    stroke-width:1.7;
}

/* ---------- Empty State ---------- */

.empty-row td{
    text-align:center;
    color:#98A2B3;
    padding:28px 10px;
}

.claim-empty-row td{
    text-align:center;
    color:#98A2B3;
    padding:28px 10px;
}

/* ---------- Pagination placeholder ---------- */

.pagination-area{
    display:flex;
    justify-content:flex-end;
    gap:5px;
    margin-top:8px;
}

.page-button{
    width:25px;
    height:23px;
    border:none;
    border-radius:3px;
    background:#EAECF0;
    color:#344054;
    font-size:10px;
    cursor:pointer;
}

.page-button.active{
    background:#019BEF;
    color:white;
}

/* ---------- Responsive ---------- */

@media(max-width:900px){

    .filter-row{
        flex-wrap:wrap;
        gap:4px;
        padding-bottom:6px;
    }

    .status-tabs{
        overflow-x:auto;
        max-width:100%;
    }

    .search-field{
        margin-left:0;
        margin-top:4px;
    }

    .voucher-card{
        padding:16px;
    }

    .voucher-table{
        min-width:850px;
    }
}

</style>

</head>

<body>

@include('admin.partials.admin-topbar')
@include('admin.partials.admin-nav')

<div class="stage">
<div class="page">

    <h1 class="page-title">
        Payment Voucher Management
    </h1>

    <!-- Filters -->
    <div class="filter-row">

        <select class="type-filter" id="request-type">
            <option value="both">Both</option>
            <option value="invoice">Invoice</option>
            <option value="claim">Claim</option>
        </select>

        <div class="status-tabs">

            <a
                href="{{ route('admin.payment-vouchers.index') }}"
                class="status-tab {{ !$status ? 'active' : '' }}"
            >
                All Requests
                <span class="tab-count">{{ $counts['all'] }}</span>
            </a>

            <a
                href="{{ route('admin.payment-vouchers.index', ['status' => 'Submitted']) }}"
                class="status-tab {{ $status === 'Submitted' ? 'active' : '' }}"
            >
                Submitted
                <span class="tab-count">{{ $counts['submitted'] }}</span>
            </a>

            <a
                href="{{ route('admin.payment-vouchers.index', ['status' => 'Approved']) }}"
                class="status-tab {{ $status === 'Approved' ? 'active' : '' }}"
            >
                Approved
                <span class="tab-count">{{ $counts['approved'] }}</span>
            </a>

            <a
                href="{{ route('admin.payment-vouchers.index', ['status' => 'Rejected']) }}"
                class="status-tab {{ $status === 'Rejected' ? 'active' : '' }}"
            >
                Rejected
                <span class="tab-count">{{ $counts['rejected'] }}</span>
            </a>

        </div>

        <div class="search-field">

            <svg viewBox="0 0 24 24"><path d="M15.5 14h-.79l-.28-.27a6.47 6.47 0 0 0 1.57-4.23 6.5 6.5 0 1 0-6.5 6.5c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.5 4.5 0 0 1 9.5 14Z"/></svg>
            <input type="text" id="voucher-search" placeholder="Search">

        </div>

    </div>


    <!-- Table -->
    <div class="voucher-card">

        <div class="table-wrapper">

            <table class="voucher-table">

                <thead>
                    <tr>
                        <th class="col-id">ID</th>
                        <th class="col-subject">Subject</th>
                        <th class="col-developer">Developer</th>
                        <th class="col-date">Date Submitted</th>
                        <th class="col-amount">Amount (RM)</th>
                        <th class="col-status">Status</th>
                        <th class="col-action"></th>
                    </tr>
                </thead>

                <tbody id="voucher-table-body">

                    @foreach ($invoices as $invoice)

                        <tr
                            class="voucher-row"
                            data-type="invoice"
                            data-search="{{ strtolower(
                                $invoice->invoice_code . ' ' .
                                $invoice->subject . ' ' .
                                ($invoice->user?->fullname ?? '') . ' ' .
                                ($invoice->user?->username ?? '') . ' ' .
                                $invoice->status
                            ) }}"
                        >

                            <td>
                                {{ $invoice->invoice_code }}
                            </td>

                            <td>
                                {{ $invoice->subject }}
                            </td>

                            <td>
                                {{
                                    $invoice->user?->fullname
                                    ?? $invoice->user?->username
                                    ?? 'Unknown Developer'
                                }}
                            </td>

                            <td>
                                {{
                                    $invoice->submitted_at
                                        ? $invoice->submitted_at->format('j F Y')
                                        : '-'
                                }}
                            </td>

                            <td>
                                {{ number_format($invoice->grand_total, 2) }}
                            </td>

                            <td>

                                @if ($invoice->status === 'Submitted')

                                    <span class="status-pill status-submitted">
                                        Submitted
                                    </span>

                                @elseif ($invoice->status === 'Approved')

                                    <span class="status-pill status-approved">
                                        Approved
                                    </span>

                                @elseif ($invoice->status === 'Rejected')

                                    <span class="status-pill status-rejected">
                                        Rejected
                                    </span>

                                @endif

                            </td>

                            <td class="col-action">

                                <a
                                    href="{{ route(
                                        'admin.payment-vouchers.invoices.show',
                                        $invoice
                                    ) }}"
                                    class="action-link"
                                    title="View request"
                                >

                                    <svg viewBox="0 0 24 24">
                                        <rect
                                            x="5"
                                            y="4"
                                            width="14"
                                            height="17"
                                            rx="2"
                                        ></rect>

                                        <path d="M9 2h6v4H9z"></path>
                                        <path d="M8 10h8"></path>
                                        <path d="M8 14h8"></path>
                                        <path d="M8 18h6"></path>
                                    </svg>

                                </a>

                            </td>

                        </tr>

                    @endforeach

                    @foreach ($claims as $claim)

                        <tr
                            class="voucher-row"
                            data-type="claim"

                            data-search="{{ strtolower(
                                $claim->claim_code . ' ' .
                                $claim->title . ' ' .
                                ($claim->user?->fullname ?? '') . ' ' .
                                ($claim->user?->username ?? '') . ' ' .
                                ($claim->category?->category_name ?? '') . ' ' .
                                $claim->status
                            ) }}"
                        >

                            <td>
                                {{ $claim->claim_code }}
                            </td>

                            <td>
                                {{ $claim->title }}
                            </td>

                            <td>
                                {{
                                    $claim->user?->fullname
                                    ?? $claim->user?->username
                                    ?? 'Unknown Developer'
                                }}
                            </td>

                            <td>
                                {{
                                    $claim->submitted_at
                                        ? $claim->submitted_at->format('j F Y')
                                        : '-'
                                }}
                            </td>

                            <td>
                                {{ number_format($claim->amount, 2) }}
                            </td>

                            <td>

                                @if ($claim->status === 'Submitted')

                                    <span class="status-pill status-submitted">
                                        Submitted
                                    </span>

                                @elseif ($claim->status === 'Approved')

                                    <span class="status-pill status-approved">
                                        Approved
                                    </span>

                                @elseif ($claim->status === 'Rejected')

                                    <span class="status-pill status-rejected">
                                        Rejected
                                    </span>

                                @endif

                            </td>

                            <td class="col-action">

                                {{-- Admin Claim Detail link --}}
                                <a href="{{ route('admin.payment-vouchers.claims.show', $claim) }}" class="action-link" title="View request">
                                    <svg viewBox="0 0 24 24">
                                        <rect
                                            x="5"
                                            y="4"
                                            width="14"
                                            height="17"
                                            rx="2"
                                        ></rect>

                                        <path d="M9 2h6v4H9z"></path>
                                        <path d="M8 10h8"></path>
                                        <path d="M8 14h8"></path>
                                        <path d="M8 18h6"></path>
                                    </svg>
                                </a>

                            </td>

                        </tr>

                    @endforeach

                    @if ($invoices->isEmpty() && $claims->isEmpty())

                        <tr class="empty-row" id="database-empty-row">

                            <td colspan="7">
                                No payment voucher requests found.
                            </td>

                        </tr>

                    @endif

                    <tr id="no-search-results" class="empty-row" style="display:none;">
                        <td colspan="7">No matching requests found.</td>
                    </tr>

                </tbody>

            </table>

        </div>

        <!--
            Static pagination appearance for now.
            We will replace this with Laravel pagination once
            the controller uses paginate().
        -->
        <div class="pagination-area">
            <button type="button" class="page-button active">1</button>
        </div>

    </div>

</div>
</div>

<script>

const searchInput =
    document.getElementById('voucher-search');

const requestType =
    document.getElementById('request-type');

const rows =
    document.querySelectorAll('.voucher-row');

const noResults =
    document.getElementById('no-search-results');

const databaseEmptyRow =
    document.getElementById('database-empty-row');


function updateTable()
{
    const selectedType =
        requestType.value;

    const searchValue =
        searchInput.value
            .toLowerCase()
            .trim();

    let visibleRows = 0;


    rows.forEach(function (row)
    {
        const searchableText =
            row.dataset.search || '';

        const rowType =
            row.dataset.type || '';

        const matchesSearch =
            searchableText.includes(searchValue);

        const matchesType =
            selectedType === 'both'
            || selectedType === rowType;


        const shouldShow =
            matchesSearch && matchesType;

        row.style.display =
            shouldShow ? '' : 'none';


        if (shouldShow)
        {
            visibleRows++;
        }
    });


    /*
     * Hide the database empty state while
     * filtering because the JS empty state
     * handles it instead.
     */
    if (databaseEmptyRow)
    {
        databaseEmptyRow.style.display =
            rows.length === 0
                ? ''
                : 'none';
    }


    if (noResults)
    {
        noResults.style.display =
            visibleRows === 0 && rows.length > 0
                ? ''
                : 'none';
    }
}


searchInput.addEventListener(
    'input',
    updateTable
);


requestType.addEventListener(
    'change',
    updateTable
);

</script>

</body>
</html>