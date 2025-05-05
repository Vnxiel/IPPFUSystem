@extends('systemAdmin.layout')

@section('title', 'User Management Page')

@section('content')
                <hr class="mx-2">
                <div class="container-fluid px-3">
                    <div class="col-md-12 m-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0">User Management</h5>
                            </div>
                            <button class="btn btn-primary d-flex align-items-center gap-2 w-10" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#addNewUserModal"
                                    style="background: linear-gradient(45deg, #2196F3, #1976D2); border: none; width: 20%;">
                                <i class="fas fa-user-plus"></i>
                                <span>Add New User</span>
                            </button>
                            <hr class="mt-2">
                        </div>
                    </div>
                </div>
        

                        <div class="row">
                            <div class="table-container table-responsive">
                                <table id="userList" class="table table-striped table-hover table-bordered projectInfo">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:5%;">ID</th>
                                            <th style="width:30%;">Fullname</th>
                                            <th style="width:25%;">Username</th>
                                            <th style="width:15%;">Position</th>
                                            <th style="width:15%;">User Role</th>
                                            <th style="width:10%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->fullname }}</td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->position }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#roleModal" data-id="{{ $user->id }}">
                                                    <span class="fa-solid fa-address-card"></span>
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
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="addNewUserLabel">Add New User</h1>
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


                <!-- Change user role Modal -->
                <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="roleLabel">Change User Role</h1>
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
                                                    <label for="timeFrame" class="form-label fw-bolder" id="timeFrameLabel" style="display: none;">User Time Frame</label>
                                                    <select id="time_frame" name="time_frame" class="form-select" style="display: none;">
                                                        <option value="">-- Choose Time Frame--</option>
                                                        <option value="Permanent">Permanent</option>
                                                        <option value="Temporary">Temporary</option>
                                                    </select>

                                                    <!-- Temporary Position Input (Initially Hidden) -->
                                                    <div id="time_limitContainer" class="mt-2 fw-bolder" style="display: none;">
                                                        <label for="time_limit" class="form-label">End Date for Temporary Position:</label>
                                                        <input type="datetime-local" id="time_limit" name="time_limit" class="form-control">
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


@endsection
