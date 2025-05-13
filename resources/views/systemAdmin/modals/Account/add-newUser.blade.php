 <!-- Add New User Modal -->
 <div class="modal fade" id="addNewUserModal" tabindex="-1" aria-labelledby="addNewUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5" id="addNewUserLabel"><span class="bi bi-person-plus me-2"></span>&nbsp; Add New User
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="registerUserForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="ofmis_id" class="form-label fw-bolder">OFMIS ID:</label>
                                            <input type="text" class="form-control" name="ofmis_id" id="ofmis_id" placeholder="OFMIS ID" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="fullname" class="form-label fw-bolder">Full Name:</label>
                                                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="position" class="form-label fw-bolder">Position:</label>
                                                <input type="text" class="form-control" name="position" id="position" placeholder="Position">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="email" class="form-label fw-bolder">Email:</label>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="username" class="form-label fw-bolder">Username:</label>
                                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label for="password" class="form-label fw-bolder">Password:</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" required minlength="6">
                                                    <span class="input-group-text" style="cursor:pointer;">
                                                        <i class="fa fa-eye toggle-password" data-target="#password"></i>
                                                    </span>
                                                </div>
                                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-1">
                                                <label for="password_confirmation" class="form-label fw-bolder">Confirm Password:</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" required minlength="6">
                                                    <span class="input-group-text" style="cursor:pointer;">
                                                        <i class="fa fa-eye toggle-password" data-target="#password_confirmation"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!-- OFMIS Button -->
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary" id="ofmisBtn">
                                                    <i class="fa-solid fa-people-group me-2"></i>
                                                    <span class="align-middle">OFMIS</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="registerNewStaff" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>