// Audit Logs Enhancement Script
document.addEventListener("DOMContentLoaded", function () {
    // Auto-refresh functionality
    const autoRefreshToggle = document.getElementById("auto-refresh-toggle");
    const refreshInterval = 30000; // 30 seconds
    let refreshTimer;

    if (autoRefreshToggle) {
        autoRefreshToggle.addEventListener("change", function () {
            if (this.checked) {
                startAutoRefresh();
            } else {
                stopAutoRefresh();
            }
        });
    }

    function startAutoRefresh() {
        refreshTimer = setInterval(() => {
            // Add a subtle loading indicator
            showRefreshIndicator();

            // Reload the page while preserving filters
            window.location.reload();
        }, refreshInterval);
    }

    function stopAutoRefresh() {
        if (refreshTimer) {
            clearInterval(refreshTimer);
        }
    }

    function showRefreshIndicator() {
        const indicator = document.querySelector(".refresh-indicator");
        if (indicator) {
            indicator.classList.add("animate-spin");
            setTimeout(() => {
                indicator.classList.remove("animate-spin");
            }, 1000);
        }
    }

    // Enhanced search with debouncing
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;

        searchInput.addEventListener("input", function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Auto-submit form after 500ms of no typing
                if (this.value.length >= 3 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 500);
        });
    }

    // Quick filter buttons
    const quickFilters = document.querySelectorAll(".quick-filter");
    quickFilters.forEach((filter) => {
        filter.addEventListener("click", function () {
            const action = this.dataset.action;
            const form = document.querySelector("form");
            const actionSelect = form.querySelector('select[name="action"]');

            if (actionSelect) {
                actionSelect.value = action;
                form.submit();
            }
        });
    });

    // Enhanced export functionality with progress
    const exportButtons = document.querySelectorAll(".export-btn");
    exportButtons.forEach((btn) => {
        btn.addEventListener("click", function (e) {
            // Add loading state
            const originalText = this.innerHTML;
            const spinner =
                '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';

            this.innerHTML = spinner + "Generating...";
            this.disabled = true;

            // Reset after 3 seconds
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 3000);
        });
    });

    // Keyboard shortcuts
    document.addEventListener("keydown", function (e) {
        // Ctrl/Cmd + F to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === "f") {
            e.preventDefault();
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.focus();
            }
        }

        // Ctrl/Cmd + R to refresh
        if ((e.ctrlKey || e.metaKey) && e.key === "r" && !e.shiftKey) {
            e.preventDefault();
            window.location.reload();
        }

        // Escape to clear search
        if (e.key === "Escape") {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput && searchInput === document.activeElement) {
                searchInput.value = "";
                searchInput.form.submit();
            }
        }
    });

    // Tooltip functionality for truncated data
    const jsonCells = document.querySelectorAll(".json-data");
    jsonCells.forEach((cell) => {
        if (cell.scrollWidth > cell.clientWidth) {
            cell.title = cell.textContent;
        }
    });

    // Table row highlighting on hover
    const tableRows = document.querySelectorAll("tbody tr");
    tableRows.forEach((row) => {
        row.addEventListener("mouseenter", function () {
            this.classList.add("bg-blue-50");
        });

        row.addEventListener("mouseleave", function () {
            this.classList.remove("bg-blue-50");
        });
    });
});
