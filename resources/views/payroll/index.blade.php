<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Payroll History') }}
            </h2>
            <a href="{{ route('payroll.create') }}" 
   style="background-color: #dc2626; color: #ffffff !important; font-weight: 700; padding: 8px 16px; border-radius: 8px; text-decoration: none; display: inline-block;">
                + Process Payroll
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
                                    <th class="px-4 py-3">#</th>
                                    <th class="px-4 py-3">Fortnight</th>
                                    <th class="px-4 py-3">Period</th>
                                    <th class="px-4 py-3">Employees</th>
                                    <th class="px-4 py-3">Total Gross</th>
                                    <th class="px-4 py-3">Total Net</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($payrolls as $payroll)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-3">{{ $payroll->id }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $payroll->fortnight_number }}</td>
                                    <td class="px-4 py-3">
                                        {{ $payroll->period_start->format('d/m/Y') }} - {{ $payroll->period_end->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-3">{{ $payroll->employee_count }}</td>
                                    <td class="px-4 py-3">K{{ number_format($payroll->total_gross, 2) }}</td>
                                    <td class="px-4 py-3">K{{ number_format($payroll->total_net, 2) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            @if($payroll->status == 'draft') bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-300
                                            @elseif($payroll->status == 'processing') bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300
                                            @elseif($payroll->status == 'completed') bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300
                                            @else bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300 @endif">
                                            {{ $payroll->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('payroll.show', $payroll) }}" class="text-blue-600 hover:text-blue-800 text-sm mr-2">View</a>
                                        @if($payroll->status != 'paid')
                                            <form action="{{ route('payroll.destroy', $payroll) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Delete this payroll record?')">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No payroll records found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $payrolls->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>