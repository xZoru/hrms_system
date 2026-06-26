<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Process Payroll') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if(session('error'))
                        <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form id="payroll-form" action="{{ route('payroll.store') }}" method="POST">
                        @csrf

                        <!-- Company & Fortnight Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Fortnight</label>
                                <select name="fortnight" id="fortnight-select" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Select Fortnight</option>
                                    @foreach($fortnights as $fortnight)
                                        <option value="{{ $fortnight['code'] }}" 
                                            data-start="{{ $fortnight['start_date'] }}" 
                                            data-end="{{ $fortnight['end_date'] }}">
                                            {{ $fortnight['code'] }} -- {{ $fortnight['start'] }} - {{ $fortnight['end'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                                <select name="company_id" id="company-select" required 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <input type="hidden" name="period_start" id="period_start" value="">
                        <input type="hidden" name="period_end" id="period_end" value="">

                        <!-- Filters -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Department</label>
                                <select id="filter-department" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">All Departments</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter by Position</label>
                                <select id="filter-position" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">All Positions</option>
                                </select>
                            </div>
                            <div class="flex items-end justify-end space-x-2">
                                <button type="button" id="reset-filters" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition">
                                    Reset Table
                                </button>
                            </div>
                        </div>

                        <!-- Employees Table -->
                        <div class="overflow-x-auto mt-4">
                            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">
                                            <input type="checkbox" id="select-all" class="rounded border-gray-300 dark:border-gray-600 text-red-600">
                                        </th>
                                        <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Emp No</th>
                                        <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Employee Name</th>
                                        <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Attendance Count</th>
                                        <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Department</th>
                                        <th class="px-4 py-3 border-b border-gray-200 dark:border-gray-600">Position</th>
                                    </tr>
                                </thead>
                                <tbody id="employee-table-body" class="divide-y divide-gray-200 dark:divide-gray-600">
                                    @forelse($employees as $employee)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition employee-row" 
                                        data-company="{{ $employee->company_id }}"
                                        data-department="{{ $employee->department ?? '' }}"
                                        data-position="{{ $employee->position ?? '' }}">
                                        <td class="px-4 py-3">
                                            <input type="checkbox" name="employee_ids[]" value="{{ $employee->id }}" 
                                                class="employee-checkbox rounded border-gray-300 dark:border-gray-600 text-red-600">
                                        </td>
                                        <td class="px-4 py-3 font-medium">{{ $employee->employee_number }}</td>
                                        <td class="px-4 py-3">{{ $employee->full_name }}</td>
                                        <td class="px-4 py-3">0 day</td>
                                        <td class="px-4 py-3">{{ $employee->department ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">{{ $employee->position ?? 'N/A' }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">No active employees found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="selected_employees" id="selected-employees" value="">

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" id="cancel-btn" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition">
                                Cancel
                            </button>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition">
                                Payrun
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fortnightSelect = document.getElementById('fortnight-select');
            const periodStart = document.getElementById('period_start');
            const periodEnd = document.getElementById('period_end');

            // Fortnight selection
            if (fortnightSelect) {
                fortnightSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    if (selectedOption && selectedOption.value) {
                        periodStart.value = selectedOption.dataset.start || '';
                        periodEnd.value = selectedOption.dataset.end || '';
                    } else {
                        periodStart.value = '';
                        periodEnd.value = '';
                    }
                });
            }

            // ===== COMPANY FILTER =====
            const companySelect = document.getElementById('company-select');
            const filterDept = document.getElementById('filter-department');
            const filterPos = document.getElementById('filter-position');
            const rows = document.querySelectorAll('.employee-row');
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.employee-checkbox');

            // Function to update department and position filters based on company
            function updateFilterOptions() {
                const companyId = companySelect.value;
                
                const depts = new Set();
                const positions = new Set();
                
                rows.forEach(row => {
                    const rowCompany = row.dataset.company || '';
                    if (!companyId || rowCompany === companyId) {
                        const dept = row.dataset.department || '';
                        const pos = row.dataset.position || '';
                        if (dept) depts.add(dept);
                        if (pos) positions.add(pos);
                    }
                });

                filterDept.innerHTML = '<option value="">All Departments</option>';
                depts.forEach(dept => {
                    filterDept.innerHTML += `<option value="${dept}">${dept}</option>`;
                });

                filterPos.innerHTML = '<option value="">All Positions</option>';
                positions.forEach(pos => {
                    filterPos.innerHTML += `<option value="${pos}">${pos}</option>`;
                });
            }

            // Function to filter table
            function filterTable() {
                const companyId = companySelect.value;
                const dept = filterDept.value || '';
                const pos = filterPos.value || '';

                rows.forEach(row => {
                    const rowCompany = row.dataset.company || '';
                    const rowDept = row.dataset.department || '';
                    const rowPos = row.dataset.position || '';
                    
                    const companyMatch = !companyId || rowCompany === companyId;
                    const deptMatch = !dept || rowDept === dept;
                    const posMatch = !pos || rowPos === pos;
                    
                    row.style.display = (companyMatch && deptMatch && posMatch) ? '' : 'none';
                });

                if (selectAll) selectAll.checked = false;
            }

            // Function to reset everything
            function resetAll() {
                if (companySelect) companySelect.value = '';
                if (filterDept) filterDept.value = '';
                if (filterPos) filterPos.value = '';
                if (fortnightSelect) fortnightSelect.value = '';
                if (periodStart) periodStart.value = '';
                if (periodEnd) periodEnd.value = '';
                
                checkboxes.forEach(cb => cb.checked = false);
                if (selectAll) selectAll.checked = false;
                
                updateFilterOptions();
                rows.forEach(row => row.style.display = '');
            }

            // Event listeners
            companySelect?.addEventListener('change', function() {
                updateFilterOptions();
                filterTable();
            });

            filterDept?.addEventListener('change', filterTable);
            filterPos?.addEventListener('change', filterTable);

            document.getElementById('reset-filters')?.addEventListener('click', resetAll);

            selectAll?.addEventListener('change', function() {
                checkboxes.forEach(cb => {
                    const row = cb.closest('.employee-row');
                    if (row && row.style.display !== 'none') {
                        cb.checked = this.checked;
                    }
                });
            });

            document.getElementById('cancel-btn')?.addEventListener('click', function() {
                window.location.href = '{{ route("payroll.index") }}';
            });

            document.getElementById('payroll-form')?.addEventListener('submit', function(e) {
                const selected = [];
                document.querySelectorAll('.employee-checkbox:checked').forEach(cb => {
                    selected.push(cb.value);
                });
                document.getElementById('selected-employees').value = selected.join(',');
            });

            updateFilterOptions();
        });
    </script>
</x-app-layout>