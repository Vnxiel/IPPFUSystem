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
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->position }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#roleModal" data-id="{{ $user->id }}">
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

    @include('systemAdmin.modals.userModals.add-user')
    @include('systemAdmin.modals.userModals.change-role')

@endsection