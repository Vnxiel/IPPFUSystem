<!-- Change user role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header  bg-primary text-white">
                <h1 class="modal-title fs-5" id="roleLabel"><span class="bi bi-person-gear me-2"></span> &nbsp; Change User Role</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userRoleForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="mb-3">
                                    <!-- User Role Select -->
                                    <label for="userRole" class="form-label fw-bolder">User Role</label>
                                    <select id="userRole" name="userRole" class="form-select">
                                        <option value="">-- Choose Role --</option>
                                        <option value="System Admin">System Admin</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Staff">Staff</option>
                                    </select>

                                    <!-- Time Frame Select (Initially Hidden) -->
                                    <label for="timeFrame" class="form-label fw-bolder" id="timeFrameLabel"
                                        style="display: none;">User Time Frame</label>
                                    <select id="time_frame" name="time_frame" class="form-select"
                                        style="display: none;">
                                        <option value="">-- Choose Time Frame--</option>
                                        <option value="Permanent">Permanent</option>
                                        <option value="Temporary">Temporary</option>
                                    </select>

                                    <!-- Temporary Position Input (Initially Hidden) -->
                                    <div id="time_limitContainer" class="mt-2 fw-bolder" style="display: none;">
                                        <label for="time_limit" class="form-label">End Date for Temporary
                                            Position:</label>
                                        <input type="datetime-local" id="time_limit" name="time_limit"
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit editRoleBtn" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>