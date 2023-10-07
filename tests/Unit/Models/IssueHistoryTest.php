<?php

namespace Tests\Unit\Models;

use App\Models\Issue;
use App\Models\IssueHistory;
use Tests\TestCase;

class IssueHistoryTest extends TestCase
{
    /**
     * @test
     * @group u-model
     */
    public function belongsToIssue()
    {
        $issue = Issue::factory()
            ->has(IssueHistory::factory(), 'histories')
            ->create();

        $history = $issue->histories->firstOrFail();

        $this->assertTrue($issue->histories()->exists());
        $this->assertEquals($issue->id, $history->issue_id);
        $this->assertEquals(1, $issue->histories->count());
    }
}
