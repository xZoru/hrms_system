<?php
// app/Http/Controllers/Admin/TaxRateController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    public function index()
    {
        $taxRates = TaxRate::where('is_active', true)
            ->orderBy('min_income')
            ->get();

        return view('admin.tax-rates.index', compact('taxRates'));
    }

    public function create()
    {
        return view('admin.tax-rates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:255',
            'min_income' => 'required|numeric|min:0',
            'max_income' => 'nullable|numeric|gt:min_income',
            'rate' => 'required|numeric|min:0|max:100',
            'fixed_tax' => 'nullable|numeric|min:0',
            'tax_free_threshold' => 'nullable|numeric|min:0',
            'effective_date' => 'nullable|date',
            'is_active' => 'boolean',
            'is_global' => 'boolean',
        ]);

        $taxRate = TaxRate::create([
            'description' => $request->description,
            'company_id' => $request->company_id ?? null,
            'min_income' => $request->min_income,
            'max_income' => $request->max_income,
            'rate' => $request->rate,
            'fixed_tax' => $request->fixed_tax ?? 0,
            'tax_free_threshold' => $request->tax_free_threshold ?? 0,
            'effective_date' => $request->effective_date ?? now(),
            'is_active' => $request->has('is_active'),
            'is_global' => $request->has('is_global'),
        ]);

        return redirect()->route('admin.tax-rates.index')
            ->with('success', 'Tax rate created successfully!');
    }

    public function edit(TaxRate $taxRate)
    {
        return view('admin.tax-rates.edit', compact('taxRate'));
    }

    public function update(Request $request, TaxRate $taxRate)
    {
        $request->validate([
            'description' => 'nullable|string|max:255',
            'min_income' => 'required|numeric|min:0',
            'max_income' => 'nullable|numeric|gt:min_income',
            'rate' => 'required|numeric|min:0|max:100',
            'fixed_tax' => 'nullable|numeric|min:0',
            'tax_free_threshold' => 'nullable|numeric|min:0',
            'effective_date' => 'nullable|date',
            'is_active' => 'boolean',
            'is_global' => 'boolean',
        ]);

        $taxRate->update([
            'description' => $request->description,
            'company_id' => $request->company_id ?? null,
            'min_income' => $request->min_income,
            'max_income' => $request->max_income,
            'rate' => $request->rate,
            'fixed_tax' => $request->fixed_tax ?? 0,
            'tax_free_threshold' => $request->tax_free_threshold ?? 0,
            'effective_date' => $request->effective_date ?? now(),
            'is_active' => $request->has('is_active'),
            'is_global' => $request->has('is_global'),
        ]);

        return redirect()->route('admin.tax-rates.index')
            ->with('success', 'Tax rate updated successfully!');
    }

    public function destroy(TaxRate $taxRate)
    {
        $taxRate->delete();
        return redirect()->route('admin.tax-rates.index')
            ->with('success', 'Tax rate deleted successfully!');
    }

    public function toggleActive(TaxRate $taxRate)
    {
        $taxRate->update(['is_active' => !$taxRate->is_active]);
        return redirect()->route('admin.tax-rates.index')
            ->with('success', 'Tax rate status updated!');
    }

    public function storeMultiple(Request $request)
{
    $request->validate([
        'rows' => 'required|array|min:1',
        'rows.*.description' => 'nullable|string|max:255',
        'rows.*.min_income' => 'required|numeric|min:0',
        'rows.*.max_income' => 'nullable|numeric|gt:rows.*.min_income',
        'rows.*.rate' => 'required|numeric|min:0|max:100',
    ]);

    $savedCount = 0;

    foreach ($request->rows as $rowData) {
        TaxRate::create([
            'description' => $rowData['description'],
            'company_id' => null,
            'min_income' => $rowData['min_income'],
            'max_income' => $rowData['max_income'] ?? null,
            'rate' => $rowData['rate'],
            'fixed_tax' => 0,
            'tax_free_threshold' => 0,
            'effective_date' => now(),
            'is_active' => true,
            'is_global' => true,
        ]);
        $savedCount++;
    }

    return redirect()->route('admin.tax-rates.index')
        ->with('success', $savedCount . ' tax bracket(s) created successfully!');
}
}