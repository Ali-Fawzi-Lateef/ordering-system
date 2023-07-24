<?php

namespace App\Http\Controllers;

use App\Models\Storage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $storage = Storage::paginate(8);
        foreach ($storage as $item) {
            if ($item->image) {
                $item->image = url(\Illuminate\Support\Facades\Storage::url($item->image));
            }
        }
        return response()->json($storage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->image->store('images', 'public');
        }
        Storage::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $path,
        ]);
        return response()->json(['message' => 'Storage created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $storage = Storage::findOrFail($id);
        if ($storage->image) {
            $storage->image = url(\Illuminate\Support\Facades\Storage::url($storage->image));
        }
        return response()->json($storage);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'description' => 'nullable|string|max:255',
        ]);

        $storage = Storage::findOrFail($id);
        $path = null;
        if( $storage->image){
            \Illuminate\Support\Facades\Storage::disk('public')->delete($storage->image);
        }
        if ($request->hasFile('image')) {
            $path = $request->image->store('images', 'public');
        }
        $storage->update([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'image' => $path
        ]);
        return response()->json(['message' => 'Storage updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $storage = Storage::findOrFail($id);
        $storage->delete();
        return response()->json(['message' => 'Storage deleted successfully'], 200);
    }
}
