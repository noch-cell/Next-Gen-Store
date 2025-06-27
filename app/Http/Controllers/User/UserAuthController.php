<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone'=> 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone'=> $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('home.home')->with('status', 'Registration successful.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || !Hash::check($request->password, $customer->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        Auth::login($customer);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home')->with('status', 'Logged out successfully');
    }
}
