<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Company;
use App\Services\PayrollService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class PayrollController extends Controller
{
    protected $payrollService;

    public function __construct(PayrollService $payrollService)
    {
        $this->payrollService = $payrollService;
    }

    public function index()
    {
        $this->switchDatabase();
        $payrolls = Payroll::with('company')->orderBy('created_at', 'desc')->paginate(15);
        return view('payroll.index', compact('payrolls'));
    }

    public function create()
    {
        $this->switchDatabase();
        $companies = Company::all();
        return view('payroll.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $this->switchDatabase();

        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
        ]);

        $periodStart = Carbon::parse($request->period_start);
        $periodEnd = Carbon::parse($request->period_end);

        $payroll = $this->payrollService->processPayroll(
            $request->company_id,
            $periodStart,
            $periodEnd
        );

        return redirect()
            ->route('payroll.show', $payroll)
            ->with('success', 'Payroll processed successfully!');
    }

    public function show($id)
    {
        $this->switchDatabase();
        $payroll = Payroll::with(['items.employee', 'company'])->findOrFail($id);
        return view('payroll.show', compact('payroll'));
    }

    public function destroy($id)
    {
        $this->switchDatabase();
        $payroll = Payroll::findOrFail($id);

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
        $companyId = session('company_id');
        if ($companyId) {
            $company = Company::find($companyId);
            if ($company) {
                $databaseName = 'hrms_' . strtolower(str_replace('-', '_', $company->code));
                Config::set('database.connections.mysql.database', $databaseName);
                Config::set('database.default', 'mysql');
                DB::purge('mysql');
                DB::connection('mysql')->reconnect();
            }
        }
    }
}