<x-layouts.app title="Create Product">
    <div class="container mt-4">
        <!-- Professional Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-gradient-success text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    <i class="fas fa-plus me-2"></i>Create New Product
                                </h4>
                                <small>Add a new product to your inventory</small>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-light btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#shortcutsModal">
                                    <i class="fas fa-keyboard me-1"></i>Shortcuts
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Form -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0 text-success">
                            <i class="fas fa-box me-2"></i>Product Information
                        </h5>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.products.store') }}" id="create-form">
                            @csrf

                            <div class="row g-4">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code" class="form-label fw-bold">
                                            <i class="fas fa-barcode text-primary me-1"></i>Product Code
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="code" id="code" value="{{ old('code') }}"
                                            class="form-control @error('code') is-invalid @enderror" required
                                            placeholder="e.g., PRD001, BOOK-123">
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Unique identifier for the product</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">
                                            <i class="fas fa-tag text-primary me-1"></i>Product Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror" required
                                            placeholder="Enter product name">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Descriptive name for the product</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="category_id" class="form-label fw-bold">
                                            <i class="fas fa-list text-primary me-1"></i>Category
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="category_id" id="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror" required>
                                            <option value="">Select a category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Product classification</small>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label fw-bold">
                                            <i class="fas fa-rupiah-sign text-success me-1"></i>Price
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" name="price" id="price"
                                                value="{{ old('price') }}"
                                                class="form-control @error('price') is-invalid @enderror" required
                                                min="0" step="100" placeholder="0">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">Price in Indonesian Rupiah</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="stock" class="form-label fw-bold">
                                            <i class="fas fa-cubes text-info me-1"></i>Initial Stock
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}"
                                            class="form-control @error('stock') is-invalid @enderror" required
                                            min="0" placeholder="0">
                                        @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Quantity available for sale</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label fw-bold">
                                            <i class="fas fa-toggle-on text-primary me-1"></i>Status
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="status" id="status"
                                            class="form-select @error('status') is-invalid @enderror" required>
                                            <option value="">Select status</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                Active - Available for sale
                                            </option>
                                            <option value="inactive"
                                                {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive - Not available
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Product availability status</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Stock Value Display -->
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="fas fa-calculator me-2"></i>
                                        <strong>Estimated Stock Value:</strong>
                                        <span id="stock-value">Rp 0</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-center flex-wrap">
                                        <button type="submit" class="btn btn-success btn-lg" id="btn-save">
                                            <i class="fas fa-save me-1"></i>Create Product
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-lg"
                                            id="btn-save-continue">
                                            <i class="fas fa-plus me-1"></i>Save & Add Another
                                        </button>
                                        <button type="reset" class="btn btn-outline-warning btn-lg" id="btn-reset">
                                            <i class="fas fa-undo me-1"></i>Reset Form
                                        </button>
                                        <a href="{{ route('admin.products.index') }}"
                                            class="btn btn-secondary btn-lg" id="btn-cancel">
                                            <i class="fas fa-times me-1"></i>Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Quick Tips Card -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 text-primary">
                            <i class="fas fa-lightbulb me-2"></i>Quick Tips
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-check text-success me-2"></i>Use unique product codes</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Set competitive prices</li>
                                    <li><i class="fas fa-check text-success me-2"></i>Choose appropriate categories
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled mb-0">
                                    <li><i class="fas fa-check text-success me-2"></i>Start with accurate stock counts
                                    </li>
                                    <li><i class="fas fa-check text-success me-2"></i>Use descriptive product names
                                    </li>
                                    <li><i class="fas fa-check text-success me-2"></i>Set status based on availability
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keyboard Shortcuts Modal -->
    <div class="modal fade" id="shortcutsModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-keyboard me-2"></i>Keyboard Shortcuts - Create
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-sm">
                        <tr>
                            <td><kbd>Ctrl+S</kbd></td>
                            <td>Save Product</td>
                        </tr>
                        <tr>
                            <td><kbd>Ctrl+Shift+S</kbd></td>
                            <td>Save & Add Another</td>
                        </tr>
                        <tr>
                            <td><kbd>Ctrl+R</kbd></td>
                            <td>Reset Form</td>
                        </tr>
                        <tr>
                            <td><kbd>Esc</kbd></td>
                            <td>Cancel/Back</td>
                        </tr>
                        <tr>
                            <td><kbd>Tab</kbd></td>
                            <td>Next Field</td>
                        </tr>
                        <tr>
                            <td><kbd>F1</kbd></td>
                            <td>Show Shortcuts</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        kbd {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 3px;
            padding: 2px 6px;
            font-size: 0.875rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #38ef7d;
            box-shadow: 0 0 0 0.2rem rgba(56, 239, 125, 0.25);
        }

        .card {
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .alert-info {
            background-color: #e3f2fd;
            border-color: #bbdefb;
            color: #0277bd;
        }

        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .was-validated .form-control:valid,
        .form-control.is-valid {
            border-color: #198754;
        }

        .list-unstyled li {
            margin-bottom: 0.5rem;
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setupKeyboardShortcuts();
            setupFormValidation();
            setupStockCalculator();
            setupCodeGenerator();
        });

        function setupKeyboardShortcuts() {
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch (e.key.toLowerCase()) {
                        case 's':
                            e.preventDefault();
                            if (e.shiftKey) {
                                saveAndContinue();
                            } else {
                                document.getElementById('create-form').submit();
                            }
                            break;
                        case 'r':
                            e.preventDefault();
                            document.getElementById('btn-reset').click();
                            break;
                    }
                } else {
                    switch (e.key) {
                        case 'Escape':
                            if (!document.querySelector('.modal.show')) {
                                e.preventDefault();
                                document.getElementById('btn-cancel').click();
                            }
                            break;
                        case 'F1':
                            e.preventDefault();
                            new bootstrap.Modal(document.getElementById('shortcutsModal')).show();
                            break;
                    }
                }
            });
        }

        function setupFormValidation() {
            const form = document.getElementById('create-form');
            const inputs = form.querySelectorAll('input[required], select[required]');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        validateField(this);
                    }
                });
            });

            form.addEventListener('submit', function(e) {
                let isValid = true;
                inputs.forEach(input => {
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    showToast('Please fix the errors before submitting', 'danger');
                }
            });

            // Save and continue functionality
            document.getElementById('btn-save-continue').addEventListener('click', function() {
                saveAndContinue();
            });
        }

        function validateField(field) {
            const value = field.value.trim();
            let isValid = true;
            let message = '';

            // Check required fields
            if (field.hasAttribute('required') && !value) {
                isValid = false;
                message = 'This field is required';
            }

            // Specific validations
            if (value && field.name === 'price' && parseFloat(value) < 0) {
                isValid = false;
                message = 'Price must be a positive number';
            }

            if (value && field.name === 'stock' && parseInt(value) < 0) {
                isValid = false;
                message = 'Stock cannot be negative';
            }

            if (value && field.name === 'code' && value.length < 3) {
                isValid = false;
                message = 'Product code must be at least 3 characters';
            }

            // Update field appearance
            field.classList.toggle('is-invalid', !isValid);
            field.classList.toggle('is-valid', isValid && value);

            // Update feedback message
            const feedback = field.parentNode.querySelector('.invalid-feedback');
            if (feedback && !isValid) {
                feedback.textContent = message;
            }

            return isValid;
        }

        function setupStockCalculator() {
            const priceInput = document.getElementById('price');
            const stockInput = document.getElementById('stock');
            const stockValueDisplay = document.getElementById('stock-value');

            function updateStockValue() {
                const price = parseFloat(priceInput.value) || 0;
                const stock = parseInt(stockInput.value) || 0;
                const totalValue = price * stock;

                stockValueDisplay.textContent = 'Rp ' + totalValue.toLocaleString('id-ID');
            }

            priceInput.addEventListener('input', updateStockValue);
            stockInput.addEventListener('input', updateStockValue);
        }

        function setupCodeGenerator() {
            const nameInput = document.getElementById('name');
            const codeInput = document.getElementById('code');

            nameInput.addEventListener('blur', function() {
                if (!codeInput.value && this.value) {
                    const generatedCode = generateProductCode(this.value);
                    codeInput.value = generatedCode;
                    validateField(codeInput);
                }
            });
        }

        function generateProductCode(name) {
            // Generate code from first 3 letters + random number
            const prefix = name.replace(/[^a-zA-Z]/g, '').substring(0, 3).toUpperCase();
            const suffix = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            return prefix + suffix;
        }

        function saveAndContinue() {
            // Add hidden input to indicate save and continue
            const form = document.getElementById('create-form');
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'save_and_continue';
            hiddenInput.value = '1';
            form.appendChild(hiddenInput);

            form.submit();
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
            toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            toast.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 3000);
        }
    </script>
</x-layouts.app>
