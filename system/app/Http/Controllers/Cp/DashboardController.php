<?php

namespace App\Http\Controllers\Cp;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('cp.index');
    }
}
