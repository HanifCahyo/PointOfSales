<x-layouts.app title="Tambah User">
    <div class="content-header">
        <div class="container-fluid">
            <div class="mb-2 row">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="mr-2 fas fa-user-plus"></i>
                        Tambah User Baru
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Manajemen User</a></li>
                        <li class="breadcrumb-item active">Tambah User</li>
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
                                <i class="mr-2 fas fa-user-plus"></i>
                                Form Tambah User
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.users.store') }}" method="POST" id="user-form">
                                @csrf

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
                                                    value="{{ old('name') }}"
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
                                                    value="{{ old('email') }}"
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
                                        Informasi Keamanan
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password" class="form-label">
                                                    <i class="mr-1 fas fa-key"></i>
                                                    Password <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" name="password" id="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        placeholder="Minimal 8 karakter" required>
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
                                                    Konfirmasi Password <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="password" name="password_confirmation"
                                                        id="password_confirmation"
                                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                                        placeholder="Ulangi password" required>
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
                                                    <option value="">Pilih Role</option>
                                                    <option value="admin"
                                                        {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                        <i class="fas fa-user-shield"></i> Admin
                                                    </option>
                                                    <option value="kasir"
                                                        {{ old('role') == 'kasir' ? 'selected' : '' }}>
                                                        <i class="fas fa-cash-register"></i> Kasir
                                                    </option>
                                                    <option value="staff"
                                                        {{ old('role') == 'staff' ? 'selected' : '' }}>
                                                        <i class="fas fa-user"></i> Staff
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
                                                    Pilih role sesuai dengan tanggung jawab user
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
                                                        {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                                                        <i class="fas fa-check-circle"></i> Aktif
                                                    </option>
                                                    <option value="0"
                                                        {{ old('is_active') == '0' ? 'selected' : '' }}>
                                                        <i class="fas fa-times-circle"></i> Nonaktif
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
                                                    Status aktif memungkinkan user untuk login
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-top pt-3">
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="mr-1 fas fa-save"></i> Simpan User
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
                    var strength = 0;

                    if (password.length >= 8) strength++;
                    if (password.match(/[a-z]/)) strength++;
                    if (password.match(/[A-Z]/)) strength++;
                    if (password.match(/[0-9]/)) strength++;
                    if (password.match(/[^a-zA-Z0-9]/)) strength++;

                    var strengthText = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
                    var strengthColor = ['#dc3545', '#fd7e14', '#ffc107', '#28a745', '#20c997'];

                    // Remove existing strength indicator
                    $(this).siblings('.password-strength').remove();

                    if (password.length > 0) {
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

                    if (confirmPassword.length > 0) {
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
                });
            });
        </script>
    @endpush
</x-layouts.app>
