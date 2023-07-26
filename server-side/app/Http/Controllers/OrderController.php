<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Order;
use App\Models\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::with(['items', 'user'])->get()->map(function ($order) {
            foreach($order->items as $item) {
                $item->image = $item->image ? url(\Illuminate\Support\Facades\Storage::url($item->image)) : null;
            }
            return [
                'id' => $order->id,
                'item' => $order->items,
                'status' => $order->status,
                'user_name' => $order->user->name,
                'created_at' => $order->created_at->format('d-m-Y H:i:s'),
            ];
        });
        return response()->json($orders, 200);

    }
    public function submitOrder(): JsonResponse
    {
        $user_id = auth()->user()->id;
        $cartItems = Cart::where('user_id', $user_id)->with('storage')->get();

        // Begin a transaction
        DB::beginTransaction();

        try {
            // Create a new order
            $newOrder = Order::create([
                'customer_id' => $user_id,
                'created_at' => now(),
            ]);

            // Loop through each item in the cart
            foreach($cartItems as $cartItem) {
                // Create a new item for each cart item and associate with the new order
                Item::create([
                    'order_id' => $newOrder->id,
                    'name' => $cartItem->storage->name,
                    'price' => $cartItem->storage->price,
                    'quantity' => $cartItem->quantity_of_item,
                    'description' => $cartItem->storage->description,
                    'image' => $cartItem->storage->image
                ]);
                Storage::where('id', $cartItem->storage_id)->decrement('quantity', $cartItem->quantity_of_item);
            }

            // Remove the cart items after transferring them to the order
            Cart::where('user_id', $user_id)->delete();

            // Commit the transaction
            DB::commit();
        } catch (\Exception $e) {
            // If something went wrong, rollback the transaction
            DB::rollback();
            throw $e;
        }
        return response()->json(['message' => 'Order submitted successfully'], 201);
    }

    public function viewMyOrders(): JsonResponse
    {
        $user_id = auth()->user()->id;
        $orders = Order::where('customer_id', $user_id)->with('items')->latest()->get()->map(function ($order) {
            foreach($order->items as $item) {
                $item->image = $item->image ? url(\Illuminate\Support\Facades\Storage::url($item->image)) : null;
            }
            return [
                'item' => $order->items,
                'status' => $order->status,
                'created_at' => $order->created_at->format('d-m-Y H:i:s'),
            ];
        });
        return response()->json($orders, 200);
    }
    public function updateOrderStatus(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:processing,completed,declined'
        ]);

        $order = Order::findOrFail($id);
        if($order->status === 'completed' || $order->status === 'declined') {
            return response()->json(['message' => 'Order status cannot be updated, the status is already in final stage'], 400);
        } else if ($order->status === 'processing' && $request->status === 'declined') {
            return response()->json(['message' => 'Order status cannot be updated, the status is already in final stage'], 400);
        } else {
            $order->update([
                'status' => $request->status
            ]);
            return response()->json(['message' => 'Order status updated successfully'], 200);
        }
    }
}
