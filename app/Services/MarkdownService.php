<?php

namespace App\Services;

use League\CommonMark\GithubFlavoredMarkdownConverter;

class MarkdownService
{
    public function __construct(
        public GithubFlavoredMarkdownConverter $converter
    ) {
    }

    /**
     * Converts Markdown to HTML.
     *
     * @return \League\CommonMark\Output\RenderedContentInterface
     *
     * @throws \RuntimeException
     */
    public function handle(string $markdown)
    {
        return $this->converter->convert($markdown);
    }
}
