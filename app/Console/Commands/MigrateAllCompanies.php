<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class MigrateAllCompanies extends Command
{
    protected $signature = 'companies:migrate';
    protected $description = 'Run migrations for all company databases';

    public function handle()
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            $databaseName = 'hrms_' . strtolower(str_replace('-', '_', $company->code));
            $this->info("Migrating: {$databaseName}");

            Config::set('database.connections.company.database', $databaseName);
            Config::set('database.default', 'company');

            DB::purge('company');
            DB::connection('company')->reconnect();

            Artisan::call('migrate:fresh', ['--force' => true]);
        }

        $this->info('All company databases migrated successfully!');
    }
}