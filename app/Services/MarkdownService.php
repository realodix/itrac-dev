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

class MarkdownService
{
    /**
     * Converts Markdown to HTML.
     *
     * @return \League\CommonMark\Output\RenderedContentInterface
     *
     * @throws \RuntimeException
     */
    public function handle(string $markdown)
    {
        $markdownConverter = new MarkdownConverter($this->env());

        return $markdownConverter->convert($markdown);
    }

    /**
     * Returns the environment.
     *
     * @return \League\CommonMark\Environment\Environment
     */
    private function env()
    {
        $environment = new Environment;
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addRenderer(FencedCode::class, new FencedCodeRenderer);
        $environment->addRenderer(IndentedCode::class, new IndentedCodeRenderer);
        $environment->addExtension(new GithubFlavoredMarkdownExtension);

        return $environment;
    }
}
