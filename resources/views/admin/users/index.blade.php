<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('User Management') }}
            </h2>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500 dark:text-gray-400">🔑 Super Admin Only</span>
                <a href="{{ route('admin.users.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition">
                    + Add User
                </a>
            </div>
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
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Name</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Role</th>
                                    <th class="px-4 py-3">Company</th>
                                    <th class="px-4 py-3">Access</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                @forelse($users as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-3">{{ $user->id }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            @if($user->role == 'super_admin') bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300
                                            @elseif($user->role == 'admin') bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300
                                            @elseif($user->role == 'hr_manager') bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300
                                            @elseif($user->role == 'payroll_officer') bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300
                                            @else bg-gray-100 text-gray-700 dark:bg-gray-600 dark:text-gray-300 @endif">
                                            {{ $user->role }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $user->company->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        @if($user->isSuperAdmin())
                                            <span class="text-xs text-purple-600 dark:text-purple-400">All Companies</span>
                                        @elseif($user->allowed_companies)
                                            <span class="text-xs text-green-600 dark:text-green-400">
                                                {{ count($user->allowed_companies) }} companies
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">Single</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="inline-block px-3 py-1 text-xs font-medium text-amber-600 dark:text-amber-400 border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-block px-3 py-1 text-xs font-medium text-red-600 dark:text-red-400 border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 rounded transition"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No users found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>