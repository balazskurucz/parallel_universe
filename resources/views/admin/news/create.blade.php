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
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                    Broadcast Date <span class="text-red-500">*</span>
                </label>
                <input type="date" id="broadcast_date" name="broadcast_date" value="{{ old('broadcast_date') }}" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900">
                <p class="mt-1 text-sm text-gray-500">The date when this news was broadcast</p>
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
            <div>
                <label for="long_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Long Description <span class="text-red-500">*</span>
                </label>
                <textarea id="long_description" name="long_description" rows="6" required
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                          placeholder="Provide the full news story with all details, quotes, and context...">{{ old('long_description') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">The complete news story with all details</p>
            </div>

            <!-- News Image Upload -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    News Image
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload a news image</span>
                                <input id="image" name="image" type="file" class="sr-only" 
                                       accept="image/*" onchange="displayFileName(this)">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, GIF up to 2MB
                        </p>
                        <p id="file-name" class="text-sm text-gray-900 font-medium hidden"></p>
                    </div>
                </div>
            </div>

            <!-- Video URL -->
            <div>
                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                    Video URL
                </label>
                <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}"
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="https://www.youtube.com/watch?v=...">
                <p class="mt-1 text-sm text-gray-500">Optional video URL related to this news story</p>
            </div>

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

    <script>
    function displayFileName(input) {
        const fileNameElement = document.getElementById('file-name');
        if (input.files && input.files[0]) {
            fileNameElement.textContent = 'Selected: ' + input.files[0].name;
            fileNameElement.classList.remove('hidden');
        } else {
            fileNameElement.classList.add('hidden');
        }
    }
    </script>
</x-app-layout>