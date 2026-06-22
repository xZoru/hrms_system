<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = session('company_id') ? \App\Models\Company::find(session('company_id')) : null;
        
        return view('dashboard', compact('user', 'company'));
    }
}