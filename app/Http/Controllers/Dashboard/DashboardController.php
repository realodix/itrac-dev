<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct(
        public User $user,
    ) {
    }

    /**
     * Show all user short URLs.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        return view('sections.admin.dashboard');
    }
}
