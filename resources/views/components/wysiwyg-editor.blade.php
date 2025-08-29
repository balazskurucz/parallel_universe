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
    </div>
    
    @if($helpText)
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $helpText }}</p>
    @endif
    
    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>