<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Final Pay Details') }}
            </h2>
            <a href="{{ route('final-pay.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Employee</p>
                            <p class="font-semibold text-lg">{{ $finalPay->employee->full_name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $finalPay->employee->employee_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Company</p>
                            <p class="font-semibold text-lg">{{ $finalPay->company->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Termination Date</p>
                            <p class="font-semibold">{{ $finalPay->termination_date->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Last Working Day</p>
                            <p class="font-semibold">{{ $finalPay->last_working_day->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Reason</p>
                            <p class="font-semibold">{{ $finalPay->reason ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                            <p class="font-semibold capitalize">{{ $finalPay->status }}</p>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Final Pay Breakdown</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Outstanding Salary</p>
                                <p class="font-semibold text-lg">K{{ number_format($finalPay->outstanding_salary, 2) }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Accrued Leave Pay</p>
                                <p class="font-semibold text-lg">K{{ number_format($finalPay->accrued_leave_pay, 2) }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Notice Pay</p>
                                <p class="font-semibold text-lg">K{{ number_format($finalPay->notice_pay, 2) }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Severance Pay</p>
                                <p class="font-semibold text-lg">K{{ number_format($finalPay->severance_pay, 2) }}</p>
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Gross Total</p>
                                    <p class="font-bold text-lg text-blue-600 dark:text-blue-400">K{{ number_format($finalPay->gross_total, 2) }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Net Total</p>
                                    <p class="font-bold text-lg text-green-600 dark:text-green-400">K{{ number_format($finalPay->net_total, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Deductions</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Tax</p>
                                <p class="font-semibold text-lg text-red-600 dark:text-red-400">K{{ number_format($finalPay->tax, 2) }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400">NASFUND</p>
                                <p class="font-semibold text-lg">K{{ number_format($finalPay->nasfund, 2) }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-xs text-gray-500 dark:text-gray-400">Outstanding Loans</p>
                                <p class="font-semibold text-lg">K{{ number_format($finalPay->outstanding_loans, 2) }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>