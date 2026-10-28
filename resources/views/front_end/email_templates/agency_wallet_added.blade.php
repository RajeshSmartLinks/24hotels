<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agency Wallet Balance Added</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #333333;
            -webkit-font-smoothing: antialiased;
        }
        table {
            border-collapse: collapse;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f6f9;
            padding: 30px 0;
        }
        .main-card {
            background-color: #ffffff;
            margin: 0 auto;
            width: 600px;
            max-width: 600px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            border: 1px solid #e9ecef;
        }
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            padding: 35px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0 0 8px 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #ffffff;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            color: #dbeafe;
        }
        .body-content {
            padding: 35px 30px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
            color: #1f2937;
        }
        .intro-text {
            font-size: 14px;
            line-height: 1.6;
            color: #4b5563;
            margin-bottom: 25px;
        }
        .amount-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
        }
        .amount-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #166534;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .amount-value {
            font-size: 28px;
            font-weight: 800;
            color: #15803d;
            margin: 0;
        }
        .details-table {
            width: 100%;
            margin-bottom: 25px;
            background-color: #f9fafb;
            border-radius: 8px;
            overflow: hidden;
        }
        .details-table td {
            padding: 12px 16px;
            font-size: 13px;
            border-bottom: 1px solid #e5e7eb;
        }
        .details-table tr:last-child td {
            border-bottom: none;
        }
        .details-label {
            color: #6b7280;
            font-weight: 600;
            width: 40%;
        }
        .details-value {
            color: #111827;
            font-weight: 600;
            text-align: right;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #9ca3af;
        }
        .footer a {
            color: #3b82f6;
            text-decoration: none;
        }
        @media only screen and (max-width: 620px) {
            .main-card {
                width: 92% !important;
            }
            .header, .body-content, .footer {
                padding: 20px !important;
            }
            .amount-value {
                font-size: 22px !important;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="main-card">
            <!-- Header -->
            <div class="header">
                <h1>Wallet Balance Added</h1>
                <p>Agency Wallet Transaction Confirmation</p>
            </div>

            <!-- Body -->
            <div class="body-content">
                <div class="greeting">Hello {{ $recipientName ?? 'Valued Partner' }},</div>
                <div class="intro-text">
                    This is an automated notification to inform you that funds have been successfully credited to the wallet of <strong>{{ $agency->name ?? 'Agency' }}</strong>.
                </div>

                <!-- Highlight Amount -->
                <div class="amount-box">
                    <div class="amount-label">Amount Credited</div>
                    <div class="amount-value">+ {{ number_format($amount, 3) }} KWD</div>
                </div>

                <!-- Transaction Details Table -->
                <table class="details-table" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="details-label">Agency Name</td>
                        <td class="details-value">{{ $agency->name ?? 'N/A' }}</td>
                    </tr>
                    @if(!empty($masterAgent))
                    <tr>
                        <td class="details-label">Master Agent</td>
                        <td class="details-value">{{ trim(($masterAgent->first_name ?? '') . ' ' . ($masterAgent->last_name ?? '')) ?: $masterAgent->email }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="details-label">Transaction ID</td>
                        <td class="details-value">{{ $walletLogger->unique_id ?? ('WL' . ($walletLogger->id ?? '')) }}</td>
                    </tr>
                    <tr>
                        <td class="details-label">Previous Balance</td>
                        <td class="details-value">{{ number_format(max(0, ($agency->wallet_balance ?? 0) - $amount), 3) }} KWD</td>
                    </tr>
                    <tr>
                        <td class="details-label">Current Balance</td>
                        <td class="details-value" style="color: #15803d;">{{ number_format($agency->wallet_balance ?? 0, 3) }} KWD</td>
                    </tr>
                    @if(!empty($walletLogger->wallet_amount_type))
                    <tr>
                        <td class="details-label">Payment Mode</td>
                        <td class="details-value">{{ ucfirst($walletLogger->wallet_amount_type) }}</td>
                    </tr>
                    @endif
                    @if(!empty($walletLogger->wallet_reference_id))
                    <tr>
                        <td class="details-label">Payment Reference</td>
                        <td class="details-value">{{ $walletLogger->wallet_reference_id }}</td>
                    </tr>
                    @endif
                    @if(!empty($walletLogger->amount_description))
                    <tr>
                        <td class="details-label">Description / Note</td>
                        <td class="details-value">{{ $walletLogger->amount_description }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="details-label">Date &amp; Time</td>
                        <td class="details-value">{{ \Carbon\Carbon::parse($walletLogger->date_of_transaction ?? now())->format('d M Y, h:i A') }}</td>
                    </tr>
                </table>

                <p style="font-size: 13px; color: #6b7280; line-height: 1.5; margin: 0;">
                    If you have any questions regarding this transaction, please feel free to reach out to our support team.
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                &copy; {{ date('Y') }} {{ config('app.name', '24Hotels') }}. All rights reserved.<br />
                This is an automated system email. Please do not reply directly to this message.
            </div>
        </div>
    </div>
</body>
</html>
