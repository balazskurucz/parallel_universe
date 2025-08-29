<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? config('app.name', 'Echoes of What If') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
        .pulsing-border { animation: pulse-border 2s infinite; }
        @keyframes pulse-border {
            0%, 100% { border-color: rgb(55, 65, 81); }
            50% { border-color: rgb(251, 191, 36); }
        }
        .live-indicator { background: linear-gradient(45deg, #10b981, #34d399); animation: pulse 2s infinite; }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .glitch-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(251, 191, 36, 0.1) 50%, transparent 70%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .universe-card:hover .glitch-overlay { opacity: 1; }
        body { background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%); min-height: 100vh; }
    </style>
    
    @stack('styles')
</head>
<body class="font-sans antialiased text-white">

@include('components.header')

<div class="w-[90%] mx-auto p-4 md:p-8">
    @yield('content')
</div>

@include('components.footer')

@stack('scripts')
</body>
</html>