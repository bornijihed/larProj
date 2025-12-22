<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'LOSTndFOUND HUB' }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 text-gray-800 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200/50 sticky top-0 z-50 shadow-sm">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="shrink-0 flex items-center gap-2">
                            <!-- Logo Icon -->
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <a href="/" class="text-2xl font-bold">
                                <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">LOSTndFOUND</span>
                                <span class="font-light text-gray-600">HUB</span>
                            </a>
                        </div>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-1">
                        <a href="/" class="{{ request()->is('/') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-all duration-200 rounded-t-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Accueil
                        </a>
                        <a href="/about" class="{{ request()->is('about') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-all duration-200 rounded-t-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            À Propos
                        </a>
                        <a href="/contact" class="{{ request()->is('contact') ? 'bg-indigo-50 border-indigo-500 text-indigo-700' : 'border-transparent text-gray-600 hover:text-gray-900 hover:bg-gray-50' }} inline-flex items-center px-4 py-2 border-b-2 text-sm font-medium transition-all duration-200 rounded-t-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Contact
                        </a>
                    </div>
                    <!-- Auth Navigation -->
                    <div class="flex items-center space-x-4 mr-4">
                        @auth
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-700">Hello, {{ Auth::user()->name }}</span>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="text-sm font-medium text-gray-500 hover:text-red-600 transition-colors duration-200">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                <a href="/login" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-lg transition-all duration-200">
                                    Log in
                                </a>
                                <a href="/register" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm hover:shadow transition-all duration-200">
                                    Sign up
                                </a>
                            </div>
                        @endauth
                    </div>

                    <!-- Slot for extra header content (like buttons) -->
                    <div class="flex items-center">
                        {{ $headerActions ?? '' }}
                    </div>
                </div>
            </div>
            
            <!-- Mobile Menu -->
            <div class="sm:hidden border-t border-gray-200 bg-gray-50">
                <div class="space-y-1 pb-3 pt-2">
                    <a href="/" class="block border-l-4 border-indigo-500 bg-indigo-50 py-2 pl-3 pr-4 text-base font-medium text-indigo-700">Accueil</a>
                    <a href="/about" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">À Propos</a>
                    <a href="/contact" class="block border-l-4 border-transparent py-2 pl-3 pr-4 text-base font-medium text-gray-500 hover:border-gray-300 hover:bg-gray-50 hover:text-gray-700">Contact</a>
                    
                    @auth
                        <div class="border-t border-gray-200 pt-4 pb-3">
                            <div class="flex items-center px-4">
                                <div class="flex-shrink-0">
                                    <!-- User Avatar Placeholder -->
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                        <span class="text-indigo-600 font-semibold text-lg">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1">
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="border-t border-gray-200 pt-4 pb-3">
                            <div class="space-y-1">
                                <a href="/login" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Log in</a>
                                <a href="/register" class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Sign up</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

    </div>
    
    <!-- Stack for page-specific scripts -->
    {{ $scripts ?? '' }}
</body>
</html>
