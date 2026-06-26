@extends('layouts.app')

@section('content')
<style>
    .tax-rates-container {
        padding: 24px 32px;
        max-width: 1400px;
        margin: 0 auto;
    }
    .tax-rates-container .card {
        background: var(--bg-secondary);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px var(--shadow-color);
        margin-bottom: 24px;
    }
    .tax-rates-container .card-header.gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 14px 24px;
        border: none;
    }
    .tax-rates-container .card-header.gradient h5 {
        color: #fff !important;
        margin: 0;
        font-weight: 600;
    }
    .tax-rates-container .card-body {
        padding: 20px 24px;
        background: var(--bg-primary);
    }
    .tax-rates-container .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr 0.6fr;
        gap: 12px;
        align-items: end;
    }
    .tax-rates-container .form-grid .form-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-secondary);
        margin-bottom: 4px;
    }
    .tax-rates-container .form-grid .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-secondary);
        color: var(--text-primary);
        font-size: 14px;
    }
    .tax-rates-container .form-grid .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    }
    .tax-rates-container .btn-update {
        width: 100%;
        padding: 10px 0;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }
    .tax-rates-container .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    .tax-rates-container .btn-back {
        padding: 8px 20px;
        background: var(--bg-secondary);
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    .tax-rates-container .btn-back:hover {
        background: var(--bg-hover);
    }
    @media (max-width: 768px) {
        .tax-rates-container { padding: 16px; }
        .tax-rates-container .form-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="tax-rates-container">

    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="margin: 0; font-weight: 700; color: var(--text-primary); font-size: 24px;">Edit Tax Rate</h2>
            <p style="margin: 4px 0 0 0; color: var(--text-muted); font-size: 14px;">Update tax bracket details</p>
        </div>
        <a href="{{ route('admin.tax-rates.index') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-header gradient">
            <h5><i class="fas fa-edit me-2"></i>Edit Salary Range</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tax-rates.update', $taxRate) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-grid">
                    <div>
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description', $taxRate->description) }}" required>
                    </div>
                    <div>
                        <label class="form-label">From (K)</label>
                        <input type="number" step="0.01" name="min_income" class="form-control" value="{{ old('min_income', $taxRate->min_income) }}" required>
                    </div>
                    <div>
                        <label class="form-label">To (K)</label>
                        <input type="number" step="0.01" name="max_income" class="form-control" value="{{ old('max_income', $taxRate->max_income) }}">
                    </div>
                    <div>
                        <label class="form-label">Fixed Tax (K)</label>
                        <input type="number" step="0.01" name="fixed_tax" class="form-control" value="{{ old('fixed_tax', $taxRate->fixed_tax) }}">
                    </div>
                    <div>
                        <label class="form-label">Percentage</label>
                        <input type="number" step="0.01" name="rate" class="form-control" value="{{ old('rate', $taxRate->rate) }}" required>
                    </div>
                    <div>
                        <button type="submit" class="btn-update">Update</button>
                    </div>
                </div>
                <input type="hidden" name="tax_free_threshold" value="{{ $taxRate->tax_free_threshold }}">
                <input type="hidden" name="effective_date" value="{{ $taxRate->effective_date ? $taxRate->effective_date->format('Y-m-d') : now()->format('Y-m-d') }}">
                <input type="hidden" name="is_active" value="{{ $taxRate->is_active ? 1 : 0 }}">
                <input type="hidden" name="is_global" value="{{ $taxRate->is_global ? 1 : 0 }}">
            </form>
        </div>
    </div>

</div>
@endsection