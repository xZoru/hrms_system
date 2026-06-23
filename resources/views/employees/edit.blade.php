<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Employee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Employee Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Employee Number</label>
                                <input type="text" name="employee_number" value="{{ old('employee_number', $employee->employee_number) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('employee_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Full Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
                                <input type="text" name="full_name" value="{{ old('full_name', $employee->full_name) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Position -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Position</label>
                                <input type="text" name="position" value="{{ old('position', $employee->position) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Gender -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gender</label>
                                <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="Male" {{ old('gender', $employee->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $employee->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $employee->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth?->format('Y-m-d')) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Joining Date -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Joining Date</label>
                                <input type="date" name="joining_date" value="{{ old('joining_date', $employee->joining_date?->format('Y-m-d')) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('joining_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Company -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company</label>
                                <select name="company_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Select Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ old('company_id', $employee->company_id) == $company->id ? 'selected' : '' }}>
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
                                        <option value="{{ $classification->id }}" {{ old('classification_id', $employee->classification_id) == $classification->id ? 'selected' : '' }}>
                                            {{ $classification->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('classification_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Department -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Department</label>
                                <input type="text" name="department" value="{{ old('department', $employee->department) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>

                            <!-- Workshift -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Workshift</label>
                                <select name="workshift" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="Regular Dayshift" {{ old('workshift', $employee->workshift) == 'Regular Dayshift' ? 'selected' : '' }}>Regular Dayshift</option>
                                    <option value="Regular Nightshift" {{ old('workshift', $employee->workshift) == 'Regular Nightshift' ? 'selected' : '' }}>Regular Nightshift</option>
                                    <option value="Flexible" {{ old('workshift', $employee->workshift) == 'Flexible' ? 'selected' : '' }}>Flexible</option>
                                    <option value="Rotating" {{ old('workshift', $employee->workshift) == 'Rotating' ? 'selected' : '' }}>Rotating</option>
                                    <option value="Other" {{ old('workshift', $employee->workshift) == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <!-- Base Salary -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Base Salary</label>
                                <input type="number" step="0.01" name="base_salary" value="{{ old('base_salary', $employee->base_salary) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>

                            <!-- Hourly Rate -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Hourly Rate</label>
                                <input type="number" step="0.01" name="hourly_rate" value="{{ old('hourly_rate', $employee->hourly_rate) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>

                            <!-- Allowance -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Allowance</label>
                                <input type="text" name="allowance" value="{{ old('allowance', $employee->allowance) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>

                            <!-- Default Pay -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Default Pay</label>
                                <select name="default_pay" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="Bank" {{ old('default_pay', $employee->default_pay) == 'Bank' ? 'selected' : '' }}>Bank</option>
                                    <option value="Cash" {{ old('default_pay', $employee->default_pay) == 'Cash' ? 'selected' : '' }}>Cash</option>
                                </select>
                            </div>

                            <!-- NASFUND Collect -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">NASFUND Collect?</label>
                                <select name="nasfund_collect" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="NO" {{ old('nasfund_collect', $employee->nasfund_collect) == 'NO' ? 'selected' : '' }}>NO</option>
                                    <option value="YES" {{ old('nasfund_collect', $employee->nasfund_collect) == 'YES' ? 'selected' : '' }}>YES</option>
                                </select>
                            </div>

                            <!-- NASFUND Number -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">NASFUND Number</label>
                                <input type="text" name="nasfund_number" value="{{ old('nasfund_number', $employee->nasfund_number) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                            </div>

                            <!-- Payment Method -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Method</label>
                                <select name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="bank_transfer" {{ old('payment_method', $employee->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="cash" {{ old('payment_method', $employee->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                </select>
                            </div>

                            <!-- Photo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Photo</label>
                                @if($employee->photo)
                                    <div class="mt-1 mb-2 flex items-center space-x-4">
                                        <img src="{{ asset('storage/' . $employee->photo) }}" class="h-16 w-16 rounded-full object-cover border-2 border-gray-200 dark:border-gray-600">
                                        <!-- Remove Photo Button -->
                                        <button type="button" onclick="document.getElementById('remove-photo').value='1'; this.style.display='none'; document.getElementById('photo-preview').style.display='none';" 
                                                class="px-3 py-1 text-xs font-medium text-red-600 dark:text-red-400 border border-red-600 dark:border-red-400 hover:bg-red-600 hover:text-white dark:hover:bg-red-500 rounded transition">
                                            Remove Photo
                                        </button>
                                    </div>
                                    <!-- Hidden input to signal photo removal -->
                                    <input type="hidden" name="remove_photo" id="remove-photo" value="0">
                                @else
                                    <div class="mt-1 mb-2">
                                        <div class="h-16 w-16 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-500">
                                            <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" name="photo" accept="image/*" 
                                    class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 dark:file:bg-red-900/30 file:text-red-700 dark:file:text-red-300 hover:file:bg-red-100 dark:hover:file:bg-red-800/50">
                            </div>

                            <!-- Active Status -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ $employee->is_active ? 'checked' : '' }}
                                    class="rounded border-gray-300 dark:border-gray-600 text-red-600 shadow-sm focus:ring-red-500">
                                <label class="ml-2 block text-sm text-gray-900 dark:text-gray-100">Active</label>
                            </div>

                        </div>

                        <!-- Submit Buttons -->
                        <div class="mt-6 flex justify-end space-x-3">
                            <a href="{{ route('employees.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition">
                                Cancel
                            </a>
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition">
                                Update Employee
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>