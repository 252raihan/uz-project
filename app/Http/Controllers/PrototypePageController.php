<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class PrototypePageController extends Controller
{
    public function home(): View
    {
        return view('prototype.home');
    }

    public function login(): View
    {
        return view('prototype.login');
    }

    public function register(): View
    {
        return view('prototype.register');
    }

    public function citizenDashboard(): View
    {
        return view('prototype.dashboard', [
            'portal' => 'citizen',
        ]);
    }

    public function adminDashboard(): View
    {
        return view('prototype.admin', [
            'portal' => 'admin',
        ]);
    }
}
