@extends('main.layout')

@section('title', 'User Management Page')

@section('content')
                <hr class="mx-2">
                <div class="container-fluid px-3">
                    <div class="col-md-12 m-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0">User Management</h5>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewUserModal">
                                    <span class="fa fa-plus"></span>&nbsp;Add New User
                                </button>
                            </div>
                            <hr class="mt-2">
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
                                   
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#roleModal">
                                                    <span class="fa-solid fa-address-card"></span>
                                                </button>
                                            </td>
                                        </tr>
                                   
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
                                                            <div class="mb-3">
                                                                <label for="fullname" class="form-label fw-bolder">Full Name:</label>
                                                                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="fullname" class="form-label fw-bolder">Position:</label>
                                                                <input type="text" class="form-control" name="position" id="position" aria-describedby="position" placeholder="Position">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="fullname" class="form-label fw-bolder">Username:</label>
                                                                <input type="text" class="form-control" name="username" id="username" aria-describedby="username" placeholder="Username">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3">
                                                            <label for="fundSource" class="form-label fw-bolder">User Role</label>
                                                            <select name="fundSource" id="fundSource" class="form-select">
                                                                <option value="">-- --</option>
                                                                <option value="System Admin">System Admin</option>
                                                                <option value="Admin">Admin</option>
                                                                <option value="Staff">Staff</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="password" class="form-label fw-bolder">Password:</label>
                                                                <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="Password">
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
                                    <button type="submit" class="btn btn-primary">Save</button>
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
                                <h1 class="modal-title fs-5" id="appNewProjectLabel">Profile</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="mb-3">
                                                    <!-- User Role Select -->
                                                    <label for="userRole" class="form-label fw-bolder">User Role</label>
                                                    <select id="userRole" class="form-select">
                                                        <option value="">-- --</option>
                                                        <option value="System Admin">System Admin</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Staff">Staff</option>
                                                    </select>

                                                    <!-- Time Frame Select (Initially Hidden) -->
                                                    <label for="timeFrame" class="form-label fw-bolder" id="timeFrameLabel" style="display: none;">User Time Frame</label>
                                                    <select id="timeFrame" class="form-select" style="display: none;">
                                                        <option value="">-- --</option>
                                                        <option value="Permanent">Permanent</option>
                                                        <option value="Temporary">Temporary</option>
                                                    </select>

                                                    <!-- Temporary Position Input (Initially Hidden) -->
                                                    <div id="temporaryDateContainer" class="mt-2 fw-bolder" style="display: none;">
                                                        <label for="temporaryDate" class="form-label">End Date for Temporary Position:</label>
                                                        <input type="datetime-local" id="temporaryDate" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    // Get references to the elements
                    const userRoleSelect = document.getElementById('userRole');
                    const timeFrameSelect = document.getElementById('timeFrame');
                    const timeFrameLabel = document.getElementById('timeFrameLabel');
                    const temporaryDateContainer = document.getElementById('temporaryDateContainer');

                    // Event listener for user role selection
                    userRoleSelect.addEventListener('change', function() {
                        // Check if "Admin" or "Staff" is selected
                        if (userRoleSelect.value === 'Admin' || userRoleSelect.value === 'Staff') {
                            // Show Time Frame Select
                            timeFrameLabel.style.display = 'block';
                            timeFrameSelect.style.display = 'block';
                        } else {
                            // Hide Time Frame Select and Temporary Date input
                            timeFrameLabel.style.display = 'none';
                            timeFrameSelect.style.display = 'none';
                            temporaryDateContainer.style.display = 'none';
                        }
                    });

                    // Event listener for time frame selection
                    timeFrameSelect.addEventListener('change', function() {
                        // Check if "Temporary" is selected
                        if (timeFrameSelect.value === 'Temporary') {
                            // Show the Temporary Date input field
                            temporaryDateContainer.style.display = 'block';
                        } else {
                            // Hide the Temporary Date input field
                            temporaryDateContainer.style.display = 'none';
                        }
                    });
                </script>

@endsection
