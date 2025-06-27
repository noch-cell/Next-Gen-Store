<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorAuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $vendor = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'is_vendor' => true, // Ensure this field is set for vendors
        ]);

        return response()->json([
            'message' => 'Vendor registered successfully.',
            'vendor' => $vendor,
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ]);

        $remember = $credentials['remember'] ?? false;
        unset($credentials['remember']);

        // Explicitly use the 'web' guard
        if (!Auth::guard('web')->attempt($credentials, $remember)) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 422);
        }

        /** @var User $user */
        $user = Auth::guard('web')->user();

        if (!$user->is_vendor) {
            Auth::guard('web')->logout();
            return response()->json([
                'message' => 'You are not authorized to access this resource.',
            ], 403);
        }


        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => new UserResource($user),
            'token' => $token,
        ]);
    }
}
