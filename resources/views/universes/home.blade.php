<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Echoes of What If - Daily News From Beyond</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* gray-50 */
        }
        .header-title {
            font-weight: 900;
            font-size: 2.5rem;
            letter-spacing: -0.05em;
        }
        .universe-tag {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
    </style>
</head>
<body class="text-gray-800">

<div class="container mx-auto px-4 py-8">

    <!-- Header Section -->
    <header class="border-b-2 border-black pb-4 mb-8 text-center">
        <h1 class="header-title">Echoes of What If</h1>
        <p class="text-gray-600 mt-1">Your Daily News From Every Parallel Universe</p>
    </header>

    <!-- Main Content Grid -->
    <main>
        <!-- Featured Story (Hero Section) -->
        @if(isset($latestNews))
            <section class="mb-12">
                <a href="{{-- route('news.show', $latestNews) --}}" class="block group">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div>
                            <!-- Use real image if available, otherwise placeholder -->
                            <img src="{{ $latestNews->image_path ? asset('storage/' . $latestNews->image_path) : 'https://placehold.co/800x600/e2e8f0/334155?text=Lead+Story' }}"
                                 alt="{{ $latestNews->headline ?? 'Lead Story Image' }}"
                                 class="w-full h-auto object-cover rounded-lg shadow-md group-hover:shadow-xl transition-shadow duration-300">
                        </div>
                        <div>
                            <span class="universe-tag text-red-600">{{ $latestNews->parallelUniverse->name ?? 'Universe Name' }}</span>
                            <h2 class="text-4xl font-bold mt-2 mb-4 group-hover:text-red-700 transition-colors duration-300">
                                {{ $latestNews->headline ?? 'Tensions Rise as Martian Colony Declares Independence' }}
                            </h2>
                            <p class="text-lg text-gray-600">
                                {{ $latestNews->short_description ?? 'In a shocking turn of events, the Ares Prime colony has formally declared its sovereignty. Leaders from the Terran Alliance are scrambling to respond...' }}
                            </p>
                            <span class="mt-4 inline-block text-sm text-gray-500">{{ $latestNews->broadcast_date ? $latestNews->broadcast_date->format('F d, Y') : '' }}</span>
                        </div>
                    </div>
                </a>
            </section>
        @endif

        <!-- News Grid for each Universe -->
        <section>
            @if(isset($universes) && $universes->count())
                @foreach($universes as $universe)
                    @if($universe->newsBroadcasts->count())
                        <div class="mb-10">
                            <h3 class="text-2xl font-bold border-b border-gray-300 pb-2 mb-6">
                                Dispatches from: <span class="text-blue-700">{{ $universe->name }}</span>
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                                <!-- Loop through the latest news from this universe -->
                                @foreach($universe->newsBroadcasts->take(3) as $news)
                                    <article class="bg-white rounded-lg shadow-md overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                                        <a href="{{-- route('news.show', $news) --}}" class="block">
                                            <div>
                                                <!-- Use real image if available, otherwise placeholder -->
                                                <img src="{{ $news->image_path ? asset('storage/' . $news->image_path) : 'https://placehold.co/600x400/e2e8f0/334155?text=' . urlencode($universe->name) }}"
                                                     alt="{{ $news->headline }}"
                                                     class="w-full h-48 object-cover">
                                            </div>
                                            <div class="p-6">
                                                <h4 class="text-xl font-bold mb-2 group-hover:text-blue-800 transition-colors duration-300">
                                                    {{ $news->headline }}
                                                </h4>
                                                <p class="text-gray-600 text-sm mb-4">
                                                    {{ Str::limit($news->short_description, 120) }}
                                                </p>
                                                <span class="text-xs text-gray-500">{{ $news->broadcast_date ? $news->broadcast_date->format('M d, Y') : '' }}</span>
                                            </div>
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @else
                <!-- Fallback content if no universes are available -->
                <div class="text-center py-16">
                    <p class="text-gray-500">No dispatches received from any universe yet. The timelines are quiet.</p>
                </div>
            @endif
        </section>
    </main>

    <!-- Footer -->
    <footer class="text-center mt-12 pt-6 border-t border-gray-300">
        <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Echoes of What If. All rights reserved.</p>
        <p class="text-xs text-gray-400 mt-1">Monitoring the multiverse so you don't have to.</p>
    </footer>

</div>
</body>
</html>
