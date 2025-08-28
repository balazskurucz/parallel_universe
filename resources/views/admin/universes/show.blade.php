<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Universe Details: ') . $universe->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div></div>
                        <div class="space-x-3">
                            <a href="{{ route('admin.universes.edit', $universe) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit Universe
                            </a>
                            <a href="{{ route('admin.universes.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Back to List
                            </a>
                        </div>
                    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Cover Image -->
        @if($universe->cover_image_path)
            <div class="w-full h-64 bg-gray-200 overflow-hidden">
                <img src="{{ asset('storage/' . $universe->cover_image_path) }}" 
                     alt="{{ $universe->name }}" 
                     class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-6">
            <!-- Universe Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Universe Name</h3>
                    <p class="text-gray-700">{{ $universe->name }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Divergence Year</h3>
                    <p class="text-gray-700">{{ $universe->divergence_year ?? 'Not specified' }}</p>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Divergence Point</h3>
                    <p class="text-gray-700">{{ $universe->divergence_point }}</p>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                    <div class="text-gray-700 whitespace-pre-wrap">{{ $universe->description }}</div>
                </div>
            </div>

            <!-- Related Content -->
            <div class="border-t pt-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Related Content</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Historical Events -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-lg font-medium text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Historical Events
                        </h4>
                        @if($universe->historicalEvents->count() > 0)
                            <ul class="space-y-2">
                                @foreach($universe->historicalEvents->take(5) as $event)
                                    <li class="text-sm text-gray-600">
                                        <a href="{{ route('admin.events.show', $event) }}" class="hover:text-blue-600">
                                            {{ $event->title }}
                                        </a>
                                    </li>
                                @endforeach
                                @if($universe->historicalEvents->count() > 5)
                                    <li class="text-sm text-gray-500">
                                        ... and {{ $universe->historicalEvents->count() - 5 }} more
                                    </li>
                                @endif
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">No historical events yet</p>
                        @endif
                    </div>

                    <!-- News Broadcasts -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-lg font-medium text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            News Broadcasts
                        </h4>
                        @if($universe->newsBroadcasts->count() > 0)
                            <ul class="space-y-2">
                                @foreach($universe->newsBroadcasts->take(5) as $news)
                                    <li class="text-sm text-gray-600">
                                        <a href="{{ route('admin.news.show', $news) }}" class="hover:text-blue-600">
                                            {{ $news->headline }}
                                        </a>
                                    </li>
                                @endforeach
                                @if($universe->newsBroadcasts->count() > 5)
                                    <li class="text-sm text-gray-500">
                                        ... and {{ $universe->newsBroadcasts->count() - 5 }} more
                                    </li>
                                @endif
                            </ul>
                        @else
                            <p class="text-sm text-gray-500">No news broadcasts yet</p>
                        @endif
                    </div>

                </div>
            </div>

            <!-- Metadata -->
            <div class="border-t pt-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Metadata</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <strong>Created:</strong> {{ $universe->created_at->format('M j, Y \a\t g:i A') }}
                    </div>
                    <div>
                        <strong>Last Updated:</strong> {{ $universe->updated_at->format('M j, Y \a\t g:i A') }}
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t pt-6 mt-6">
                <div class="flex justify-between items-center">
                    <form action="{{ route('admin.universes.destroy', $universe) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                onclick="return confirm('Are you sure you want to delete this universe? This action cannot be undone and will also delete all related events, news, and media.')">
                            Delete Universe
                        </button>
                    </form>
                    
                    <div class="space-x-3">
                        <a href="{{ route('admin.universes.edit', $universe) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Universe
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>