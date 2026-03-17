<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Verification Code</title>
</head>
<body style="margin:0;padding:0;background:#f6f8fb;font-family:Arial,sans-serif;color:#0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:620px;background:#ffffff;border-radius:10px;padding:24px;">
                    <tr>
                        <td>
                            <h2 style="margin:0 0 10px;">Verify Your Booking</h2>
                            <p style="margin:0 0 16px;color:#475569;">
                                Hello {{ $verificationData['customer_name'] ?? 'Customer' }}, use this code to confirm your booking request.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:12px 0 18px;">
                            <div style="font-size:30px;font-weight:700;letter-spacing:4px;padding:14px 18px;border-radius:8px;background:#eff6ff;color:#1d4ed8;display:inline-block;">
                                {{ $verificationData['confirmation_code'] ?? '------' }}
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="color:#475569;">
                            Route: <strong>{{ $verificationData['route'] ?? '-' }}</strong><br>
                            Agency: <strong>{{ $verificationData['agency_name'] ?? '-' }}</strong>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
