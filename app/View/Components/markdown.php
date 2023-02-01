<?php

namespace App\View\Components;

use Illuminate\View\Component;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension;
use League\CommonMark\MarkdownConverter;

class markdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $theme = 'one-dark-pro',
    ) {
        //
    }

    /**
     * Converts Markdown to HTML.
     *
     * @return \League\CommonMark\Output\RenderedContentInterface
     *
     * @throws \RuntimeException
     */
    public function toHtml(string $markdown)
    {
        $markdownConverter = new MarkdownConverter($this->env($this->theme));

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
            ->addExtension(new Extension\CommonMark\CommonMarkCoreExtension)
            ->addExtension(new \ElGigi\CommonMarkEmoji\EmojiExtension)
            ->addExtension(new \Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension($theme))
            ->addExtension(new Extension\GithubFlavoredMarkdownExtension);

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
