<div>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div x-data="wysiwyg('{{ old($name, $value) }}')" class="space-y-2">
        <!-- Quill Editor Container -->
        <div x-ref="editor" 
             class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md min-h-[150px] focus-within:ring-2 focus-within:ring-indigo-500 focus-within:border-indigo-500">
        </div>
        
        <!-- Hidden Input for Form Submission -->
        <input type="hidden" 
               name="{{ $name }}" 
               x-ref="hiddenInput" 
               :value="content"
               @if($required) required @endif>

        <!-- Media Selection Modal -->
        <div x-show="showMediaModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showMediaModal = false"></div>

                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4">
                                    Select Image from Media Library
                                </h3>
                                
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 max-h-96 overflow-y-auto">
                                    <template x-for="item in mediaItems" :key="item.id">
                                        <div class="cursor-pointer border-2 border-transparent hover:border-blue-500 rounded-lg p-2 transition-colors"
                                             @click="insertImage(item)">
                                            <img :src="`/media/${item.id}/150x150`" 
                                                 :alt="item.alt_text || item.file_name"
                                                 class="w-full h-20 object-cover rounded">
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 truncate" x-text="item.file_name"></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500 truncate" x-text="item.folder_name || 'general'"></p>
                                        </div>
                                    </template>
                                </div>
                                
                                <div x-show="mediaItems.length === 0" class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    No images found in media library.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" 
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 dark:hover:bg-gray-500"
                                @click="showMediaModal = false">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif
    
    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>