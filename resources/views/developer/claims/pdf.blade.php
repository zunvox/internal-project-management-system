<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>{{ $claim->claim_code }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header img {
            width: 90px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 5px 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 9px;
            text-align: left;
            vertical-align: top;
        }

        th {
            width: 30%;
            background-color: #f3f3f3;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 25px 0 10px;
        }

        .amount {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="header">

        <img src="{{ public_path('images/logo.png') }}">

        <h1>CLAIM DETAILS</h1>

        <p>Syedn Tech Solution</p>

    </div>

    <table>

        <tr>
            <th>Claim ID</th>
            <td>{{ $claim->claim_code ?? '-' }}</td>
        </tr>

        <tr>
            <th>Submitted By</th>
            <td>{{ $claim->user->fullname ?? '-' }}</td>
        </tr>

        <tr>
            <th>Category</th>
            <td>
                @if ($claim->other_category)
                    Other - {{ $claim->other_category }}
                @else
                    {{ $claim->category->name ?? '-' }}
                @endif
            </td>
        </tr>

        <tr>
            <th>Title</th>
            <td>{{ $claim->title ?? '-' }}</td>
        </tr>

        <tr>
            <th>Description</th>
            <td>{{ $claim->description ?? '-' }}</td>
        </tr>

        <tr>
            <th>Claim Date</th>
            <td>
                {{ $claim->submitted_at
                    ? \Carbon\Carbon::parse($claim->submitted_at)->format('d M Y')
                    : '-' }}
            </td>
        </tr>

        <tr>
            <th>Status</th>
            <td>{{ $claim->status ?? '-' }}</td>
        </tr>

        <tr>
            <th>Submitted At</th>
            <td>
                {{ $claim->submitted_at
                    ? \Carbon\Carbon::parse($claim->submitted_at)->format('d M Y, h:i A')
                    : '-' }}
            </td>
        </tr>

    </table>

    <div class="amount">
        Claim Amount:
        RM {{ number_format($claim->amount, 2) }}
    </div>

    @if ($claim->review_notes)

        <div class="section-title">
            Admin Review
        </div>

        <table>

            <tr>
                <th>Review Notes</th>
                <td>{{ $claim->review_notes }}</td>
            </tr>

            <tr>
                <th>Reviewed By</th>
                <td>
                    {{ $claim->paymentVoucher?->reviewer?->fullname ?? '-' }}
                </td>
            </tr>

        </table>

    @endif

    @if ($claim->receipt)

        @php
            $receiptPath = storage_path('app/public/' . $claim->receipt);
            $extension = strtolower(pathinfo($receiptPath, PATHINFO_EXTENSION));
        @endphp

        @if (in_array($extension, ['jpg', 'jpeg', 'png']))

            <div style="page-break-before: always;"></div>

            <div style="
                text-align: left;
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 10px;
            ">
            UPLOADED RECEIPT
            </div>

            <div style="
                width: 170mm;
                height: 230mm;
                margin: 0 auto;
                text-align: center;
                overflow: hidden;
            ">
                <img
                    src="{{ $receiptPath }}"
                    style="
                        max-width: 170mm;
                        max-height: 230mm;
                        width: auto;
                        height: auto;
                    "
                >
            </div>

        @endif

    @endif

</body>
</html>