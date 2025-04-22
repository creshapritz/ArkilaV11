<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        Log::info('PayMongo Webhook:', $payload);

        if ($payload['data']['attributes']['status'] === 'paid') {
            // Payment successful → update order status in DB
        }

        return response()->json(['message' => 'Webhook received']);
    }
}
