<?php

namespace Tests\Unit\Helpers;

use App\Helpers\Helper;
use Tests\TestCase;

class HelperTest extends TestCase
{
    /**
     * @test
     * @group u-helper
     * @dataProvider toAmountShortProvider
     *
     * @param mixed $expected
     * @param mixed $actual
     */
    public function compactNumber($expected, $actual): void
    {
        $this->assertSame($expected, Helper::compactNumber($actual));
    }

        public static function toAmountShortProvider(): array
        {
            return [
                ['12', 12],
                ['12', 12.3],

                ['1K', pow(10, 3)],
                ['10K', pow(10, 4)],
                ['100K', pow(10, 5)],
                ['12.34K+', 12345],

                ['1M', pow(10, 6)],
                ['10M', pow(10, 7)],
                ['100M', pow(10, 8)],
                ['99.99M+', 99997092],

                ['1B', pow(10, 9)],
                ['10B', pow(10, 10)],
                ['100B', pow(10, 11)],
                ['1.23B+', 1234567890],

                ['1T', pow(10, 12)],
                ['10T', pow(10, 13)],
                ['100T', pow(10, 14)],
                ['1.23T+', 1234567890000],
            ];
        }
}
