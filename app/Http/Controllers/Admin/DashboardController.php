<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    function index() 
    {
        $checkouts = Checkout::with('Camp')->get();
        return view('admin.dashboard', [
            'checkouts' => $checkouts
        ]);
    }
}
