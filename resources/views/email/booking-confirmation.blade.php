<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your CineMax Tickets</title>
    <style>
        /* ── Reset ── */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background-color: #0d0d0f;
            font-family: Arial, Helvetica, sans-serif;
            color: #f0eff4;
            padding: 0;
            margin: 0;
        }

        /* ── Wrapper ── */
        .email-wrapper {
            background-color: #0d0d0f;
            padding: 32px 16px;
            min-height: 100vh;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
        }

        /* ── Header ── */
        .header {
            background: linear-gradient(135deg, #1a0a07 0%, #2d0f05 50%, #1a0a07 100%);
            border: 1px solid rgba(232,52,10,0.3);
            border-radius: 16px 16px 0 0;
            padding: 36px 32px;
            text-align: center;
        }
        .brand-logo {
            font-size: 28px;
            font-weight: 900;
            color: #e8340a;
            letter-spacing: 4px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }
        .brand-tagline {
            font-size: 11px;
            color: rgba(240,239,244,0.4);
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        .divider-line {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #e8340a, transparent);
            margin: 16px auto;
        }
        .success-badge {
            display: inline-block;
            background: rgba(40,167,69,0.15);
            border: 1px solid rgba(40,167,69,0.4);
            color: #4ade80;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 20px;
            margin-bottom: 16px;
        }
        .header-title {
            font-size: 30px;
            font-weight: 900;
            color: #f0eff4;
            letter-spacing: 1px;
            line-height: 1.2;
            margin-bottom: 8px;
        }
        .header-title span { color: #e8340a; }
        .header-sub {
            font-size: 14px;
            color: rgba(240,239,244,0.55);
            line-height: 1.5;
        }

        /* ── Booking Summary ── */
        .summary-box {
            background: #141417;
            border-left: 1px solid rgba(240,239,244,0.07);
            border-right: 1px solid rgba(240,239,244,0.07);
            padding: 28px 32px;
        }
        .summary-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(240,239,244,0.4);
            margin-bottom: 16px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table tr td {
            padding: 8px 0;
            font-size: 14px;
            border-bottom: 1px solid rgba(240,239,244,0.05);
        }
        .summary-table tr:last-child td { border-bottom: none; }
        .summary-table .label {
            color: rgba(240,239,244,0.45);
            font-weight: 600;
            width: 120px;
        }
        .summary-table .value {
            color: #f0eff4;
            text-align: right;
        }
        .summary-table .value.movie-title {
            color: #e8340a;
            font-weight: 700;
        }
        .total-row td {
            padding-top: 14px !important;
        }
        .total-row .label { color: #f0eff4 !important; font-weight: 700 !important; }
        .total-row .value {
            color: #f5c518 !important;
            font-weight: 900 !important;
            font-size: 18px !important;
        }

        /* ── Tickets Section ── */
        .tickets-header {
            background: #141417;
            border-left: 1px solid rgba(240,239,244,0.07);
            border-right: 1px solid rgba(240,239,244,0.07);
            padding: 0 32px 8px;
        }
        .tickets-section-title {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: rgba(240,239,244,0.4);
            padding: 20px 0 12px;
            border-top: 1px solid rgba(240,239,244,0.07);
        }

        /* ── Ticket Stub ── */
        .ticket-wrapper {
            background: #141417;
            border-left: 1px solid rgba(240,239,244,0.07);
            border-right: 1px solid rgba(240,239,244,0.07);
            padding: 0 32px 20px;
        }
        .ticket-stub {
            background: linear-gradient(135deg, #1a1a22 0%, #111115 100%);
            border: 1px solid rgba(232,52,10,0.22);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 16px;
            position: relative;
        }
        /* Red left stripe */
        .ticket-stripe {
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            background: linear-gradient(to bottom, #e8340a, #ff6b35);
            border-radius: 12px 0 0 12px;
        }
        .ticket-inner {
            display: table;
            width: 100%;
        }
        .ticket-body {
            display: table-cell;
            padding: 20px 20px 20px 24px;
            vertical-align: top;
            width: 100%;
        }
        .ticket-qr-side {
            display: table-cell;
            width: 140px;
            min-width: 140px;
            vertical-align: middle;
            text-align: center;
            padding: 16px 20px 16px 0;
            border-left: 1px dashed rgba(232,52,10,0.3);
        }
        .ticket-movie-title {
            font-size: 16px;
            font-weight: 900;
            color: #f0eff4;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
            text-transform: uppercase;
        }
        .ticket-meta {
            font-size: 12px;
            color: rgba(240,239,244,0.5);
            margin-bottom: 4px;
        }
        .ticket-meta strong { color: rgba(240,239,244,0.75); }
        .seat-badge {
            display: inline-block;
            background: rgba(232,52,10,0.15);
            border: 1px solid rgba(232,52,10,0.4);
            color: #ff6b35;
            font-size: 13px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 6px;
            margin: 10px 0 8px;
        }
        .ticket-code-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(240,239,244,0.35);
            margin-bottom: 4px;
        }
        .ticket-code {
            font-family: 'Courier New', Courier, monospace;
            font-size: 14px;
            font-weight: 700;
            color: #f5c518;
            letter-spacing: 2px;
            background: rgba(245,197,24,0.08);
            border: 1px solid rgba(245,197,24,0.25);
            border-radius: 6px;
            padding: 5px 10px;
            display: inline-block;
        }
        .qr-img-wrap {
            background: #ffffff;
            border-radius: 8px;
            padding: 6px;
            display: inline-block;
            margin-bottom: 6px;
        }
        .qr-img-wrap img {
            display: block;
            border-radius: 4px;
        }
        .qr-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(240,239,244,0.35);
        }

        /* ── Footer ── */
        .footer {
            background: #0a0a0c;
            border: 1px solid rgba(240,239,244,0.05);
            border-top: none;
            border-radius: 0 0 16px 16px;
            padding: 28px 32px;
            text-align: center;
        }
        .footer-note {
            font-size: 13px;
            color: rgba(240,239,244,0.4);
            line-height: 1.6;
            margin-bottom: 16px;
        }
        .footer-note strong { color: rgba(240,239,244,0.65); }
        .footer-brand {
            font-size: 11px;
            color: rgba(240,239,244,0.2);
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .cta-button {
            display: inline-block;
            background: #e8340a;
            color: #ffffff !important;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 12px 28px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-box {
            background: rgba(245,197,24,0.08);
            border: 1px solid rgba(245,197,24,0.2);
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 12px;
            color: rgba(240,239,244,0.55);
            text-align: left;
            margin: 0 32px 0;
        }
        .alert-box strong { color: #f5c518; }
    </style>
</head>
<body>
<div class="email-wrapper">
<div class="email-container">

    {{-- ── HEADER ── --}}
    <div class="header">
        <div class="brand-logo">&#9654; CINEMAX</div>
        <div class="brand-tagline">Premium Cinema Experience</div>
        <div class="divider-line"></div>
        <div class="success-badge">&#10003; Booking Confirmed</div>
        <div class="header-title">Your tickets are <span>ready!</span></div>
        <div class="header-sub">
            Hi {{ $booking->user->name ?? 'Valued Guest' }}, your booking has been confirmed.<br>
            Present your QR code at the entrance to scan in.
        </div>
    </div>

    {{-- ── BOOKING SUMMARY ── --}}
    <div class="summary-box">
        <div class="summary-title">&#128197; Booking Summary</div>
        <table class="summary-table">
            <tr>
                <td class="label">Movie</td>
                <td class="value movie-title">{{ $booking->showtime->movie->title }}</td>
            </tr>
            <tr>
                <td class="label">Date</td>
                <td class="value">{{ $booking->showtime->start_time->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td class="label">Showtime</td>
                <td class="value">{{ $booking->showtime->start_time->format('g:i A') }}</td>
            </tr>
            <tr>
                <td class="label">Venue</td>
                <td class="value">{{ $booking->showtime->hall->cinema->name }} &mdash; {{ $booking->showtime->hall->name }}</td>
            </tr>
            <tr>
                <td class="label">Seats</td>
                <td class="value">
                    @foreach($booking->bookings_seats as $bs)
                        {{ $bs->seat->row_number }}{{ $bs->seat->number }}@if(!$loop->last), @endif
                    @endforeach
                </td>
            </tr>
            <tr>
                <td class="label">Booking ID</td>
                <td class="value">#{{ $booking->id }}</td>
            </tr>
            <tr class="total-row">
                <td class="label">Total Paid</td>
                <td class="value">&#8369;{{ number_format($booking->payment->amount, 0) }}</td>
            </tr>
        </table>
    </div>

    {{-- ── TICKETS ── --}}
    <div class="tickets-header">
        <div class="tickets-section-title">&#127915; Your Tickets</div>
    </div>
    <div class="ticket-wrapper">
        @foreach($booking->tickets as $ticket)
        @php
            $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=110x110&data=' . urlencode($ticket->code);
        @endphp
        <div class="ticket-stub">
            <div class="ticket-stripe"></div>
            <div class="ticket-inner">
                <div class="ticket-body">
                    <div class="ticket-movie-title">{{ $booking->showtime->movie->title }}</div>
                    <div class="ticket-meta">
                        <strong>{{ $booking->showtime->start_time->format('M j, Y') }}</strong>
                        &nbsp;&#183;&nbsp;
                        {{ $booking->showtime->start_time->format('g:i A') }}
                    </div>
                    <div class="ticket-meta">
                        {{ $booking->showtime->hall->cinema->name }} &mdash; {{ $booking->showtime->hall->name }}
                    </div>
                    <div class="seat-badge">
                        &#9632; Seat {{ $ticket->seat->row_number }}{{ $ticket->seat->number }}
                    </div>
                    <div class="ticket-code-label">Ticket Number</div>
                    <div class="ticket-code">{{ $ticket->code }}</div>
                </div>
                <div class="ticket-qr-side">
                    <div class="qr-img-wrap">
                        <img src="{{ $qrUrl }}" width="110" height="110" alt="QR Code for {{ $ticket->code }}">
                    </div>
                    <div class="qr-label">Scan to Verify</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── IMPORTANT NOTE ── --}}
    <div style="background:#141417; border-left:1px solid rgba(240,239,244,0.07); border-right:1px solid rgba(240,239,244,0.07); padding: 0 0 24px;">
        <div class="alert-box" style="margin: 0 32px;">
            <strong>&#9888; Important:</strong> Please arrive at least 15 minutes before showtime.
            Tickets are non-transferable and valid only for the booked showtime.
            Present this QR code at the cinema entrance &mdash; one scan per ticket.
        </div>
    </div>

    {{-- ── FOOTER ── --}}
    <div class="footer">
        <a href="{{ url('/bookings/' . $booking->id) }}" class="cta-button">View My Booking Online</a>
        <div class="footer-note">
            Questions? Reply to this email or visit our support page.<br>
            <strong>Thank you for choosing CineMax &mdash; enjoy the show!</strong>
        </div>
        <div class="footer-brand">&copy; {{ date('Y') }} CineMax &bull; All rights reserved</div>
    </div>

</div>
</div>
</body>
</html>
