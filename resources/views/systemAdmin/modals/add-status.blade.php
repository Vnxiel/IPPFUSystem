<!-- Modal for adding project status -->
<!-- Add Status Modal -->
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
                            <option value="Ongoing">Ongoing</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <!-- Percentage Input -->
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Percentage</label>
                        <input type="number" class="form-control" id="percentage" placeholder="Enter percentage">
                    </div>

                    <!-- Date Input with Checkbox for Auto Date -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <div class="form-check">
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

