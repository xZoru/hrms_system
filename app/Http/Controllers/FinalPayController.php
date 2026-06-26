<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Models\FinalPay;
use App\Services\FinalPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class FinalPayController extends Controller
{
    protected $finalPayService;

    public function __construct(FinalPayService $finalPayService)
    {
        $this->finalPayService = $finalPayService;
    }

    public function index()
    {
        $finalPays = FinalPay::on('mysql')->with(['employee', 'company'])->orderBy('created_at', 'desc')->paginate(15);
        return view('final-pay.index', compact('finalPays'));
    }

    public function create()
    {
        $companies = Company::on('mysql')->get();
        $employees = Employee::on('mysql')->where('is_active', true)->get();
        return view('final-pay.create', compact('companies', 'employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'termination_date' => 'required|date',
            'last_working_day' => 'required|date|after_or_equal:termination_date',
            'reason' => 'nullable|string|max:255',
        ]);

        $finalPay = $this->finalPayService->calculateFinalPay(
            $request->employee_id,
            $request->termination_date,
            $request->last_working_day,
            $request->reason
        );

        return redirect()
            ->route('final-pay.show', $finalPay)
            ->with('success', 'Final Pay calculated successfully!');
    }

    public function show($id)
    {
        $finalPay = FinalPay::on('mysql')->with(['employee', 'company'])->findOrFail($id);
        return view('final-pay.show', compact('finalPay'));
    }

    public function destroy($id)
    {
        $finalPay = FinalPay::on('mysql')->findOrFail($id);
        $finalPay->delete();

        return redirect()
            ->route('final-pay.index')
            ->with('success', 'Final Pay record deleted successfully!');
    }
}