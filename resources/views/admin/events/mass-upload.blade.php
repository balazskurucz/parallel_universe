<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mass Upload Historical Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Mass Upload Historical Events</h1>
            
            <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-800 mb-2">JSON Format Example:</h3>
                <pre class="text-sm text-blue-700 bg-blue-100 p-3 rounded overflow-x-auto"><code>[
  {
    "eventNumber": 1,
    "eventName": "The Great Consolidation Edict",
    "year": "310 BCE",
    "shortDescription": "Following several minor revolts...",
    "longDescription": "After decades of relentless campaigning..."
  }
]</code></pre>
                <p class="text-sm text-blue-600 mt-2">
                    <strong>Note:</strong> Years with "BCE" will be converted to negative values. The eventNumber field is optional.
                </p>
            </div>

            <form action="{{ route('admin.events.mass-upload.process') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label for="parallel_universe_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Universe <span class="text-red-500">*</span>
                    </label>
                    <select name="parallel_universe_id" id="parallel_universe_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black @error('parallel_universe_id') border-red-500 @enderror" 
                            required>
                        <option value="">Choose a universe...</option>
                        @foreach($universes as $universe)
                            <option value="{{ $universe->id }}" {{ old('parallel_universe_id') == $universe->id ? 'selected' : '' }}>
                                {{ $universe->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('parallel_universe_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="json_file" class="block text-sm font-medium text-gray-700 mb-2">
                        JSON File <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="json_file" id="json_file" accept=".json"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('json_file') border-red-500 @enderror"
                           required>
                    @error('json_file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maximum file size: 2MB. Only JSON files are allowed.</p>
                </div>

                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('admin.events.index') }}" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Upload Events
                    </button>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>