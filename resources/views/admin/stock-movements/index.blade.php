<x-layouts.app title="Stock Movements">
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="mr-2 fas fa-exchange-alt"></i>
                        Manajemen Pergerakan Stok
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pergerakan Stok</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="mr-2 fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="mb-4 row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $movements->where('movement_type', 'IN')->count() }}</h3>
                            <p>Total Stok Masuk</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-up"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $movements->where('movement_type', 'OUT')->count() }}</h3>
                            <p>Total Stok Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-arrow-down"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $movements->where('movement_type', 'IN')->sum('quantity') }}</h3>
                            <p>Total Qty Masuk</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $movements->where('movement_type', 'OUT')->sum('quantity') }}</h3>
                            <p>Total Qty Keluar</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-minus-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="mr-2 fas fa-list"></i>
                        Daftar Pergerakan Stok
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.stock-movements.create') }}" class="btn btn-primary btn-sm">
                            <i class="mr-1 fas fa-plus"></i> Tambah Pergerakan
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="mb-3 row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter-type">Filter Tipe:</label>
                                <select id="filter-type" class="form-control form-control-sm">
                                    <option value="">Semua Tipe</option>
                                    <option value="IN">Stok Masuk</option>
                                    <option value="OUT">Stok Keluar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter-product">Filter Produk:</label>
                                <select id="filter-product" class="form-control form-control-sm">
                                    <option value="">Semua Produk</option>
                                    @foreach ($movements->unique('product_id') as $movement)
                                        <option value="{{ $movement->product->name }}">{{ $movement->product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search-input">Pencarian:</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="search-input" class="form-control"
                                        placeholder="Cari berdasarkan produk, catatan, atau user...">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="button" id="reset-filters" class="btn btn-secondary btn-sm btn-block">
                                    <i class="mr-1 fas fa-redo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table id="stock-movements-table" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">
                                        <i class="mr-1 fas fa-calendar"></i>Tanggal & Waktu
                                    </th>
                                    <th width="20%">
                                        <i class="mr-1 fas fa-box"></i>Produk
                                    </th>
                                    <th width="10%">
                                        <i class="mr-1 fas fa-exchange-alt"></i>Tipe
                                    </th>
                                    <th width="10%">
                                        <i class="mr-1 fas fa-hashtag"></i>Kuantitas
                                    </th>
                                    <th width="25%">
                                        <i class="mr-1 fas fa-sticky-note"></i>Catatan
                                    </th>
                                    <th width="15%">
                                        <i class="mr-1 fas fa-user"></i>Dibuat Oleh
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($movements as $index => $movement)
                                    <tr class="fade-in-up">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="text-sm">
                                                <div class="font-weight-bold">
                                                    {{ $movement->created_at->format('d/m/Y') }}</div>
                                                <div class="text-muted">{{ $movement->created_at->format('H:i:s') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <div class="p-1 rounded bg-light">
                                                        <i class="fas fa-box text-muted"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $movement->product->name }}</div>
                                                    <small class="text-muted">Stok saat ini:
                                                        {{ $movement->product->stock }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if ($movement->movement_type == 'IN')
                                                <span class="badge badge-success badge-lg">
                                                    <i class="mr-1 fas fa-arrow-up"></i>Masuk
                                                </span>
                                            @else
                                                <span class="badge badge-danger badge-lg">
                                                    <i class="mr-1 fas fa-arrow-down"></i>Keluar
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info badge-lg">
                                                {{ number_format($movement->quantity) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($movement->note)
                                                <div class="text-sm">
                                                    <i class="mr-1 fas fa-quote-left text-muted"></i>
                                                    {{ Str::limit($movement->note, 50) }}
                                                    @if (strlen($movement->note) > 50)
                                                        <a href="#" class="text-primary" data-toggle="tooltip"
                                                            title="{{ $movement->note }}">
                                                            Lihat selengkapnya
                                                        </a>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted font-italic">
                                                    <i class="mr-1 fas fa-minus"></i>Tidak ada catatan
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <div class="p-1 bg-primary rounded-circle"
                                                        style="width: 25px; height: 25px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="text-white fas fa-user"
                                                            style="font-size: 10px;"></i>
                                                    </div>
                                                </div>
                                                <div class="text-sm">{{ $movement->user->name }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 text-center">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox"></i>
                                                <h5>Belum ada data pergerakan stok</h5>
                                                <p>Klik tombol "Tambah Pergerakan" untuk menambah data baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($movements->count() > 0)
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                Menampilkan {{ $movements->count() }} dari {{ $movements->count() }} data
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="mr-1 fas fa-clock"></i>
                                    Terakhir diperbarui: {{ now()->format('d/m/Y H:i:s') }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            /* Stock Movements Index Styles */
            .content-header h1 {
                font-weight: 600;
                color: #2c3e50;
            }

            .breadcrumb {
                background: transparent;
                margin-bottom: 0;
            }

            .breadcrumb-item+.breadcrumb-item::before {
                content: "›";
                font-weight: bold;
            }

            .small-box {
                border-radius: 8px;
                overflow: hidden;
                transition: transform 0.2s ease;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .small-box:hover {
                transform: translateY(-2px);
            }

            .small-box .inner h3 {
                font-weight: 700;
                font-size: 2.2rem;
            }

            .small-box .icon {
                transition: all 0.3s ease;
            }

            .small-box:hover .icon {
                transform: scale(1.1);
            }

            .card-outline.card-primary {
                border-top: 4px solid #007bff;
                box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
            }

            .card-header {
                background: linear-gradient(135deg, #667eea 0%, #4b69a2 100%);
                color: white;
                border-bottom: none;
            }

            .card-header .card-title {
                font-weight: 600;
                margin: 0;
            }

            .table {
                font-size: 0.9rem;
            }

            .table thead th {
                background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%) !important;
                color: white !important;
                border: none !important;
                font-weight: 600;
                text-transform: uppercase;
                font-size: 0.8rem;
                letter-spacing: 0.5px;
            }

            .table tbody tr {
                transition: background-color 0.2s ease;
            }

            .table tbody tr:hover {
                background-color: rgba(0, 123, 255, 0.05) !important;
            }

            .table td {
                vertical-align: middle;
                padding: 1rem 0.75rem;
                border-color: #e9ecef;
            }

            .badge-lg {
                font-size: 0.8em;
                padding: 0.5em 0.8em;
                font-weight: 600;
                border-radius: 6px;
            }

            .badge-success {
                background: linear-gradient(135deg, #28a745, #20c997);
                border: none;
            }

            .badge-danger {
                background: linear-gradient(135deg, #dc3545, #e83e8c);
                border: none;
            }

            .badge-info {
                background: linear-gradient(135deg, #17a2b8, #6f42c1);
                border: none;
            }

            .btn {
                border-radius: 6px;
                font-weight: 600;
                transition: all 0.2s ease;
            }

            .btn-primary {
                background: linear-gradient(135deg, #007bff, #0056b3);
                border: none;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #0056b3, #004085);
                transform: translateY(-1px);
            }

            .btn-secondary {
                background: linear-gradient(135deg, #6c757d, #5a6268);
                border: none;
            }

            .form-control {
                border-radius: 6px;
                border: 1px solid #ced4da;
                transition: all 0.2s ease;
            }

            .form-control:focus {
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                border-color: #007bff;
            }

            .alert-success {
                background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
                border-left: 4px solid #28a745;
                color: #155724;
                border-radius: 8px;
                border: none;
            }

            .loading-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
                border-radius: 8px;
            }

            .loading-overlay i {
                color: #007bff;
            }

            .empty-state {
                text-align: center;
                padding: 3rem 1rem;
                color: #6c757d;
            }

            .empty-state i {
                font-size: 4rem;
                margin-bottom: 1rem;
                opacity: 0.5;
            }

            .empty-state h5 {
                font-weight: 600;
                margin-bottom: 0.5rem;
            }

            .empty-state p {
                margin-bottom: 0;
                font-size: 0.9rem;
            }

            .fade-in-up {
                animation: fadeInUp 0.5s ease;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input {
                border-radius: 6px;
                border: 1px solid #ced4da;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                border-radius: 6px !important;
                margin: 0 2px;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: linear-gradient(135deg, #007bff, #0056b3) !important;
                color: white !important;
                border: none !important;
            }

            @media (max-width: 768px) {
                .small-box .inner h3 {
                    font-size: 1.8rem;
                }

                .table-responsive {
                    border-radius: 8px;
                }

                .btn-sm {
                    font-size: 0.75rem;
                    padding: 0.25rem 0.5rem;
                }

                .card-tools .btn {
                    margin-bottom: 0.5rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize tooltips
                $('[data-toggle="tooltip"]').tooltip();

                // DataTable initialization with custom styling
                var table = $('#stock-movements-table').DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "pageLength": 10,
                    "order": [
                        [1, "desc"]
                    ], // Sort by date descending
                    "language": {
                        "search": "Cari:",
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "zeroRecords": "Data tidak ditemukan",
                        "info": "Halaman _PAGE_ dari _PAGES_",
                        "infoEmpty": "Tidak ada data tersedia",
                        "infoFiltered": "(difilter dari _MAX_ total data)",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        }
                    },
                    "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip'
                });

                // Custom filters
                $('#filter-type').on('change', function() {
                    var value = $(this).val();
                    if (value === '') {
                        table.column(3).search('').draw();
                    } else {
                        table.column(3).search(value === 'IN' ? 'Masuk' : 'Keluar').draw();
                    }
                });

                $('#filter-product').on('change', function() {
                    table.column(2).search($(this).val()).draw();
                });

                $('#search-input').on('keyup', function() {
                    table.search($(this).val()).draw();
                });

                $('#reset-filters').on('click', function() {
                    $('#filter-type').val('').trigger('change');
                    $('#filter-product').val('').trigger('change');
                    $('#search-input').val('');
                    table.search('').columns().search('').draw();
                });

                // Add loading overlay for better UX
                $(document).ajaxStart(function() {
                    $('<div class="loading-overlay"><i class="fas fa-spinner fa-spin fa-2x"></i></div>')
                        .appendTo('.card-body');
                }).ajaxStop(function() {
                    $('.loading-overlay').remove();
                });
            });
        </script>
    @endpush
</x-layouts.app>
