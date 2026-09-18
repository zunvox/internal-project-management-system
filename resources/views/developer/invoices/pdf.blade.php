<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>{{ $invoice->invoice_code }}</title>

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

        .info-table,
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table th,
        .info-table td,
        .items-table th,
        .items-table td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        .info-table th {
            width: 30%;
            background: #f3f3f3;
            text-align: left;
        }

        .items-table th {
            background: #f3f3f3;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 25px 0 10px;
        }

        .summary-table {
            width: 45%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 6px 0;
        }

        .summary-table td:last-child {
            text-align: right;
        }

        .grand-total td {
            font-size: 15px;
            font-weight: bold;
            border-top: 1px solid #222;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <div class="header">

        <img src="{{ public_path('images/logo.png') }}">

        <h1>INVOICE</h1>

        <p>Syedn Tech Solution</p>

    </div>

    <table class="info-table">

        <tr>
            <th>Invoice ID</th>
            <td>{{ $invoice->invoice_code }}</td>
        </tr>

        <tr>
            <th>Subject</th>
            <td>{{ $invoice->subject }}</td>
        </tr>

        <tr>
            <th>Billed By</th>
            <td>
                {{ $invoice->user?->fullname ?? ($invoice->user?->username ?? '-') }}
            </td>
        </tr>

        <tr>
            <th>Project</th>
            <td>{{ $invoice->project?->name ?? '-' }}</td>
        </tr>

        <tr>
            <th>Date Issued</th>
            <td>
                {{ $invoice->created_at?->format('F j, Y') ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Status</th>
            <td>{{ $invoice->status }}</td>
        </tr>

        <tr>
            <th>Description</th>
            <td>{{ $invoice->description ?: '-' }}</td>
        </tr>

    </table>


    <div class="section-title">
        Invoice Details
    </div>

    <table class="items-table">

        <thead>
            <tr>
                <th>Items / Services</th>
                <th class="text-right">Quantity</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>

                    <td class="text-right">
                        {{ $item->quantity }}
                    </td>

                    <td class="text-right">
                        RM {{ number_format($item->unit_price, 2) }}
                    </td>

                    <td class="text-right">
                        RM {{ number_format($item->total_price, 2) }}
                    </td>
                </tr>
            @endforeach

        </tbody>

    </table>


    <table class="summary-table">

        <tr>
            <td>Subtotal</td>

            <td>
                RM {{ number_format($invoice->subtotal, 2) }}
            </td>
        </tr>

        <tr>
            <td>
                Tax ({{ (float) $invoice->tax_percentage }}%)
            </td>

            <td>
                RM {{ number_format($invoice->tax_amount, 2) }}
            </td>
        </tr>

        <tr>
            <td>Discount</td>

            <td>
                RM {{ number_format($invoice->discount_amount ?? 0, 2) }}
            </td>
        </tr>

        <tr class="grand-total">

            <td>Grand Total</td>

            <td>
                RM {{ number_format($invoice->grand_total, 2) }}
            </td>

        </tr>

    </table>


    @if ($invoice->review_notes)
        <div class="section-title">
            Admin Review
        </div>

        <table class="info-table">

            <tr>
                <th>Review Notes</th>
                <td>{{ $invoice->review_notes }}</td>
            </tr>

        </table>
    @endif

    @if ($invoice->attachment)

        @php
            $attachmentPath = storage_path('app/public/' . $invoice->attachment);
            $extension = strtolower(pathinfo($attachmentPath, PATHINFO_EXTENSION));
        @endphp

        @if (in_array($extension, ['jpg', 'jpeg', 'png']))

            <div style="page-break-before: always;"></div>

            <div style="
                text-align: left;
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 10px;
            ">
               UPLOADED SUPPORTING DOCUMENT
            </div>

            <div style="
                width: 160mm;
                height: 220mm;
                margin: 0 auto;
                text-align: center;
                overflow: hidden;
            ">
                <img
                    src="{{ $attachmentPath }}"
                    style="
                        max-width: 160mm;
                        max-height: 220mm;
                        width: auto;
                        height: auto;
                    "
                >
            </div>

        @endif

    @endif

</body>

</html>
