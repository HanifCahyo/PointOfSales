<x-layouts.app title="Categories">
    <div class="mt-4 container-fluid">
        <!-- Professional Header -->
        <div class="mb-4 row">
            <div class="col-12">
                <div class="border-0 shadow-sm card">
                    <div class="text-white card-header bg-gradient-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-plus-circle me-2"></i>Add New Category
                                </h4>
                                <small>Create a new product category</small>
                            </div>
                            <div>
                                <!-- Keyboard Shortcuts Help -->
                                <button type="button" class="btn btn-outline-light btn-sm me-2" data-bs-toggle="modal"
                                    data-bs-target="#shortcutsModal">
                                    <i class="fas fa-keyboard me-1"></i>Shortcuts <span
                                        class="badge bg-light text-success">F1</span>
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

        <!-- Form Card -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="shadow-sm card">
                    <div class="text-white card-header bg-primary">
                        <h5 class="mb-0">
                            <i class="fas fa-tag me-2"></i>Category Information
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

                        <form method="POST" action="{{ route('admin.category.store') }}" id="categoryForm">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag text-primary me-1"></i>Category Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Enter category name..." required
                                    autocomplete="off">
                                @error('name')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>Choose a descriptive name for your category.
                                    This will help organize your products.
                                </div>
                            </div>

                            <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                                <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i>Cancel
                                    <span class="badge bg-secondary ms-1">Esc</span>
                                </a>
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <i class="fas fa-save me-1"></i>Save Category
                                    <span class="badge bg-success ms-1">Ctrl+S</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips Card -->
        <div class="mt-4 row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="border-0 card bg-light">
                    <div class="card-body">
                        <h6 class="text-primary">
                            <i class="fas fa-lightbulb me-1"></i>Tips for Creating Categories
                        </h6>
                        <ul class="mb-0 list-unstyled small">
                            <li><i class="fas fa-check text-success me-2"></i>Use clear, descriptive names that are easy
                                to understand</li>
                            <li><i class="fas fa-check text-success me-2"></i>Keep category names concise but meaningful
                            </li>
                            <li><i class="fas fa-check text-success me-2"></i>Think about how customers will search for
                                products</li>
                            <li><i class="fas fa-check text-success me-2"></i>Consider creating subcategories for better
                                organization</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shortcuts Modal -->
    <div class="modal fade" id="shortcutsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="text-white modal-header bg-success">
                    <h5 class="modal-title">
                        <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts - Create Category
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
                                    <td>Save Category</td>
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
        document.addEventListener('DOMContentLoaded', function() {
            setupKeyboardShortcuts();
            setupFormValidation();
            setupPreview();

            // Focus on name field
            document.getElementById('name').focus();
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
                    case 'd':
                    case 'D':
                        if (e.altKey) {
                            e.preventDefault();
                            document.getElementById('description').focus();
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
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Saving...';
            });
        }

        function setupPreview() {
            const nameInput = document.getElementById('name');
            const descInput = document.getElementById('description');
            const previewName = document.getElementById('previewName');
            const previewDesc = document.getElementById('previewDesc');

            function updatePreview() {
                const name = nameInput.value.trim() || 'Category Name';
                const desc = descInput.value.trim() || 'Category description will appear here';

                previewName.textContent = name;
                previewDesc.textContent = desc;
            }

            nameInput.addEventListener('input', updatePreview);
            descInput.addEventListener('input', updatePreview);
        }

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>
</x-layouts.app>
