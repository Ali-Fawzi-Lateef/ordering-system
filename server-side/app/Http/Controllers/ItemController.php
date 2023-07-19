<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Item::all());
    }

    /**
     * Store a newly created resource in Item.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|uuid',
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
        ]);
        Item::create($request->all());
        return response()->json(['message' => 'Item created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json(Item::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|uuid',
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
        ]);
        $item = Item::findOrFail($id);
        $item->update($request->all());
        return response()->json(['message' => 'Item updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        Item::findOrFail($id)->delete();
        return response()->json(['message' => 'Item deleted successfully'], 200);
    }
}
