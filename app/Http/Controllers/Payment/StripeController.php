<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function stripePayment(Request $request)
    {
        // Set the secret API key from the environment variable
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:1',
            'stripeToken' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Create a charge
            $charge = Charge::create([
                'amount' => $request->amount * 100, // Amount in cents
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Test payment from Laravel API',
            ]);

            return response()->json(['success' => true, 'data' => $charge]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->server('HTTP_STRIPE_SIGNATURE');
        
        return response()->json(['success' => true]);
    }
}
