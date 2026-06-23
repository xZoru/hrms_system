<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Models\EmployeeClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index()
    {
        $this->switchDatabase();

        $employees = Employee::with(['company', 'classification'])->paginate(10);

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        $this->switchDatabase();

        $companies = Company::where('is_active', true)->get();
        $classifications = EmployeeClassification::where('is_active', true)->get();

        return view('employees.create', compact('companies', 'classifications'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $this->switchDatabase();

        $validated = $request->validate([
            'employee_number' => 'required|unique:employees',
            'company_id' => 'required|exists:companies,id',
            'classification_id' => 'required|exists:employee_classifications,id',
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'department' => 'nullable|string|max:255',
            'workshift' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'joining_date' => 'required|date',
            'base_salary' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'allowance' => 'nullable|string|max:255',
            'default_pay' => 'nullable|string|max:255',
            'nasfund_collect' => 'nullable|string|max:10',
            'nasfund_number' => 'nullable|string|max:100',
            'payment_method' => 'required|in:bank_transfer,cash',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employee-photos', 'public');
            $validated['photo'] = $path;
        }

        Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully!');
    }

    /**
     * Display the specified employee.
     */
    public function show($id)
    {
        $this->switchDatabase();

        $employee = Employee::with(['company', 'classification'])->findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit($id)
    {
        $this->switchDatabase();

        $employee = Employee::findOrFail($id);
        $companies = Company::where('is_active', true)->get();
        $classifications = EmployeeClassification::where('is_active', true)->get();

        return view('employees.edit', compact('employee', 'companies', 'classifications'));
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, $id)
    {
        $this->switchDatabase();

        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'employee_number' => 'required|unique:employees,employee_number,' . $id,
            'company_id' => 'required|exists:companies,id',
            'classification_id' => 'required|exists:employee_classifications,id',
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'department' => 'nullable|string|max:255',
            'workshift' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'joining_date' => 'required|date',
            'base_salary' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'allowance' => 'nullable|string|max:255',
            'default_pay' => 'nullable|string|max:255',
            'nasfund_collect' => 'nullable|string|max:10',
            'nasfund_number' => 'nullable|string|max:100',
            'payment_method' => 'required|in:bank_transfer,cash',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $path = $request->file('photo')->store('employee-photos', 'public');
            $validated['photo'] = $path;
        }

        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
                $validated['photo'] = null;
            }
        }

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy($id)
    {
        $this->switchDatabase();

        $employee = Employee::findOrFail($id);

        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }

    /**
     * Switch to the current company's database.
     */
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