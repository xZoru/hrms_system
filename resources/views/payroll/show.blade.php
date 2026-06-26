<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Payroll') }} #{{ $payroll->fortnight_number }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('payroll.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Company</p>
                            <p class="font-semibold">{{ $payroll->company->name ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Fortnight</p>
                            <p class="font-semibold">{{ $payroll->fortnight_number }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Period</p>
                            <p class="font-semibold">{{ $payroll->period_start->format('d/m/Y') }} - {{ $payroll->period_end->format('d/m/Y') }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Status</p>
                            <p class="font-semibold capitalize">{{ $payroll->status }}</p>
                        </div>
                    </div>

                    <!-- Totals -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total Gross</p>
                            <p class="font-bold text-lg">K{{ number_format($payroll->total_gross, 2) }}</p>
                        </div>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total Tax</p>
                            <p class="font-bold text-lg">K{{ number_format($payroll->total_tax, 2) }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Total Net</p>
                            <p class="font-bold text-lg">K{{ number_format($payroll->total_net, 2) }}</p>
                        </div>
                        <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Employees</p>
                            <p class="font-bold text-lg">{{ $payroll->employee_count }}</p>
                        </div>
                    </div>

                    <!-- Full Width Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Emp. No.</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Employee Name</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">FN Rate</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Basic Pay</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Regular</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Overtime</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Sunday OT</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Holiday OT</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Leave Pay</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Other</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Gross Total</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">FN Tax</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">NPF (%)</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">NCSL</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Cash Adv.</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Others</th>
                                    <th class="px-3 py-2 border-b border-gray-200 dark:border-gray-600 whitespace-nowrap">Net Pay</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($payroll->items as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $item->employee->employee_number }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap font-medium">{{ $item->employee->full_name }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->fn_rate, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->basic_pay, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->regular_pay, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->overtime_pay, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->sunday_pay, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->holiday_pay, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->leave_pay ?? 0, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->other_allowances ?? 0, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap font-bold">K{{ number_format($item->gross_pay, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->tax, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $item->npf_percent ?? 6.00 }}%</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->ncsl ?? 0, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->cash_advance ?? 0, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap">K{{ number_format($item->other_deductions ?? 0, 2) }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap font-bold text-green-600 dark:text-green-400">K{{ number_format($item->net_pay, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-700 font-bold">
                                <tr>
                                    <td colspan="10" class="px-3 py-2 text-right">TOTAL</td>
                                    <td class="px-3 py-2">K{{ number_format($payroll->total_gross, 2) }}</td>
                                    <td class="px-3 py-2">K{{ number_format($payroll->total_tax, 2) }}</td>
                                    <td class="px-3 py-2"></td>
                                    <td class="px-3 py-2">K{{ number_format($payroll->total_nasfund_ee, 2) }}</td>
                                    <td class="px-3 py-2"></td>
                                    <td class="px-3 py-2"></td>
                                    <td class="px-3 py-2">K{{ number_format($payroll->total_net, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>