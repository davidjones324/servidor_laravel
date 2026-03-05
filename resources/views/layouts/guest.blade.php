<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gestión FCT') }} — Iniciar Sesión</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-ies-blue-600 via-ies-blue-500 to-ies-green-500">
            <div class="mb-6 text-center">
                <a href="/" class="flex flex-col items-center space-y-2">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                        <span class="text-3xl font-bold text-ies-green-600">DH</span>
                    </div>
                    <h1 class="text-white text-xl font-bold tracking-tight">IES Delgado Hernández</h1>
                    <p class="text-ies-blue-100 text-sm">Gestión de Prácticas FCT</p>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-xl overflow-hidden rounded-2xl">
                {{ $slot }}
            </div>

            <p class="mt-6 text-xs text-ies-blue-100">
                &copy; {{ date('Y') }} IES Delgado Hernández — Bollullos del Condado (Huelva)
            </p>
        </div>
    </body>
</html>
