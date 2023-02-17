<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Easymde extends Component
{
    public string $name;

    public string $id;

    public array $options;

    public function __construct(string $name, string $id = null, array $options = [])
    {
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->options = $options;
    }

    public function options(): array
    {
        return array_merge([
            'forceSync'    => true,
            'spellChecker' => false,
            'minHeight'    => '150px',
            'toolbar' => [
                'bold', 'italic', 'heading',
                '|', 'code', 'quote', 'unordered-list', 'ordered-list',
                '|', 'link', 'image',
                '|', 'preview', 'side-by-side', 'fullscreen',
                '|', 'guide',
            ],
        ], $this->options);
    }

    public function jsonOptions(): string
    {
        if (empty($this->options())) {
            return '';
        }

        return ', ...'.json_encode((object) $this->options());
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('components.easymde');
    }
}
