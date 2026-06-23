
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Employee Overview
            </h2>
            <div class="space-x-2">
                <a href="{{ route('employees.edit', $employee) }}" 
                   class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                    Edit
                </a>
                <a href="{{ route('employees.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <!-- Employee Header -->
                    <div class="flex items-start space-x-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex-shrink-0">
                            @if($employee->photo)
                                <img src="{{ asset('storage/' . $employee->photo) }}" 
                                     class="w-24 h-24 rounded-full object-cover border-4 border-gray-200 dark:border-gray-600">
                            @else
                                <div class="w-24 h-24 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center text-3xl font-bold text-red-600 dark:text-red-300">
                                    {{ strtoupper(substr($employee->full_name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $employee->full_name }}</h3>
                            <p class="text-gray-600 dark:text-gray-400">{{ $employee->position }}</p>
                            <div class="flex flex-wrap gap-4 mt-2 text-sm">
                                <span class="text-gray-500 dark:text-gray-400">
                                    <strong>Employee #:</strong> {{ $employee->employee_number }}
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">
                                    <strong>Department:</strong> {{ $employee->department ?? 'N/A' }}
                                </span>
                                <span class="text-gray-500 dark:text-gray-400">
                                    <strong>Status:</strong> 
                                    <span class="px-2 py-0.5 rounded-full text-xs {{ $employee->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                        
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee #</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->employee_number }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Full Name</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->full_name }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Position</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->position }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Company</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->company->name ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Employee Type</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->classification->name ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Department</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->department ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Gender</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->gender }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date of Birth</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->date_of_birth?->format('d M Y') ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Age</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->age ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Joining Date</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->joining_date?->format('d M Y') ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Base Salary</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">K{{ number_format($employee->base_salary, 2) }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hourly Rate</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">K{{ number_format($employee->hourly_rate, 2) }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment Method</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $employee->payment_method)) }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">NASFUND #</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->nasfund_number ?? 'N/A' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</p>
                            <p class="text-lg font-semibold">
                                <span class="px-2 py-1 rounded-full text-xs {{ $employee->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                    {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>

                    </div>

                    @if($employee->isExpatriate())
                    <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-800">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">Expatriate Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Passport #</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->passport_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Passport Expiry</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->passport_expiry_date?->format('d M Y') ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Work Permit #</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->work_permit_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Work Permit Expiry</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->work_permit_expiry_date?->format('d M Y') ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Visa #</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->visa_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Visa Expiry</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $employee->visa_expiry_date?->format('d M Y') ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>