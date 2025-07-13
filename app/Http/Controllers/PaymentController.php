<?php

namespace App\Http\Controllers;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private PaymentService $payments;

    public function __construct(PaymentService $payments)
    {
        $this->payments = $payments;
    }

    public function createIntent(Request $request)
    {
        $intent = $this->payments->createIntent($request->all());

        return response()->json($intent);
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        $intent = $this->payments->confirm($validated['payment_intent_id']);

        return response()->json($intent);
    }

    public function refund(Request $request)
    {
        $validated = $request->validate([
            'payment_intent_id' => 'required|string',
        ]);

        $refund = $this->payments->refund($validated['payment_intent_id']);

        return response()->json($refund);
    }
}
