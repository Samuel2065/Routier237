<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
</head>
<body style="margin:0;padding:0;background:#f6f8fb;font-family:Arial,sans-serif;color:#0f172a;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px;background:#ffffff;border-radius:10px;padding:24px;">
                    <tr>
                        <td style="padding-bottom:12px;">
                            <h2 style="margin:0 0 8px;font-size:24px;">Booking Confirmed</h2>
                            <p style="margin:0;color:#475569;">
                                Hello {{ $bookingData['customer_name'] ?? 'Customer' }}, your trip reservation has been confirmed.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:12px 0;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;">Confirmation Code</td>
                                    <td style="padding:8px 0;text-align:right;font-weight:700;">{{ $bookingData['confirmation_code'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;">Ticket Number</td>
                                    <td style="padding:8px 0;text-align:right;font-weight:700;">{{ $bookingData['ticket_number'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;">Agency</td>
                                    <td style="padding:8px 0;text-align:right;">{{ $bookingData['agency_name'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;">Route</td>
                                    <td style="padding:8px 0;text-align:right;">{{ $bookingData['route'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;">Date</td>
                                    <td style="padding:8px 0;text-align:right;">{{ $bookingData['travel_date'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;">Departure Time</td>
                                    <td style="padding:8px 0;text-align:right;">{{ $bookingData['departure_time'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;">Seat</td>
                                    <td style="padding:8px 0;text-align:right;">{{ $bookingData['seat_number'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;">Service Class</td>
                                    <td style="padding:8px 0;text-align:right;">{{ $bookingData['service_class'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;color:#64748b;">Total Paid</td>
                                    <td style="padding:8px 0;text-align:right;font-weight:700;">{{ $bookingData['total_amount'] ?? '-' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-top:8px;color:#64748b;font-size:13px;">
                            Please keep this email as your booking proof.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
