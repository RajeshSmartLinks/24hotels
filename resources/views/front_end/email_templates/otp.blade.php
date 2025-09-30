<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your OTP Code</title>
    <style>
        /* Reset and base styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f6f8;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }

        .content {
            text-align: center;
            color: #555;
        }

        .otp-code {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            font-size: 32px;
            font-weight: bold;
            padding: 15px 25px;
            margin: 20px 0;
            border-radius: 8px;
            letter-spacing: 5px;
        }

        .note {
            font-size: 14px;
            color: #888;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 30px;
        }

        /* Responsive */
        @media screen and (max-width: 600px) {
            .container {
                padding: 20px;
            }
            .otp-code {
                font-size: 28px;
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>One-Time Password (OTP)</h1>
        </div>
        <div class="content">
            <p>Hello {{ $user->first_name }}!</p>
            <p>Your login verification code is:</p>
            <div class="otp-code">{{ $otp }}</div>
            <p>This code is valid for <strong>5 minutes</strong>. Please do not share it with anyone.</p>
            <p class="note">If you did not request this OTP, please ignore this email.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{env('APP_NAME')}}. All rights reserved.
        </div>
    </div>
</body>
</html>
