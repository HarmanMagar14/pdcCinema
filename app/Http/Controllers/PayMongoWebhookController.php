<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Payments;
use App\Models\Tickets;
use App\Services\PayMongoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PayMongoWebhookController extends Controller
{
    private PayMongoService $payMongo;

    public function __construct()
    {
        $this->payMongo = new PayMongoService();
    }

    /**
     * Handle PayMongo webhook events
     */
    public function handle(Request $request)
    {
        // Verify webhook signature
        $signature = $request->header('x-paymongo-signature');
        $payload = $request->getContent();

        if (!$signature || !$this->payMongo->verifyWebhookSignature($payload, $signature)) {
            Log::warning('Invalid PayMongo webhook signature', [
                'signature' => $signature,
                'ip' => $request->ip(),
            ]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->all();
        $eventType = $data['data']['type'] ?? null;

        Log::info('PayMongo webhook received', [
            'event_type' => $eventType,
            'data' => $data,
        ]);

        switch ($eventType) {
            case 'checkout_session.payment.success':
                return $this->handlePaymentSuccess($data['data']['attributes'] ?? []);
            case 'checkout_session.payment.failed':
                return $this->handlePaymentFailed($data['data']['attributes'] ?? []);
            case 'payment.success':
                return $this->handleDirectPaymentSuccess($data['data']['attributes'] ?? []);
            case 'payment.failed':
                return $this->handleDirectPaymentFailed($data['data']['attributes'] ?? []);
            default:
                Log::info('Unknown PayMongo event type', ['type' => $eventType]);
                return response()->json(['status' => 'received']);
        }
    }

    /**
     * Handle successful checkout session payment
     */
    private function handlePaymentSuccess(array $attributes)
    {
        $referenceNumber = $attributes['reference_number'] ?? null;
        $sessionId = $attributes['id'] ?? null;
        $payments = $attributes['payments'] ?? [];

        if (empty($payments)) {
            Log::warning('No payments in successful checkout session', [
                'reference' => $referenceNumber,
                'session' => $sessionId,
            ]);
            return response()->json(['status' => 'received']);
        }

        $payment = $payments[0];
        $paymentId = $payment['id'] ?? null;

        // Extract booking ID from reference number
        $bookingId = $this->extractBookingId($referenceNumber);

        if (!$bookingId) {
            Log::error('Could not extract booking ID from reference', [
                'reference' => $referenceNumber,
            ]);
            return response()->json(['status' => 'received']);
        }

        $booking = Bookings::find($bookingId);
        if (!$booking) {
            Log::error('Booking not found', ['booking_id' => $bookingId]);
            return response()->json(['status' => 'received']);
        }

        $bookingPayment = $booking->payment;
        if (!$bookingPayment) {
            Log::error('Payment record not found for booking', ['booking_id' => $bookingId]);
            return response()->json(['status' => 'received']);
        }

        if ($bookingPayment->status === 'paid') {
            Log::info('Payment already marked as paid', ['booking_id' => $bookingId]);
            return response()->json(['status' => 'received']);
        }

        // Update payment
        $bookingPayment->update([
            'status' => 'paid',
            'method' => 'paymongo_checkout',
            'paymongo_payment_id' => $paymentId,
            'paymongo_session_id' => $sessionId,
            'payment_method_type' => $payment['type'] ?? 'card',
        ]);

        $booking->update(['status' => 'confirmed']);

        // Generate tickets
        $booking->load('bookings_seats');
        foreach ($booking->bookings_seats as $bookedSeat) {
            $ticketCode = strtoupper(uniqid('TK')) . rand(10000, 99999);
            Tickets::create([
                'booking_id' => $booking->id,
                'seat_id' => $bookedSeat->seat_id,
                'code' => $ticketCode,
                'issued_at' => now(),
            ]);
        }

        Log::info('Payment successful and booking confirmed', [
            'booking_id' => $bookingId,
            'payment_id' => $paymentId,
        ]);

        return response()->json(['status' => 'processed']);
    }

    /**
     * Handle failed checkout session payment
     */
    private function handlePaymentFailed(array $attributes)
    {
        $referenceNumber = $attributes['reference_number'] ?? null;
        $sessionId = $attributes['id'] ?? null;

        $bookingId = $this->extractBookingId($referenceNumber);

        if ($bookingId) {
            $booking = Bookings::find($bookingId);
            if ($booking && $booking->payment) {
                $booking->payment->update(['status' => 'failed']);
            }
        }

        Log::warning('Payment failed', [
            'reference' => $referenceNumber,
            'session' => $sessionId,
        ]);

        return response()->json(['status' => 'received']);
    }

    /**
     * Handle direct payment success
     */
    private function handleDirectPaymentSuccess(array $attributes)
    {
        $paymentId = $attributes['id'] ?? null;

        $payment = Payments::where('paymongo_payment_id', $paymentId)->first();
        if (!$payment) {
            Log::warning('Payment record not found for ID', ['payment_id' => $paymentId]);
            return response()->json(['status' => 'received']);
        }

        $payment->update([
            'status' => 'paid',
            'payment_method_type' => $attributes['type'] ?? 'card',
        ]);

        $booking = $payment->booking;
        if ($booking) {
            $booking->update(['status' => 'confirmed']);

            // Generate tickets
            $booking->load('bookings_seats');
            foreach ($booking->bookings_seats as $bookedSeat) {
                $ticketCode = strtoupper(uniqid('TK')) . rand(10000, 99999);
                Tickets::firstOrCreate(
                    [
                        'booking_id' => $booking->id,
                        'seat_id' => $bookedSeat->seat_id,
                    ],
                    [
                        'code' => $ticketCode,
                        'issued_at' => now(),
                    ]
                );
            }
        }

        return response()->json(['status' => 'processed']);
    }

    /**
     * Handle direct payment failure
     */
    private function handleDirectPaymentFailed(array $attributes)
    {
        $paymentId = $attributes['id'] ?? null;

        $payment = Payments::where('paymongo_payment_id', $paymentId)->first();
        if ($payment) {
            $payment->update(['status' => 'failed']);
        }

        Log::warning('Direct payment failed', ['payment_id' => $paymentId]);

        return response()->json(['status' => 'received']);
    }

    /**
     * Extract booking ID from reference number
     * Reference format: BOOKING-{booking_id}-{timestamp}
     */
    private function extractBookingId(string $reference): ?int
    {
        if (preg_match('/BOOKING-(\d+)-/', $reference, $matches)) {
            return (int)$matches[1];
        }
        return null;
    }
}
