<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Expense Claims</title>
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

.page-heading{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:14px;
}

.page-title{
    font-size:26px;
    font-weight:800;
    margin:0;
    color:#101828;
}

/* Create Claim Button */

.btn-create{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    height:32px;
    padding:0 14px;
    background:#009FE3;
    color:white;
    border:none;
    border-radius:6px;
    font-size:12px;
    font-weight:500;
    text-decoration:none;
    transition:0.15s ease;
}

.btn-create:hover{
    background:#008AC7;
}

/* Filter Row */

.filter-row{
    display:flex;
    align-items:center;
    min-height:38px;
    margin-bottom:16px;
    border-top:1px solid #E4E7EC;
    border-bottom:1px solid #E4E7EC;
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

/* Tab Count */

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

.search-field input:focus{
    border-color:#2B6FFF;
}

/* Claim Card */

.claim-card{
    background:white;
    border:1px solid #2B6FFF;
    border-radius:14px;
    padding:20px 28px 12px;
    box-shadow:0 5px 10px rgba(43,111,255,0.28);
    overflow:hidden;
}

/* Table */

.table-wrapper{
    width:100%;
    overflow-x:auto;
}

.claim-table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
}

.claim-table th{
    text-align:left;
    font-size:16px;
    font-weight:700;
    color:#101828;
    padding:8px;
    border-bottom:1px solid #D0D5DD;
}

.claim-table td{
    font-size:14px;
    color:#344054;
    padding:10px 8px;
    border-bottom:1px solid #D0D5DD;
    vertical-align:middle;
}

/* Column Widths */

.col-id{
    width:17%;
}

.col-title{
    width:26%;
}

.col-category{
    width:20%;
}

.col-date{
    width:21%;
}

.col-amount{
    width:15%;
}

.col-status{
    width:13%;
}

.col-action{
    width:6%;
    text-align:right;
}

/* Status Pills */

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

/* Action Buttons */

.action-buttons{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:5px;
}

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
    box-sizing:border-box;
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

/* Empty State */

.empty-row td{
    text-align:center;
    color:#98A2B3;
    padding:28px 10px;
}

/* Pagination Placeholder */

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

/* Responsive */

@media(max-width:900px){

    .page{
        width:95%;
        padding-left:12px;
        padding-right:12px;
    }

    .page-heading{
        gap:12px;
    }

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

    .claim-card{
        padding:16px;
    }

    .claim-table{
        min-width:900px;
    }
}

</style>

</head>

<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')


<div class="stage">
<div class="page">


    <!-- Page Heading -->

    <div class="page-heading">

        <h1 class="page-title">My Expense Claims</h1>

        <a
            href="{{ route('developer.claims.create') }}"
            class="btn-create"
        >
            + New Claim
        </a>

    </div>


    <!-- Filter Row -->

    <div class="filter-row">

        <div class="status-tabs">


            <!-- All Claims -->

            <a
                href="{{ route('developer.claims.index') }}"
                class="status-tab {{ !$status ? 'active' : '' }}"
            >
                All Claims

                <span class="tab-count">
                    {{ $counts['all'] }}
                </span>

            </a>


            <!-- Submitted -->

            <a
                href="{{ route(
                    'developer.claims.index',
                    ['status' => 'Submitted']
                ) }}"
                class="status-tab {{
                    $status === 'Submitted'
                        ? 'active'
                        : ''
                }}"
            >

                Submitted

                <span class="tab-count">
                    {{ $counts['submitted'] }}
                </span>

            </a>


            <!-- Approved -->

            <a
                href="{{ route(
                    'developer.claims.index',
                    ['status' => 'Approved']
                ) }}"
                class="status-tab {{
                    $status === 'Approved'
                        ? 'active'
                        : ''
                }}"
            >

                Approved

                <span class="tab-count">
                    {{ $counts['approved'] }}
                </span>

            </a>


            <!-- Rejected -->

            <a
                href="{{ route(
                    'developer.claims.index',
                    ['status' => 'Rejected']
                ) }}"
                class="status-tab {{
                    $status === 'Rejected'
                        ? 'active'
                        : ''
                }}"
            >

                Rejected

                <span class="tab-count">
                    {{ $counts['rejected'] }}
                </span>

            </a>

        </div>


        <!-- Search -->

        <div class="search-field">

            <svg viewBox="0 0 24 24">

                <path
                    d="M15.5 14h-.79l-.28-.27a6.47
                    6.47 0 0 0 1.57-4.23
                    6.5 6.5 0 1 0-6.5 6.5
                    c1.61 0 3.09-.59 4.23-1.57
                    l.27.28v.79l5 4.99
                    L20.49 19l-4.99-5Zm-6 0
                    A4.5 4.5 0 1 1 14 9.5
                    4.5 4.5 0 0 1 9.5 14Z"
                />

            </svg>

            <input
                type="text"
                id="claim-search"
                placeholder="Search..."
            >

        </div>

    </div>


    <!-- Claim Table Card -->

    <div class="claim-card">

        <div class="table-wrapper">

            <table class="claim-table">


                <!-- Table Header -->

                <thead>

                    <tr>

                        <th class="col-id">
                            Claim ID
                        </th>

                        <th class="col-title">
                            Claim Title
                        </th>

                        <th class="col-category">
                            Category
                        </th>

                        <th class="col-date">
                            Date Submitted
                        </th>

                        <th class="col-amount">
                            Amount (RM)
                        </th>

                        <th class="col-status">
                            Status
                        </th>

                        <th class="col-action"></th>

                    </tr>

                </thead>


                <!-- Table Body -->

                <tbody id="claim-table-body">


                    @forelse ($claims as $claim)


                        <tr
                            class="claim-row"

                            data-search="{{ strtolower(
                                $claim->claim_code . ' ' .
                                $claim->title . ' ' .
                                ($claim->category?->category_name ?? '') . ' ' .
                                $claim->status
                            ) }}"
                        >


                            <!-- Claim ID -->

                            <td>

                                {{ $claim->claim_code }}

                            </td>


                            <!-- Claim Title -->

                            <td>

                                {{ $claim->title }}

                            </td>


                            <!-- Category -->

                            <td>

                                {{
                                    $claim->category?->category_name
                                    ?? 'No Category'
                                }}

                            </td>


                            <!-- Date Submitted -->

                            <td>

                                {{
                                    $claim->submitted_at
                                        ? $claim->submitted_at->format('j F Y')
                                        : '-'
                                }}

                            </td>


                            <!-- Amount -->

                            <td>

                                {{
                                    number_format(
                                        $claim->amount,
                                        2
                                    )
                                }}

                            </td>


                            <!-- Status -->

                            <td>

                                @if ($claim->status === 'Submitted')

                                    <span
                                        class="status-pill status-submitted"
                                    >
                                        Submitted
                                    </span>


                                @elseif ($claim->status === 'Approved')

                                    <span
                                        class="status-pill status-approved"
                                    >
                                        Approved
                                    </span>


                                @elseif ($claim->status === 'Rejected')

                                    <span
                                        class="status-pill status-rejected"
                                    >
                                        Rejected
                                    </span>

                                @endif

                            </td>


                            <!-- View Claim -->

                            <td class="col-action">

                                <div class="action-buttons">

                                    <a
                                        href="{{ route(
                                            'developer.claims.show',
                                            $claim
                                        ) }}"
                                        class="action-link"
                                        title="View Claim"
                                    >

                                        <svg viewBox="0 0 24 24">

                                            <path
                                                d="M2 12
                                                s3.5-6 10-6
                                                10 6 10 6
                                                -3.5 6-10 6
                                                S2 12 2 12Z"
                                            >
                                            </path>

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="2.5"
                                            >
                                            </circle>

                                        </svg>

                                    </a>

                                </div>

                            </td>

                        </tr>


                    @empty


                        <tr class="empty-row">

                            <td colspan="7">

                                No claims found.

                            </td>

                        </tr>


                    @endforelse


                    <!-- Search Empty State -->

                    <tr
                        id="no-search-results"
                        class="empty-row"
                        style="display:none;"
                    >

                        <td colspan="7">

                            No matching claims found.

                        </td>

                    </tr>


                </tbody>

            </table>

        </div>


        <!-- Static Pagination For Now -->

        <div class="pagination-area">

            <button
                type="button"
                class="page-button active"
            >
                1
            </button>

        </div>

    </div>

</div>

</div>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function ()
    {

        const searchInput =
            document.getElementById('claim-search');

        const rows =
            document.querySelectorAll('.claim-row');

        const noResults =
            document.getElementById('no-search-results');


        searchInput.addEventListener(
            'input',
            function ()
            {

                const searchValue =
                    this.value
                        .toLowerCase()
                        .trim();

                let visibleRows = 0;


                rows.forEach(
                    function (row)
                    {

                        const searchableText =
                            row.dataset.search || '';

                        const matches =
                            searchableText.includes(
                                searchValue
                            );


                        row.style.display =
                            matches
                                ? ''
                                : 'none';


                        if (matches)
                        {
                            visibleRows++;
                        }

                    }
                );


                if (noResults)
                {

                    noResults.style.display =
                        visibleRows === 0
                        && rows.length > 0
                            ? ''
                            : 'none';

                }

            }
        );

    }
);

</script>


</body>

</html>