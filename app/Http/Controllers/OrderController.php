<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\System;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductLowStockNotification;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'items' => 'required|array',
            'items.*.system_id' => 'required|exists:systems,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Check if there is enough stock for each product in the order
            foreach ($request->items as $item) {
                $system = System::findOrFail($item['system_id']);

                foreach ($system->products as $product) {
                    $quantityNeeded = $item['quantity'] * $product->pivot->quantity;

                    if ($product->stock < $quantityNeeded) {
                        throw new \Exception('Insufficient stock for product: ' . $product->name);
                    }
                }
            }

            // Process each item in the order
            foreach ($request->items as $item) {
                $system = System::findOrFail($item['system_id']);

                // Create a new order
                $order = new Order();
                $order->system_id = $item['system_id'];
                $order->quantity = $item['quantity'];
                $order->save();

                // Update stock for each product in the system
                foreach ($system->products as $product) {
                    $quantityToDeduct = $item['quantity'] * $product->pivot->quantity;

                    // Update product stock
                    $product->stock -= $quantityToDeduct;
                    $product->save();

                    // TODO: Check if stock is below 20% and send email if not already sent
                    if ($product->stock < ($product->initial_stock * 0.2) && !$product->low_stock_email_sent) {
                        // Send email notification
                        Mail::to('supplies@example.com')->send(new ProductLowStockNotification($product));

                        // Set flag to indicate email has been sent
                        $product->low_stock_email_sent = true;
                        $product->save();
                    }
                }
            }

            // Commit the transaction
            DB::commit();

            return response()->json(['message' => 'Order placed successfully'], 200);
        } catch (\Exception $e) {
            // Rollback the transaction if an exception occurs
            DB::rollBack();

            return response()->json(['message' => 'Failed to place order: ' . $e->getMessage()], 500);
        }
    }
}
