<?php

namespace App\Services;

use League\CommonMark\CommonMarkConverter;

class MarkdownService
{
    public function __construct(
        public CommonMarkConverter $converter
    ) {
    }

    /**
     * @return \League\CommonMark\Output\RenderedContentInterface
     */
    public function handle(string $markdown)
    {
        return $this->converter->convert($markdown);
    }
}
