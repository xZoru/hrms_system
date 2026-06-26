<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Company;

class SetCompanyDatabase
{
    public function handle(Request $request, Closure $next)
    {
        $companyId = session('company_id');

        // ✅ If no company in session, set a default
        if (!$companyId && auth()->check()) {
            $user = auth()->user();
            if ($user->company_id) {
                $companyId = $user->company_id;
                session(['company_id' => $companyId]);
                Log::info('🔍 Middleware: Set company from user: ' . $companyId);
            } else {
                $firstCompany = Company::first();
                if ($firstCompany) {
                    $companyId = $firstCompany->id;
                    session(['company_id' => $companyId]);
                    Log::info('🔍 Middleware: Set company to first available: ' . $companyId);
                }
            }
        }

        Log::info('🔍 Middleware: Company ID: ' . ($companyId ?? 'NULL'));

        if ($companyId) {
            $company = Company::find($companyId);
            if ($company) {
                $databaseName = 'hrms_' . strtolower(str_replace('-', '_', $company->code));
                
                Config::set('database.connections.mysql.database', $databaseName);
                Config::set('database.default', 'mysql');
                
                DB::purge('mysql');
                DB::connection('mysql')->reconnect();

                Log::info('✅ Middleware: Switched to: ' . DB::connection('mysql')->getDatabaseName());
            }
        }

        return $next($request);
    }
}