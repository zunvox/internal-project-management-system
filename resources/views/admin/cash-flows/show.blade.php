<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Flow Transaction Detail</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        .page {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 10px 24px 64px;
            box-sizing: border-box;
        }


        /* ---------- Breadcrumb ---------- */

        .breadcrumb {
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #344054;
        }

        .breadcrumb span {
            color: #98A2B3;
        }


        /* ---------- Page Heading ---------- */

        .page-title {
            margin: 0;
            font-size: 27px;
            font-weight: 800;
            color: #101828;
        }

        .back-link {
            display: inline-block;
            margin-top: 4px;
            margin-bottom: 14px;
            font-size: 11px;
            color: #344054;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }


        /* ---------- Detail Card ---------- */

        .detail-card {
            width: 90%;
            max-width: 1400px;
            min-width: 560px;
            margin: 0 auto;
            background: white;
            border: 1px solid #2B6FFF;
            border-radius: 13px;
            box-shadow: 0 5px 10px rgba(43, 111, 255, 0.28);
            overflow: hidden;
        }

        .detail-card-header {
            padding: 14px 16px;
            border-bottom: 1px solid #D0D5DD;
            font-size: 13px;
            font-weight: 700;
            color: #101828;
        }

        .detail-card-body {
            padding: 18px 18px 10px;
        }


        /* ---------- Detail Grid ---------- */

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 46px;
            row-gap: 14px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-item.full-width {
            grid-column: 1 / -1;
        }

        .detail-label {
            margin-bottom: 4px;
            font-size: 12px;
            font-weight: 500;
            color: #98A2B3;
        }

        .detail-value {
            font-size: 14px;
            color: #101828;
            line-height: 1.45;
        }


        /* ---------- Buttons ---------- */

        .detail-actions {
            display: flex;
            justify-content: flex-end;
            gap: 6px;
            margin-top: 12px;
        }

        .action-button {
            height: 24px;
            padding: 0 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            font-family: 'Inter', system-ui, sans-serif;
            font-size: 14px;
            text-decoration: none;
            background: white;
            cursor: pointer;
        }

        .edit-button {
            border: 1px solid #D0D5DD;
            color: #98A2B3;
        }

        .edit-button:hover {
            background: #F2F4F7;
        }

        .delete-button {
            border: 1px solid #FF4D4F;
            color: #FF4D4F;
            font-family: 'Inter', system-ui, sans-serif;
        }

        .delete-button:hover {
            background: #FEF2F2;
        }

        .delete-form {
            margin: 0;
        }


        /* ---------- Responsive ---------- */

        @media(max-width:800px) {

            .detail-card {
                width: 100%;
                min-width: 0;
            }

            .detail-grid {
                grid-template-columns: 1fr;
            }

            .detail-item.full-width {
                grid-column: auto;
            }

        }
    </style>

</head>


<body>

    @include('admin.partials.admin-topbar')
    @include('admin.partials.admin-nav')

    <div class="stage">
        <div class="page">


            <!-- Breadcrumb -->

            <div class="breadcrumb">
                Cash Flow Transaction List
                <span>
                    >
                </span>
                {{ $cashFlow->transaction_code }}
            </div>


            <!-- Page Title -->

            <h1 class="page-title">{{ $cashFlow->subject }}</h1>

            <a href="{{ route('admin.cash-flows.index') }}" class="back-link"> ← Back to Cash Flow Index</a>

            <!-- Detail Card -->

            <div class="detail-card">


                <div class="detail-card-header">

                    Transaction Record Detail

                </div>


                <div class="detail-card-body">


                    <div class="detail-grid">


                        <!-- Transaction ID -->

                        <div class="detail-item">

                            <div class="detail-label">

                                Transaction ID

                            </div>

                            <div class="detail-value">

                                {{ $cashFlow->transaction_code }}

                            </div>

                        </div>



                        <!-- Category -->

                        <div class="detail-item">

                            <div class="detail-label">Category</div>
                            <div class="detail-value">{{ $cashFlow->category?->category_name ?? '-' }}</div>

                        </div>

                        @if ($cashFlow->other_category)
                            <div class="detail-item">

                                <div class="detail-label">
                                    Specify Category
                                </div>

                                <div class="detail-value">
                                    {{ $cashFlow->other_category }}
                                </div>

                            </div>
                        @endif



                        <!-- Subject -->

                        <div class="detail-item full-width">

                            <div class="detail-label">Subject</div>
                            <div class="detail-value">{{ $cashFlow->subject }}</div>

                        </div>



                        <!-- Type -->

                        <div class="detail-item">

                            <div class="detail-label">

                                Type

                            </div>

                            <div class="detail-value">

                                {{ $cashFlow->type }}

                            </div>

                        </div>



                        <!-- Date -->

                        <div class="detail-item">

                            <div class="detail-label">

                                Date

                            </div>

                            <div class="detail-value">

                                {{ $cashFlow->transaction_date ? $cashFlow->transaction_date->format('d/m/Y') : '-' }}

                            </div>

                        </div>



                        <!-- Amount -->

                        <div class="detail-item">

                            <div class="detail-label">

                                Amount

                            </div>

                            <div class="detail-value">

                                RM {{ number_format($cashFlow->amount, 2) }}

                            </div>

                        </div>



                        <!-- Logged By -->

                        <div class="detail-item">

                            <div class="detail-label">

                                Logged By

                            </div>

                            <div class="detail-value">

                                {{ $cashFlow->loggedBy?->fullname ?? ($cashFlow->loggedBy?->username ?? 'Unknown User') }}

                                @if ($cashFlow->loggedBy?->role)
                                    ({{ $cashFlow->loggedBy->role }})
                                @endif

                            </div>

                        </div>



                        <!-- Description -->

                        <div class="detail-item full-width">

                            <div class="detail-label">

                                Description

                            </div>

                            <div class="detail-value">

                                {{ $cashFlow->description ?: 'No description provided.' }}

                            </div>

                        </div>


                    </div>



                    <!-- Actions -->

                    <div class="detail-actions">

                        <a href="{{ route('admin.cash-flows.edit', $cashFlow) }}"
                            class="action-button edit-button">Edit Record</a>
                        <form action="{{ route('admin.cash-flows.destroy', $cashFlow) }}" method="POST"
                            class="delete-form">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="action-button delete-button">Delete Record</button>
                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        const deleteForm =
            document.querySelector('.delete-form');


        deleteForm?.addEventListener(
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
    </script>

</body>

</html>
