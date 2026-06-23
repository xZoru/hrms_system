<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-8">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <div class="inline-block p-4 bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                            Select Your Company
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Choose the company you want to manage
                        </p>
                    </div>

                    <!-- Company List -->
                    <form method="POST" action="{{ route('company.select') }}">
                        @csrf
                        <div class="space-y-3">
                            @forelse($companies as $company)
                                <button type="submit" 
                                        name="company_id" 
                                        value="{{ $company['id'] ?? $company->id }}"
                                        class="w-full text-left px-4 py-4 rounded-xl border-2 border-gray-200 dark:border-gray-700 hover:border-red-500 dark:hover:border-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 group">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400">
                                                {{ $company['name'] ?? $company->name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                Code: {{ $company['code'] ?? $company->code }}
                                            </p>
                                        </div>
                                        <div class="text-gray-400 group-hover:text-red-500 dark:group-hover:text-red-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </button>
                            @empty
                                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                    No companies available. Please contact your administrator.
                                </div>
                            @endforelse
                        </div>
                    </form>

                    <!-- Logout Link -->
                    <div class="mt-6 text-center">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition">
                                ← Back to login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>