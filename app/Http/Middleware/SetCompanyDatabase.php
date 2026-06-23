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