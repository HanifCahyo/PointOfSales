<x-layouts.app title="Categories">
    <div class="mt-4 container-fluid">
        <!-- Professional Header -->
        <div class="mb-4 row">
            <div class="col-12">
                <div class="border-0 shadow-sm card">
                    <div class="text-white card-header bg-gradient-warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-edit me-2"></i>Edit Category
                                </h4>
                                <small>Update category: <strong>{{ $category->name }}</strong></small>
                            </div>
                            <div>
                                <!-- Keyboard Shortcuts Help -->
                                <button type="button" class="btn btn-outline-light btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#shortcutsModal">
                                    <i class="fas fa-keyboard me-1"></i>Shortcuts <span
                                        class="badge bg-light text-warning">F1</span>
                                </button>
                                <a href="{{ route('admin.category.index') }}" class="btn btn-outline-light">
                                    <i class="fas fa-arrow-left me-1"></i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Info & Form -->
        <div class="row">
            <!-- Category Information Card -->
            <div class="col-md-4">
                <div class="shadow-sm card">
                    <div class="text-white card-header bg-info">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>Category Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <div class="mx-auto bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="text-white fas fa-tag" style="font-size: 2rem;"></i>
                            </div>
                        </div>

                        <table class="table table-sm">
                            <tr>
                                <td><strong>ID:</strong></td>
                                <td>{{ $category->id }}</td>
                            </tr>
                            <tr>
                                <td><strong>Current Name:</strong></td>
                                <td>{{ $category->name }}</td>
                            </tr>

                            <tr>
                                <td><strong>Created:</strong></td>
                                <td>{{ $category->created_at->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Updated:</strong></td>
                                <td>{{ $category->updated_at->format('d M Y') }}</td>
                            </tr>
                        </table>


                    </div>
                </div>


            </div>

            <!-- Edit Form -->
            <div class="col-md-8">
                <div class="shadow-sm card">
                    <div class="text-white card-header bg-primary">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2"></i>Edit Category Details
                        </h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <div class="d-flex">
                                    <i class="mt-1 fas fa-exclamation-triangle me-2"></i>
                                    <div>
                                        <strong>Please fix the following errors:</strong>
                                        <ul class="mt-1 mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.category.update', $category) }}" id="categoryForm">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag text-primary me-1"></i>Category Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name', $category->name) }}" placeholder="Enter category name..."
                                    required autocomplete="off">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>Choose a descriptive name for your category.
                                </div>
                            </div>

                            <!-- Preview -->
                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-eye text-primary me-1"></i>Preview Changes
                                </label>
                                <div class="p-3 border rounded bg-light">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px;">
                                            <i class="text-white fas fa-tag"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" id="previewName">{{ $category->name }}</div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                                <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Cancel
                                    <span class="badge bg-secondary ms-1">Esc</span>
                                </a>
                                <button type="button" class="btn btn-outline-primary" onclick="resetForm()">
                                    <i class="fas fa-undo me-1"></i>Reset
                                    <span class="badge bg-primary ms-1">Ctrl+R</span>
                                </button>
                                <button type="submit" class="btn btn-warning" id="submitBtn">
                                    <i class="fas fa-save me-1"></i>Update Category
                                    <span class="badge bg-warning ms-1">Ctrl+S</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shortcuts Modal -->
    <div class="modal fade" id="shortcutsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="text-white modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts - Edit Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary"><i class="fas fa-bolt me-1"></i>Quick Actions</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><kbd>F1</kbd></td>
                                    <td>Show Shortcuts</td>
                                </tr>
                                <tr>
                                    <td><kbd>Ctrl+S</kbd></td>
                                    <td>Update Category</td>
                                </tr>
                                <tr>
                                    <td><kbd>Ctrl+R</kbd></td>
                                    <td>Reset Form</td>
                                </tr>
                                <tr>
                                    <td><kbd>Escape</kbd></td>
                                    <td>Cancel & Go Back</td>
                                </tr>
                                <tr>
                                    <td><kbd>Alt+N</kbd></td>
                                    <td>Focus Name Field</td>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Store original values for comparison
        const originalData = {
            name: '{{ $category->name }}',
            description: '{{ $category->description ?? '' }}'
        };

        document.addEventListener('DOMContentLoaded', function() {
            setupKeyboardShortcuts();
            setupFormValidation();
            setupPreview();
            setupChangeTracking();

            // Focus on name field
            document.getElementById('name').focus();
            document.getElementById('name').select();
        });

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                switch (e.key) {
                    case 'F1':
                        e.preventDefault();
                        new bootstrap.Modal(document.getElementById('shortcutsModal')).show();
                        break;
                    case 's':
                    case 'S':
                        if (e.ctrlKey || e.metaKey) {
                            e.preventDefault();
                            document.getElementById('categoryForm').submit();
                        }
                        break;
                    case 'r':
                    case 'R':
                        if (e.ctrlKey || e.metaKey) {
                            e.preventDefault();
                            resetForm();
                        }
                        break;
                    case 'Escape':
                        window.location.href = '{{ route('admin.category.index') }}';
                        break;
                    case 'n':
                    case 'N':
                        if (e.altKey) {
                            e.preventDefault();
                            document.getElementById('name').focus();
                        }
                        break;
                }
            });
        }

        function setupFormValidation() {
            const form = document.getElementById('categoryForm');
            const nameInput = document.getElementById('name');
            const submitBtn = document.getElementById('submitBtn');

            // Real-time validation
            nameInput.addEventListener('input', function() {
                const value = this.value.trim();

                if (value.length === 0) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                    submitBtn.disabled = true;
                } else if (value.length < 2) {
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                    submitBtn.disabled = true;
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    submitBtn.disabled = false;
                }
            });

            // Form submission handling
            form.addEventListener('submit', function(e) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Updating...';
            });
        }

        function setupPreview() {
            const nameInput = document.getElementById('name');
            const descInput = document.getElementById('description');
            const previewName = document.getElementById('previewName');
            const previewDesc = document.getElementById('previewDesc');

            function updatePreview() {
                const name = nameInput.value.trim() || originalData.name;
                const desc = descInput.value.trim() || 'No description provided';

                previewName.textContent = name;
                previewDesc.textContent = desc;
            }

            nameInput.addEventListener('input', updatePreview);
            descInput.addEventListener('input', updatePreview);
        }

        function setupChangeTracking() {
            const nameInput = document.getElementById('name');
            const descInput = document.getElementById('description');
            const changeLog = document.getElementById('changeLog');

            function updateChangeLog() {
                const changes = [];

                if (nameInput.value.trim() !== originalData.name) {
                    changes.push(`Name: "${originalData.name}" → "${nameInput.value.trim()}"`);
                }

                if (descInput.value.trim() !== originalData.description) {
                    changes.push(
                        `Description: "${originalData.description || 'Empty'}" → "${descInput.value.trim() || 'Empty'}"`
                    );
                }

                if (changes.length > 0) {
                    changeLog.innerHTML = changes.map(change =>
                        `<div class="mb-1"><i class="fas fa-arrow-right text-primary me-2"></i>${change}</div>`
                    ).join('');
                    changeLog.className = 'text-success small';
                } else {
                    changeLog.textContent = 'No changes detected';
                    changeLog.className = 'text-muted small';
                }
            }

            nameInput.addEventListener('input', updateChangeLog);
            descInput.addEventListener('input', updateChangeLog);
        }

        function resetForm() {
            if (confirm('Reset all changes? This will restore the original values.')) {
                document.getElementById('name').value = originalData.name;
                document.getElementById('description').value = originalData.description;

                // Trigger events to update preview and change log
                document.getElementById('name').dispatchEvent(new Event('input'));
                document.getElementById('description').dispatchEvent(new Event('input'));
            }
        }

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</x-layouts.app>
