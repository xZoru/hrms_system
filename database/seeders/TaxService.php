<?php
// app/Services/TaxService.php

namespace App\Services;

use App\Models\TaxRate;

class TaxService
{
    /**
     * Calculate tax based on FN RATE
     */
    public function calculateTax($employee, $grossPay)
    {
        $taxRates = TaxRate::where('is_active', true)
            ->where(function ($query) use ($employee) {
                $query->where('company_id', $employee->company_id)
                    ->orWhere('is_global', true);
            })
            ->orderBy('min_income')
            ->get();

        if ($taxRates->isEmpty()) {
            return $this->getDefaultTax($grossPay);
        }

        $tax = 0;
        foreach ($taxRates as $rate) {
            if ($grossPay > $rate->min_income && ($rate->max_income === null || $grossPay <= $rate->max_income)) {
                if ($grossPay > $rate->tax_free_threshold) {
                    $tax = ($grossPay - $rate->tax_free_threshold) * ($rate->rate / 100);
                } else {
                    $tax = 0;
                }
                break;
            }
        }

        return max(0, round($tax, 2));
    }

    /**
     * Get all active tax rates
     */
    public function getActiveTaxRates($companyId = null)
    {
        $query = TaxRate::where('is_active', true);

        if ($companyId) {
            $query->where(function ($q) use ($companyId) {
                $q->where('company_id', $companyId)
                  ->orWhere('is_global', true);
            });
        }

        return $query->orderBy('min_income')->get();
    }

    /**
     * Default tax table (fallback)
     */
    private function getDefaultTax($grossPay)
    {
        if ($grossPay <= 769) return 0;
        if ($grossPay <= 1269) return round(($grossPay - 769) * 0.30, 2);
        if ($grossPay <= 2692) return round(($grossPay - 769) * 0.35, 2);
        if ($grossPay <= 9615) return round(($grossPay - 769) * 0.40, 2);
        return round(($grossPay - 769) * 0.42, 2);
    }
}