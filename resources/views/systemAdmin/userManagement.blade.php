@extends('systemAdmin.layout')

@section('title', 'User Management Page')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card mb-2 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon-circle me-3" style="background: rgba(33, 150, 243, 0.1); padding: 12px; border-radius: 50%;">
                        <i class="fas fa-users" style="font-size: 24px; color: #2196F3;"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">User Management</h4>
                        <small class="text-muted">Manage system users and their roles</small>
                    </div>
                </div>
                <button class="btn btn-primary d-flex align-items-center gap-2" 
                        data-bs-toggle="modal" 
                        data-bs-target="#addNewUserModal"
                        style="background: linear-gradient(45deg, #2196F3, #1976D2); border: none;">
                    <i class="fas fa-user-plus"></i>
                    <span>Add New User</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="userList" class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 5%;" class="py-3">ID</th>
                            <th style="width: 30%;" class="py-3">Fullname</th>
                            <th style="width: 25%;" class="py-3">Username</th>
                            <th style="width: 15%;" class="py-3">Position</th>
                            <th style="width: 15%;" class="py-3">User Role</th>
                            <th style="width: 10%;" class="py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span>{{ $user->fullname }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->position }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $user->role }}</span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-outline-primary btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#roleModal" 
                                            data-id="{{ $user->id }}"
                                            title="Change Role">
                                        <i class="fas fa-user-tag"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add New User Modal -->
<div class="modal fade" id="addNewUserModal" tabindex="-1" aria-labelledby="addNewUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addNewUserLabel">
                    <i class="fas fa-user-plus me-2"></i>Add New User
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="registerUserForm">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Left Column -->
                        <div class="col-md-8">
                            <!-- OFMIS ID -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="ofmis_id" id="ofmis_id" placeholder="OFMIS ID" required>
                                <label for="ofmis_id">
                                    <i class="fas fa-id-card me-2"></i>OFMIS ID
                                </label>
                            </div>

                            <!-- Full Name -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name">
                                <label for="fullname">
                                    <i class="fas fa-user me-2"></i>Full Name
                                </label>
                            </div>

                            <!-- Position -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="position" id="position" placeholder="Position">
                                <label for="position">
                                    <i class="fas fa-briefcase me-2"></i>Position
                                </label>
                            </div>

                            <!-- Username -->
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                                <label for="username">
                                    <i class="fas fa-at me-2"></i>Username
                                </label>
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" 
                                           placeholder="Password" required minlength="6">
                                    <span class="input-group-text bg-light" style="cursor:pointer;">
                                        <i class="fa fa-eye toggle-password" data-target="#password"></i>
                                    </span>
                                </div>
                                @error('password') 
                                    <small class="text-danger mt-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </small> 
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-floating mb-3">
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password_confirmation" 
                                           id="password_confirmation" placeholder="Confirm Password" required minlength="6">
                                    <span class="input-group-text bg-light" style="cursor:pointer;">
                                        <i class="fa fa-eye toggle-password" data-target="#password_confirmation"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - OFMIS Button -->
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
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                    <button type="submit" id="registerNewStaff" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Change user role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="roleLabel">
                    <i class="fas fa-user-shield me-2"></i>Change User Role
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="userRoleForm">
                @csrf
                <div class="modal-body p-4">
                    <!-- User Role Select -->
                    <div class="mb-4">
                        <label class="form-label d-flex align-items-center">
                            <i class="fas fa-users-cog me-2 text-primary"></i>
                            <span class="fw-bold">User Role</span>
                        </label>
                        <select id="userRole" name="userRole" class="form-select form-select-lg">
                            <option value="">-- Choose Role --</option>
                            <option value="System Admin">
                                <i class="fas fa-user-shield"></i> System Admin
                            </option>
                            <option value="Admin">
                                <i class="fas fa-user-tie"></i> Admin
                            </option>
                            <option value="Staff">
                                <i class="fas fa-user"></i> Staff
                            </option>
                        </select>
                    </div>

                    <!-- Time Frame Select -->
                    <div class="mb-4" id="timeFrameLabel" style="display: none;">
                        <label class="form-label d-flex align-items-center">
                            <i class="fas fa-clock me-2 text-primary"></i>
                            <span class="fw-bold">User Time Frame</span>
                        </label>
                        <select id="time_frame" name="time_frame" class="form-select form-select-lg">
                            <option value="">-- Choose Time Frame --</option>
                            <option value="Permanent">
                                <i class="fas fa-infinity"></i> Permanent
                            </option>
                            <option value="Temporary">
                                <i class="fas fa-hourglass-half"></i> Temporary
                            </option>
                        </select>
                    </div>

                    <!-- Temporary Position Input -->
                    <div id="time_limitContainer" class="mb-4" style="display: none;">
                        <label class="form-label d-flex align-items-center">
                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                            <span class="fw-bold">End Date for Temporary Position</span>
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <input type="datetime-local" 
                                   id="time_limit" 
                                   name="time_limit" 
                                   class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" 
                            class="btn btn-outline-secondary" 
                            data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" 
                            class="btn btn-primary" 
                            id="editRoleBtn">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
