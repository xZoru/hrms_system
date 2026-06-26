<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Company;
use App\Models\Employee;
use App\Services\PayrollService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayrollController extends Controller
{
    protected $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    public function index()
    {
        $payrolls = Payroll::on('mysql')->with('company')->orderBy('created_at', 'desc')->paginate(15);
        return view('payroll.index', compact('payrolls'));
    }

    public function create()
    {
        $companies = Company::on('mysql')->get();
        $employees = Employee::on('mysql')->where('is_active', true)->get();
        
        $departments = Employee::on('mysql')->where('is_active', true)->distinct()->pluck('department')->filter()->values();
        $positions = Employee::on('mysql')->where('is_active', true)->distinct()->pluck('position')->filter()->values();
        
        $fortnights = $this->generateFortnights();
        
        return view('payroll.create', compact('companies', 'employees', 'departments', 'positions', 'fortnights'));
    }

    private function generateFortnights()
    {
        return [
            ['code' => 'FN2601', 'start' => '25-Dec', 'end' => '07-Jan', 'start_date' => '2025-12-25', 'end_date' => '2026-01-07'],
            ['code' => 'FN2602', 'start' => '08-Jan', 'end' => '21-Jan', 'start_date' => '2026-01-08', 'end_date' => '2026-01-21'],
            ['code' => 'FN2603', 'start' => '22-Jan', 'end' => '04-Feb', 'start_date' => '2026-01-22', 'end_date' => '2026-02-04'],
            ['code' => 'FN2604', 'start' => '05-Feb', 'end' => '18-Feb', 'start_date' => '2026-02-05', 'end_date' => '2026-02-18'],
            ['code' => 'FN2605', 'start' => '19-Feb', 'end' => '04-Mar', 'start_date' => '2026-02-19', 'end_date' => '2026-03-04'],
            ['code' => 'FN2606', 'start' => '05-Mar', 'end' => '18-Mar', 'start_date' => '2026-03-05', 'end_date' => '2026-03-18'],
            ['code' => 'FN2607', 'start' => '19-Mar', 'end' => '01-Apr', 'start_date' => '2026-03-19', 'end_date' => '2026-04-01'],
            ['code' => 'FN2608', 'start' => '02-Apr', 'end' => '15-Apr', 'start_date' => '2026-04-02', 'end_date' => '2026-04-15'],
            ['code' => 'FN2609', 'start' => '16-Apr', 'end' => '29-Apr', 'start_date' => '2026-04-16', 'end_date' => '2026-04-29'],
            ['code' => 'FN2610', 'start' => '30-Apr', 'end' => '13-May', 'start_date' => '2026-04-30', 'end_date' => '2026-05-13'],
            ['code' => 'FN2611', 'start' => '14-May', 'end' => '27-May', 'start_date' => '2026-05-14', 'end_date' => '2026-05-27'],
            ['code' => 'FN2612', 'start' => '28-May', 'end' => '10-Jun', 'start_date' => '2026-05-28', 'end_date' => '2026-06-10'],
            ['code' => 'FN2613', 'start' => '11-Jun', 'end' => '24-Jun', 'start_date' => '2026-06-11', 'end_date' => '2026-06-24'],
            ['code' => 'FN2614', 'start' => '25-Jun', 'end' => '08-Jul', 'start_date' => '2026-06-25', 'end_date' => '2026-07-08'],
            ['code' => 'FN2615', 'start' => '09-Jul', 'end' => '22-Jul', 'start_date' => '2026-07-09', 'end_date' => '2026-07-22'],
            ['code' => 'FN2616', 'start' => '23-Jul', 'end' => '05-Aug', 'start_date' => '2026-07-23', 'end_date' => '2026-08-05'],
            ['code' => 'FN2617', 'start' => '06-Aug', 'end' => '19-Aug', 'start_date' => '2026-08-06', 'end_date' => '2026-08-19'],
            ['code' => 'FN2618', 'start' => '20-Aug', 'end' => '02-Sep', 'start_date' => '2026-08-20', 'end_date' => '2026-09-02'],
            ['code' => 'FN2619', 'start' => '03-Sep', 'end' => '16-Sep', 'start_date' => '2026-09-03', 'end_date' => '2026-09-16'],
            ['code' => 'FN2620', 'start' => '17-Sep', 'end' => '30-Sep', 'start_date' => '2026-09-17', 'end_date' => '2026-09-30'],
            ['code' => 'FN2621', 'start' => '01-Oct', 'end' => '14-Oct', 'start_date' => '2026-10-01', 'end_date' => '2026-10-14'],
            ['code' => 'FN2622', 'start' => '15-Oct', 'end' => '28-Oct', 'start_date' => '2026-10-15', 'end_date' => '2026-10-28'],
            ['code' => 'FN2623', 'start' => '29-Oct', 'end' => '11-Nov', 'start_date' => '2026-10-29', 'end_date' => '2026-11-11'],
            ['code' => 'FN2624', 'start' => '12-Nov', 'end' => '25-Nov', 'start_date' => '2026-11-12', 'end_date' => '2026-11-25'],
            ['code' => 'FN2625', 'start' => '26-Nov', 'end' => '09-Dec', 'start_date' => '2026-11-26', 'end_date' => '2026-12-09'],
            ['code' => 'FN2626', 'start' => '10-Dec', 'end' => '23-Dec', 'start_date' => '2026-10-26', 'end_date' => '2026-12-23'],
        ];
    }

    public function store(Request $request)
    {
        try {
            \Log::info('===== PAYROLL STORE STARTED =====');
            \Log::info('Company ID: ' . $request->company_id);
            \Log::info('Period Start: ' . $request->period_start);
            \Log::info('Period End: ' . $request->period_end);

            $request->validate([
                'company_id' => 'required|exists:companies,id',
                'period_start' => 'required|date',
                'period_end' => 'required|date|after:period_start',
            ]);

            $periodStart = Carbon::parse($request->period_start);
            $periodEnd = Carbon::parse($request->period_end);

            $selectedEmployees = $request->selected_employees 
                ? explode(',', $request->selected_employees) 
                : [];

            \Log::info('Selected employees: ' . count($selectedEmployees));

            $payroll = $this->payrollService->processPayroll(
                $request->company_id,
                $periodStart,
                $periodEnd,
                $selectedEmployees
            );

            return redirect()
                ->route('payroll.show', $payroll)
                ->with('success', 'Payroll processed successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            \Log::error('Payroll error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return redirect()
                ->back()
                ->with('error', 'Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $payroll = Payroll::on('mysql')->with(['items.employee', 'company'])->findOrFail($id);
        return view('payroll.show', compact('payroll'));
    }

    public function destroy($id)
    {
        $payroll = Payroll::on('mysql')->findOrFail($id);

        if ($payroll->status === 'paid') {
            return redirect()
                ->route('payroll.index')
                ->with('error', 'Cannot delete a paid payroll!');
        }

        $payroll->items()->delete();
        $payroll->delete();

        return redirect()
            ->route('payroll.index')
            ->with('success', 'Payroll deleted successfully!');
    }

    private function switchDatabase()
    {
        \Log::info('===== SWITCH DATABASE =====');
        
        $companyId = session('company_id');
        \Log::info('Company ID from session: ' . ($companyId ?? 'NULL'));
        
        if (!$companyId) {
            \Log::error('No company ID in session!');
            return;
        }
        
        $company = Company::find($companyId);
        if (!$company) {
            \Log::error('Company not found for ID: ' . $companyId);
            return;
        }
        
        $databaseName = 'hrms_' . strtolower(str_replace('-', '_', $company->code));
        \Log::info('Switching to database: ' . $databaseName);
        
        Config::set('database.connections.mysql.database', $databaseName);
        Config::set('database.default', 'mysql');
        DB::purge('mysql');
        DB::connection('mysql')->reconnect();
        
        \Log::info('Switched to: ' . DB::connection('mysql')->getDatabaseName());
    }
}