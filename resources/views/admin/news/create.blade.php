<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New News Broadcast') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div></div>
                        <a href="{{ route('admin.news.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to News List
                        </a>
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
        <form action="{{ route('admin.news.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Parallel Universe -->
            <div>
                <label for="parallel_universe_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Parallel Universe <span class="text-red-500">*</span>
                </label>
                <select id="parallel_universe_id" name="parallel_universe_id" required
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900">
                    <option value="">Select a parallel universe</option>
                    @foreach($universes as $universe)
                        <option value="{{ $universe->id }}" {{ old('parallel_universe_id') == $universe->id ? 'selected' : '' }}>
                            {{ $universe->name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">The parallel universe where this news was broadcast</p>
            </div>

            <!-- News Headline -->
            <div>
                <label for="headline" class="block text-sm font-medium text-gray-700 mb-2">
                    News Headline <span class="text-red-500">*</span>
                </label>
                <input type="text" id="headline" name="headline" value="{{ old('headline') }}" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="e.g., Viking Fleet Discovers New Continent">
                <p class="mt-1 text-sm text-gray-500">A compelling headline for this news broadcast</p>
            </div>

            <!-- Broadcast Date -->
            <div>
                <label for="broadcast_date" class="block text-sm font-medium text-gray-700 mb-2">
                    Broadcast Date & Time <span class="text-red-500">*</span>
                </label>
                <input type="datetime-local" id="broadcast_date" name="broadcast_date" value="{{ old('broadcast_date') }}" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900">
                <p class="mt-1 text-sm text-gray-500">The date and time when this news was broadcast</p>
            </div>

            <!-- Short Description -->
            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Short Description <span class="text-red-500">*</span>
                </label>
                <textarea id="short_description" name="short_description" rows="3" required
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                          placeholder="A brief summary of the news story...">{{ old('short_description') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">A brief summary for listings and previews</p>
            </div>

            <!-- Long Description -->
            <x-wysiwyg-editor 
                name="long_description"
                label="Long Description"
                :value="old('long_description')"
                :required="true"
                help-text="The complete news story with all details" />

            <!-- Cover Image Selection -->
            <x-media-selector 
                name="cover_image_id" 
                :value="old('cover_image_id')" 
                label="Cover Image" 
                :media-files="$mediaFiles" />

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.news.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create News Broadcast
                </button>
            </div>
        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>