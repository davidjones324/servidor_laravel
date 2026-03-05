<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Sistema de Gestión de FCT - IES Delgado Hernández">

        <title>{{ config('app.name', 'Gestión FCT') }} — IES Delgado Hernández</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow-sm border-b border-gray-100">
                    <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="pb-8">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-ies-blue-700 text-white mt-auto">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex flex-col sm:flex-row justify-between items-center space-y-2 sm:space-y-0">
                        <p class="text-sm text-ies-blue-200">
                            &copy; {{ date('Y') }} IES Delgado Hernández — Bollullos del Condado (Huelva)
                        </p>
                        <p class="text-xs text-ies-blue-300">
                            Sistema de Gestión FCT / Prácticas Dual
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
