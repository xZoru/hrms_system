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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Company</p>
                            <p class="font-semibold">{{ $payroll->company->name }}</p>
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

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-3">Employee</th>
                                    <th class="px-4 py-3">Regular</th>
                                    <th class="px-4 py-3">Overtime</th>
                                    <th class="px-4 py-3">Gross</th>
                                    <th class="px-4 py-3">Tax</th>
                                    <th class="px-4 py-3">NASFUND</th>
                                    <th class="px-4 py-3">Net</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @foreach($payroll->items as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-3 font-medium">{{ $item->employee->full_name }}</td>
                                    <td class="px-4 py-3">K{{ number_format($item->regular_pay, 2) }}</td>
                                    <td class="px-4 py-3">K{{ number_format($item->overtime_pay, 2) }}</td>
                                    <td class="px-4 py-3">K{{ number_format($item->gross_pay, 2) }}</td>
                                    <td class="px-4 py-3">K{{ number_format($item->tax, 2) }}</td>
                                    <td class="px-4 py-3">K{{ number_format($item->nasfund_ee, 2) }}</td>
                                    <td class="px-4 py-3 font-bold">K{{ number_format($item->net_pay, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 dark:bg-gray-700 font-bold">
                                <tr>
                                    <td class="px-4 py-3">TOTAL</td>
                                    <td class="px-4 py-3"></td>
                                    <td class="px-4 py-3"></td>
                                    <td class="px-4 py-3">K{{ number_format($payroll->total_gross, 2) }}</td>
                                    <td class="px-4 py-3">K{{ number_format($payroll->total_tax, 2) }}</td>
                                    <td class="px-4 py-3">K{{ number_format($payroll->total_nasfund_ee, 2) }}</td>
                                    <td class="px-4 py-3">K{{ number_format($payroll->total_net, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>