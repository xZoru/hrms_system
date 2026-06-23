<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::on('mysql')->with('company')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function edit($id)
    {
        $user = User::on('mysql')->findOrFail($id);
        $companies = Company::on('mysql')->get(); // ✅ USE get() NOT all()
        $allCompanyIds = $companies->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'companies', 'allCompanyIds'));
    }

    public function update(Request $request, $id)
    {
        $user = User::on('mysql')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:super_admin,admin,hr_manager,payroll_officer,employee',
            'company_id' => 'nullable|exists:companies,id',
            'allowed_companies' => 'nullable|array',
            'allowed_companies.*' => 'exists:companies,id',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $validated['allowed_companies'] = $request->allowed_companies ?? [];

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $user = User::on('mysql')->findOrFail($id);

        if ($user->isSuperAdmin() && User::where('role', 'super_admin')->count() <= 1) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Cannot delete the last Super Admin!');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }
}