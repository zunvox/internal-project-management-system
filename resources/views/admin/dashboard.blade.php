<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — Syedn Tech Solution</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        .page {
        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
        padding: 20px 12px 26px;
    }

    /*GREETING*/
    .greeting {
        margin: 4px 0 18px 16px;
        font-size: 32px;
        line-height: 1.1;
        font-weight: 700;
        letter-spacing: 0.3px;
        color: #111111;
    }

    /*GENERAL CARD*/
    .card {
        background: #ffffff;
        border: 1.5px solid #5791ff;
        border-radius: 11px;

        box-shadow:
            -7px 9px 10px rgba(0, 0, 0, 0.20),
            0 5px 9px rgba(77, 128, 255, 0.17);
    }

    /*TOP STAT CARDS*/
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 13px;
        margin: 0 0 43px;
    }

    .stat-card {
        min-height: 133px;
        padding: 10px 12px 14px;
    }

    .stat-label {
        margin-bottom: 25px;
        font-size: 14px;
        font-weight: 400;
        color: #7d7d7d;
    }

    .stat-value {
        font-size: 33px;
        line-height: 1;
        font-weight: 700;
        white-space: nowrap;
    }

    .value-blue {
        color: #22aef4;
    }

    .value-red {
        color: #ff4247;
    }

    .value-green {
        color: #36cf67;
    }

    .value-black {
        color: #111111;
    }

    /*BOTTOM GRID*/
    .bottom-row {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(300px, 1fr);
        gap: 12px;
        align-items: stretch;
    }

    .bottom-row > .card {
        min-width: 0;
        min-height: 226px;
    }

    .card-body {
        padding: 8px 8px 7px;
    }

    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 8px;
    }

    .card-head h2 {
        margin: 0;
        font-size: 16px;
        line-height: 1.2;
        font-weight: 700;
        color: #191919;
    }

    .card-head .meta {
        font-size: 12px;
        color: #252525;
        white-space: nowrap;
    }

    /*PROJECT TABLE*/
    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    thead th {
        padding: 7px 4px 7px 0;
        border-bottom: 1px solid #bdbdbd;

        text-align: left;
        font-size: 14px;
        font-weight: 700;
        color: #222222;
    }

    tbody td {
        padding: 10px 4px 10px 0;
        border-bottom: 1px solid #c8c8c8;

        font-size: 12px;
        font-weight: 400;
        color: #2b2b2b;
        vertical-align: middle;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    .project-card th:nth-child(1),
    .project-card td:nth-child(1) {
        width: 28%;
    }

    .project-card th:nth-child(2),
    .project-card td:nth-child(2) {
        width: 28%;
    }

    .project-card th:nth-child(3),
    .project-card td:nth-child(3) {
        width: 30%;
    }

    .project-card th:nth-child(4),
    .project-card td:nth-child(4) {
        width: 14%;
        text-align: center;
    }

    /*STATUS PILLS*/
    .status-pill {
        display: inline-block;
        min-width: 58px;
        padding: 2px 8px;
        border-radius: 999px;

        font-size: 10px;
        line-height: 1.2;
        font-weight: 500;
        text-align: center;
        white-space: nowrap;
    }

    .status-ongoing {
        background: #9ce5fa;
        color: #247d99;
    }

    .status-completed {
        background: #D3F8DF;
        color: #1A7F37;
    }

    .status-submitted {
        background: #174c6f;
        color: #ffffff;
    }

    .status-approved {
        background: #D3F8DF;
        color: #1A7F37;
    }

    .status-rejected {
        background: #f9b5b5;
        color: #a22020;
    }

    .status-hold {
        background: #FEE4E2;
        color: #996200;
    }

    .status-not-started {
        background: #E9C24C;
        color: #483b12;
    }

    /*AWAITING REVIEW*/
    .awaiting-card .card-body {
        padding: 8px 12px 7px;
    }

    .awaiting-card .card-head {
        margin-bottom: 7px;
    }

    .progress-block {
        margin-bottom: 6px;
    }

    .progress-label-row {
        display: flex;
        align-items: center;
        justify-content: space-between;

        margin-bottom: 2px;
        padding: 0 2px;

        font-size: 12px;
        color: #a0a0a0;
    }

    .progress-label-row .count {
        color: #888888;
        font-weight: 400;
    }

    .progress-track {
        width: 100%;
        height: 13px;
        border-radius: 999px;
        background: #dedede;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 999px;
    }

    .fill-invoices {
        background: #09d19c;
    }

    .fill-claims {
        background: #10c8c8;
    }

    hr.divider {
        border: none;
        border-top: 1px solid #c7c7c7;
        margin: 12px 0 2px;
    }

    .review-item {
        display: grid;
        grid-template-columns: 1.1fr 1fr auto;
        align-items: center;
        gap: 8px;

        min-height: 37px;
        padding: 7px 3px;

        border-bottom: 1px solid #c8c8c8;
    }

    .review-item:last-child {
        border-bottom: none;
    }

    .review-item .id,
    .review-item .amount {
        font-size: 14px;
        font-weight: 400;
        color: #222222;
    }

    .review-item .amount {
        text-align: left;
    }

    /*CLICKABLE CARDS / ROWS*/
    .stat-link {
        display: block;
        color: inherit;
        text-decoration: none;
        cursor: pointer;

        transition:
            transform 0.15s ease,
            box-shadow 0.15s ease;
    }

    .stat-link:hover {
        transform: translateY(-2px);

        box-shadow:
            -7px 11px 13px rgba(0, 0, 0, 0.22),
            0 6px 11px rgba(77, 128, 255, 0.20);
    }

    .review-link {
        color: inherit;
        text-decoration: none;
    }

    .review-link:hover {
        color: #019bef;
        text-decoration: underline;
    }

    /*RESPONSIVE*/
    @media (max-width: 900px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .bottom-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .page {
            padding-left: 12px;
            padding-right: 12px;
        }

        .greeting {
            margin-left: 0;
            font-size: 27px;
        }

        .stats-row {
            grid-template-columns: 1fr;
        }
    }
    </style>

</head>

<body>
    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

    <div class ="stage">
        <div class="page">

            <h1 class="greeting">{{ $greeting }}, {{ $displayName }}!</h1>

            <div class="stats-row">

                <a href="{{ route('admin.cash-flows.index', ['type' => 'Cash In']) }}" class="card stat-card stat-link">
                    <div class="stat-label">Total Cash In</div>

                    <div class="stat-value value-blue">RM{{ number_format($totalCashIn, 0) }}</div>
                </a>


                <a href="{{ route('admin.cash-flows.index', ['type' => 'Cash Out']) }}" class="card stat-card stat-link">
                    <div class="stat-label">Total Cash Out </div>

                    <div class="stat-value value-red">RM{{ number_format($totalCashOut, 0) }}</div>
                </a>


                <a href="{{ route('admin.cash-flows.index') }}" class="card stat-card stat-link">
                    <div class="stat-label">Cash Flow Balance</div>

                    <div class="stat-value value-green">RM{{ number_format($cashFlowBalance, 0) }}</div>
                </a>


                <a href="{{ route('admin.cash-flows.index') }}" class="card stat-card stat-link">
                    <div class="stat-label">Total Transactions</div>

                    <div class="stat-value value-black">{{ $totalTransactions }}</div>
                </a>

            </div>

            <div class="bottom-row">

                <!-- Project Status Overview -->
                <div class="card project-card">
                    <div class="card-body">
                        <div class="card-head">
                            <h2>Project Status Overview</h2>
                            <span class="meta">Total Project : {{ $totalProjects }}</span>
                        </div>

                        <table>
                            <thead>
                                <tr>
                                    <th>Projects</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($projects as $project)

                                    @php
                                        $projectStatusClass = match ($project->status) {
                                            'Ongoing'
                                                => 'status-ongoing',

                                            'Completed'
                                                => 'status-completed',

                                            'On Hold'
                                                => 'status-hold',

                                            'Not Started'
                                                => 'status-not-started',

                                            default
                                                => 'status-not-started',
                                        };
                                    @endphp

                                    <tr>

                                        <td>
                                            {{ $project->name }}
                                        </td>

                                        <td>
                                            {{ $project->start_date
                                                ?->format('j F Y') ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $project->end_date
                                                ?->format('j F Y') ?? '-' }}
                                        </td>

                                        <td>
                                            <span
                                                class="
                                                    status-pill
                                                    {{ $projectStatusClass }}
                                                "
                                            >
                                                {{ $project->status }}
                                            </span>
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="4" style="text-align:center;">
                                            No projects found.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Completed Review -->
                <div class="card awaiting-card">
                    <div class="card-body">
                        <div class="card-head">
                            <h2>Awaiting Review</h2>
                        </div>

                        <div class="progress-block">

                            <div class="progress-label-row">

                                <span>
                                    Invoices Reviewed
                                </span>

                                <span class="count">
                                    {{ $reviewedInvoices }}
                                    /
                                    {{ $totalSubmittedInvoices }}
                                </span>

                            </div>

                            <div class="progress-track">

                                <div
                                    class="progress-fill fill-invoices"
                                    style="width: {{ $invoiceReviewedPercentage }}%;"
                                ></div>

                            </div>

                        </div>

                        <div class="progress-block" style="margin-bottom:8px;">

                        <div class="progress-label-row">

                            <span>
                                Claims Reviewed
                            </span>

                            <span class="count">
                                {{ $reviewedClaims }}
                                /
                                {{ $totalSubmittedClaims }}
                            </span>

                        </div>

                        <div class="progress-track">

                            <div
                                class="progress-fill fill-claims"
                                style="width: {{ $claimReviewedPercentage }}%;"
                            ></div>

                        </div>

                    </div>

                        <hr class="divider">

                        @forelse ($reviewItems as $item)

                            @php
                                $statusClass = match ($item['status']) {
                                    'Submitted'
                                        => 'status-submitted',

                                    'Approved'
                                        => 'status-approved',

                                    'Rejected'
                                        => 'status-rejected',

                                    default
                                        => 'status-submitted',
                                };

                                $itemRoute =
                                    $item['type'] === 'invoice'
                                        ? route(
                                            'admin.payment-vouchers.invoices.show',
                                            $item['id']
                                        )
                                        : route(
                                            'admin.payment-vouchers.claims.show',
                                            $item['id']
                                        );
                            @endphp

                            <div class="review-item">

                                <a
                                    href="{{ $itemRoute }}"
                                    class="id review-link"
                                >
                                    {{ $item['code'] }}
                                </a>

                                <span class="amount">
                                    RM{{ number_format($item['amount'], 0) }}
                                </span>

                                <span
                                    class="
                                        status-pill
                                        {{ $statusClass }}
                                    "
                                >
                                    {{ $item['status'] }}
                                </span>

                            </div>

                        @empty

                            <div
                                style="
                                    padding: 20px 4px;
                                    text-align: center;
                                    color: #888;
                                    font-size: 11px;
                                "
                            >
                                No review records found.
                            </div>

                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>

</html>
