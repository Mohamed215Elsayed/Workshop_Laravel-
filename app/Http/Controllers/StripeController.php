<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
// use Session;
class StripeController extends Controller
{
    public function showform()
    {
        return view('paymentform');
    }

    public function payment ()
    {
        $product_name = "Apple";
        $product_price = 2000;
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = Session::create([
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product_name,
                        ],
                        'unit_amount' => $product_price,
                    ],
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('showform'),
        ]);
        return redirect()->away($session->url);
    }

    public function success()
    {
        return 'payment is done successfully';
    }
}
