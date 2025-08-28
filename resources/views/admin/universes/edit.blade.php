<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Universe: ') . $universe->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div></div>
                        <div class="space-x-3">
                            <a href="{{ route('admin.universes.show', $universe) }}" 
                               class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                View Universe
                            </a>
                            <a href="{{ route('admin.universes.index') }}" 
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
        <form action="{{ route('admin.universes.update', $universe) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Cover Image -->
            @if($universe->cover_image_path)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Current Cover Image
                    </label>
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $universe->cover_image_path) }}" 
                             alt="{{ $universe->name }}" 
                             class="h-32 w-auto object-cover rounded border">
                    </div>
                </div>
            @endif

            <!-- Universe Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Universe Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name', $universe->name) }}" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="e.g., Viking Vinland Universe">
                <p class="mt-1 text-sm text-gray-500">A descriptive name for this parallel universe</p>
            </div>

            <!-- Divergence Point -->
            <div>
                <label for="divergence_point" class="block text-sm font-medium text-gray-700 mb-2">
                    Divergence Point <span class="text-red-500">*</span>
                </label>
                <input type="text" id="divergence_point" name="divergence_point" value="{{ old('divergence_point', $universe->divergence_point) }}" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="e.g., Vikings successfully colonize North America in 1000 AD">
                <p class="mt-1 text-sm text-gray-500">The key historical event that created this alternate timeline</p>
            </div>

            <!-- Divergence Year -->
            <div>
                <label for="divergence_year" class="block text-sm font-medium text-gray-700 mb-2">
                    Divergence Year
                </label>
                <input type="number" id="divergence_year" name="divergence_year" value="{{ old('divergence_year', $universe->divergence_year) }}"
                       min="1" max="{{ date('Y') + 1000 }}"
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="e.g., 1000">
                <p class="mt-1 text-sm text-gray-500">The year when this universe diverged from our timeline (optional)</p>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description" name="description" rows="4" required
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                          placeholder="Describe this parallel universe, its key characteristics, and how it differs from our timeline...">{{ old('description', $universe->description) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">A detailed description of this universe and its unique features</p>
            </div>

            <!-- Cover Image Upload -->
            <div>
                <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ $universe->cover_image_path ? 'Replace Cover Image' : 'Cover Image' }}
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>{{ $universe->cover_image_path ? 'Upload new image' : 'Upload a cover image' }}</span>
                                <input id="cover_image" name="cover_image" type="file" class="sr-only" 
                                       accept="image/*" onchange="displayFileName(this)">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            PNG, JPG, GIF up to 2MB
                            @if($universe->cover_image_path)
                                <br><span class="text-orange-600">Leave empty to keep current image</span>
                            @endif
                        </p>
                        <p id="file-name" class="text-sm text-gray-900 font-medium hidden"></p>
                    </div>
                </div>
            </div>

            <!-- Related Content Summary -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Related Content Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-700">
                            {{ $universe->historicalEvents->count() }} Historical Events
                        </span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        <span class="text-gray-700">
                            {{ $universe->newsBroadcasts->count() }} News Broadcasts
                        </span>
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="text-gray-700">
                            {{ $universe->media->count() }} Media Files
                        </span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Note: Deleting this universe will also delete all related content.
                </p>
            </div>

            <!-- Submit Button -->
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

                <div class="flex space-x-3">
                    <a href="{{ route('admin.universes.show', $universe) }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Update Universe
                    </button>
                </div>
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