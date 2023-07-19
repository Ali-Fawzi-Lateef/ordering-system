<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Order::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'customer_id' => 'required|uuid',
            'status' => 'required|in:pending,processing,completed,declined',
            'created_at' => 'required|date',
        ]);
        Order::create($request->all());
        return response()->json(['message' => 'Order created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json(Order::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'customer_id' => 'required|uuid',
            'status' => 'required|in:pending,processing,completed,declined',
            'created_at' => 'required|date',
        ]);
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json(['message' => 'Order updated successfully'], 200);
    }

    /**
     * Remove the specified resource from order.
     */
    public function destroy(string $id): JsonResponse
    {
        Order::findOrFail($id)->delete();
        return response()->json(['message' => 'Order deleted successfully'], 200);
    }
}
