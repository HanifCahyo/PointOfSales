<x-layouts.app title="Edit User">
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="mr-2 fas fa-user-edit"></i>
                        Edit User
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manajemen User</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="mr-2 fas fa-user-edit"></i>
                                Form Edit User: {{ $user->name }}
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-info">
                                    <i class="mr-1 fas fa-calendar"></i>
                                    Bergabung: {{ $user->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST" id="user-form">
                                @csrf @method('PUT')

                                <!-- User Profile Info -->
                                <div class="mb-4 text-center">
                                    <div class="rounded-circle bg-light mx-auto d-flex align-items-center justify-content-center"
                                        style="width: 80px; height: 80px;">
                                        <i class="fas fa-user fa-2x text-muted"></i>
                                    </div>
                                    <h5 class="mt-2 mb-0">{{ $user->name }}</h5>
                                    <p class="text-muted">{{ $user->email }}</p>
                                </div>

                                <!-- Personal Information Section -->
                                <div class="mb-4">
                                    <h5 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="mr-1 fas fa-user"></i>
                                        Informasi Personal
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name" class="form-label">
                                                    <i class="mr-1 fas fa-user"></i>
                                                    Nama Lengkap <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="name" id="name"
                                                    value="{{ old('name', $user->name) }}"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    placeholder="Masukkan nama lengkap" required>
                                                @error('name')
                                                    <div class="invalid-feedback">
                                                        <i class="mr-1 fas fa-exclamation-circle"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email" class="form-label">
                                                    <i class="mr-1 fas fa-envelope"></i>
                                                    Email <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" name="email" id="email"
                                                    value="{{ old('email', $user->email) }}"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    placeholder="Masukkan alamat email" required>
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        <i class="mr-1 fas fa-exclamation-circle"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Information Section -->
                                <div class="mb-4">
                                    <h5 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="mr-1 fas fa-lock"></i>
                                        Ubah Password
                                    </h5>

                                    <div class="alert alert-info">
                                        <i class="mr-2 fas fa-info-circle"></i>
                                        <strong>Info:</strong> Kosongkan field password jika tidak ingin mengubah
                                        password.
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password" class="form-label">
                                                    <i class="mr-1 fas fa-key"></i>
                                                    Password Baru
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" name="password" id="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="Kosongkan jika tidak diubah">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            id="toggle-password">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('password')
                                                        <div class="invalid-feedback">
                                                            <i class="mr-1 fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation" class="form-label">
                                                    <i class="mr-1 fas fa-check-double"></i>
                                                    Konfirmasi Password Baru
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation"
                                                        id="password_confirmation"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        placeholder="Ulangi password baru">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            id="toggle-password-confirm">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    </div>
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">
                                                            <i class="mr-1 fas fa-exclamation-circle"></i>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Role & Status Section -->
                                <div class="mb-4">
                                    <h5 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="mr-1 fas fa-user-tag"></i>
                                        Role & Status
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="role" class="form-label">
                                                    <i class="mr-1 fas fa-user-tag"></i>
                                                    Role <span class="text-danger">*</span>
                                                </label>
                                                <select name="role" id="role"
                                                    class="form-control @error('role') is-invalid @enderror" required>
                                                    <option value="admin"
                                                        {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                                        Admin
                                                    </option>
                                                    <option value="kasir"
                                                        {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>
                                                        Kasir
                                                    </option>
                                                    <option value="staff"
                                                        {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>
                                                        Staff
                                                    </option>
                                                </select>
                                                @error('role')
                                                    <div class="invalid-feedback">
                                                        <i class="mr-1 fas fa-exclamation-circle"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <small class="form-text text-muted">
                                                    <i class="mr-1 fas fa-info-circle"></i>
                                                    Role saat ini:
                                                    @php
                                                        $currentRoleIcons = [
                                                            'admin' => 'fas fa-user-shield text-danger',
                                                            'kasir' => 'fas fa-cash-register text-warning',
                                                            'staff' => 'fas fa-user text-info',
                                                        ];
                                                    @endphp
                                                    <i
                                                        class="{{ $currentRoleIcons[$user->role] ?? 'fas fa-user' }}"></i>
                                                    {{ ucfirst($user->role) }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="is_active" class="form-label">
                                                    <i class="mr-1 fas fa-toggle-on"></i>
                                                    Status
                                                </label>
                                                <select name="is_active" id="is_active"
                                                    class="form-control @error('is_active') is-invalid @enderror">
                                                    <option value="1"
                                                        {{ old('is_active', $user->is_active) == '1' ? 'selected' : '' }}>
                                                        Aktif
                                                    </option>
                                                    <option value="0"
                                                        {{ old('is_active', $user->is_active) == '0' ? 'selected' : '' }}>
                                                        Nonaktif
                                                    </option>
                                                </select>
                                                @error('is_active')
                                                    <div class="invalid-feedback">
                                                        <i class="mr-1 fas fa-exclamation-circle"></i>
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                                <small class="form-text text-muted">
                                                    <i class="mr-1 fas fa-info-circle"></i>
                                                    Status saat ini:
                                                    <span
                                                        class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                                                        <i
                                                            class="fas {{ $user->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                                    </span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Information -->
                                <div class="mb-4">
                                    <h5 class="text-primary border-bottom pb-2 mb-3">
                                        <i class="mr-1 fas fa-info-circle"></i>
                                        Informasi Tambahan
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body p-3">
                                                    <small class="text-muted">
                                                        <i class="mr-1 fas fa-calendar-plus"></i>
                                                        <strong>Dibuat:</strong><br>
                                                        {{ $user->created_at->format('d F Y, H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card bg-light">
                                                <div class="card-body p-3">
                                                    <small class="text-muted">
                                                        <i class="mr-1 fas fa-edit"></i>
                                                        <strong>Terakhir diubah:</strong><br>
                                                        {{ $user->updated_at->format('d F Y, H:i') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="mr-1 fas fa-save"></i> Update User
                                        </button>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg">
                                            <i class="mr-1 fas fa-arrow-left"></i> Batal
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        <style>
            .form-label {
                font-weight: 600;
                color: #495057;
            }

            .card {
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                border: none;
            }

            .form-control:focus {
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .text-danger {
                font-weight: 600;
            }

            .border-bottom {
                border-bottom: 2px solid #007bff !important;
            }

            .bg-light {
                background-color: #f8f9fa !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Toggle password visibility
                $('#toggle-password').on('click', function() {
                    var passwordField = $('#password');
                    var icon = $(this).find('i');

                    if (passwordField.attr('type') === 'password') {
                        passwordField.attr('type', 'text');
                        icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        passwordField.attr('type', 'password');
                        icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });

                $('#toggle-password-confirm').on('click', function() {
                    var passwordField = $('#password_confirmation');
                    var icon = $(this).find('i');

                    if (passwordField.attr('type') === 'password') {
                        passwordField.attr('type', 'text');
                        icon.removeClass('fa-eye').addClass('fa-eye-slash');
                    } else {
                        passwordField.attr('type', 'password');
                        icon.removeClass('fa-eye-slash').addClass('fa-eye');
                    }
                });

                // Password strength indicator
                $('#password').on('input', function() {
                    var password = $(this).val();

                    // Remove existing strength indicator
                    $(this).siblings('.password-strength').remove();

                    if (password.length > 0) {
                        var strength = 0;

                        if (password.length >= 8) strength++;
                        if (password.match(/[a-z]/)) strength++;
                        if (password.match(/[A-Z]/)) strength++;
                        if (password.match(/[0-9]/)) strength++;
                        if (password.match(/[^a-zA-Z0-9]/)) strength++;

                        var strengthText = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
                        var strengthColor = ['#dc3545', '#fd7e14', '#ffc107', '#28a745', '#20c997'];

                        $(this).after(
                            '<small class="password-strength text-muted d-block mt-1"><i class="fas fa-shield-alt mr-1"></i>Kekuatan: <span style="color: ' +
                            strengthColor[strength - 1] + '">' + strengthText[strength - 1] +
                            '</span></small>');
                    }
                });

                // Password confirmation validation
                $('#password_confirmation').on('input', function() {
                    var password = $('#password').val();
                    var confirmPassword = $(this).val();

                    // Remove existing validation message
                    $(this).siblings('.password-match').remove();

                    if (confirmPassword.length > 0 && password.length > 0) {
                        if (password === confirmPassword) {
                            $(this).after(
                                '<small class="password-match text-success d-block mt-1"><i class="fas fa-check mr-1"></i>Password cocok</small>'
                                );
                        } else {
                            $(this).after(
                                '<small class="password-match text-danger d-block mt-1"><i class="fas fa-times mr-1"></i>Password tidak cocok</small>'
                                );
                        }
                    }
                });

                // Form validation
                $('#user-form').on('submit', function(e) {
                    var password = $('#password').val();
                    var confirmPassword = $('#password_confirmation').val();

                    // Only validate if password is being changed
                    if (password.length > 0 || confirmPassword.length > 0) {
                        if (password !== confirmPassword) {
                            e.preventDefault();
                            alert('Password dan konfirmasi password tidak cocok!');
                            return false;
                        }

                        if (password.length < 8) {
                            e.preventDefault();
                            alert('Password minimal 8 karakter!');
                            return false;
                        }
                    }
                });
            });
        </script>
    @endpush
</x-layouts.app>
