<?php

namespace App\View\Components;

use Illuminate\View\Component;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;

class markdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Converts Markdown to HTML.
     *
     * @return \League\CommonMark\Output\RenderedContentInterface
     *
     * @throws \RuntimeException
     */
    public function toHtml(string $markdown, string $theme = 'one-dark-pro')
    {
        $markdownConverter = new MarkdownConverter($this->env($theme));

        return $markdownConverter->convert($markdown);
    }

    /**
     * Returns the environment.
     *
     * @return \League\CommonMark\Environment\Environment
     */
    private function env(string $theme)
    {
        $environment = app(Environment::class)
            ->addExtension(new CommonMarkCoreExtension)
            ->addExtension(new HighlightCodeExtension($theme))
            ->addExtension(new GithubFlavoredMarkdownExtension);

        return $environment;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.markdown');
    }
}
