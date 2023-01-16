<?php

namespace Tests\Feature\AuthPage;

use App\Models\Url;
use Tests\TestCase;
use Vinkla\Hashids\Facades\Hashids;

class DashboardPageTest extends TestCase
{
    protected function hashIdRoute($routeName, $url_id)
    {
        $hashids = Hashids::connection(Url::class);

        return route($routeName, $hashids->encode($url_id));
    }

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
