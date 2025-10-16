<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pizza House') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Inter:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Custom CSS -->
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                background-size: 400% 400%;
                animation: gradientShift 15s ease infinite;
            }
            
            @keyframes gradientShift {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }
            
            .auth-card {
                backdrop-filter: blur(16px);
                background: rgba(255, 255, 255, 0.95);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            .pizza-icon {
                font-size: 4rem;
                color: #f97316;
                text-shadow: 0 4px 8px rgba(249, 115, 22, 0.3);
            }
            
            .btn-primary {
                background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
                transition: all 0.3s ease;
            }
            
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
            }
            
            .input-field {
                transition: all 0.3s ease;
                border: 2px solid #e5e7eb;
            }
            
            .input-field:focus {
                border-color: #f97316;
                box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo -->
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center group">
                    <div class="pizza-icon mb-2 group-hover:scale-110 transition-transform duration-300">🍕</div>
                    <h1 class="text-3xl font-bold text-white text-center">Pizza House</h1>
                    <p class="text-orange-100 text-sm mt-1">Hương vị tuyệt vời</p>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md auth-card px-8 py-10 shadow-2xl overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
            
            <!-- Footer -->
            <div class="mt-8 text-center">
                <p class="text-white text-sm opacity-80">© 2025 Pizza House. Được làm với ❤️</p>
            </div>
        </div>
    </body>
</html>
