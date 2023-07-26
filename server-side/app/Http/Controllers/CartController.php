<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCartContent(): JsonResponse
    {
        $user_id = auth()->user()->id;
        $cart = Cart::where('user_id', $user_id)->with('storage')->get()->map(function ($cart) {
            $total_price = $cart->storage->price * $cart->quantity_of_item;

            return [
                'id' => $cart->storage->id,
                'name' => $cart->storage->name,
                'price' => $cart->storage->price,
                'quantity' => $cart->quantity_of_item,
                'total_price_for_item' => $total_price,
                'image' => $cart->storage->image ? url(\Illuminate\Support\Facades\Storage::url($cart->storage->image)) : null ,
            ];
        });
        return response()->json($cart);
    }
    public function getCartTotalCost(): JsonResponse
    {
        $user_id = auth()->user()->id;
        $cart = Cart::where('user_id', $user_id)->with('storage')->get()->map(function ($cart) {
            $total_price = $cart->storage->price * $cart->quantity_of_item;

            return [
                'total_price_for_item' => $total_price
            ];
        });
        return response()->json($cart);
    }
    public function addToCart(Request $request): JsonResponse
    {
        $user_id = auth()->user()->id;
        $cart = Cart::create([
            'user_id' => $user_id,
            'storage_id' => $request->storage_id,
            'quantity_of_item' => 1,
        ]);
        return response()->json(['message' => 'Item added to cart', 'quantity' => $cart->quantity_of_item], 201);
    }
    public function removeFromCart(string $id): JsonResponse
    {
        $user_id = auth()->user()->id;
        $cart = Cart::where('user_id', $user_id)->where('storage_id', $id)->firstOrFail();
        $cart->delete();
        return response()->json(['message' => 'Item removed from cart'], 200);
    }
    public function updateCart(Request $request, string $storage_id): JsonResponse
    {
        $request->validate([
            'quantity' => 'required|integer|in:1,-1'
        ]);
        $user_id = auth()->user()->id;
        $cart = Cart::where('user_id', $user_id)->where('storage_id', $storage_id)->firstOrFail();
        $cart->quantity_of_item += $request->quantity;
        $cart->save();
        return response()->json(['message' => "Cart updated", 'quantity' => $cart->quantity_of_item], 200);
    }
    public function clearCart(): JsonResponse
    {
        $user_id = auth()->user()->id;
        try {
            Cart::where('user_id', $user_id)->delete();
            return response()->json(['message' => 'Cart cleared'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Cart is already empty'], 200);
        }
    }
}
