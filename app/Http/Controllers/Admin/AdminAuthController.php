<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Handle admin login.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */

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

        if (!$user->is_admin && !$user->is_vendor) {
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

    /**
     * Handle admin logout.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json(null, 204);
    }

    /**
     * Get the authenticated admin user.
     *
     * @param Request $request
     * @return UserResource
     */
    public function getUser(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
