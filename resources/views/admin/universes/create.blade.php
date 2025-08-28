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

            <!-- Cover Image Selection -->
            <x-media-selector 
                name="cover_image_id" 
                :value="old('cover_image_id')" 
                label="Cover Image" 
                :media-files="$mediaFiles" />

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

</x-app-layout>