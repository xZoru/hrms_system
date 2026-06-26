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
        margin-bottom: 12px;
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
    .tax-rates-container .btn-add-row {
        padding: 10px 24px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        display: inline-flex;
        align-items: center;
    }
    .tax-rates-container .btn-add-row:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }
    .tax-rates-container .btn-remove-row {
        padding: 8px 12px;
        background: #dc3545;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }
    .tax-rates-container .btn-remove-row:hover {
        background: #c82333;
    }
    .tax-rates-container .btn-save-table {
        padding: 10px 32px;
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        display: inline-flex;
        align-items: center;
    }
    .tax-rates-container .btn-save-table:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
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
    .tax-rates-container .row-item {
        background: var(--bg-secondary);
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 12px;
        border: 1px solid var(--border-color);
    }
    .tax-rates-container .row-item .form-grid {
        margin-bottom: 0;
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
            <h2 style="margin: 0; font-weight: 700; color: var(--text-primary); font-size: 24px;">New Tax Table</h2>
            <p style="margin: 4px 0 0 0; color: var(--text-muted); font-size: 14px;">Add multiple tax brackets at once</p>
        </div>
        <a href="{{ route('admin.tax-rates.index') }}" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i>Back to Table
        </a>
    </div>

    <!-- Form -->
    <div class="card">
        <div class="card-header gradient">
            <h5><i class="fas fa-plus-circle me-2"></i>Add Salary Ranges with Percentage</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tax-rates.store-multiple') }}" method="POST" id="taxForm">
                @csrf

                <div id="rowsContainer">
                    <!-- Row 1 (Default) -->
                    <div class="row-item" data-row="1">
                        <div class="form-grid">
                            <div>
                                <label class="form-label">Description</label>
                                <input type="text" name="rows[0][description]" class="form-control" placeholder="e.g., 30% Bracket" required>
                            </div>
                            <div>
                                <label class="form-label">From (K)</label>
                                <input type="number" step="0.01" name="rows[0][min_income]" class="form-control" placeholder="0.01" required>
                            </div>
                            <div>
                                <label class="form-label">To (K)</label>
                                <input type="number" step="0.01" name="rows[0][max_income]" class="form-control" placeholder="769.00" required>
                            </div>
                            <div>
                                <label class="form-label">Percentage</label>
                                <input type="number" step="0.01" name="rows[0][rate]" class="form-control" placeholder="0" required>
                            </div>
                            <div style="display: flex; align-items: end; gap: 8px;">
                                <button type="button" class="btn-remove-row" onclick="removeRow(this)" style="display: none;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 16px;">
                    <button type="button" class="btn-add-row" onclick="addRow()">
                        <i class="fas fa-plus me-2"></i>Add Another Tax Bracket
                    </button>
                    <button type="submit" class="btn-save-table">
                        <i class="fas fa-save me-2"></i>Save Table
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    let rowCount = 1;

    function addRow() {
        const container = document.getElementById('rowsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'row-item';
        newRow.dataset.row = rowCount + 1;

        newRow.innerHTML = `
            <div class="form-grid">
                <div>
                    <label class="form-label">Description</label>
                    <input type="text" name="rows[${rowCount}][description]" class="form-control" placeholder="e.g., 30% Bracket" required>
                </div>
                <div>
                    <label class="form-label">From (K)</label>
                    <input type="number" step="0.01" name="rows[${rowCount}][min_income]" class="form-control" placeholder="0.01" required>
                </div>
                <div>
                    <label class="form-label">To (K)</label>
                    <input type="number" step="0.01" name="rows[${rowCount}][max_income]" class="form-control" placeholder="769.00" required>
                </div>
                <div>
                    <label class="form-label">Percentage</label>
                    <input type="number" step="0.01" name="rows[${rowCount}][rate]" class="form-control" placeholder="0" required>
                </div>
                <div style="display: flex; align-items: end; gap: 8px;">
                    <button type="button" class="btn-remove-row" onclick="removeRow(this)" style="display: inline-block;">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(newRow);
        rowCount++;
    }

    function removeRow(button) {
        const row = button.closest('.row-item');
        const container = document.getElementById('rowsContainer');

        // Don't remove if it's the last row
        if (container.children.length <= 1) {
            alert('You must have at least one tax bracket.');
            return;
        }

        if (confirm('Remove this tax bracket?')) {
            row.remove();
        }
    }
</script>

@endsection