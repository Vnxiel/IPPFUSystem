@extends('systemAdmin.layout')

@section('title', 'User Management Page')

@section('content')
<div class="container-fluid py-4" style="background-color: transparent;">
    <!-- Header Section -->
    <div class="card mb-1 border-0 shadow-lg "style="margin-top:75px;" >
        <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="ms-auto">
                    <button class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#addNewUserModal"
                            style="background: linear-gradient(45deg, #2196F3, #1976D2); border: none; box-shadow: 0 2px 5px rgba(33, 150, 243, 0.3); padding: 10px 20px; font-weight: 500;">
                        <i class="fas fa-plus-circle me-2"></i>Add New User
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="row row-cols-1 row-cols-md-12 g-3">
    <!-- Password Request Sidebar -->
    <div class="col-md-2 d-flex">
    <div class="card w-100 d-flex flex-column">
        <div class="card-header text-center fw-bold" style="font-size: 0.85rem;">
            Password Requests
        </div>
        <div class="card-body p-2 flex-grow-1" style="overflow-y: auto;" id="passwordRequestsContainer">
            <div class="text-muted text-center">Loading requests...</div>
        </div>
    </div>
</div>


    <!-- Users Table Card -->
    <div class="col-md-10 d-flex">
        <div class="card border-0 shadow-sm w-100 d-flex flex-column">
            <div class="card-body p-4 flex-grow-1">
                <div class="table-responsive">
                    <table id="userList" class="table table-hover table-bordered table-sm mb-0"
                       style="width:100%; font-size: 1rem; white-space: nowrap;">
                        <thead class="bg-light" >
                            <tr>
                                <th style="width: 5%; white-space: nowrap;" class="py-3">ID</th>
                                <th style="width: 30%; white-space: nowrap;" class="py-3">Fullname</th>
                                <th style="width: 25%; white-space: nowrap;" class="py-3">Username</th>
                                <th style="width: 15%; white-space: nowrap;" class="py-3">Position</th>
                                <th style="width: 15%; white-space: nowrap;" class="py-3">User Role</th>
                                <th style="width: 10%; white-space: nowrap;" class="py-3 text-center">Action</th>
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
                                    <button type="button"
                                        class="btn btn-outline-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#roleModal"
                                        data-id="{{ $user->id }}"
                                        title="Change Role"
                                        id="changeRoleBtn-{{ $user->id }}"
                                        name="changeRoleBtn">
                                    <i class="fas fa-user-tag"></i>
                                </button>

                                <button type="button"
                                    class="btn btn-outline-info btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#changePassModal"
                                    data-id="{{ $user->id }}"
                                    title="Change Password"
                                    id="changePassBtn-{{ $user->id }}">
                                <i class="fas fa-key"></i>
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
</div>

</div>
</div>


@include('systemAdmin.modals.Account.add-newUser')
@include('systemAdmin.modals.Account.change-userRole')
@include('systemAdmin.modals.Account.change-password')


@endsection
