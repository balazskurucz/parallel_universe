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
        <form action="{{ route('admin.universes.update', $universe) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Cover Image -->
            @if($universe->coverImage)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Current Cover Image
                    </label>
                    <div class="mb-4">
                        <img src="{{ $universe->coverImage->url }}" 
                             alt="{{ $universe->coverImage->alt_text ?? $universe->name }}" 
                             class="h-32 w-auto object-cover rounded border">
                        <p class="text-sm text-gray-500 mt-1">{{ $universe->coverImage->file_name }}</p>
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
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="e.g., 1000">
                <p class="mt-1 text-sm text-gray-500">The year when this universe diverged from our timeline (optional)</p>
            </div>

            <!-- Short Description -->
            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Short Description <span class="text-red-500">*</span>
                </label>
                <textarea id="short_description" name="short_description" rows="3" required
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                          placeholder="A brief summary of this universe...">{{ old('short_description', $universe->short_description) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">A brief summary of this universe for listings and previews</p>
            </div>

            <!-- Long Description -->
            <div>
                <label for="long_description" class="block text-sm font-medium text-gray-700 mb-2">
                    Long Description <span class="text-red-500">*</span>
                </label>
                <textarea id="long_description" name="long_description" rows="6" required
                          class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                          placeholder="Describe this parallel universe, its key characteristics, and how it differs from our timeline...">{{ old('long_description', $universe->long_description) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">A detailed description of this universe and its unique features</p>
            </div>

            <!-- Cover Image Selection -->
            <x-media-selector 
                name="cover_image_id" 
                :value="old('cover_image_id', $universe->cover_image_id)" 
                label="Cover Image" 
                :media-files="$mediaFiles" />


            <!-- Related Content Summary -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Related Content Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
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
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Note: Deleting this universe will also delete all related content.
                </p>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.universes.show', $universe) }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Update Universe
                </button>
            </div>
        </form>

        <!-- Delete Form (separate from update form) -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <form action="{{ route('admin.universes.destroy', $universe) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                        onclick="return confirm('Are you sure you want to delete this universe? This action cannot be undone and will also delete all related events, news, and media.')">
                    Delete Universe
                </button>
            </form>
        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>