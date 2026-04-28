# PayMongo Integration Setup Guide

This document explains how to set up and use the PayMongo payment integration in the CineMax Cinema application.

## Prerequisites

- PayMongo account (create one at https://paymongo.com)
- API keys from PayMongo dashboard

## Setup Steps

### 1. Get Your PayMongo API Keys

1. Log in to your PayMongo dashboard: https://dashboard.paymongo.com
2. Go to **Developers** → **API Keys**
3. Copy your **Public Key** (pk_test_...) and **Secret Key** (sk_test_...)
4. Go to **Webhooks** and create a new webhook with:
   - **URL**: `https://yourdomain.com/webhooks/paymongo`
   - **Events**: Select `checkout_session.payment.success` and `checkout_session.payment.failed`

### 2. Configure Environment Variables

Update your `.env` file with your PayMongo credentials:

```env
PAYMONGO_API_KEY=pk_test_your_api_key_here
PAYMONGO_SECRET_KEY=sk_test_your_secret_key_here
PAYMONGO_WEBHOOK_SECRET=whsec_test_your_webhook_secret_here
```

### 3. Run Migrations

The migration has already been run, which added the following fields to the `payments` table:
- `paymongo_payment_id` - Stores the PayMongo payment ID
- `paymongo_session_id` - Stores the PayMongo checkout session ID
- `payment_method_type` - Stores the payment method (card, gcash, grab_pay, etc.)
- `receipt_number` - Stores the receipt number

## How It Works

### Payment Flow

1. **User Creates Booking**: User selects seats and creates a booking
   - A pending payment record is created with status `pending`

2. **User Initiates Payment**: User clicks "Pay Now" button
   - `BookingsController::pay()` is triggered
   - A PayMongo checkout session is created with booking details
   - User is redirected to PayMongo's hosted checkout page

3. **User Completes Payment**: User completes payment on PayMongo
   - PayMongo sends a confirmation to the success URL
   - `BookingsController::paymentSuccess()` verifies the payment
   - If successful, booking status is updated to `confirmed`
   - Tickets are automatically generated for each seat

4. **Webhook Verification (Optional)**: PayMongo sends webhook events
   - `PayMongoWebhookController::handle()` processes webhook events
   - Provides additional verification of payment status
   - Handles edge cases where user doesn't complete the success flow

### Payment Methods Supported

- **Credit/Debit Cards** (Visa, Mastercard, JCB)
- **GCash** (GCash Mobile Money)
- **Grab Pay** (Grab's payment solution)

## Usage Examples

### Creating a Checkout Session

```php
use App\Services\PayMongoService;

$payMongo = new PayMongoService();

$checkoutData = [
    'customer_email' => 'user@example.com',
    'product_name' => 'Cinema Ticket - Avatar',
    'product_description' => 'Movie tickets for Avatar at CineMax Downtown',
    'quantity' => 2,
    'amount' => 500.00, // in PHP
    'reference_number' => 'BOOKING-123-1234567890',
    'description' => 'CineMax Cinema Booking #123',
    'success_url' => 'https://yourdomain.com/bookings/123/payment-success',
    'cancel_url' => 'https://yourdomain.com/bookings/123',
];

$response = $payMongo->createCheckoutSession($checkoutData);

if ($response['success']) {
    // Redirect to checkout
    redirect($response['data']['attributes']['checkout_url']);
}
```

### Retrieving Payment Status

```php
$response = $payMongo->retrieveCheckoutSession($sessionId);

if ($response['success']) {
    $status = $response['data']['attributes']['status'];
    
    if ($status === 'paid') {
        // Payment successful
    }
}
```

## Database Schema

### Payments Table

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| booking_id | bigint | Foreign key to bookings |
| amount | decimal | Payment amount in PHP |
| method | varchar | Payment method (paymongo_checkout) |
| status | varchar | pending, paid, failed, canceled |
| date | datetime | Payment date |
| paymongo_payment_id | varchar | PayMongo payment ID |
| paymongo_session_id | varchar | PayMongo checkout session ID |
| payment_method_type | varchar | card, gcash, grab_pay, etc. |
| receipt_number | varchar | Receipt/reference number |

## Error Handling

### Common Errors

1. **"Failed to initiate payment"**
   - Check PayMongo API key is correct
   - Verify network connectivity
   - Check PayMongo service status

2. **"Invalid session"**
   - Session has expired (sessions expire after 24 hours)
   - User may have manipulated the session ID
   - Session was not found in PayMongo system

3. **"Payment was not completed"**
   - User cancelled the payment
   - Session status is not "paid"

### Debugging

Enable logging to see detailed PayMongo interactions:
- Check `storage/logs/laravel.log` for PayMongo-related messages
- Look for entries starting with "PayMongo" in the logs
- Webhook calls are logged with request body and response

## Testing

### Test Mode

PayMongo credentials you get initially are in **test mode**. Use these test card numbers:

- **Visa**: 4343434343434345
- **Mastercard**: 5555555555554444
- **JCB**: 3530111333300000

Use any future expiry date and any CVC.

### Test GCash

1. Go to test mode GCash login at https://test-app.paymongo.com/gcash
2. Enter any mobile number (e.g., 09123456789)
3. One-time password is always `123456`

## Production Deployment

When deploying to production:

1. Generate new API keys from PayMongo (production keys)
2. Update `.env` with production keys
3. Update webhook URL in PayMongo dashboard to your production domain
4. Test a payment with real amounts (use smallest amount possible)
5. Monitor webhook delivery in PayMongo dashboard

## Support

- PayMongo Documentation: https://developers.paymongo.com
- PayMongo Support: support@paymongo.com
- Application Logs: `storage/logs/laravel.log`

## Security Considerations

1. **Never commit `.env` file** - It contains sensitive API keys
2. **Always verify webhook signatures** - Ensures webhooks are from PayMongo
3. **Use HTTPS in production** - Required by PayMongo for webhooks
4. **Validate all user input** - Never trust user-provided amounts
5. **Log all transactions** - For audit and debugging purposes

## Troubleshooting

### Webhook not being received?

1. Check firewall/security rules allow POST to `/webhooks/paymongo`
2. Verify webhook URL is correct in PayMongo dashboard
3. Ensure domain is accessible from internet (not localhost)
4. Check logs for webhook processing errors

### Payment marked as paid but booking not confirmed?

1. Check if booking exists in database
2. Verify payment record has correct booking_id
3. Check logs for any errors during ticket generation
4. Manually verify and update if needed via admin panel

### Session expired error?

- Sessions expire after 24 hours
- User must restart the booking process
- Create a new checkout session for retry

## Future Enhancements

- Add installment payment support
- Implement partial refunds
- Add payment retry logic
- Create admin payment management interface
- Send payment receipts via email
- Add payment analytics
