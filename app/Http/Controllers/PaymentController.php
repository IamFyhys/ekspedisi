<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Payment;
use App\Models\CashDrawer;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function createMidtransPayment(Request $request)
    {
        $request->validate([
            'shipment_id' => 'required|exists:shipments,id',
        ]);

        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');

        $shipment = Shipment::findOrFail($request->shipment_id);

        $params = [
            'transaction_details' => [
                'order_id'     => $shipment->tracking_number . '-' . time(), // Append time to avoid duplicate order_id in Sandbox
                'gross_amount' => $shipment->total_price, // Assuming total_price is the column
            ],
            'customer_details' => [
                'first_name' => $shipment->sender_name,
                'phone'      => $shipment->sender_phone,
            ],
            'item_details' => [[
                'id'       => $shipment->id,
                'price'    => $shipment->total_price,
                'quantity' => 1,
                'name'     => 'Ongkir ' . $shipment->tracking_number,
            ]],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            // Update shipment tracking number reference in payments? We just save it later.
            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_id'   => $params['transaction_details']['order_id'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function midtransCallback(Request $request)
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        $status = $notif->transaction_status;
        $orderId = $notif->order_id;
        
        // Extract original tracking number (we appended -time())
        $parts = explode('-', $orderId);
        array_pop($parts); // Remove the timestamp part
        $trackingNumber = implode('-', $parts);

        $shipment = Shipment::where('tracking_number', $trackingNumber)->first();

        if (!$shipment) {
            return response()->json(['status' => 'error', 'message' => 'Shipment not found'], 404);
        }

        if (in_array($status, ['capture', 'settlement'])) {
            if ($shipment->payment_status !== 'paid') {
                $shipment->update([
                    'payment_status' => 'paid',
                    'payment_method' => 'midtrans',
                    'status'         => 'ready_to_ship',
                    'paid_at'        => now(),
                ]);

                // Increment Cash Drawer automatically if there's an open one
                CashDrawer::where('date', today())
                    ->where('branch_id', $shipment->branch_id)
                    ->where('status', 'open')
                    ->increment('current_balance', $shipment->total_price);

                // Update or Create Payment record
                $payment = Payment::where('shipment_id', $shipment->id)->first();
                if ($payment) {
                    $payment->update([
                        'status' => 'success',
                        'payment_method' => 'midtrans',
                        'paid_at' => now(),
                    ]);
                } else {
                    Payment::create([
                        'shipment_id' => $shipment->id,
                        'amount'      => $shipment->total_price,
                        'status'      => 'success',
                        'payment_method' => 'midtrans',
                        'paid_at'     => now(),
                    ]);
                }
            }
        } elseif ($status === 'pending') {
            $shipment->update(['payment_status' => 'pending', 'payment_method' => 'midtrans']);
        } elseif (in_array($status, ['deny', 'expire', 'cancel'])) {
            $shipment->update(['payment_status' => 'failed']);
        }

        return response()->json(['status' => 'ok']);
    }
}
