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
    
    init() {
        this.$nextTick(() => {
            this.editor = new Quill(this.$refs.editor, {
                theme: 'snow',
                placeholder: 'Start typing...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        ['link'],
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
        });
    }
}));

window.Alpine = Alpine;

Alpine.start();
