<div class="modal fade" id="passwordRequestModal" tabindex="-1" aria-labelledby="passwordRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="passwordRequestModalLabel">Password Change Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="requestPassForm" method="POST">
                @csrf
                <!-- Add @csrf if using Laravel -->
                <div class="modal-body">
                    <p>This request will be sent to the system administrator.</p>
                    <div class="mb-3">
                        <label for="username" class="form-label">Your Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for request</label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="e.g., I forgot my password." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
