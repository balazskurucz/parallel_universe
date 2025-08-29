<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('News Broadcasts Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div></div>
                        <a href="{{ route('admin.news.create') }}" 
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create New News Broadcast
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
                        Image
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Headline
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Broadcast Date
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Parallel Universe
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Short Description
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($news as $newsItem)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($newsItem->coverImage)
                                <img src="{{ $newsItem->coverImage->url }}" 
                                     alt="{{ $newsItem->coverImage->alt_text ?? $newsItem->headline }}" 
                                     class="h-16 w-16 object-cover rounded">
                            @else
                                <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $newsItem->headline }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($newsItem->broadcast_date)->format('M d, Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                {{ $newsItem->parallelUniverse ? $newsItem->parallelUniverse->name : 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ Str::limit($newsItem->short_description, 100) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.news.show', $newsItem) }}" 
                               class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('admin.news.edit', $newsItem) }}" 
                               class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                            <form action="{{ route('admin.news.destroy', $newsItem) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Are you sure you want to delete this news broadcast?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No news broadcasts found. <a href="{{ route('admin.news.create') }}" class="text-blue-600 hover:text-blue-800">Create your first news broadcast</a>.
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