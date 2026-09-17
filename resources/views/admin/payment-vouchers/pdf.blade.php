<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <title>Payment Voucher</title>

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

        .header h1 {
            margin: 0;
            font-size: 22px;
        }

        .header p {
            margin: 5px 0 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .label {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .amount {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    @php
        $isInvoice = !is_null($paymentVoucher->invoice_id);
        $isClaim = !is_null($paymentVoucher->claim_id);
    @endphp

    <div class="header">
        <img src="{{ public_path('images/logo.png') }}" width="100">
        <h1>PAYMENT VOUCHER</h1>
        <p>Syedn Tech Solution</p>
    </div>

    <div class="section">

        <p>
            <span class="label">Voucher ID:</span>
            {{ $paymentVoucher->voucher_code }}
        </p>

        <p>
            <span class="label">Date:</span>
            {{ $paymentVoucher->generated_at->format('d M Y') ?? '-' }}
        </p>

    </div>

    <table>

        <tr>
            <th>Developer</th>
            <td>
                @if ($isInvoice)
                    {{ $paymentVoucher->invoice->user->fullname ?? '-' }}
                @elseif ($isClaim)
                    {{ $paymentVoucher->claim->user->fullname ?? '-' }}
                @else
                    -
                @endif
            </td>
        </tr>

        @if ($isInvoice)

            <tr>
                <th>Invoice Number</th>
                <td>
                    {{ $paymentVoucher->invoice->invoice_code ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Project</th>
                <td>
                    {{ $paymentVoucher->invoice->project->name ?? '-' }}
                </td>
            </tr>
        @elseif ($isClaim)
            <tr>
                <th>Claim ID</th>
                <td>
                    {{ $paymentVoucher->claim->claim_code ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Claim Title</th>
                <td>
                    {{ $paymentVoucher->claim->title ?? '-' }}
                </td>
            </tr>

            <tr>
                <th>Category</th>
                <td>
                    @if ($paymentVoucher->claim->other_category)
                        Other - {{ $paymentVoucher->claim->other_category }}
                    @else
                        {{ $paymentVoucher->claim->category->name ?? '-' }}
                    @endif
                </td>
            </tr>

        @endif

        <tr>
            <th>Payment Method</th>
            <td>
                {{ $paymentVoucher->payment_method ?? '-' }}
            </td>
        </tr>

        <tr>
            <th>Reviewed By</th>
            <td>
                {{ $paymentVoucher->reviewer->fullname ?? '-' }}
            </td>
        </tr>

    </table>

    <div class="amount">
        Total Amount: RM {{ number_format($paymentVoucher->amount, 2) }}
    </div>

    <div class="footer">

        <p>
            <strong>Admin Review:</strong>
        </p>

        <p>
            {{ $paymentVoucher->notes ?? 'No remarks.' }}
        </p>

    </div>

</body>

</html>
