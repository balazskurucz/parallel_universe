<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Media Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div class="flex items-center space-x-4">
                            <div>
                                <label for="folder-filter" class="block text-sm font-medium text-gray-700 mb-1">Filter by Folder:</label>
                                <select id="folder-filter" onchange="filterByFolder()" 
                                        class="block w-48 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">All Folders</option>
                                    @foreach($folders as $folder)
                                        <option value="{{ $folder }}">{{ $folder }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <a href="{{ route('admin.media.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Upload New Media
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
                        Preview
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        File Info
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Folder
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Type
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Size
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($media as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->isImage())
                                <img src="{{ $item->url }}" alt="{{ $item->alt_text }}" 
                                     class="h-16 w-16 object-cover rounded">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->file_name }}</div>
                            @if($item->alt_text)
                                <div class="text-sm text-gray-500">Alt: {{ $item->alt_text }}</div>
                            @endif
                            @if($item->description)
                                <div class="text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $item->folder_name ?: 'general' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                         {{ $item->isImage() ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($item->file_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ number_format($item->file_size / 1024, 1) }} KB
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ $item->url }}" target="_blank" 
                               class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <form action="{{ route('admin.media.destroy', $item) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this media file?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No media files found. <a href="{{ route('admin.media.create') }}" class="text-blue-600 hover:text-blue-800">Upload your first media file</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($media->hasPages())
        <div class="mt-6">
            {{ $media->links() }}
        </div>
    @endif
</div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function filterByFolder() {
        const filterValue = document.getElementById('folder-filter').value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            if (row.querySelector('td[colspan]')) {
                // Skip empty state row
                return;
            }
            
            const folderCell = row.cells[2]; // Folder is the 3rd column (index 2)
            if (folderCell) {
                const folderName = folderCell.textContent.trim().toLowerCase();
                
                if (filterValue === '' || folderName === filterValue) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }
    </script>
</x-app-layout>