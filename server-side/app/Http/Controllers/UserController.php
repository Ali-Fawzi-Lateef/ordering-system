<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $users = User::paginate(7);

        foreach ($users as $user) {
            if ($user->profile_image) {
                $user->profile_image = url(Storage::url($user->profile_image));
            }
        }

        return response()->json($users);
    }
    public function getAuthUser(): JsonResponse
    {
        $user = auth()->user();
        if($user->profile_image) {
            // Generate the URL to the image file
            $user->profile_image = url(Storage::url($user->profile_image));
        }
        return response()->json($user);
    }
    public function updateProfile(Request $request): JsonResponse
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $user = auth()->user();
        if($user->profile_image){
            Storage::disk('public')->delete($user->profile_image);
        }
        $path = $request->profile_image->store('images', 'public');
        $user->profile_image = $path;
        $user->save();

        return response()->json($user);
    }
}
