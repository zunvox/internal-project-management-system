<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Generate Report</title>
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

            font-size: 14px;

            font-weight: 700;

        }

        .cash-action-subtitle {
            margin-top: 3px;
            font-size: 12px;
            color: #98A2B3;
        }

        /* ---------- Filter Fields ---------- */

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            margin-bottom: 4px;
            font-size: 12px;
            font-weight: 500;
            color: #344054;
        }

        .form-control {
            width: 100%;
            height: 34px;
            box-sizing: border-box;
            padding: 6px 9px;
            border: 1px solid #D0D5DD;
            border-radius: 4px;
            background: white;
            color: #101828;
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 12px;
            outline: none;
        }

        .form-control:focus {
            border-color: #2B6FFF;
        }

        .period-picker-area {
            padding: 12px 24px 20px;
        }

        .period-picker {
            max-width: 420px;
        }

        .custom-range-picker {
            max-width: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
        }

        .report-card {
            margin-bottom: 18px;
            background: white;
            border: 1px solid #2B6FFF;
            border-radius: 12px;
            box-shadow: 0 4px 9px rgba(43, 111, 255, .22);
            overflow: hidden;
        }

        .report-card-header {
            padding: 13px 18px;
            border-bottom: 1px solid #D0D5DD;
            font-size: 14px;
            font-weight: 700;
        }

        .report-tabs {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            border-bottom: 1px solid #D0D5DD;
        }

        .report-tab {
            height: 38px;
            border: none;
            border-bottom: 2px solid transparent;
            background: white;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 12px;
        }

        .report-tab.active {
            border-bottom-color: #2B6FFF;
            color: #2B6FFF;
        }

        .date-filter-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            padding: 12px 24px 4px;
        }

        .summary-content {
            padding: 18px 24px;
        }

        .company-name {
            margin-bottom: 12px;
            font-size: 14px;
            font-weight: 700;
        }

        .report-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 18px;
            font-size: 12px;
        }

        .report-section-title {
            margin: 0 0 14px;
            font-size: 14px;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 14px;
        }

        .summary-box {
            padding: 12px 14px;
            border: 1px solid #98A2B3;
            border-radius: 10px;
        }

        .summary-label {
            margin-bottom: 5px;
            color: #98A2B3;
            font-size: 12px;
        }

        .summary-value {
            font-size: 25px;
            font-weight: 700;
        }

        .summary-value.cash-in {
            color: #0EA5E9;
        }

        .summary-value.cash-out {
            color: #EF4444;
        }

        .report-table-wrapper {
            overflow-x: auto;
            border: 1px solid #2B6FFF;
            border-radius: 9px;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        .report-table th,
        .report-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #D0D5DD;
            text-align: left;
        }

        .report-table th {
            font-weight: 700;
        }

        .report-table small {
            display: block;
            margin-top: 2px;
            color: #98A2B3;
        }

        .opening-row {
            background: #F9FAFB;
        }

        .closing-row {
            font-weight: 700;
        }

        .empty-row {
            padding: 24px !important;
            text-align: center !important;
            color: #98A2B3;
        }

        .export-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 14px 18px;
            background: white;
            border: 1px solid #2B6FFF;
            border-radius: 12px;
            box-shadow: 0 4px 9px rgba(43, 111, 255, .22);
        }

        .export-message {
            font-size: 12px;
            font-weight: 600;
        }

        .export-actions {
            display: flex;
            gap: 8px;
        }

        .download-button {
            min-width: 100px;
            height: 28px;
            border: 1px solid #D0D5DD;
            border-radius: 4px;
            background: white;
            font-size: 12px;
            cursor: auto;
        }
        
        .download-button hover{
            background: #F2F4F7;
            border-color: #98A2B3;
        }

        .download-button.pdf {
            background: #039BEF;
            border-color: #039BEF;
            color: white;
        }

        .download-button.pdf:hover {
            background: #0288D1;
            border-color: #0288D1;
        }

        .download-button.disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        @media(max-width:800px) {

            .report-tabs,
            .summary-cards,
            .report-meta,
            .date-filter-row {
                grid-template-columns: 1fr;
            }

            .export-card {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

</head>

<body>
    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

    <div class="stage">
        <div class="page">

            <h1 class="page-title">Cash Flow Report</h1>

            <!-- TOP ACTION CARDS -->

            <div class="cash-flow-actions">

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


                <a href="{{ route('admin.cash-flows.index') }}" class="cash-action-card">
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
                            Full list of every transactions made
                        </span>
                    </div>
                </a>


                <a href="{{ route('admin.cash-flows.report') }}" class="cash-action-card active">
                    <div class="cash-action-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                        </svg>
                    </div>

                    <div class="cash-action-text">
                        <span class="cash-action-title">
                            Generate Report
                        </span>

                        <span class="cash-action-subtitle">
                            Export as PDF or CSV
                        </span>
                    </div>
                </a>

            </div>


            <!-- REPORT FILTER -->

            <div class="report-card">

                <div class="report-card-header">Report Filters</div>


                <form action="{{ route('admin.cash-flows.report') }}" method="GET" id="report-filter-form">

                    <div class="report-tabs">

                        <button type="button" class="report-tab {{ $period === 'weekly' ? 'active' : '' }}"
                            data-period="weekly">
                            Weekly
                        </button>

                        <button type="button" class="report-tab {{ $period === 'monthly' ? 'active' : '' }}"
                            data-period="monthly">
                            Monthly
                        </button>

                        <button type="button" class="report-tab {{ $period === 'yearly' ? 'active' : '' }}"
                            data-period="yearly">
                            Yearly
                        </button>

                        <button type="button" class="report-tab {{ $period === 'custom' ? 'active' : '' }}"
                            data-period="custom">
                            Custom Range
                        </button>

                    </div>

                    <input type="hidden" name="period" id="period" value="{{ $period }}">

                    <div class="period-picker-area">

                        <!-- Weekly -->
                        <div class="period-picker" id="weekly-picker" style="display:none;">
                            <div class="form-group">

                                <label class="form-label">
                                    Select Week
                                </label>

                                <input type="week" name="week" id="week" class="form-control"
                                    value="{{ request('week', $from->format('o-\WW')) }}">

                            </div>
                        </div>


                        <!-- Monthly -->
                        <div class="period-picker" id="monthly-picker" style="display:none;">
                            <div class="form-group">

                                <label class="form-label">
                                    Select Month
                                </label>

                                <input type="month" name="month" id="month" class="form-control"
                                    value="{{ request('month', $from->format('Y-m')) }}">

                            </div>
                        </div>


                        <!-- Yearly -->
                        <div class="period-picker" id="yearly-picker" style="display:none;">
                            <div class="form-group">

                                <label class="form-label">
                                    Select Year
                                </label>

                                <select name="year" id="year" class="form-control">

                                    @for ($year = now()->year; $year >= 2020; $year--)
                                        <option value="{{ $year }}"
                                            {{ request('year', now()->year) == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor

                                </select>

                            </div>
                        </div>


                        <!-- Custom Range -->
                        <div class="period-picker custom-range-picker" id="custom-picker" style="display:none;">
                            <div class="form-group">

                                <label class="form-label">From</label>
                                <input type="date" name="from" id="from" class="form-control"
                                    value="{{ request('from', $from->format('Y-m-d')) }}">

                            </div>


                            <div class="form-group">

                                <label class="form-label">To</label>
                                <input type="date" name="to" id="to" class="form-control"
                                    value="{{ request('to', $to->format('Y-m-d')) }}">

                            </div>

                        </div>

                    </div>

                </form>

            </div>


            <!-- REPORT SUMMARY -->

            <div class="report-card report-summary">

                <div class="report-card-header">
                    Report Summary
                </div>


                <div class="summary-content">

                    <div class="company-name">
                        Syedn Tech Solutions
                    </div>


                    <div class="report-meta">

                        <div>
                            Period:
                            <span id="report-period-text">
                                {{ $from->format('j F Y') }}
                                -
                                {{ $to->format('j F Y') }}
                            </span>
                        </div>

                        <div>
                            Generated on:
                            {{ now()->format('j F Y') }}
                        </div>

                        <div>
                            Generated by:
                            {{ auth()->user()->username ?? (auth()->user()->fullname ?? 'Admin') }}
                        </div>

                    </div>


                    <h3 class="report-section-title">
                        Cash Flow Report
                    </h3>


                    <div class="summary-cards">

                        <div class="summary-box">

                            <div class="summary-label">
                                Total Cash In
                            </div>

                            <div class="summary-value cash-in" id="summary-cash-in">
                                RM {{ number_format($totalCashIn, 2) }}
                            </div>

                        </div>


                        <div class="summary-box">

                            <div class="summary-label">
                                Total Cash Out
                            </div>

                            <div class="summary-value cash-out" id="summary-cash-out">
                                RM {{ number_format($totalCashOut, 2) }}
                            </div>

                        </div>


                        <div class="summary-box">

                            <div class="summary-label">
                                Net Cash Flow
                            </div>

                            <div class="summary-value" id="summary-net-cash-flow">
                                RM {{ number_format($netCashFlow, 2) }}
                            </div>

                        </div>

                    </div>


                    <!-- REPORT TABLE -->

                    <div class="report-table-wrapper">

                        <table class="report-table">

                            <thead>

                                <tr>
                                    <th>Subject</th>
                                    <th>Category</th>
                                    <th>Date</th>
                                    <th>Cash In</th>
                                    <th>Cash Out</th>
                                    <th>Balance</th>
                                </tr>

                            </thead>


                            <tbody id="report-table-body">

                                <tr class="opening-row">

                                    <td>
                                        Opening Balance
                                    </td>

                                    <td>
                                        Opening Balance
                                    </td>

                                    <td>
                                        {{ $from->format('j F Y') }}
                                    </td>

                                    <td>-</td>

                                    <td>-</td>

                                    <td>
                                        RM {{ number_format($openingBalance, 2) }}
                                    </td>

                                </tr>


                                @forelse ($reportRows as $row)
                                    @php

                                        $cashFlow = $row['cashFlow'];

                                        $normalCategory = $cashFlow->category?->category_name ?? '-';

                                        $categoryName = $cashFlow->other_category
                                            ? $normalCategory . ' — ' . $cashFlow->other_category
                                            : $normalCategory;

                                    @endphp


                                    <tr>

                                        <td>

                                            {{ $cashFlow->subject }}

                                            <small>
                                                {{ $cashFlow->transaction_code }}
                                            </small>

                                        </td>


                                        <td>
                                            {{ $categoryName }}
                                        </td>


                                        <td>
                                            {{ $cashFlow->transaction_date->format('j F Y') }}
                                        </td>


                                        <td>

                                            @if ($cashFlow->type === 'Cash In')
                                                RM {{ number_format($cashFlow->amount, 2) }}
                                            @else
                                                -
                                            @endif

                                        </td>


                                        <td>

                                            @if ($cashFlow->type === 'Cash Out')
                                                RM {{ number_format($cashFlow->amount, 2) }}
                                            @else
                                                -
                                            @endif

                                        </td>


                                        <td>
                                            RM {{ number_format($row['balance'], 2) }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="6" class="empty-row">
                                            No transactions found for this period.
                                        </td>

                                    </tr>
                                @endforelse


                                <tr class="closing-row">

                                    <td colspan="3">
                                        Closing balance —
                                        {{ $to->format('j F Y') }}
                                    </td>

                                    <td>
                                        RM {{ number_format($totalCashIn, 2) }}
                                    </td>

                                    <td>
                                        RM {{ number_format($totalCashOut, 2) }}
                                    </td>

                                    <td>
                                        RM {{ number_format($closingBalance, 2) }}
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>


            <!-- EXPORT SECTION -->

            <div class="export-card">

                <div class="export-message">

                    Report generated for
                    {{ $from->format('j M') }}
                    –
                    {{ $to->format('j M Y') }}.

                    Export it for accounting or keep it as a company record.

                </div>


                <div class="export-actions">

                    <button type="button" class="download-button" id="download-csv-button">↓ Download CSV</button>
                    <button type="button" class="download-button pdf" id="download-pdf-button">↓ Download PDF</button>

                </div>

            </div>

        </div>

    </div>

    <script>
        const reportTabs =
            document.querySelectorAll('.report-tab');

        const periodInput =
            document.getElementById('period');

        const fromInput =
            document.getElementById('from');

        const toInput =
            document.getElementById('to');

        const weeklyPicker =
            document.getElementById('weekly-picker');

        const monthlyPicker =
            document.getElementById('monthly-picker');

        const yearlyPicker =
            document.getElementById('yearly-picker');

        const customPicker =
            document.getElementById('custom-picker');

        const summaryCashIn =
            document.getElementById('summary-cash-in');

        const summaryCashOut =
            document.getElementById('summary-cash-out');

        const summaryNet =
            document.getElementById('summary-net-cash-flow');

        const reportTableBody =
            document.getElementById('report-table-body');

        const reportPeriodText =
            document.getElementById('report-period-text');

        const weekInput =
            document.getElementById('week');

        const monthInput =
            document.getElementById('month');

        const yearInput =
            document.getElementById('year');

        weekInput.addEventListener(
            'change',
            updateReportPreview
        );

        monthInput.addEventListener(
            'change',
            updateReportPreview
        );

        yearInput.addEventListener(
            'change',
            updateReportPreview
        );

        fromInput.addEventListener(
            'change',
            updateReportPreview
        );

        toInput.addEventListener(
            'change',
            updateReportPreview
        );

        const allCashFlows = @js($allCashFlowsForJs);

        function showPeriodPicker(period) {
            weeklyPicker.style.display = 'none';
            monthlyPicker.style.display = 'none';
            yearlyPicker.style.display = 'none';
            customPicker.style.display = 'none';


            if (period === 'weekly') {
                weeklyPicker.style.display = 'block';
            } else if (period === 'monthly') {
                monthlyPicker.style.display = 'block';
            } else if (period === 'yearly') {
                yearlyPicker.style.display = 'block';
            } else if (period === 'custom') {
                customPicker.style.display = 'grid';
            }
        }

        reportTabs.forEach(function(tab) {
            tab.addEventListener(
                'click',
                function() {
                    const selectedPeriod =
                        this.dataset.period;

                    periodInput.value =
                        selectedPeriod;

                    reportTabs.forEach(function(item) {
                        item.classList.remove('active');
                    });

                    this.classList.add('active');

                    showPeriodPicker(
                        selectedPeriod
                    );

                    updateReportPreview();
                }
            );
        });


        showPeriodPicker(periodInput.value);

        function formatMoney(value) {
            return 'RM ' +
                Number(value).toLocaleString(
                    'en-MY', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );
        }


        function formatDate(dateString) {
            const date =
                new Date(dateString + 'T00:00:00');

            return date.toLocaleDateString(
                'en-GB', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                }
            );
        }

        function toLocalDateString(date) {
            const year =
                date.getFullYear();

            const month =
                String(
                    date.getMonth() + 1
                ).padStart(2, '0');

            const day =
                String(
                    date.getDate()
                ).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }

        function getSelectedRange() {
            const period =
                periodInput.value;


            if (period === 'weekly') {
                if (!weekInput.value) {
                    return null;
                }

                const parts =
                    weekInput.value.split('-W');

                const year =
                    parseInt(parts[0]);

                const week =
                    parseInt(parts[1]);


                const january4 =
                    new Date(year, 0, 4);

                const day =
                    january4.getDay() || 7;

                const monday =
                    new Date(january4);

                monday.setDate(
                    january4.getDate() -
                    day +
                    1 +
                    (week - 1) * 7
                );


                const sunday =
                    new Date(monday);

                sunday.setDate(
                    monday.getDate() + 6
                );


                return {
                    from: monday,
                    to: sunday
                };
            }


            if (period === 'monthly') {
                if (!monthInput.value) {
                    return null;
                }

                const parts =
                    monthInput.value.split('-');

                const year =
                    parseInt(parts[0]);

                const month =
                    parseInt(parts[1]) - 1;


                return {

                    from: new Date(
                        year,
                        month,
                        1
                    ),

                    to: new Date(
                        year,
                        month + 1,
                        0
                    )

                };
            }


            if (period === 'yearly') {
                const year =
                    parseInt(yearInput.value);


                return {

                    from: new Date(
                        year,
                        0,
                        1
                    ),

                    to: new Date(
                        year,
                        11,
                        31
                    )

                };
            }


            if (period === 'custom') {
                if (
                    !fromInput.value ||
                    !toInput.value
                ) {
                    return null;
                }


                return {

                    from: new Date(
                        fromInput.value +
                        'T00:00:00'
                    ),

                    to: new Date(
                        toInput.value +
                        'T00:00:00'
                    )

                };
            }


            return null;
        }

        function updateReportPreview() {

            if (
                periodInput.value === 'custom' &&
                fromInput.value &&
                toInput.value &&
                fromInput.value > toInput.value
            ) {
                return;
            }
            const range = getSelectedRange();

            if (!range) {
                return;
            }

            const filteredTransactions = allCashFlows.filter(
                function(transaction) {
                    const transactionDate = new Date(transaction.transaction_date + 'T00:00:00');
                    return (transactionDate >= range.from && transactionDate <= range.to);
                }
            );

            let totalCashIn = 0;
            let totalCashOut = 0;

            filteredTransactions.forEach(
                function(transaction) {
                    if (transaction.type === 'Cash In') {
                        totalCashIn += Number(transaction.amount);
                    } else {
                        totalCashOut += Number(transaction.amount);
                    }
                }
            );


            const netCashFlow = totalCashIn - totalCashOut;


            summaryCashIn.textContent = formatMoney(totalCashIn);

            summaryCashOut.textContent = formatMoney(totalCashOut);

            summaryNet.textContent = formatMoney(netCashFlow);


            reportPeriodText.textContent = formatDate(toLocalDateString(range.from)) + ' - ' + formatDate(toLocalDateString(
                range.to));

            rebuildReportTable(filteredTransactions, range);
        }

        function rebuildReportTable(transactions, range) {
            let openingBalance = 0;

            allCashFlows.forEach(function(transaction) {
                const transactionDate = new Date(transaction.transaction_date + 'T00:00:00');

                if (transactionDate < range.from) {
                    if (transaction.type === 'Cash In') {
                        openingBalance += Number(transaction.amount);
                    } else {
                        openingBalance -= Number(transaction.amount);
                    }
                }
            });


            let runningBalance = openingBalance;
            let html = '';

            html += `
        <tr class="opening-row">

            <td>
                Opening Balance
            </td>

            <td>
                Opening Balance
            </td>

            <td>
                ${formatDate(toLocalDateString(range.from))}
            </td>

            <td>-</td>

            <td>-</td>

            <td>
                ${formatMoney(openingBalance)}
            </td>

        </tr>
    `;


            if (transactions.length === 0) {
                html += `
            <tr>
                <td colspan="6" class="empty-row"> No transactions found for this period.</td>
            </tr>
        `;
            } else {
                transactions.forEach(function(transaction) {
                    if (transaction.type === 'Cash In') {
                        runningBalance += Number(transaction.amount);
                    } else {
                        runningBalance -= Number(transaction.amount);
                    }

                    const category = transaction.other_category ? transaction.category + ' — ' + transaction
                        .other_category : transaction.category;

                    html += `
                    <tr>
                        <td>
                            ${transaction.subject}
                            <small>
                                ${transaction.transaction_code}
                            </small>
                        </td>
                        <td>
                            ${category ?? '-'}
                        </td>
                        <td>
                            ${formatDate(
                                transaction.transaction_date
                            )}
                        </td>
                        <td>
                            ${transaction.type === 'Cash In' ? formatMoney(transaction.amount) : '-'}
                        </td>
                        <td>
                            ${transaction.type === 'Cash Out' ? formatMoney(transaction.amount) : '-'}
                        </td>
                        <td>
                            ${formatMoney(runningBalance)}
                        </td>
                    </tr>
                `;
                });
            }


            const totalCashIn = transactions.filter(transaction => transaction.type === 'Cash In').reduce((total,
                transaction) => total + Number(transaction.amount), 0);

            const totalCashOut = transactions.filter(transaction => transaction.type === 'Cash Out').reduce((total,
                transaction) => total + Number(transaction.amount), 0);

            html += `
        <tr class="closing-row">

            <td colspan="3">

                Closing balance — ${formatDate(toLocalDateString(range.to))}

            </td>

            <td>
                ${formatMoney(totalCashIn)}
            </td>

            <td>
                ${formatMoney(totalCashOut)}
            </td>

            <td>
                ${formatMoney(runningBalance)}
            </td>

        </tr>
    `;


            reportTableBody.innerHTML = html;
        }

        updateReportPreview();

        const downloadPdfButton =
            document.getElementById(
                'download-pdf-button'
            );

        const downloadCsvButton =
            document.getElementById(
                'download-csv-button'
            );


        function buildDownloadUrl(baseUrl) {
            const params =
                new URLSearchParams();

            params.set(
                'period',
                periodInput.value
            );


            if (
                periodInput.value === 'weekly'
            ) {
                params.set(
                    'week',
                    weekInput.value
                );
            } else if (
                periodInput.value === 'monthly'
            ) {
                params.set(
                    'month',
                    monthInput.value
                );
            } else if (
                periodInput.value === 'yearly'
            ) {
                params.set(
                    'year',
                    yearInput.value
                );
            } else if (
                periodInput.value === 'custom'
            ) {

                params.set(
                    'from',
                    fromInput.value
                );

                params.set(
                    'to',
                    toInput.value
                );
            }


            return baseUrl +
                '?' +
                params.toString();
        }


        downloadPdfButton.addEventListener(
            'click',
            function() {
                const url =
                    buildDownloadUrl(
                        @json(route('admin.cash-flows.report.pdf'))
                    );

                window.open(
                    url,
                    '_blank'
                );
            }
        );


        downloadCsvButton.addEventListener(
            'click',
            function() {
                const url =
                    buildDownloadUrl(
                        @json(route('admin.cash-flows.report.csv'))
                    );

                window.location.href =
                    url;
            }
        );
    </script>

</body>

</html>
