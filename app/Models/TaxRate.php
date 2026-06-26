<?php
// app/Models/TaxRate.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    protected $fillable = [
        'description',
        'annual_description',
        'company_id',
        'min_income',
        'max_income',
        'rate',
        'fixed_tax',
        'tax_free_threshold',
        'effective_date',
        'is_active',
        'is_global'
    ];

    protected $casts = [
        'min_income' => 'decimal:2',
        'max_income' => 'decimal:2',
        'rate' => 'decimal:2',
        'fixed_tax' => 'decimal:2',
        'tax_free_threshold' => 'decimal:2',
        'is_active' => 'boolean',
        'is_global' => 'boolean',
        'effective_date' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getRangeDisplayAttribute()
    {
        if ($this->max_income === null) {
            return 'from K' . number_format($this->min_income, 2) . ' and Above';
        }
        return 'from K' . number_format($this->min_income, 2) . ' to K' . number_format($this->max_income, 2);
    }

    public function getAnnualRangeDisplayAttribute()
    {
        $annualRanges = [
            ['min' => 0, 'max' => 20000, 'label' => 'Does not exceed K20,000.00'],
            ['min' => 20000, 'max' => 33000, 'label' => 'Exceeds K20,001.00 but does not exceed K33,000.00'],
            ['min' => 33000, 'max' => 70000, 'label' => 'Exceeds K33,001.00 but does not exceed K70,000.00'],
            ['min' => 70000, 'max' => 250000, 'label' => 'Exceeds K70,001.00 but does not exceed K250,000.00'],
            ['min' => 250000, 'max' => null, 'label' => 'Exceeds K250,000.01'],
        ];

        foreach ($annualRanges as $range) {
            if ($this->min_income >= $range['min'] && ($range['max'] === null || $this->min_income <= $range['max'])) {
                return $range['label'];
            }
        }

        return $this->description;
    }
}