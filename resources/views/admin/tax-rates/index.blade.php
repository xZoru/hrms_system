@extends('layouts.app')

@section('content')
<style>
    .tax-rates-container {
        padding: 24px 32px;
        max-width: 1400px;
        margin: 0 auto;
    }
    .tax-rates-container .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .tax-rates-container .stat-card {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 16px 20px;
        box-shadow: 0 1px 3px var(--shadow-color);
    }
    .tax-rates-container .stat-card .stat-label {
        font-size: 12px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 0;
    }
    .tax-rates-container .stat-card .stat-value {
        font-size: 28px;
        font-weight: 700;
        margin: 4px 0 0 0;
    }
    .tax-rates-container .stat-card.border-blue { border-left: 4px solid #667eea; }
    .tax-rates-container .stat-card.border-blue .stat-value { color: #667eea; }
    .tax-rates-container .stat-card.border-green { border-left: 4px solid #28a745; }
    .tax-rates-container .stat-card.border-green .stat-value { color: #28a745; }
    .tax-rates-container .stat-card.border-orange { border-left: 4px solid #fd7e14; }
    .tax-rates-container .stat-card.border-orange .stat-value { color: #fd7e14; }
    .tax-rates-container .stat-card.border-purple { border-left: 4px solid #6f42c1; }
    .tax-rates-container .stat-card.border-purple .stat-value { color: #6f42c1; }

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
    .tax-rates-container .btn-add {
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
    .tax-rates-container .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .tax-rates-container .card {
        background: var(--bg-secondary);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px var(--shadow-color);
        margin-bottom: 24px;
    }
    .tax-rates-container .card-header {
        padding: 14px 24px;
        border-bottom: 2px solid var(--border-color);
        background: var(--bg-primary);
    }
    .tax-rates-container .card-header.gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    .tax-rates-container .card-header.gradient h5 {
        color: #fff !important;
    }
    .tax-rates-container .card-body {
        padding: 20px 24px;
        background: var(--bg-primary);
    }

    .tax-rates-container .table-wrap {
        overflow-x: auto;
    }
    .tax-rates-container .table-wrap table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    .tax-rates-container .table-wrap table thead {
        background: var(--bg-primary);
    }
    .tax-rates-container .table-wrap table thead th {
        padding: 12px 20px;
        text-align: left;
        font-weight: 600;
        color: var(--text-secondary);
        border-bottom: 2px solid var(--border-color);
    }
    .tax-rates-container .table-wrap table thead th.text-center {
        text-align: center;
    }
    .tax-rates-container .table-wrap table tbody tr {
        border-bottom: 1px solid var(--border-color);
    }
    .tax-rates-container .table-wrap table tbody td {
        padding: 12px 20px;
        color: var(--text-secondary);
    }
    .tax-rates-container .table-wrap table tbody td .desc-main {
        font-weight: 600;
        color: var(--text-primary);
    }
    .tax-rates-container .table-wrap table tbody td .desc-sub {
        font-size: 12px;
        color: var(--text-muted);
    }
    .tax-rates-container .table-wrap table tbody td.text-center {
        text-align: center;
    }

    .tax-rates-container .badge-status {
        display: inline-block;
        padding: 4px 16px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 12px;
        color: #fff;
        min-width: 60px;
        text-align: center;
    }
    .tax-rates-container .badge-active {
        background: #28a745;
        padding: 4px 16px;
        border-radius: 20px;
        color: #fff;
        font-size: 12px;
        font-weight: 500;
    }

    .tax-rates-container .card-footer {
        padding: 14px 24px;
        background: var(--bg-primary);
        border-top: 2px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .tax-rates-container .card-footer .footer-text {
        color: var(--text-muted);
        font-size: 13px;
    }
    .tax-rates-container .card-footer .footer-text strong {
        color: var(--text-primary);
    }
    .tax-rates-container .btn-save {
        padding: 8px 28px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }
    .tax-rates-container .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    }

    .tax-rates-container .btn-action {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        margin: 0 2px;
        border: none;
        cursor: pointer;
        background: transparent;
    }
    .tax-rates-container .btn-action.edit { color: #fd7e14; }
    .tax-rates-container .btn-action.edit:hover { color: #e67e22; }
    .tax-rates-container .btn-action.delete { color: #dc3545; }
    .tax-rates-container .btn-action.delete:hover { color: #c82333; }
    .tax-rates-container .btn-action.toggle { color: var(--text-muted); }
    .tax-rates-container .btn-action.toggle:hover { color: var(--text-primary); }

    @media (max-width: 768px) {
        .tax-rates-container { padding: 16px; }
        .tax-rates-container .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .tax-rates-container .form-grid { grid-template-columns: 1fr; }
        .tax-rates-container .card-footer { flex-direction: column; gap: 12px; align-items: stretch; text-align: center; }
    }

    /* Force action icons to show */
    .tax-rates-container .btn-action i {
        display: inline-block !important;
        font-size: 15px !important;
        color: inherit !important;
        opacity: 1 !important;
        visibility: visible !important;
    }
    .tax-rates-container .btn-action {
        opacity: 1 !important;
        visibility: visible !important;
    }
    .tax-rates-container .table-wrap table tbody td:last-child {
        min-width: 120px !important;
        white-space: nowrap !important;
    }
</style>

<div class="tax-rates-container">

    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="margin: 0; font-weight: 700; color: var(--text-primary); font-size: 24px;">Tax Rates</h2>
            <p style="margin: 4px 0 0 0; color: var(--text-muted); font-size: 14px;">Manage tax brackets and rates for payroll calculations</p>
        </div>
        <a href="{{ route('admin.tax-rates.create') }}" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #fff; padding: 10px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4); display: inline-flex; align-items: center;">
            <i class="fas fa-plus me-2"></i>Add New Tax Rate
        </a>
    </div>
    @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card border-blue">
            <p class="stat-label">Total Brackets</p>
            <h3 class="stat-value">{{ $taxRates->count() }}</h3>
        </div>
        <div class="stat-card border-green">
            <p class="stat-label">Active Rates</p>
            <h3 class="stat-value">{{ $taxRates->where('is_active', true)->count() }}</h3>
        </div>
        <div class="stat-card border-orange">
            <p class="stat-label">Highest Rate</p>
            <h3 class="stat-value">{{ $taxRates->max('rate') ?? 0 }}%</h3>
        </div>
        <div class="stat-card border-purple">
            <p class="stat-label">Tax Free Threshold</p>
            <h3 class="stat-value">K{{ number_format($taxRates->first()->tax_free_threshold ?? 0, 2) }}</h3>
        </div>
    </div>

    <!-- Add Salary Ranges -->
    <div class="card">
        <div class="card-header gradient">
            <h5 style="margin: 0; font-weight: 600; color: #fff;">
                <i class="fas fa-plus-circle me-2"></i>Add Salary Ranges with Percentage
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tax-rates.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div>
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" placeholder="e.g., 30% Bracket" required>
                    </div>
                    <div>
                        <label class="form-label">From (K)</label>
                        <input type="number" step="0.01" name="min_income" class="form-control" placeholder="0.01" required>
                    </div>
                    <div>
                        <label class="form-label">To (K)</label>
                        <input type="number" step="0.01" name="max_income" class="form-control" placeholder="769.00" required>
                    </div>
                    <div>
                        <label class="form-label">Percentage</label>
                        <input type="number" step="0.01" name="rate" class="form-control" placeholder="0" required>
                    </div>
                    <div>
                        <button type="submit" class="btn-add">Add</button>
                    </div>
                </div>
                <input type="hidden" name="tax_free_threshold" value="0">
                <input type="hidden" name="effective_date" value="{{ now()->format('Y-m-d') }}">
                <input type="hidden" name="is_active" value="1">
                <input type="hidden" name="is_global" value="1">
            </form>
        </div>
    </div>

    <!-- Tax Table -->
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <h5 style="margin: 0; font-weight: 600; color: var(--text-primary);">
                            <i class="fas fa-table me-2" style="color: #667eea;"></i>Tax Table
                        </h5>
                        <span class="badge-active">
                            <i class="fas fa-circle me-1" style="font-size: 6px;"></i> Active
                        </span>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Salary Ranges</th>
                                    <th class="text-center">Percentage</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $statusColors = ['#6c757d', '#0d6efd', '#0dcaf0', '#fd7e14', '#dc3545'];
                                @endphp

                                @forelse($taxRates as $index => $rate)
                                <tr>
                                    <td>
                                        <div class="desc-main">{{ $rate->description }}</div>
                                    </td>
                                    <td>{{ $rate->effective_date ? $rate->effective_date->format('d/m/Y') : now()->format('d/m/Y') }}</td>
                                    <td>from K{{ number_format($rate->min_income, 2) }} to K{{ number_format($rate->max_income, 2) }}</td>
                                    <td class="text-center">
                                        <span class="badge-status" style="background: {{ $statusColors[$index % count($statusColors)] }};">
                                            {{ $rate->rate }}%
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.tax-rates.edit', $rate) }}" class="btn-action edit" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tax-rates.destroy', $rate) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete" onclick="return confirm('Delete this tax rate?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                                        No tax rates configured yet.
                                        <br>
                                        <a href="{{ route('admin.tax-rates.create') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">Add your first tax rate</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer">
                        <span class="footer-text">
                            Showing <strong>{{ $taxRates->count() }}</strong> tax brackets
                        </span>
                        <button class="btn-save" onclick="window.location.reload()">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </table>
        </div>
        </div>
    </div>

</div>
@endsection