@extends('systemAdmin.layout')

@section('title', 'User Management Page')

@section('content')
<div class="container-fluid py-4" style="background-color: transparent;">
    <!-- Header Section -->
    <div class="card mb-1 border-0 shadow-lg" >
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


@include('systemAdmin.modals.UserManagementModals.add-newUser')
@include('systemAdmin.modals.UserManagementModals.change-userRole')


@endsection
