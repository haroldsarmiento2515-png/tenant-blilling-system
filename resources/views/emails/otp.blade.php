<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification OTP</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f7fb;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            background-color: #f5f7fb;
            padding: 24px 0;
        }
        .card {
            max-width: 520px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            color: #ffffff;
            padding: 18px 28px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 0.5px;
        }
        .content {
            padding: 24px 28px 32px;
        }
        .content p {
            margin: 0 0 12px;
            line-height: 1.6;
        }
        .otp-box {
            display: inline-block;
            padding: 14px 22px;
            margin: 18px 0;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 6px;
            color: #1f2937;
            background-color: #eef2ff;
            border: 2px dashed #4f46e5;
            border-radius: 10px;
        }
        .footer {
            padding: 18px 28px 26px;
            border-top: 1px solid #eef2ff;
            font-size: 12px;
            color: #6b7280;
        }
        .footer a {
            color: #4f46e5;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>Verify your email address</h1>
            </div>
            <div class="content">
                <p>Hi {{ $user->name }},</p>
                <p>Use the One-Time Password (OTP) below to verify your email address and complete your registration.</p>
                <div class="otp-box">{{ $otp }}</div>
                <p>This code will expire in 10 minutes. If you did not request this verification, please ignore this email.</p>
            </div>
            <div class="footer">
                <p>Thank you for choosing Tenant Billing System.</p>
                <p>If you need help, contact our support team.</p>
            </div>
        </div>
    </div>
</body>
</html>
