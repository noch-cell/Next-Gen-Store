@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ url('/login') }}" class="w-[400px] mx-auto p-6 my-16 bg-white">
        @csrf

        <h2 class="text-2xl font-semibold text-center mb-5">
            Login to your account
        </h2>

        <p class="text-center text-gray-500 mb-6">or
            <a href="{{ url('/register') }}" class="text-sm text-purple-700 hover:text-purple-600">create new account</a>
        </p>

        {{-- Show errors --}}
        @if ($errors->any())
            <div class="mb-4 text-red-600">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Email --}}
        <div class="mb-4">
            <x-input class="bg-gray-100" type="email" name="email" placeholder="Your email address" :value="old('email')" required autofocus/>
        </div>

        {{-- Password --}}
        <div class="mb-4">
            <x-input class="bg-gray-100" type="password" name="password" placeholder="Your password" required />
        </div>

        <div class="flex justify-between items-center mb-5">
            <div class="flex items-center">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="mr-2 rounded border-gray-300 text-purple-500 focus:ring-purple-500"
                />
                <label for="remember_me" class="text-sm">Remember Me</label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-purple-700 hover:text-purple-600">
                    Forgot Password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-primary bg-emerald-500 hover:bg-emerald-600 active:bg-emerald-700 w-full text-white px-4 py-2 rounded">
            Login
        </button>
    </form>
@endsection
