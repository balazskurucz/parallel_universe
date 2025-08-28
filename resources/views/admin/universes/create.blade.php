<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Parallel Universe') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div></div>
                        <a href="{{ route('admin.universes.index') }}" 
                           class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Universes List
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
        <form action="{{ route('admin.universes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Universe Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Universe Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="e.g., Viking Vinland Universe">
                <p class="mt-1 text-sm text-gray-500">A descriptive name for this parallel universe</p>
            </div>

            <!-- Divergence Point -->
            <div>
                <label for="divergence_point" class="block text-sm font-medium text-gray-700 mb-2">
                    Divergence Point <span class="text-red-500">*</span>
                </label>
                <input type="text" id="divergence_point" name="divergence_point" value="{{ old('divergence_point') }}" required
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-gray-900"
                       placeholder="e.g., Vikings successfully colonize North America in 1000 AD">
                <p class="mt-1 text-sm text-gray-500">The key historical event that created this alternate timeline</p>
            </div>

            <!-- Divergence Year -->
            <div>
                <label for="divergence_year" class="block text-sm font-medium text-gray-700 mb-2">
                    Divergence Year
                </label>
                <input type="number" id="divergence_year" name="divergence_year" value="{{ old('divergence_year') }}"
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
                          placeholder="Describe this parallel universe, its key characteristics, and how it differs from our timeline...">{{ old('description') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">A detailed description of this universe and its unique features</p>
            </div>

            <!-- Cover Image Upload -->
            <div>
                <label for="cover_image" class="block text-sm font-medium text-gray-700 mb-2">
                    Cover Image
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="cover_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload a cover image</span>
                                <input id="cover_image" name="cover_image" type="file" class="sr-only" 
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

            <!-- Submit Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.universes.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create Universe
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