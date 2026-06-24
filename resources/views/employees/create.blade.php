<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add New Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('employees.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Employee Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employee Number</label>
                                <input type="text" name="employee_number" value="{{ old('employee_number') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('employee_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Full Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Position -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                                <input type="text" name="position" value="{{ old('position') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                                <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Joining Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Joining Date</label>
                                <input type="date" name="joining_date" value="{{ old('joining_date') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('joining_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Company -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                                <select name="company_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Classification -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employee Type</label>
                                <select name="classification_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Select Type</option>
                                    @foreach($classifications as $classification)
                                        <option value="{{ $classification->id }}" {{ old('classification_id') == $classification->id ? 'selected' : '' }}>
                                            {{ $classification->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classification_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Department -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                <input type="text" name="department" value="{{ old('department') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>

                            <!-- Monthly Rate -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monthly Rate (K)</label>
                                <input type="number" step="0.01" name="monthly_rate" value="{{ old('monthly_rate') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('monthly_rate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                                <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                </select>
                            </div>

                            <!-- Active Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked 
                                    class="rounded border-gray-300 dark:border-gray-600 text-red-600 shadow-sm focus:ring-red-500">
                                <label class="ml-2 block text-sm text-gray-900 dark:text-gray-100">Active</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('employees.index') }}" class="bg-gray-500 hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition">
                                Cancel
                            </a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition">
                                Create Employee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>