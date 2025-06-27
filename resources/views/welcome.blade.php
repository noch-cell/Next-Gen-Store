<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NextGenStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

<!-- Navbar -->
<nav class="bg-orange-600 text-white px-6 py-4 shadow">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        <!-- Left: Logo & Links -->
        <div class="flex items-center space-x-6">
            <a href="#" class="text-xl font-bold">NextGenStore</a>
            <a href="#" class="hover:text-orange-400">Home</a>
            <a href="#" class="hover:text-orange-400">Categories</a>
            <a href="#" class="hover:text-orange-400">Something</a>
        </div>

        <!-- Right: Account + Cart -->
        <div class="flex items-center space-x-6">
            <a href="{{ route('user.login') }}" class="hover:text-orange-400">Login</a>
            <a href="{{ route('user.register') }}" class="hover:text-orange-400">Register now</a>
            <a href="#" class="hover:text-orange-400">🛒 Cart</a>
            <!-- Account Dropdown -->
            <div class="relative group">
                <button class="flex items-center hover:text-orange-400 space-x-1">
                    <span>👤 My Account</span>
                    <svg class="w-4 h-4 transform transition-transform group-hover:rotate-180" fill="none"
                         stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div
                    class="absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded-md shadow-md hidden group-hover:block z-50">
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">My Profile</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Watchlist</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">My Orders</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
</nav>

<!-- Main content -->
<main class="flex-grow p-6">
    @include('layouts.home')
</main>

</body>
</html>
