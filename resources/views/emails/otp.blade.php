<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - TenantBill</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color: #0f172a; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width: 500px; background-color: #1e293b; border-radius: 16px; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
                    
                    <!-- Header with gradient -->
                    <tr>
                        <td style="height: 4px; background: linear-gradient(90deg, #10b981 0%, #34d399 100%);"></td>
                    </tr>
                    
                    <!-- Logo Section -->
                    <tr>
                        <td align="center" style="padding: 40px 40px 30px 40px;">
                            <table role="presentation" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); width: 50px; height: 50px; border-radius: 12px; text-align: center; vertical-align: middle;">
                                        <span style="font-size: 24px; color: white;">&#127970;</span>
                                    </td>
                                    <td style="padding-left: 12px;">
                                        <span style="font-size: 24px; font-weight: 700; color: #f8fafc;">TenantBill</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Greeting -->
                    <tr>
                        <td align="center" style="padding: 0 40px 10px 40px;">
                            <h1 style="margin: 0; font-size: 26px; font-weight: 700; color: #f8fafc;">Verify Your Email</h1>
                        </td>
                    </tr>
                    
                    <!-- Description -->
                    <tr>
                        <td align="center" style="padding: 0 40px 10px 40px;">
                            <p style="margin: 0; font-size: 15px; color: #94a3b8; line-height: 1.6;">
                                Hi <strong style="color: #f8fafc;">{{ $user->name }}</strong>,
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align="center" style="padding: 0 40px 30px 40px;">
                            <p style="margin: 0; font-size: 15px; color: #94a3b8; line-height: 1.6;">
                                Use the verification code below to complete your registration.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- OTP Code Box -->
                    <tr>
                        <td align="center" style="padding: 0 40px 30px 40px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" style="background-color: #0f172a; border-radius: 12px; border: 2px solid #334155;">
                                <tr>
                                    <td style="padding: 25px 50px;">
                                        <p style="margin: 0 0 8px 0; font-size: 12px; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px;">Your verification code</p>
                                        <p style="margin: 0; font-size: 36px; font-weight: 700; color: #10b981; letter-spacing: 8px;">{{ $otp }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Expiry Notice -->
                    <tr>
                        <td align="center" style="padding: 0 40px 30px 40px;">
                            <table role="presentation" cellspacing="0" cellpadding="0" style="background-color: rgba(245, 158, 11, 0.1); border-radius: 8px; border: 1px solid rgba(245, 158, 11, 0.3);">
                                <tr>
                                    <td style="padding: 12px 20px;">
                                        <p style="margin: 0; font-size: 13px; color: #f59e0b;">
                                            <strong>This code expires in 10 minutes</strong>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Security Notice -->
                    <tr>
                        <td align="center" style="padding: 0 40px 40px 40px;">
                            <p style="margin: 0; font-size: 13px; color: #64748b; line-height: 1.6;">
                                If you didn't request this code, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>
                    
                    <!-- Divider -->
                    <tr>
                        <td style="padding: 0 40px;">
                            <div style="height: 1px; background-color: #334155;"></div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 30px 40px;">
                            <p style="margin: 0; font-size: 12px; color: #475569;">
                                &copy; 2025 TenantBill. All rights reserved.
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>