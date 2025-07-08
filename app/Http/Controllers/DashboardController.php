<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //
        $user = session()->get('auth_user');
        if ($user['role'] == 'organisateur') {
            return view('pages.backend.dashboard.organisateur', compact('user'));
        } else {
            return view('pages.backend.dashboard.client', compact('user'));
        }
    }
}
