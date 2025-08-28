<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Event: ') . $event->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div></div>
                        <div class="space-x-3">
                            <a href="{{ route('admin.events.show', $event) }}" 
                               class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                View Event
                            </a>
                            <a href="{{ route('admin.events.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Back to List
                            </a>
                        </div>
                    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Cover Image -->
            @if($event->coverImage)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Current Cover Image
                    </label>
                    <div class="mb-4">
                        <img src="{{ $event->coverImage->url }}" 
                             alt="{{ $event->coverImage->alt_text ?? $event->title }}" 
                             class="h-32 w-auto object-cover rounded border">
                        <p class="text-sm text-gray-500 mt-1">{{ $event->coverImage->file_name }}</p>
                    </div>
                </div>
            @endif

            <!-- Parallel Universe -->
            <div>
                <label for="parallel_universe_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Parallel Universe <span class="text-red-500">*</span>
                </label>
                <select id="parallel_universe_id" name="parallel_universe_id" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900">
                    <option value="">Select a parallel universe</option>
                    @foreach($universes as $universe)
                        <option value="{{ $universe->id }}" 
                                {{ old('parallel_universe_id', $event->parallel_universe_id) == $universe->id ? 'selected' : '' }}>
                            {{ $universe->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">The parallel universe where this event occurred</p>
            </div>

            <!-- Event Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Event Title <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="e.g., The Great Viking Settlement of Vinland">
                <p class="mt-1 text-sm text-gray-500">A descriptive title for this historical event</p>
            </div>

            <!-- Event Year -->
            <div>
                <label for="event_year" class="block text-sm font-medium text-gray-700 mb-2">
                    Event Year <span class="text-red-500">*</span>
                </label>
                <input type="number" id="event_year" name="event_year" value="{{ old('event_year', $event->event_year) }}" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="e.g., 1003">
                <p class="mt-1 text-sm text-gray-500">The year when this event occurred</p>
            </div>

            <!-- Short Description -->
            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Short Description <span class="text-red-500">*</span>
                </label>
                <textarea id="short_description" name="short_description" rows="3" required
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                          placeholder="A brief summary of the event...">{{ old('short_description', $event->short_description) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">A brief summary for listings and previews</p>
            </div>

            <!-- Long Description -->
            <div>
                <label for="long_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Long Description <span class="text-red-500">*</span>
                </label>
                <textarea id="long_description" name="long_description" rows="6" required
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                          placeholder="Provide a detailed description of the event, its causes, consequences, and significance...">{{ old('long_description', $event->long_description) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">A detailed description of the event and its significance</p>
            </div>

            <!-- Cover Image Selection -->
            <x-media-selector 
                name="cover_image_id" 
                :value="old('cover_image_id', $event->cover_image_id)" 
                label="Cover Image" 
                :media-files="$mediaFiles" />


            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.events.show', $event) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Event
                </button>
            </div>
        </form>

        <!-- Delete Section -->
        <div class="border-t pt-6 mt-8">
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <h3 class="text-lg font-medium text-red-900 mb-2">Danger Zone</h3>
                <p class="text-sm text-red-700 mb-4">
                    Once you delete this event, there is no going back. Please be certain.
                </p>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline">
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

</x-app-layout>