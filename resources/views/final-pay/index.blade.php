<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Final Pay Records') }}
            </h2>
            <a href="{{ route('final-pay.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition">
                + Calculate Final Pay
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    @if(session('success'))
                        <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 px-4 py-3 rounded-lg bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300">
                                <tr>
                                    <th class="px-4 py-3">Employee</th>
                                    <th class="px-4 py-3">Company</th>
                                    <th class="px-4 py-3">Termination Date</th>
                                    <th class="px-4 py-3">Gross Total</th>
                                    <th class="px-4 py-3">Net Total</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($finalPays as $finalPay)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-3 font-medium">{{ $finalPay->employee->full_name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $finalPay->company->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">{{ $finalPay->termination_date->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3">K{{ number_format($finalPay->gross_total, 2) }}</td>
                                    <td class="px-4 py-3 font-bold text-green-600 dark:text-green-400">K{{ number_format($finalPay->net_total, 2) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            @if($finalPay->status == 'draft') bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-300
                                            @elseif($finalPay->status == 'completed') bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300
                                            @else bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 @endif">
                                            {{ ucfirst($finalPay->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('final-pay.show', $finalPay) }}" class="text-blue-600 hover:text-blue-800 text-sm mr-2">View</a>
                                        <form action="{{ route('final-pay.destroy', $finalPay) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Delete this record?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No final pay records found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $finalPays->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>