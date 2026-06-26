<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Company;
use App\Models\EmployeeClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        $companyId = session('company_id');
        $employees = Employee::on('mysql')
            ->where('company_id', $companyId)
            ->with(['company', 'classification'])
            ->paginate(10);

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $companies = Company::on('mysql')->where('is_active', true)->get();
        $classifications = EmployeeClassification::on('mysql')->where('is_active', true)->get();
        return view('employees.create', compact('companies', 'classifications'));
    }

    public function store(Request $request)
    {
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
            'monthly_rate' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:bank_transfer,cash',
            'is_active' => 'boolean',
            'pay_raise' => 'nullable|numeric|min:0',
            'pay_raise_date' => 'nullable|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employee-photos', 'public');
            $validated['photo'] = $path;
        }

        $employee = Employee::on('mysql')->create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully!');
    }

    public function show($id)
    {
        $employee = Employee::on('mysql')->with(['company', 'classification'])->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function edit($id)
    {
        $employee = Employee::on('mysql')->findOrFail($id);
        $companies = Company::on('mysql')->where('is_active', true)->get();
        $classifications = EmployeeClassification::on('mysql')->where('is_active', true)->get();
        return view('employees.edit', compact('employee', 'companies', 'classifications'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::on('mysql')->findOrFail($id);

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
            'monthly_rate' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:bank_transfer,cash',
            'is_active' => 'boolean',
            'pay_raise' => 'nullable|numeric|min:0',
            'pay_raise_date' => 'nullable|date',
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

    public function destroy($id)
    {
        $employee = Employee::on('mysql')->findOrFail($id);

        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}