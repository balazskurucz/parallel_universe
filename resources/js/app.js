import './bootstrap';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

import Alpine from 'alpinejs';

// Make Quill available globally
window.Quill = Quill;

// Alpine.js WYSIWYG component
Alpine.data('wysiwyg', (initialValue = '') => ({
    content: initialValue,
    editor: null,
    showMediaModal: false,
    mediaItems: [],
    savedRange: null,
    
    init() {
        this.$nextTick(() => {
            this.editor = new Quill(this.$refs.editor, {
                theme: 'snow',
                placeholder: 'Start typing...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        ['link', 'image'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['clean']
                    ]
                }
            });
            
            // Set initial content
            if (this.content) {
                this.editor.root.innerHTML = this.content;
            }
            
            // Update hidden input when content changes
            this.editor.on('text-change', () => {
                this.content = this.editor.root.innerHTML;
                this.$refs.hiddenInput.value = this.content;
            });

            // Handle image button click
            const toolbar = this.editor.getModule('toolbar');
            toolbar.addHandler('image', () => {
                this.openMediaModal();
            });
        });
    },

    async openMediaModal() {
        // Save current cursor position - check if editor is ready
        if (this.editor && this.editor.root && this.editor.root.parentNode) {
            try {
                this.savedRange = this.editor.getSelection() || { index: 0, length: 0 };
            } catch (error) {
                console.warn('Could not get editor selection:', error);
                this.savedRange = { index: 0, length: 0 };
            }
        } else {
            this.savedRange = { index: 0, length: 0 };
        }
        
        try {
            const response = await fetch('/admin/media/api');
            this.mediaItems = await response.json();
            this.showMediaModal = true;
        } catch (error) {
            console.error('Failed to load media items:', error);
        }
    },

    insertImage(mediaItem) {
        const imageUrl = `/media/${mediaItem.id}/400x300`;
        
        // Close modal first
        this.showMediaModal = false;
        
        // Wait for modal to close and then insert image
        this.$nextTick(() => {
            // Check if editor is properly initialized and mounted
            if (!this.editor || !this.editor.root || !this.editor.root.parentNode) {
                console.error('Editor is not properly initialized');
                return;
            }
            
            // Wait a bit more to ensure the modal transition is complete
            setTimeout(() => {
                try {
                    // Ensure editor is ready by checking if it has content container
                    if (!this.editor.container || !this.editor.container.querySelector('.ql-editor')) {
                        console.error('Editor container not ready');
                        return;
                    }
                    
                    // Get the current length first to ensure editor is responsive
                    const editorLength = this.editor.getLength();
                    
                    // Determine insertion point
                    let insertIndex = editorLength - 1; // Default to end (before final newline)
                    
                    // Try to use saved range if available and valid
                    if (this.savedRange && this.savedRange.index >= 0 && this.savedRange.index <= editorLength) {
                        insertIndex = this.savedRange.index;
                    }
                    
                    // Insert the image
                    this.editor.insertEmbed(insertIndex, 'image', imageUrl);
                    
                    // Set alt text if available
                    if (mediaItem.alt_text) {
                        // Wait a moment for the image to be inserted
                        setTimeout(() => {
                            const img = this.editor.root.querySelector(`img[src="${imageUrl}"]`);
                            if (img) {
                                img.alt = mediaItem.alt_text;
                            }
                        }, 100);
                    }
                    
                    // Try to focus and set cursor after the image
                    try {
                        this.editor.setSelection(insertIndex + 1, 0);
                    } catch (selectionError) {
                        console.warn('Could not set selection after image insertion:', selectionError);
                    }
                    
                } catch (error) {
                    console.error('Error inserting image:', error);
                    // Simple fallback: just append to the end
                    try {
                        const content = this.editor.root.innerHTML;
                        this.editor.root.innerHTML = content + `<img src="${imageUrl}" alt="${mediaItem.alt_text || ''}" />`;
                        this.content = this.editor.root.innerHTML;
                        this.$refs.hiddenInput.value = this.content;
                    } catch (fallbackError) {
                        console.error('Fallback image insertion failed:', fallbackError);
                    }
                }
                
                this.savedRange = null; // Clear saved range
            }, 100); // Small delay to ensure modal is fully closed
        });
    }
}));

window.Alpine = Alpine;

Alpine.start();
