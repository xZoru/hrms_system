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
        $employees = Employee::with(['company', 'classification'])
            ->where('is_active', true)
            ->paginate(10);
        
        return view('employees.index', compact('employees'));
    }


    public function create()
    {
        $companies = Company::where('is_active', true)->get();
        $classifications = EmployeeClassification::where('is_active', true)->get();
        
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
            'date_of_birth' => 'required|date',
            'joining_date' => 'required|date',
            'base_salary' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
            'nasfund_number' => 'nullable|string|max:100',
            'payment_method' => 'required|in:bank_transfer,cash',
            'is_active' => 'boolean',
        ]);


        $validated['is_active'] = $request->has('is_active');
        

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('employee-photos', 'public');
            $validated['photo'] = $path;
        }

        $employee = Employee::create($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee created successfully!');
    }


    public function show(Employee $employee)
{
    // Load ONLY the relationships that work
    $employee->load(['company', 'classification']);
    
    // Try to load others - but catch errors
    try {
        $employee->load('bankAccounts');
    } catch (\Exception $e) {
        // Bank accounts not working yet
    }
    
    try {
        $employee->load('documents');
    } catch (\Exception $e) {
        // Documents not working yet
    }
    
    try {
        $employee->load('leaveRecords');
    } catch (\Exception $e) {
        // Leave records not working yet
    }
    
    return view('employees.show', compact('employee'));
}

    public function edit(Employee $employee)
    {
        $companies = Company::where('is_active', true)->get();
        $classifications = EmployeeClassification::where('is_active', true)->get();
        
        return view('employees.edit', compact('employee', 'companies', 'classifications'));
    }



    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_number' => 'required|unique:employees,employee_number,' . $employee->id,
            'company_id' => 'required|exists:companies,id',
            'classification_id' => 'required|exists:employee_classifications,id',
            'full_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other',
            'department' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'joining_date' => 'required|date',
            'base_salary' => 'nullable|numeric|min:0',
            'hourly_rate' => 'nullable|numeric|min:0',
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

        $employee->update($validated);

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee updated successfully!');
    }


 
    public function destroy(Employee $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully!');
    }
}