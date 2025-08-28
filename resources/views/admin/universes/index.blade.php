<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parallel Universes Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div></div>
                        <a href="{{ route('admin.universes.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create New Universe
                        </a>
                    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cover Image
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Divergence Point
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Divergence Year
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Description
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($universes as $universe)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($universe->cover_image_path)
                                <img src="{{ asset('storage/' . $universe->cover_image_path) }}" 
                                     alt="{{ $universe->name }}" 
                                     class="h-16 w-16 object-cover rounded">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $universe->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ Str::limit($universe->divergence_point, 50) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $universe->divergence_year ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ Str::limit($universe->description, 100) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.universes.show', $universe) }}" 
                               class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('admin.universes.edit', $universe) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('admin.universes.destroy', $universe) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this universe?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No parallel universes found. <a href="{{ route('admin.universes.create') }}" class="text-blue-600 hover:text-blue-800">Create your first universe</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>