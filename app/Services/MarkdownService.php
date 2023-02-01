<?php

namespace App\Services;

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\CommonMark\Node\Block\FencedCode;
use League\CommonMark\Extension\CommonMark\Node\Block\IndentedCode;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;
use Spatie\CommonMarkHighlighter\FencedCodeRenderer;
use Spatie\CommonMarkHighlighter\IndentedCodeRenderer;
use Spatie\CommonMarkShikiHighlighter\HighlightCodeExtension;

class MarkdownService
{
    /**
     * Converts Markdown to HTML.
     *
     * @return \League\CommonMark\Output\RenderedContentInterface
     *
     * @throws \RuntimeException
     */
    public function handle(string $markdown, string $theme = 'one-dark-pro')
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
}
