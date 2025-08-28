<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Event Details: ') . $historicalEvent->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div></div>
                        <div class="space-x-3">
                            <a href="{{ route('admin.events.edit', $historicalEvent) }}" 
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit Event
                            </a>
                            <a href="{{ route('admin.events.index') }}" 
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
        <!-- Event Image -->
        @if($historicalEvent->image_path)
            <div class="w-full h-64 bg-gray-200 overflow-hidden">
                <img src="{{ asset('storage/' . $historicalEvent->image_path) }}" 
                     alt="{{ $historicalEvent->title }}" 
                     class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-6">
            <!-- Event Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Event Title</h3>
                    <p class="text-gray-700">{{ $historicalEvent->title }}</p>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Event Year</h3>
                    <p class="text-gray-700">{{ $historicalEvent->event_year }}</p>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Parallel Universe</h3>
                    <p class="text-gray-700">
                        @if($historicalEvent->parallelUniverse)
                            <a href="{{ route('admin.universes.show', $historicalEvent->parallelUniverse) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                {{ $historicalEvent->parallelUniverse->name }}
                            </a>
                        @else
                            Not specified
                        @endif
                    </p>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Short Description</h3>
                    <div class="text-gray-700 whitespace-pre-wrap">{{ $historicalEvent->short_description }}</div>
                </div>

                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Long Description</h3>
                    <div class="text-gray-700 whitespace-pre-wrap">{{ $historicalEvent->long_description }}</div>
                </div>

                @if($historicalEvent->video_url)
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Related Video</h3>
                    <div class="text-gray-700">
                        <a href="{{ $historicalEvent->video_url }}" target="_blank" 
                           class="text-blue-600 hover:text-blue-800 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m-6-8h1m4 0h1M9 6h6a2 2 0 012 2v8a2 2 0 01-2 2H9a2 2 0 01-2-2V8a2 2 0 012-2z"></path>
                            </svg>
                            Watch Video
                        </a>
                        <p class="text-sm text-gray-500 mt-1">{{ $historicalEvent->video_url }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Metadata -->
            <div class="border-t pt-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Metadata</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-lg font-medium text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Creation Info
                        </h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><strong>Created:</strong> {{ $historicalEvent->created_at->format('M d, Y \a\t g:i A') }}</p>
                            <p><strong>Last Updated:</strong> {{ $historicalEvent->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-lg font-medium text-gray-900 mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Media Info
                        </h4>
                        <div class="space-y-2 text-sm text-gray-600">
                            <p><strong>Has Image:</strong> {{ $historicalEvent->image_path ? 'Yes' : 'No' }}</p>
                            <p><strong>Has Video:</strong> {{ $historicalEvent->video_url ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t pt-6 mt-6">
                <div class="flex justify-between items-center">
                    <div class="space-x-3">
                        <a href="{{ route('admin.events.edit', $historicalEvent) }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Event
                        </a>
                        <a href="{{ route('admin.events.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Back to List
                        </a>
                    </div>
                    
                    <form action="{{ route('admin.events.destroy', $historicalEvent) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                onclick="return confirm('Are you sure you want to delete this event? This action cannot be undone.')">
                            Delete Event
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>