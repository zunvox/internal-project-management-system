<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Flow Transaction List</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        .page {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 28px 24px 64px;
            box-sizing: border-box;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            margin: 0 0 14px;
            color: #101828;
        }


        /* ---------- Top Action Cards ---------- */

        .cash-flow-actions {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .cash-action-card {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 66px;
            padding: 11px 16px;
            box-sizing: border-box;
            background: white;
            border: 1px solid #D0D5DD;
            border-radius: 11px;
            text-decoration: none;
            color: #101828;
            box-shadow: 0 4px 8px rgba(16, 24, 40, 0.12);
            transition: 0.15s ease;
        }

        .cash-action-card:hover {
            background: #F9FAFB;
            border-color: #7F9CF5;
        }

        .cash-action-card.active {
            background: #DCE6FF;
            border: 2px solid #2B6FFF;
        }

        .cash-action-card.disabled {
            cursor: not-allowed;
        }

        .cash-action-card.disabled:hover {
            background: white;
            border-color: #D0D5DD;
        }

        .cash-action-icon {
            width: 29px;
            height: 29px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 5px;
            background: #DCE6FF;
            color: #2B6FFF;
        }

        .cash-action-card.active .cash-action-icon {
            background: #2B6FFF;
            color: white;
        }

        .cash-action-icon svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.8;
        }

        .cash-action-plus {
            font-size: 22px;
            font-weight: 500;
        }

        .cash-action-text {

            display: flex;

            flex-direction: column;

        }

        .cash-action-title {

            font-size: 13px;

            font-weight: 700;

        }

        .cash-action-subtitle {
            margin-top: 3px;
            font-size: 10px;
            color: #98A2B3;
        }


        /* ---------- Filter / Tabs Row ---------- */

        .filter-row {
            display: flex;
            align-items: center;
            min-height: 38px;
            margin-bottom: 16px;
            border-bottom: 1px solid #E4E7EC;
            border-top: 1px solid #E4E7EC;
        }


        /* Category dropdown */

        .type-filter {

            min-width: 135px;

            height: 36px;

            border: none;

            border-right: 1px solid #E4E7EC;

            background: #F2F4F7;

            padding: 0 14px;

            font-family: 'Inter', system-ui, sans-serif;

            font-size: 13px;

            color: #101828;

            outline: none;

            cursor: pointer;

        }


        /* Tabs */

        .status-tabs {

            display: flex;

            align-items: stretch;

            height: 36px;

        }

        .status-tab {

            display: flex;

            align-items: center;

            gap: 4px;

            padding: 0 18px;

            text-decoration: none;

            font-size: 13px;

            font-weight: 500;

            color: #344054;

            border-bottom: 3px solid transparent;

            transition: 0.15s ease;

            white-space: nowrap;

        }

        .status-tab:hover {

            background: #F9FAFB;

        }

        .status-tab.active {

            border-bottom-color: #7F9CF5;

            background: #EEF4FF;

        }


        /* Count circle */

        .tab-count {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 17px;

            height: 17px;

            padding: 0 4px;

            border-radius: 999px;

            background: #A6E9FA;

            color: #175CD3;

            font-size: 9px;

            font-weight: 600;

            box-sizing: border-box;

        }


        /* Search */

        .search-field {

            position: relative;

            min-width: 220px;

            margin-left: auto;

            margin-right: 8px;

        }

        .search-field svg {

            position: absolute;

            left: 7px;

            top: 50%;

            transform: translateY(-50%);

            width: 14px;

            height: 14px;

            fill: #98A2B3;

        }

        .search-field input {

            width: 100%;

            height: 20px;

            box-sizing: border-box;

            padding: 2px 8px 2px 22px;

            font-size: 10px;

            font-family: 'Inter', system-ui, sans-serif;

            border: 1px solid #BFC4CC;

            border-radius: 7px;

            outline: none;

            background: white;

        }

        .search-field input::placeholder {

            color: #98A2B3;

        }


        /* ---------- Table Card ---------- */

        .voucher-card {

            background: white;

            border: 1px solid #2B6FFF;

            border-radius: 14px;

            padding: 20px 28px 12px;

            box-shadow: 0 5px 10px rgba(43, 111, 255, 0.28);

            overflow: hidden;

        }

        .table-wrapper {

            width: 100%;

            overflow-x: auto;

        }

        .voucher-table {

            width: 100%;

            border-collapse: collapse;

            table-layout: fixed;

        }

        .voucher-table th {

            text-align: left;

            font-size: 16px;

            font-weight: 700;

            color: #101828;

            padding: 8px 8px;

            border-bottom: 1px solid #D0D5DD;

        }

        .voucher-table td {

            font-size: 14px;

            color: #344054;

            padding: 10px 8px;

            border-bottom: 1px solid #D0D5DD;

            vertical-align: middle;

        }


        /* Column widths */

        .col-id {

            width: 16%;

        }

        .col-subject {

            width: 25%;

        }

        .col-type {

            width: 14%;

        }

        .col-date {

            width: 19%;

        }

        .col-amount {

            width: 16%;

        }

        .col-action {

            width: 10%;

            text-align: center;

        }


        /* ---------- Amount ---------- */

        .amount-in {

            color: #16A34A !important;

            font-weight: 500;

        }

        .amount-out {

            color: #EF4444 !important;

            font-weight: 500;

        }


        /* ---------- Actions ---------- */

        .action-group {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 5px;

        }

        .action-link {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            width: 24px;

            height: 24px;

            border: 1px solid #D0D5DD;

            border-radius: 4px;

            text-decoration: none;

            background: white;

            transition: 0.15s ease;

        }

        .action-link:hover {

            background: #F2F4F7;

            border-color: #98A2B3;

        }

        .action-link svg {

            width: 15px;

            height: 15px;

            stroke: #344054;

            fill: none;

            stroke-width: 1.7;

        }

        .action-link.disabled {

            opacity: 0.4;

            cursor: not-allowed;

        }

        .index-delete-form {
            margin: 0;
            display: inline-flex;
        }

        button.action-link {
            padding: 0;
            cursor: pointer;
        }


        /* ---------- Empty State ---------- */

        .empty-row td {
            text-align: center;
            color: #98A2B3;
            padding: 28px 10px;
        }

        /* ---------- Table Footer ---------- */

        .table-footer {
            display: grid;
            grid-template-columns:
                1fr auto auto;
            align-items: start;
            column-gap: 70px;
            margin-top: 12px;
        }


        /* Push Grand Total so it sits below Amount */
        .grand-total {
            grid-column: 2;
            min-width: 150px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            transform: translateX(-45px);
        }


        /* Pagination stays at far right */
        .pagination-area {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 5px;
        }


        .grand-total-label {
            margin-bottom: 3px;
            font-size: 11px;
            font-weight: 600;
            color: #667085;
        }


        .grand-total-amount {
            font-size: 15px;
            font-weight: 700;
            color: #101828;
        }


        /* ---------- Pagination placeholder ---------- */

        .pagination-area {
            display: flex;
            justify-content: flex-end;
            gap: 5px;
            margin-top: 8px;
        }

        .page-button {
            width: 25px;
            height: 23px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 3px;
            background: #EAECF0;
            color: #344054;
            font-size: 11px;
            text-decoration: none;
            cursor: pointer;
        }

        .page-button.active {
            background: #019BEF;
            color: white;
        }

        .page-button.disabled {
            opacity: .45;
            cursor: not-allowed;
        }


        /* ---------- Responsive ---------- */

        @media(max-width:900px) {

            .cash-flow-actions {

                grid-template-columns: 1fr;

            }

            .filter-row {

                flex-wrap: wrap;

                gap: 4px;

                padding-bottom: 6px;

            }

            .status-tabs {

                overflow-x: auto;

                max-width: 100%;

            }

            .search-field {

                margin-left: 0;

                margin-top: 4px;

            }

            .voucher-card {

                padding: 16px;

            }

            .voucher-table {

                min-width: 850px;

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

                Cash Flow Transaction List

            </h1>


            <!-- Top Action Cards -->

            <div class="cash-flow-actions">


                <!-- Record Transaction -->

                <a href="{{ route('admin.cash-flows.create') }}" class="cash-action-card">

                    <div class="cash-action-icon cash-action-plus">

                        +

                    </div>

                    <div class="cash-action-text">

                        <span class="cash-action-title">

                            Record Transaction

                        </span>

                        <span class="cash-action-subtitle">

                            Log a new cash in/out entry

                        </span>

                    </div>

                </a>



                <!-- View All Transactions -->

                <a href="{{ route('admin.cash-flows.index') }}" class="cash-action-card active">

                    <div class="cash-action-icon">

                        <svg viewBox="0 0 24 24">

                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"></path>

                            <circle cx="12" cy="12" r="3"></circle>

                        </svg>

                    </div>

                    <div class="cash-action-text">

                        <span class="cash-action-title">

                            View All Transactions

                        </span>

                        <span class="cash-action-subtitle">

                            Full list of every transaction made

                        </span>

                    </div>

                </a>



                <!-- Generate Report -->

                <a href="{{ route('admin.cash-flows.report') }}" class="cash-action-card">
                    <div class="cash-action-icon">

                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>

                    </div>

                    <div class="cash-action-text">

                        <span class="cash-action-title">Generate Report</span>
                        <span class="cash-action-subtitle">Export as PDF or CSV</span>

                    </div>
                </a>


            </div>



            <!-- Filters -->

            <div class="filter-row">


                <!-- Category -->

                <select class="type-filter" id="category-filter">

                    <option value="all">

                        Category

                    </option>

                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">

                            {{ $category->category_name }}

                        </option>
                    @endforeach

                </select>



                <!-- Tabs -->

                <div class="status-tabs">


                    <a href="{{ route('admin.cash-flows.index') }}" class="status-tab {{ !$type ? 'active' : '' }}">

                        All Transactions

                        <span class="tab-count">

                            {{ $counts['all'] }}

                        </span>

                    </a>



                    <a href="{{ route('admin.cash-flows.index', ['type' => 'Cash In']) }}"
                        class="status-tab {{ $type === 'Cash In' ? 'active' : '' }}">

                        Cash In

                        <span class="tab-count">

                            {{ $counts['cash_in'] }}

                        </span>

                    </a>



                    <a href="{{ route('admin.cash-flows.index', ['type' => 'Cash Out']) }}"
                        class="status-tab {{ $type === 'Cash Out' ? 'active' : '' }}">

                        Cash Out

                        <span class="tab-count">

                            {{ $counts['cash_out'] }}

                        </span>

                    </a>


                </div>



                <!-- Search -->

                <div class="search-field">


                    <svg viewBox="0 0 24 24">

                        <path d="M15.5 14h-.79l-.28-.27a6.47 6.47 0 0 0 1.57-4.23
                    6.5 6.5 0 1 0-6.5 6.5c1.61 0 3.09-.59
                    4.23-1.57l.27.28v.79l5 4.99L20.49
                    19l-4.99-5Zm-6 0A4.5 4.5 0 1 1
                    14 9.5 4.5 4.5 0 0 1 9.5 14Z"></path>

                    </svg>


                    <input type="text" id="cash-flow-search" placeholder="Search">


                </div>


            </div>



            <!-- Table -->

            <div class="voucher-card">


                <div class="table-wrapper">


                    <table class="voucher-table">


                        <thead>

                            <tr>

                                <th class="col-id">

                                    Transaction ID

                                </th>

                                <th class="col-subject">

                                    Subject

                                </th>

                                <th class="col-type">

                                    Type

                                </th>

                                <th class="col-date">

                                    Date Transaction

                                </th>

                                <th class="col-amount">

                                    Amount (RM)

                                </th>

                                <th class="col-action">

                                </th>

                            </tr>

                        </thead>



                        <tbody id="cash-flow-table-body">


                            @foreach ($cashFlows as $cashFlow)
                                <tr class="cash-flow-row" data-category="{{ $cashFlow->flowcategory_id }}"
                                    data-search="{{ strtolower(
                                        $cashFlow->transaction_code . ' ' . $cashFlow->subject . ' ' . ($cashFlow->category?->category_name ?? ''),
                                    ) }}"
                                    data-type="{{ $cashFlow->type }}" data-amount="{{ $cashFlow->amount }}">


                                    <td>

                                        {{ $cashFlow->transaction_code }}

                                    </td>


                                    <td>

                                        {{ $cashFlow->subject }}

                                    </td>


                                    <td>

                                        {{ $cashFlow->type }}

                                    </td>


                                    <td>

                                        {{ $cashFlow->transaction_date ? $cashFlow->transaction_date->format('j F Y') : '-' }}

                                    </td>


                                    <td
                                        class="{{ $cashFlow->type === 'Cash In' ? 'amount-in' : 'amount-out' }}">

                                        {{ $cashFlow->type === 'Cash In' ? '+' : '-' }}

                                        {{ number_format($cashFlow->amount, 2) }}

                                    </td>



                                    <td class="col-action">


                                        <div class="action-group">


                                            <!-- View -->

                                            <a href="{{ route('admin.cash-flows.show', $cashFlow) }}"
                                                class="action-link" title="View transaction">
                                                <svg viewBox="0 0 24 24">
                                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"></path>
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                </svg>
                                            </a>

                                            <a href="{{ route('admin.cash-flows.edit', $cashFlow) }}"
                                                class="action-link" title="Edit transaction">
                                                <svg viewBox="0 0 24 24">
                                                    <path d="M12 20h9"></path>
                                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                                </svg>
                                            </a>

                                            <!-- Delete -->

                                            <form action="{{ route('admin.cash-flows.destroy', $cashFlow) }}"
                                                method="POST" class="index-delete-form">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="action-link" title="Delete transaction">

                                                    <svg viewBox="0 0 24 24">

                                                        <polyline points="3 6 5 6 21 6"></polyline>

                                                        <path d="M19 6l-1 14H6L5 6"></path>

                                                        <path d="M10 11v6"></path>

                                                        <path d="M14 11v6"></path>

                                                        <path d="M9 6V4h6v2"></path>

                                                    </svg>

                                                </button>
                                            </form>


                                        </div>


                                    </td>


                                </tr>
                            @endforeach



                            @if ($cashFlows->isEmpty())
                                <tr class="empty-row" id="database-empty-row">

                                    <td colspan="6">

                                        No cash flow transactions found.

                                    </td>

                                </tr>
                            @endif



                            <tr id="no-search-results" class="empty-row" style="display:none;">

                                <td colspan="6">

                                    No matching transactions found.

                                </td>

                            </tr>


                        </tbody>


                    </table>


                </div>



                <!-- Static pagination for now -->

                <div class="table-footer">

                    <div class="grand-total">

                        <span class="grand-total-label">
                            Grand Total
                        </span>

                        <span class="grand-total-amount" id="grand-total-amount">
                            RM 0.00
                        </span>

                    </div>


                    <div class="pagination-area">

                        @for ($page = 1; $page <= $cashFlows->lastPage(); $page++)
                            <a href="{{ $cashFlows->url($page) }}"
                                class="page-button {{ $cashFlows->currentPage() === $page ? 'active' : '' }}">
                                {{ $page }}
                            </a>
                        @endfor

                    </div>

                </div>


            </div>


        </div>

    </div>



    <script>
        const searchInput =

            document.getElementById('cash-flow-search');


        const categoryFilter =

            document.getElementById('category-filter');


        const rows =

            document.querySelectorAll('.cash-flow-row');


        const noResults =

            document.getElementById('no-search-results');


        const databaseEmptyRow =

            document.getElementById('database-empty-row');



        function updateTable()

        {

            const selectedCategory =

                categoryFilter.value;


            const searchValue =

                searchInput.value
                .toLowerCase()
                .trim();


            let visibleRows = 0;



            rows.forEach(function(row)

                {

                    const searchableText =
                        row.dataset.search || '';

                    const rowCategory =
                        row.dataset.category || '';

                    const matchesSearch =
                        searchableText.includes(searchValue);

                    const matchesCategory =
                        selectedCategory === 'all' ||
                        selectedCategory === rowCategory;

                    const shouldShow =
                        matchesSearch && matchesCategory;

                    row.style.display =
                        shouldShow ? '' : 'none';


                    if (shouldShow)

                    {

                        visibleRows++;

                    }

                });



            if (databaseEmptyRow)

            {

                databaseEmptyRow.style.display =

                    rows.length === 0 ?
                    '' :
                    'none';

            }



            if (noResults)

            {

                noResults.style.display =

                    visibleRows === 0 &&
                    rows.length > 0 ?
                    '' :
                    'none';

            }

        }

        const deleteForms = document.querySelectorAll('.index-delete-form');


        deleteForms.forEach(function(form) {

            form.addEventListener(
                'submit',
                function(event) {

                    const confirmed = confirm(
                        'Are you sure you want to delete this transaction? This action cannot be undone.'
                    );


                    if (!confirmed) {

                        event.preventDefault();

                    }

                }
            );

        });

        function updateTable() {
            const selectedCategory =
                categoryFilter.value;

            const searchValue =
                searchInput.value
                .trim()
                .toLowerCase();


            let grandTotal = 0;


            rows.forEach(function(row) {
                const rowCategory =
                    row.dataset.category;

                const rowSearch =
                    row.dataset.search;

                const matchesCategory =
                    selectedCategory === 'all' ||
                    rowCategory === selectedCategory;

                const matchesSearch =
                    rowSearch.includes(searchValue);


                const shouldShow =
                    matchesCategory &&
                    matchesSearch;


                row.style.display =
                    shouldShow ? '' : 'none';


                if (shouldShow) {
                    const amount =
                        parseFloat(
                            row.dataset.amount || 0
                        );

                    const type =
                        row.dataset.type;


                    if (type === 'Cash In') {
                        grandTotal += amount;
                    } else {
                        grandTotal -= amount;
                    }
                }
            });


            document
                .getElementById('grand-total-amount')
                .textContent =
                'RM ' +
                grandTotal.toLocaleString(
                    'en-MY', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );
        }



        searchInput.addEventListener(
            'input',
            updateTable
        );



        categoryFilter.addEventListener(
            'change',
            updateTable
        );

        updateTable();
    </script>


</body>

</html>
