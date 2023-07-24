<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class CartController extends Controller
{
    /**
     * Display the cart content.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $user = auth()->user();
////        try {
////            $cartCollection = \Cart::session(auth()->user->id)->getContent;
//            return response()->json(\Cart::session($user->id)->getContent());
////        } catch (\Exception $e) {
////            return response()->json(['message' => $e->getMessage()], 500);
////        }
        $userId = 1; // replace with actual user ID
        $cartCollection = \Cart::session($userId)->getContent();
        return response()->json($cartCollection);
    }

    /**
     * Add an item to the cart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
//        $request->validate([
//            'size' => 'required|string|max:255',
//        ]);
//
//        $user = auth()->user();
//
//        try {
//            \Cart::session($user->id)->add('293ad', 'Product 1', 1, 9.99, array('size' => 'large'));
//            return response()->json(['message' => 'Product added to cart']);
//        } catch (\Exception $e) {
//            return response()->json(['message' => $e->getMessage()], 500);
//        }
        $userId = 1; // replace with actual user ID
        \Cart::session($userId)->add('293ad', 'Product 1', 1, 9.99, array('size' => 'large'));
    }
}
