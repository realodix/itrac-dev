<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension;
use League\CommonMark\MarkdownConverter;

class Markdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $theme = 'one-dark-pro',
    ) {
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
        $cacheKey = $this->getCacheKey($markdown);

        // If the Markdown is already cached, we'll return it.
        return Cache::store(null)
            ->rememberForever($cacheKey, function () use ($markdown) {
                $markdownConverter = new MarkdownConverter($this->env());

                return $markdownConverter->convert($markdown);
            });
    }

    /**
     * Returns the environment.
     *
     * @return \League\CommonMark\Environment\Environment
     */
    protected function env()
    {
        $environment = app(Environment::class)
            ->addExtension(new Extension\CommonMark\CommonMarkCoreExtension)
            ->addExtension(new Extension\GithubFlavoredMarkdownExtension)
            ->addExtension(new \ElGigi\CommonMarkEmoji\EmojiExtension)
            ->addExtension(new \Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension($this->theme));

        return $environment;
    }

    /**
     * Returns the cache key.
     */
    protected function getCacheKey(string $markdown): string
    {
        $options = json_encode([
            'theme' => $this->theme,
        ]);

        return md5("markdown{$markdown}{$options}");
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.markdown');
    }
}
