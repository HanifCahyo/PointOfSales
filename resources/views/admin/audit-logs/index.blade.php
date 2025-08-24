<x-layouts.app title="Audit Logs">
    <div class="min-h-screen py-6 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Audit Logs</h1>
                        <p class="mt-2 text-sm text-gray-600">Monitor and track all system activities and user actions
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="px-4 py-2 bg-white border rounded-lg shadow-sm">
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                <span class="text-sm font-medium text-gray-700">Live Monitoring</span>
                            </div>
                        </div>
                        <div class="px-4 py-2 bg-white border rounded-lg shadow-sm">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" id="auto-refresh-toggle"
                                    class="w-4 h-4 text-blue-600 rounded form-checkbox focus:ring-blue-500">
                                <span class="text-sm font-medium text-gray-700">Auto Refresh</span>
                                <svg class="w-4 h-4 text-gray-400 refresh-indicator" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                </svg>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                @include('admin.audit-logs.components.alert', [
                    'type' => 'success',
                    'message' => session('success'),
                ])
            @endif

            @if (session('error'))
                @include('admin.audit-logs.components.alert', [
                    'type' => 'error',
                    'message' => session('error'),
                ])
            @endif

            @if (session('warning'))
                @include('admin.audit-logs.components.alert', [
                    'type' => 'warning',
                    'message' => session('warning'),
                ])
            @endif

            <!-- Statistics Overview -->
            @include('admin.audit-logs.components.stats')

            <!-- Advanced Filter Form -->
            <div class="mb-6 bg-white border border-gray-200 shadow-sm rounded-xl">
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                            </path>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">Filter Options</h3>
                    </div>
                </div>
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="space-y-4">
                        <!-- Search Bar -->
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-700">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search by user name, email, action, table name, or record ID..."
                                    class="block w-full py-2 pl-10 pr-3 transition-colors border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">User</label>
                                <select name="user_id"
                                    class="w-full px-3 py-2 transition-colors border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Users</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Action Type</label>
                                <select name="action"
                                    class="w-full px-3 py-2 transition-colors border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">All Actions</option>
                                    <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>
                                        Created</option>
                                    <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>
                                        Updated</option>
                                    <option value="deleted" {{ request('action') == 'deleted' ? 'selected' : '' }}>
                                        Deleted</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">From Date</label>
                                <input type="date" name="from_date" value="{{ request('from_date') }}"
                                    class="w-full px-3 py-2 transition-colors border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">To Date</label>
                                <input type="date" name="to_date" value="{{ request('to_date') }}"
                                    class="w-full px-3 py-2 transition-colors border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center space-x-3">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 font-medium text-white transition-colors duration-200 bg-blue-600 rounded-lg hover:bg-blue-700">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Apply Filters
                                </button>
                                <a href="{{ route('admin.audit-logs.index') }}"
                                    class="inline-flex items-center px-4 py-2 font-medium text-gray-700 transition-colors duration-200 bg-gray-100 rounded-lg hover:bg-gray-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Reset
                                </a>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm text-gray-500">Quick filters:</span>
                                <button type="button"
                                    class="px-2 py-1 text-xs text-green-800 transition-colors bg-green-100 rounded quick-filter hover:bg-green-200"
                                    data-action="created">Created</button>
                                <button type="button"
                                    class="px-2 py-1 text-xs text-yellow-800 transition-colors bg-yellow-100 rounded quick-filter hover:bg-yellow-200"
                                    data-action="updated">Updated</button>
                                <button type="button"
                                    class="px-2 py-1 text-xs text-red-800 transition-colors bg-red-100 rounded quick-filter hover:bg-red-200"
                                    data-action="deleted">Deleted</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white border border-gray-200 shadow-sm rounded-xl">
                <!-- Table Header -->
                <div class="px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900">Audit Trail Records</h3>
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                {{ $logs->total() }} records
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.audit-logs.exportExcel', request()->query()) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-white transition-colors duration-200 bg-green-600 rounded-lg export-btn hover:bg-green-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Excel
                            </a>
                            <a href="{{ route('admin.audit-logs.exportPdf', request()->query()) }}"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-white transition-colors duration-200 bg-red-600 rounded-lg export-btn hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                                PDF
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Table Content -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    User</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Action</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Table</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Record ID</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Changes</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Timestamp</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($logs as $log)
                                <tr class="transition-colors duration-150 hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-8 h-8">
                                                <div
                                                    class="flex items-center justify-center w-8 h-8 bg-gray-200 rounded-full">
                                                    <span class="text-sm font-medium text-gray-700">
                                                        {{ substr($log->user?->name ?? 'S', 0, 1) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $log->user?->name ?? 'System' }}
                                                </div>
                                                @if ($log->user)
                                                    <div class="text-sm text-gray-500">{{ $log->user->email }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $actionColors = [
                                                'created' => 'bg-green-100 text-green-800',
                                                'updated' => 'bg-yellow-100 text-yellow-800',
                                                'deleted' => 'bg-red-100 text-red-800',
                                            ];
                                            $actionColor = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $actionColor }}">
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="px-2 py-1 font-mono text-sm text-gray-900 bg-gray-100 rounded">
                                            {{ $log->table_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="font-mono">#{{ $log->record_id }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-2">
                                            @if ($log->old_values)
                                                <details class="group">
                                                    <summary
                                                        class="flex items-center space-x-1 text-xs text-red-600 cursor-pointer hover:text-red-800">
                                                        <span>Old Values</span>
                                                        <svg class="w-3 h-3 transition-transform group-open:rotate-90"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                    </summary>
                                                    <div
                                                        class="max-w-xs p-2 mt-2 overflow-x-auto font-mono text-xs rounded bg-red-50">
                                                        <pre>{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                                    </div>
                                                </details>
                                            @endif
                                            @if ($log->new_values)
                                                <details class="group">
                                                    <summary
                                                        class="flex items-center space-x-1 text-xs text-green-600 cursor-pointer hover:text-green-800">
                                                        <span>New Values</span>
                                                        <svg class="w-3 h-3 transition-transform group-open:rotate-90"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                        </svg>
                                                    </summary>
                                                    <div
                                                        class="max-w-xs p-2 mt-2 overflow-x-auto font-mono text-xs rounded bg-green-50">
                                                        <pre>{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                                    </div>
                                                </details>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="font-medium">{{ $log->created_at->format('M d, Y') }}</span>
                                            <span
                                                class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</span>
                                            <span
                                                class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <div class="text-gray-500">
                                                <p class="text-lg font-medium">No audit logs found</p>
                                                <p class="text-sm">Try adjusting your filter criteria or check back
                                                    later.</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($logs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex justify-between flex-1 sm:hidden">
                                @if ($logs->onFirstPage())
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default">
                                        Previous
                                    </span>
                                @else
                                    <a href="{{ $logs->previousPageUrl() }}"
                                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                                        Previous
                                    </a>
                                @endif
                                @if ($logs->hasMorePages())
                                    <a href="{{ $logs->nextPageUrl() }}"
                                        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700">
                                        Next
                                    </a>
                                @else
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-500 bg-white border border-gray-300 rounded-md cursor-default">
                                        Next
                                    </span>
                                @endif
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing <span class="font-medium">{{ $logs->firstItem() }}</span> to <span
                                            class="font-medium">{{ $logs->lastItem() }}</span> of <span
                                            class="font-medium">{{ $logs->total() }}</span> results
                                    </p>
                                </div>
                                <div>
                                    {{ $logs->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/audit-logs.js')
    @endpush
</x-layouts.app>
