@extends('layouts.app')

@section('content')
        <form method="POST" action="{{ url('/register') }}" class="w-[500px] mx-auto p-6 my-16 bg-white">
        @csrf

        <h2 class="text-2xl font-semibold text-center mb-4">Create an account</h2>
        <p class="text-center text-gray-500 mb-3">or
            <a href="{{ url('login') }}" class="text-sm text-purple-700 hover:text-purple-600">login with existing account</a>
        </p>
        <!-- Session Status -->
        <auth-session-status class="mb-4" :status="session('status')"/>
            <div class="mb-4">
                <x-input class="bg-gray-100" type="text" name="name" placeholder="Your name" :value="old('name')" required autofocus/>
            </div>
            <div class="mb-4">
                <x-input class="bg-gray-100" type="text" name="address" placeholder="Your address" :value="old('address')" required autofocus/>
            </div>
            <div class="mb-4">
                <x-input class="bg-gray-100" type="text" name="phone" placeholder="Your phone" :value="old('phone')" required autofocus/>
            </div>
        <div class="mb-4">
            <x-input class="bg-gray-100" type="email" name="email" placeholder="Your email address" :value="old('email')" required autofocus/>
        </div>
        <div class="mb-4">
            <x-input class="bg-gray-100" type="password" name="password" placeholder="Your password" :value="old('password')" required autofocus/>
        </div>

        <button
            class="btn-primary bg-orange-600 hover:bg-orange-600 active:bg-orange-700 w-full text-white">
            Signup
        </button>
    </form>
@endsection
