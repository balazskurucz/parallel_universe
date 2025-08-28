@props([
    'name' => 'cover_image_id',
    'value' => null,
    'label' => 'Cover Image',
    'required' => false,
    'mediaFiles' => collect()
])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    @if($mediaFiles->isEmpty())
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No media files available</h3>
            <p class="mt-1 text-sm text-gray-500">Upload some media files to select as cover image.</p>
            <div class="mt-6">
                <a href="{{ route('admin.media.create') }}"
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Upload Media
                </a>
            </div>
        </div>
    @else
        <input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}">

        <div class="space-y-6">
            @php
                $groupedMedia = $mediaFiles->groupBy('folder_name');
            @endphp

            @foreach($groupedMedia as $folderName => $folderMedia)
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                        <h3 class="text-sm font-medium text-gray-900 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                            </svg>
                            {{ $folderName ?: 'Root Folder' }}
                            <span class="ml-2 text-xs text-gray-500">({{ $folderMedia->count() }} files)</span>
                        </h3>
                    </div>

                    <div class="p-4">
                        {{-- We removed the `grid-cols-4` class and added a direct `style` attribute for robustness. --}}
                        <div class="grid gap-4" style="grid-template-columns: repeat(4, minmax(0, 1fr));">
                            @foreach($folderMedia as $media)
                                <div class="media-item cursor-pointer group"
                                     data-media-id="{{ $media->id }}"
                                     data-media-name="{{ $media->file_name }}">
                                    <div class="relative aspect-square border-2 border-gray-200 rounded-lg overflow-hidden hover:border-indigo-300 transition-colors duration-200 group-hover:shadow-md">
                                        @if($media->isImage())
                                            <img src="{{ $media->url }}"
                                                 alt="{{ $media->alt_text ?? $media->file_name }}"
                                                 class="w-full h-full object-cover"
                                                 loading="lazy">
                                        @else
                                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif

                                        <div class="absolute inset-0 bg-indigo-600 bg-opacity-0 flex items-center justify-center transition-all duration-200 media-overlay">
                                            <svg class="w-8 h-8 text-white opacity-0 transition-opacity duration-200 media-check" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <p class="text-xs font-medium text-gray-900 truncate" title="{{ $media->file_name }}">
                                            {{ $media->file_name }}
                                        </p>
                                        @if($media->alt_text)
                                            <p class="text-xs text-gray-500 truncate" title="{{ $media->alt_text }}">
                                                {{ $media->alt_text }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="selected-media-info" class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-md hidden">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-sm text-blue-800">
                    Selected: <span id="selected-media-name" class="font-medium"></span>
                </span>
                <button type="button" id="clear-selection" class="ml-auto text-blue-600 hover:text-blue-800 text-sm">
                    Clear selection
                </button>
            </div>
        </div>

        <p class="mt-2 text-sm text-gray-500">Click on a media file to select it as the cover image.</p>
    @endif
</div>

{{-- The script and style tags remain unchanged --}}
<script>
    // ...
</script>
<style>
    // ...
</style>