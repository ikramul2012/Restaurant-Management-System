<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Order;
use Exception;

class StripePaymentController extends Controller
{
    /**
     * Show checkout page with order details.
     */
    public function checkout($id)
{
    // Use 'foods' instead of 'food'
    $order = Order::with('foods')->findOrFail($id);  // Fetch order with food items

    return view('stripe.checkout', compact('order'));
}


public function stripePost(Request $request, $id)
{
    $order = Order::with('foods')->findOrFail($id);

    // Calculate total price and advance payment
    $totalPrice = $order->foods->sum(function ($food) {
        return $food->price * $food->pivot->quantity;
    });

    $advancePayment = $totalPrice * 0.5; // 50% of total price

    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    Stripe\Charge::create([
        "amount" => $advancePayment * 100, // Convert to cents
        "currency" => "usd",
        "source" => $request->stripeToken,
        "description" => "50% Advance Payment for Order #" . $order->id
    ]);

    // Update order payment status (for example)
    $order->update(['payment_status' => '50% paid']);

    return back()->with('success', '50% Advance Payment Successful!');
}


public function finalPayment(Request $request, $id)
{
    $order = Order::with('food')->findOrFail($id);

    $remainingAmount = ($order->food->price * $order->quantity) * 0.5; // Remaining 50%

    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

    Stripe\Charge::create([
        "amount" => $remainingAmount * 100, // Convert to cents
        "currency" => "usd",
        "source" => $request->stripeToken,
        "description" => "Final Payment for " . $order->food->name
    ]);

    // Update order status to 'fully paid'
    $order->update(['delivery_status' => 'fully paid']);

    return back()->with('success', 'Full payment successful!');
}




}


