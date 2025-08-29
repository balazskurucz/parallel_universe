<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Echoes of What If') }}</title>
    
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
</head>
<body class="font-sans antialiased text-white">

<!-- Live Anomaly Status Bar -->
<div class="bg-black/50 backdrop-blur-sm text-center p-2 text-sm text-gray-300 flex items-center justify-center space-x-2 fixed top-0 w-full z-50">
  <div class="live-indicator w-2 h-2 rounded-full"></div>
  <span>TEMPORAL STREAM: <span class="font-bold text-green-400">STABLE</span> // ANOMALY INDEX: <span class="font-bold text-gray-100">0.013%</span></span>
</div>

<!-- Header - Full Width -->
<header class="mb-4">
  <img src="{{ asset('images/main_header.png') }}" alt="Echoes of What If Header" class="w-full h-auto shadow-2xl">
</header>

<div class="w-[90%] mx-auto p-4 md:p-8">

  <!-- Main Content Grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- Main Column -->
    <main class="lg:col-span-2 space-y-8">
      <div class="bg-gray-800 rounded-lg p-6 shadow-lg border border-gray-700 pulsing-border">
        <h2 class="font-playfair text-3xl font-bold text-white mb-6 border-b border-gray-600 pb-4">Observed Parallel Universes</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

          @forelse($universes as $universe)
          <!-- Universe Card -->
          <div class="universe-card bg-gray-900 rounded-lg shadow-md border border-gray-700 overflow-hidden flex flex-col transition-transform transform hover:-translate-y-2 relative">
            <div class="glitch-overlay"></div>
            @if($universe->coverImage)
              <img src="{{ route('media.serve', ['id' => $universe->coverImage->id, 'dimensions' => '400x300']) }}" alt="{{ $universe->name }}" class="w-full h-48 object-cover">
            @else
              <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-900 flex items-center justify-center">
                <span class="text-gray-400 text-lg font-playfair">{{ $universe->name }}</span>
              </div>
            @endif
            <div class="p-4 flex flex-col flex-grow">
              <h3 class="text-xl font-bold text-white font-playfair">{{ $universe->name }}</h3>
              <p class="text-md text-gray-300 mt-2 flex-grow">
                <strong class="font-semibold text-gray-100">Divergence Point:</strong> {{ $universe->divergence_point }}
              </p>
              @if($universe->long_description)
                <p class="text-sm text-gray-400 mt-2">{{ $universe->long_description }}</p>
              @endif
              <!-- Data Readout -->
              <div class="text-xs mt-4 space-y-2">
                <p>Timeline Stability: <span class="font-mono text-green-400">{{ rand(75, 99) }}.{{ rand(0, 9) }}%</span></p>
                <div class="w-full bg-gray-700 rounded-full h-1.5">
                  <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ rand(75, 99) }}.{{ rand(0, 9) }}%"></div>
                </div>
                @if($universe->newsBroadcasts->first())
                  <p>Last Echo Received: <span class="font-mono text-gray-400">{{ $universe->newsBroadcasts->first()->broadcast_date->diffForHumans() }}</span></p>
                @else
                  <p>Last Echo Received: <span class="font-mono text-gray-400">No data</span></p>
                @endif
                @if($universe->divergence_year)
                  <p>Divergence Year: <span class="font-mono text-cyan-400">{{ abs($universe->divergence_year) }} {{ $universe->divergence_year < 0 ? 'BCE' : 'CE' }}</span></p>
                @endif
              </div>
              <a href="{{ route('universes.show', $universe) }}" class="text-amber-400 hover:text-amber-300 font-semibold text-sm mt-4 inline-block self-start transition-colors z-10">View Latest Report &rarr;</a>
            </div>
          </div>
          @empty
          <div class="col-span-2 text-center py-12">
            <p class="text-gray-400 text-lg">No parallel universes detected. The multiverse scanner is offline.</p>
          </div>
          @endforelse

        </div>
      </div>
    </main>

    <!-- Sidebar -->
    <aside class="space-y-8">
      <!-- Latest Echoes -->
      <div class="bg-gray-800 rounded-lg p-6 shadow-lg border border-gray-700">
        <h3 class="font-playfair text-2xl font-bold text-white mb-4 border-b border-gray-600 pb-2">Latest Echoes</h3>
        <div class="space-y-4">
          @forelse($latestNews as $news)
          <div class="bg-gray-900 rounded-lg p-4 border border-gray-700 hover:border-amber-500 transition-colors">
            <div class="flex items-start space-x-3">
              @if($news->coverImage)
                <img src="{{ route('media.serve', ['id' => $news->coverImage->id, 'dimensions' => '60x60']) }}" alt="{{ $news->headline }}" class="w-12 h-12 rounded object-cover flex-shrink-0">
              @else
                <div class="w-12 h-12 bg-gradient-to-br from-amber-600 to-amber-800 rounded flex items-center justify-center flex-shrink-0">
                  <span class="text-white text-xs font-bold">{{ substr($news->parallelUniverse->name, 0, 2) }}</span>
                </div>
              @endif
              <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-white mb-1 line-clamp-2">{{ $news->headline }}</h4>
                <p class="text-xs text-gray-400 mb-2">{{ $news->parallelUniverse->name }}</p>
                <p class="text-xs text-gray-500">{{ $news->broadcast_date->format('M j, Y') }}</p>
              </div>
            </div>
          </div>
          @empty
          <div class="text-center py-8">
            <p class="text-gray-400">No recent echoes detected.</p>
          </div>
          @endforelse
        </div>
      </div>

      <!-- Temporal Readings -->
      <div class="bg-gray-800 rounded-lg p-6 shadow-lg border border-gray-700">
        <h3 class="font-playfair text-2xl font-bold text-white mb-4 border-b border-gray-600 pb-2">Temporal Readings</h3>
        <div class="space-y-3">
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-300">Quantum Flux:</span>
            <span class="text-sm font-mono text-green-400">{{ number_format(rand(1000, 9999) / 100, 2) }} THz</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-300">Dimensional Drift:</span>
            <span class="text-sm font-mono text-yellow-400">{{ rand(1, 5) }}.{{ rand(10, 99) }}°</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-300">Reality Index:</span>
            <span class="text-sm font-mono text-cyan-400">{{ rand(85, 99) }}.{{ rand(0, 9) }}%</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-sm text-gray-300">Active Observers:</span>
            <span class="text-sm font-mono text-white">{{ rand(100, 999) }}</span>
          </div>
        </div>
      </div>

      <!-- About Echoes -->
      <div class="bg-gray-800 rounded-lg p-6 shadow-lg border border-gray-700">
        <h3 class="font-playfair text-2xl font-bold text-white mb-4 border-b border-gray-600 pb-2">ABOUT ECHOES</h3>
        <p class="text-gray-400 text-sm leading-relaxed">
          Powered by a Chronos-7 AI, "Echoes of What If" taps into temporal fluctuations across infinite realities. We are a window into the worlds that could have been. Our mission is to observe, record, and report on the histories that never were.
        </p>
      </div>
    </aside>

  </div>

</div>

<!-- Footer -->
<footer class="text-center mt-12 pt-8 border-t border-gray-700">
  <p class="text-gray-400">&copy; 2025 Echoes of What If. All timelines observed.</p>
  <p class="text-xs text-gray-500 mt-1">Temporal Interference is strictly prohibited.</p>
</footer>

</body>
</html>