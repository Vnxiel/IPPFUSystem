<!-- Modal for adding project status -->
<div class="modal fade" id="addStatusModal" tabindex="-1" aria-labelledby="addStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStatusModalLabel">Add Project Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addStatusForm">
                <div class="modal-body">

                    <!-- Progress Dropdown -->
                    <div class="mb-3">
                        <label for="progress" class="form-label">Progress</label>
                        <select class="form-select" id="progress" aria-label="Select project progress">
                            <option value="">Select Status</option>
                            <option value="Not Started">Not Started</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                            <option value="Discontinued">Discontinued</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                    </div>

                    <!-- Percentage Input with History -->
                    <div class="mb-3 position-relative">
                        <label for="percentage" class="form-label">Percentage</label>
                        <input type="number" class="form-control" id="percentage" placeholder="Enter percentage">

                        <!-- Info Label for History Dropdown -->
                        <small class="form-text text-muted mt-1" id="historyLabel" style="display: none;">Previous Status History:</small>

                        <!-- History Dropdown Suggestion Box -->
                        <div id="historyDropdown" class="dropdown-menu show" style="display: none; max-height: 150px; overflow-y: auto;">
                            <!-- Dynamically filled via JS -->
                        </div>
                    </div>


                    <!-- Date Input with Auto Checkbox -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="autoDate" checked>
                            <label class="form-check-label" for="autoDate">Set to Current Date</label>
                        </div>
                        <input type="date" class="form-control" id="date" disabled>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const percentageInput = document.getElementById('percentage');
    const progressSelect = document.getElementById('progress');
    const dropdown = document.getElementById('historyDropdown');
    const historyLabel = document.getElementById('historyLabel');
    const autoDate = document.getElementById('autoDate');
    const dateInput = document.getElementById('date');

    const historyData = @json($projectStatusData['ongoingStatus']);
    const existingPercentages = historyData.map(entry => parseInt(entry.percentage));
    const totalUsedPercentage = existingPercentages.reduce((sum, val) => sum + val, 0);
    const remainingPercentage = 100 - totalUsedPercentage;

    function showHistory() {
        dropdown.innerHTML = '';
        historyData.forEach(entry => {
            const item = document.createElement('div');
            item.className = 'dropdown-item text-muted small';
            item.textContent = `${entry.progress} - ${entry.percentage}% on ${entry.date}`;
            dropdown.appendChild(item);
        });
        dropdown.style.display = 'block';
        if (historyLabel) historyLabel.style.display = 'block';
    }

    percentageInput.addEventListener('focus', showHistory);

    percentageInput.addEventListener('input', () => {
    showHistory();

    const currentValue = parseInt(percentageInput.value);
    const duplicate = existingPercentages.includes(currentValue);
    const exceedsLimit = currentValue > remainingPercentage;

    percentageInput.setCustomValidity('');

    // Check for exceeding remaining percentage
    if (exceedsLimit) {
        percentageInput.setCustomValidity(`Only ${remainingPercentage}% remaining. Please enter a value within the limit.`);
    }

    // ✅ Automatically set progress to "Completed" if user enters remaining %
    if (currentValue === remainingPercentage && progressSelect.value !== 'Completed') {
        progressSelect.value = 'Completed';
    }

    // ✅ If user reduces value again, allow manual override of status
    if (currentValue < remainingPercentage && progressSelect.value === 'Completed') {
        progressSelect.value = ''; // or revert to previous status if you track it
    }

    percentageInput.reportValidity();
});

    percentageInput.addEventListener('blur', () => {
        setTimeout(() => {
            dropdown.style.display = 'none';
            if (historyLabel) historyLabel.style.display = 'none';
        }, 200);
    });

    // If 'Completed' is selected, auto-fill remaining % and disable editing
    progressSelect.addEventListener('change', () => {
        const selected = progressSelect.value;

        if (selected === 'Completed') {
            percentageInput.value = remainingPercentage;
            percentageInput.disabled = true;
            percentageInput.setCustomValidity('');
        } else {
            percentageInput.disabled = false;
        }

        percentageInput.dispatchEvent(new Event('input')); // Re-validate
    });

    // Auto date handling
    autoDate.addEventListener('change', () => {
        if (autoDate.checked) {
            const today = new Date().toISOString().split('T')[0];
            dateInput.value = today;
            dateInput.disabled = true;
        } else {
            dateInput.disabled = false;
        }
    });

    if (autoDate.checked) {
        const today = new Date().toISOString().split('T')[0];
        dateInput.value = today;
    }
});
</script>
