<x-layouts.app title="Manajemen Users">
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="mr-2 fas fa-users"></i>
                        Manajemen User
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manajemen User</li>
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
                            <h3>{{ $users->count() }}</h3>
                            <p>Total User</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $users->where('is_active', 1)->count() }}</h3>
                            <p>User Aktif</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $users->where('role', 'admin')->count() }}</h3>
                            <p>Admin</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>{{ $users->where('role', 'kasir')->count() }}</h3>
                            <p>Kasir</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="mr-2 fas fa-list"></i>
                        Daftar User
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
                            <i class="mr-1 fas fa-plus"></i> Tambah User
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <div class="mb-3 row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter-role">Filter Role:</label>
                                <select id="filter-role" class="form-control form-control-sm">
                                    <option value="">Semua Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="kasir">Kasir</option>
                                    <option value="staff">Staff</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter-status">Filter Status:</label>
                                <select id="filter-status" class="form-control form-control-sm">
                                    <option value="">Semua Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="search-input">Pencarian:</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" id="search-input" class="form-control"
                                        placeholder="Cari berdasarkan nama atau email...">
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
                        <table id="users-table" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">
                                        <i class="mr-1 fas fa-user"></i>Nama
                                    </th>
                                    <th width="25%">
                                        <i class="mr-1 fas fa-envelope"></i>Email
                                    </th>
                                    <th width="15%">
                                        <i class="mr-1 fas fa-user-tag"></i>Role
                                    </th>
                                    <th width="10%">
                                        <i class="mr-1 fas fa-toggle-on"></i>Status
                                    </th>
                                    <th width="15%">
                                        <i class="mr-1 fas fa-calendar"></i>Bergabung
                                    </th>
                                    <th width="5%">
                                        <i class="mr-1 fas fa-cogs"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $index => $user)
                                    <tr class="fade-in-up">
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="mr-2">
                                                    <div class="rounded-circle bg-light p-2 d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px;">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-weight-bold">{{ $user->name }}</div>
                                                    <small class="text-muted">ID: {{ $user->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-sm">
                                                <i class="mr-1 fas fa-envelope text-muted"></i>
                                                {{ $user->email }}
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $roleColors = [
                                                    'admin' => 'badge-danger',
                                                    'kasir' => 'badge-warning',
                                                    'staff' => 'badge-info',
                                                ];
                                                $roleIcons = [
                                                    'admin' => 'fas fa-user-shield',
                                                    'kasir' => 'fas fa-cash-register',
                                                    'staff' => 'fas fa-user',
                                                ];
                                            @endphp
                                            <span
                                                class="badge {{ $roleColors[$user->role] ?? 'badge-secondary' }} badge-lg">
                                                <i class="{{ $roleIcons[$user->role] ?? 'fas fa-user' }} mr-1"></i>
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }} badge-lg">
                                                <i
                                                    class="fas {{ $user->is_active ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                                {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-sm">
                                                <div class="font-weight-bold">
                                                    {{ $user->created_at->format('d/m/Y') }}
                                                </div>
                                                <div class="text-muted">
                                                    {{ $user->created_at->format('H:i') }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.users.edit', $user) }}"
                                                    class="btn btn-primary btn-sm" data-toggle="tooltip"
                                                    title="Edit User">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus user {{ $user->name }}?')"
                                                        class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                        title="Hapus User">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-3x mb-3"></i>
                                                <h5>Belum ada data user</h5>
                                                <p>Klik tombol "Tambah User" untuk menambahkan user baru.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($users->count() > 0)
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <i class="mr-1 fas fa-info-circle"></i>
                                Menampilkan {{ $users->count() }} user
                            </div>
                            <div>
                                <small class="text-muted">
                                    Terakhir diperbarui: {{ now()->format('d/m/Y H:i') }}
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
            .fade-in-up {
                animation: fadeInUp 0.5s ease-in-out;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .small-box {
                border-radius: 0.5rem;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s;
            }

            .small-box:hover {
                transform: translateY(-5px);
            }

            .badge-lg {
                font-size: 0.85em;
                padding: 0.5em 0.75em;
            }

            .bg-purple {
                background-color: #6f42c1 !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Initialize tooltips
                $('[data-toggle="tooltip"]').tooltip();

                // DataTable initialization with custom styling
                var table = $('#users-table').DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "pageLength": 10,
                    "order": [
                        [1, "asc"]
                    ], // Sort by name ascending
                    "language": {
                        "search": "",
                        "searchPlaceholder": "Cari user...",
                        "lengthMenu": "Tampilkan _MENU_ data per halaman",
                        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                        "infoFiltered": "(difilter dari _MAX_ total data)",
                        "paginate": {
                            "first": "Pertama",
                            "last": "Terakhir",
                            "next": "Selanjutnya",
                            "previous": "Sebelumnya"
                        },
                        "emptyTable": "Tidak ada data yang tersedia",
                        "zeroRecords": "Tidak ditemukan data yang sesuai"
                    },
                    "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rtip'
                });

                // Custom filters
                $('#filter-role').on('change', function() {
                    var value = $(this).val();
                    table.column(3).search(value).draw();
                });

                $('#filter-status').on('change', function() {
                    var value = $(this).val();
                    table.column(4).search(value).draw();
                });

                $('#search-input').on('keyup', function() {
                    table.search($(this).val()).draw();
                });

                // Reset filters
                $('#reset-filters').on('click', function() {
                    $('#filter-role').val('');
                    $('#filter-status').val('');
                    $('#search-input').val('');
                    table.search('').columns().search('').draw();
                });

                // Animate statistics cards
                $('.small-box').each(function(index) {
                    $(this).delay(index * 100).animate({
                        opacity: 1
                    }, 500);
                });
            });
        </script>
    @endpush
</x-layouts.app>
