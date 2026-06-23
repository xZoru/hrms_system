<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Company;

class CompanySwitchController extends Controller
{
    /**
     * Switch to a different company.
     */
    public function switch(Request $request): RedirectResponse
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
        ]);

        $company = Company::findOrFail($request->company_id);

        if (!auth()->user()->canAccessCompany($company->id)) {
            abort(403, 'You do not have access to this company.');
        }

        session(['company_id' => $company->id]);
        session(['company_code' => $company->code]);
        session()->save();

        $databaseName = 'hrms_' . strtolower(str_replace('-', '_', $company->code));
        Config::set('database.connections.mysql.database', $databaseName);
        Config::set('database.default', 'mysql');
        DB::purge('mysql');
        DB::connection('mysql')->reconnect();

        return redirect()->back()->with('success', 'Switched to ' . $company->name);
    }
}