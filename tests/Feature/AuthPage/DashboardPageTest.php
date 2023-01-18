<?php

namespace Tests\Feature\AuthPage;

use Tests\TestCase;

class DashboardPageTest extends TestCase
{
    /**
     * @test
     * @group f-dashboard
     */
    public function dCanAccessPage()
    {
        $response = $this->actingAs($this->admin())
            ->get(route('dashboard'));

        $response->assertOk();
    }
}
