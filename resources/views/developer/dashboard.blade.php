<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Dashboard — Syedn Tech Solution</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        .page {
            width: 100%;
            max-width: 1180px;
            margin: 0 auto;
            padding: 16px 20px 30px;
        }

        /*MAIN DASHBOARD GRID*/
        .dashboard-layout {
            display: grid;
            grid-template-columns: 136px minmax(0, 1fr);
            gap: 40px;
            align-items: start;
        }

        /*LEFT STAT CARDS*/
        .sidebar-stats {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .stat-card {
            width: 136px;
            min-height: 127px;
            background: #ffffff;
            border: 1.5px solid #5791ff;
            border-radius: 11px;
            padding: 10px 7px 9px;
            text-align: center;
            box-shadow: -7px 9px 10px rgba(0, 0, 0, 0.20), 0 4px 7px rgba(74, 130, 255, 0.14);
        }

        .stat-label {
            font-size: 11px;
            font-weight: 400;
            color: #7c7c7c;
            text-align: left;
            margin-bottom: 13px;
        }

        .stat-value {
            font-size: 39px;
            line-height: 1;
            font-weight: 500;
            color: #111111;
            margin-bottom: 5px;
        }

        .stat-delta {
            font-size: 9px;
            color: #111111;
            line-height: 1.45;
            padding: 10px;
        }

        .stat-card-link {
            display: block;
            text-decoration: none;
            color: inherit;
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .stat-card-link:hover {
            transform: translateY(-3px);
            border-color: #168fff;
            box-shadow: -7px 11px 14px rgba(0, 0, 0, 0.23), 0 6px 12px rgba(74, 130, 255, 0.22);
        }

        .stat-card-link:active {
            transform: translateY(-1px);
        }

        .stat-card-link:focus-visible {
            outline: 2px solid #019bef;
            outline-offset: 3px;
        }

        /*RIGHT CONTENT*/
        .main-col {
            min-width: 0;
        }

        .greeting {
            margin: 7px 0 38px 4px;
            font-size: 32px;
            line-height: 1.1;
            font-weight: 700;
            letter-spacing: 0.4px;
            color: #090909;
        }

        /*GENERAL DASHBOARD CARDS*/
        .card {
            background: #ffffff;
            border: 1.5px solid #5791ff;
            border-radius: 11px;
            padding: 6px 10px 8px;
            box-shadow: -7px 9px 10px rgba(0, 0, 0, 0.20), 0 5px 10px rgba(77, 128, 255, 0.17);
        }

        .card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 3px;
        }

        .card-head h2 {
            margin: 0;
            font-size: 15px;
            font-weight: 700;
            color: #161616;
        }

        .view-all-link {
            font-size: 9px;
            font-weight: 400;
            color: #444444;
            text-decoration: none;
            white-space: nowrap;
        }

        .view-all-link:hover {
            color: #019bef;
        }

        /*ASSIGNED PROJECTS*/
        .projects-card {
            width: 100%;
            margin-bottom: 17px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        thead th {
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #222222;
            padding: 4px 5px 4px 0;
            border-bottom: 1px solid #bdbdbd;
        }

        tbody td {
            font-size: 12px;
            font-weight: 400;
            color: #2b2b2b;
            padding: 8px 5px 8px 0;
            border-bottom: 1px solid #d0d0d0;
            vertical-align: middle;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .projects-card th:nth-child(1),
        .projects-card td:nth-child(1) {
            width: 31%;
        }

        .projects-card th:nth-child(2),
        .projects-card td:nth-child(2) {
            width: 27%;
        }

        .projects-card th:nth-child(3),
        .projects-card td:nth-child(3) {
            width: 27%;
        }

        .projects-card th:nth-child(4),
        .projects-card td:nth-child(4) {
            width: 15%;
            text-align: center;
        }

        /*STATUS PILLS*/
        .status-pill {
            display: inline-block;
            min-width: 57px;
            padding: 2px 8px;
            border-radius: 999px;
            font-size: 8px;
            font-weight: 500;
            line-height: 1.25;
            text-align: center;
            white-space: nowrap;
        }

        .status-completed,
        .status-approved {
            background: #D3F8DF;
            color: #1A7F37;
        }

        .status-ongoing {
            background: #D1E9FF;
            color: #175CD3;
        }

        .status-pending {
            background: #f1bd3c;
            color: #735400;
        }

        .status-submitted {
            background: #174c6f;
            color: #ffffff;
        }

        .status-draft {
            background: #656565;
            color: #ffffff;
        }

        .status-rejected {
            background: #f9b5b5;
            color: #a22020;
        }

        .status-hold {
            background: #FEE4E2;
            color: #D92D20;
        }

        /*BOTTOM SECTION*/
        .bottom-row {
            display: grid;
            grid-template-columns: minmax(0, 1.3fr) minmax(210px, 1fr);
            gap: 17px;
            align-items: stretch;
        }

        .invoices-card,
        .donut-card {
            min-height: 158px;
        }

        .invoices-card {
            padding-left: 13px;
            padding-right: 8px;
        }

        .invoices-card thead th:nth-child(1),
        .invoices-card tbody td:nth-child(1) {
            width: 40%;
        }

        .invoices-card thead th:nth-child(2),
        .invoices-card tbody td:nth-child(2) {
            width: 30%;
        }

        .invoices-card thead th:nth-child(3),
        .invoices-card tbody td:nth-child(3) {
            width: 30%;
            text-align: center;
        }

        /*CREATE INVOICE BUTTON*/
        .btn-create {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 22px;
            background: #08a6f4;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 0 10px;
            font-size: 10px;
            font-weight: 400;
            text-decoration: none;
            cursor: pointer;
            transition: 0.15s ease;
        }

        .btn-create:hover {
            background: #008fd7;
            color: #ffffff;
        }

        /*REIMBURSED DONUT*/
        .donut-card {
            position: relative;
            padding: 8px 9px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .donut-card .card-head {
            width: 100%;
            align-self: stretch;
        }

        .donut {
            width: 80px;
            height: 80px;
            margin-top: 9px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .donut-inner {
            width: 43px;
            height: 43px;
            border-radius: 50%;
            background: #ffffff;
        }

        .donut-value {
            margin-top: 2px;
            font-size: 25px;
            line-height: 1;
            font-weight: 600;
            color: #31d956;
        }

        .donut-total {
            margin-top: 4px;
            font-size: 10px;
            color: #777;
            text-align: center;
        }

        .dashboard-table-link {
            color: #222;
            text-decoration: none;
        }

        .dashboard-table-link:hover {
            color: #019bef;
            text-decoration: underline;
        }

        /*RESPONSIVE*/
        @media (max-width: 850px) {
            .dashboard-layout {
                grid-template-columns: 120px minmax(0, 1fr);
                gap: 20px;
            }

            .stat-card {
                width: 120px;
            }

            .greeting {
                font-size: 28px;
            }

            .bottom-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .page {
                padding: 15px;
            }

            .dashboard-layout {
                display: block;
            }

            .sidebar-stats {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                margin-bottom: 20px;
            }

            .stat-card {
                width: auto;
            }

            .greeting {
                margin: 0 0 20px;
            }

            .projects-card {
                overflow-x: auto;
            }
        }
    </style>

</head>

<body>

    @include('developer.partials.developer-topbar')
    @include('developer.partials.developer-nav')

    <div class="stage">
        <div class="page">
            <div class="dashboard-layout">

                <!-- Sidebar stats -->
                <div class="sidebar-stats">

                    {{-- Assigned Projects --}}
                    <a href="{{ route('developer.projects.index') }}" class="stat-card stat-card-link">

                        <div class="stat-label">
                            Assigned Projects
                        </div>

                        <div class="stat-value">{{ $assignedProjectsCount }}</div>

                        <div class="stat-delta">This Month</div>

                    </a>


                    {{-- Pending Invoices --}}
                    <a href="{{ route('developer.invoices.index') }}" class="stat-card stat-card-link">

                        <div class="stat-label">
                            Invoices Pending
                        </div>

                        <div class="stat-value">
                            {{ $pendingInvoicesCount }}
                        </div>

                        <div class="stat-delta">This Month</div>

                    </a>


                    {{-- Pending Claims --}}
                    <a href="{{ route('developer.claims.index') }}" class="stat-card stat-card-link">

                        <div class="stat-label">
                            Claims Pending
                        </div>

                        <div class="stat-value">
                            {{ $pendingClaimsCount }}
                        </div>

                        <div class="stat-delta">This Month</div>

                    </a>

                </div>

                <!-- Main column -->
                <div class="main-col">
                    <h1 class="greeting">{{ $greeting }}, {{ $displayName }}!</h1>
                    <div class="card projects-card">
                        <div class="card-head">
                            <h2> My Assigned Projects</h2>
                            <a href="{{ route('developer.projects.index') }}" class="view-all-link">All Projects
                                &rarr;</a>
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

                                @forelse ($assignedProjects as $project)
                                    @php

                                        $projectStatusClass = match ($project->status) {
                                            'Completed' => 'status-completed',

                                            'Ongoing' => 'status-ongoing',

                                            'On Hold' => 'status-hold',

                                            default => 'status-pending',
                                        };

                                    @endphp

                                    <tr>

                                        <td>
                                            {{ $project->name }}
                                        </td>

                                        <td>
                                            {{ $project->start_date?->format('j F Y') ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $project->end_date?->format('j F Y') ?? '-' }}
                                        </td>

                                        <td>

                                            <span
                                                class="
                                                    status-pill
                                                    {{ $projectStatusClass }}
                                                ">
                                                {{ $project->status }}
                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="4"
                                            style="
                                                text-align: center;
                                                color: #888;
                                                padding: 18px;
                                            ">
                                            No assigned projects.
                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="bottom-row">
                        <div class="card invoices-card">

                            <div class="card-head">

                                <h2>My Invoices</h2>

                                <a href="{{ route('developer.invoices.create') }}" class="btn-create">+ Create
                                    Invoice</a>

                            </div>


                            <table>

                                <thead>

                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse ($latestInvoices as $invoice)
                                        @php

                                            $invoiceStatusClass = match ($invoice->status) {
                                                'Approved' => 'status-approved',

                                                'Submitted' => 'status-submitted',

                                                'Draft' => 'status-draft',

                                                'Rejected' => 'status-rejected',

                                                default => 'status-draft',
                                            };

                                        @endphp

                                        <tr>

                                            <td>

                                                <a href="{{ route('developer.invoices.show', $invoice) }}"
                                                    class="dashboard-table-link">{{ $invoice->invoice_code }}</a>

                                            </td>


                                            <td>
                                                RM{{ number_format($invoice->grand_total, 0) }}
                                            </td>


                                            <td>

                                                <span
                                                    class="status-pill {{ $invoiceStatusClass }}">{{ $invoice->status }}
                                                </span>

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="3" style=" text-align: center; color: #888; padding: 18px;">
                                                No invoices created yet.
                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                        <div class="card donut-card">

                            <div class="card-head">
                                <h2>Approved Requests (month)</h2>
                            </div>

                            <div class="donut"
                                style="
                                    background:
                                        conic-gradient(
                                            #8eec93
                                            0%
                                            {{ $approvedPercentage }}%,

                                            #d0d0d0
                                            {{ $approvedPercentage }}%
                                            100%
                                        );
                                ">
                                <div class="donut-inner"></div>
                            </div>

                            <div class="donut-value">
                                RM{{ number_format($approvedAmount, 0) }}
                            </div>

                            <div class="donut-total">
                                of RM{{ number_format($submittedRequestAmount, 0) }} submitted
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>

</html>
