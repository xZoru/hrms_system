<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Employees') }}
            </h2>
            <a href="{{ route('employees.create') }}" 
               class="bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-lg shadow-md hover:shadow-lg transition duration-200"
               style="color: #ffffff !important; background-color: #dc2626 !important; text-decoration: none; display: inline-block;">
                + Add Employee
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

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                            <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300">
                                <tr>
                                    <th class="px-3 py-3">Image</th>
                                    <th class="px-3 py-3">Emp No</th>
                                    <th class="px-3 py-3">Employee Details</th>
                                    <th class="px-3 py-3">Position</th>
                                    <th class="px-3 py-3">Workshift</th>
                                    <th class="px-3 py-3">Department</th>
                                    <th class="px-3 py-3">Status</th>
                                    <th class="px-3 py-3">Fortnightly Rate</th>
                                    <th class="px-3 py-3">Allowance</th>
                                    <th class="px-3 py-3">Default Pay</th>
                                    <th class="px-3 py-3">NASFUND Collect?</th>
                                    <th class="px-3 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($employees as $employee)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <!-- Image -->
                                    <td class="px-3 py-3">
                                        @if($employee->photo)
                                            <img src="{{ asset('storage/' . $employee->photo) }}" 
                                                 class="w-10 h-10 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-500 dark:text-gray-400 border-2 border-dashed border-gray-300 dark:border-gray-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>

                                    <!-- Emp No -->
                                    <td class="px-3 py-3 font-medium text-gray-900 dark:text-white">
                                        {{ $employee->employee_number }}
                                    </td>

                                    <!-- Employee Details -->
                                    <td class="px-3 py-3">
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $employee->full_name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $employee->email ?? 'N/A' }}
                                        </p>
                                    </td>

                                    <!-- Position -->
                                    <td class="px-3 py-3 text-gray-700 dark:text-gray-300">
                                        {{ $employee->position }}
                                    </td>

                                    <!-- Workshift -->
                                    <td class="px-3 py-3 text-gray-700 dark:text-gray-300">
                                        {{ $employee->workshift ?? 'Regular Dayshift' }}
                                    </td>

                                    <!-- Department -->
                                    <td class="px-3 py-3 text-gray-700 dark:text-gray-300">
                                        {{ $employee->department ?? 'N/A' }}
                                    </td>

                                    <!-- Status -->
                                    <td class="px-3 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $employee->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                            {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>

                                    <!-- Fortnightly Rate -->
                                    <td class="px-3 py-3 font-medium text-gray-900 dark:text-white">
                                        K{{ number_format($employee->fortnightly_rate, 2) }}
                                    </td>

                                    <!-- Allowance -->
                                    <td class="px-3 py-3 text-gray-700 dark:text-gray-300">
                                        {{ $employee->allowance ?? 'N/A' }}
                                    </td>

                                    <!-- Default Pay -->
                                    <td class="px-3 py-3 text-gray-700 dark:text-gray-300">
                                        {{ $employee->default_pay ?? 'Bank' }}
                                    </td>

                                    <!-- NASFUND Collect? -->
                                    <td class="px-3 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ ($employee->nasfund_collect ?? 'NO') == 'YES' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-300' }}">
                                            {{ $employee->nasfund_collect ?? 'NO' }}
                                        </span>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-3 py-3 whitespace-nowrap text-center">
                                        <a href="{{ route('employees.show', $employee) }}" 
                                           class="inline-block px-2.5 py-1 text-xs font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                            View
                                        </a>
                                        <a href="{{ route('employees.edit', $employee) }}" 
                                           class="inline-block px-2.5 py-1 text-xs font-medium text-amber-600 dark:text-amber-400 hover:underline">
                                            Edit
                                        </a>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-block px-2.5 py-1 text-xs font-medium text-red-600 dark:text-red-400 hover:underline"
                                                    onclick="return confirm('Are you sure you want to delete this employee?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="12" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No employees found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $employees->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>