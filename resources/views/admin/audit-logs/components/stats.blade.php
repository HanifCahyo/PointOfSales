@php
    $stats = [
        'total' => $logs->total(),
        'today' => \App\Models\AuditLog::whereDate('created_at', today())->count(),
        'this_week' => \App\Models\AuditLog::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->count(),
        'created' => \App\Models\AuditLog::where('action', 'created')->count(),
        'updated' => \App\Models\AuditLog::where('action', 'updated')->count(),
        'deleted' => \App\Models\AuditLog::where('action', 'deleted')->count(),
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Logs</p>
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Today</p>
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['today']) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">This Week</p>
                <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['this_week']) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Created</p>
                <p class="text-2xl font-semibold text-green-600">{{ number_format($stats['created']) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Updated</p>
                <p class="text-2xl font-semibold text-yellow-600">{{ number_format($stats['updated']) }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Deleted</p>
                <p class="text-2xl font-semibold text-red-600">{{ number_format($stats['deleted']) }}</p>
            </div>
        </div>
    </div>
</div>
