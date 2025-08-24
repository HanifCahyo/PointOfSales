@props(['title' => 'Audit Logs', 'description' => 'Monitor and track all system activities and user actions'])

<div class="min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <nav class="flex space-x-2 text-sm text-gray-500 mb-2">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
                            <span>/</span>
                            <span class="text-gray-900 font-medium">{{ $title }}</span>
                        </nav>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $title }}</h1>
                        <p class="mt-2 text-sm text-gray-600">{{ $description }}</p>
                    </div>
                    {{ $headerActions ?? '' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        {{ $slot }}
    </div>
</div>

@push('styles')
    <style>
        /* Custom scrollbar for better aesthetics */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Smooth transitions for interactive elements */
        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        /* Enhanced table styling */
        .table-hover tr:hover {
            background-color: rgba(59, 130, 246, 0.05);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Loading states */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        /* Professional form styling */
        .form-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        /* Enhanced badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .badge-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
        }

        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* Professional card shadows */
        .card-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .card-shadow:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endpush
