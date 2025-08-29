<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class WysiwygEditor extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $name,
        public ?string $value = null,
        public ?string $label = null,
        public ?string $placeholder = null,
        public bool $required = false,
        public ?string $helpText = null,
        public ?string $id = null
    ) {
        $this->id = $id ?? $name;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.wysiwyg-editor');
    }
}
