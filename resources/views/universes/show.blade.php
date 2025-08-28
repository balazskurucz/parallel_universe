<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $universe->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Universe Details -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">Universe Details</h3>
                    <p class="text-gray-600 dark:text-gray-300">{{ $universe->long_description }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Historical Events -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Historical Events</h3>
                        
                        @if($universe->historicalEvents->count() > 0)
                            <div class="space-y-4">
                                @foreach($universe->historicalEvents as $event)
                                    <div class="border-l-4 border-blue-500 pl-4">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-semibold">{{ $event->title }}</h4>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $event->event_year }}</span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $event->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-300">No historical events recorded for this universe.</p>
                        @endif
                    </div>
                </div>

                <!-- News Broadcasts -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-medium mb-4">Recent News Broadcasts</h3>
                        
                        @if($universe->newsBroadcasts->count() > 0)
                            <div class="space-y-4">
                                @foreach($universe->newsBroadcasts as $broadcast)
                                    <div class="border-l-4 border-green-500 pl-4">
                                        <div class="flex items-center justify-between">
                                            <h4 class="font-semibold">{{ $broadcast->title }}</h4>
                                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $broadcast->broadcast_date->format('M d, Y') }}</span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-300 mt-1">{{ $broadcast->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-gray-300">No news broadcasts available for this universe.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="mt-6">
                <a href="{{ route('home') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition duration-150 ease-in-out">
                    ← Back to All Universes
                </a>
            </div>
        </div>
    </div>
</x-app-layout>