@extends('main.layout')

@section('title', 'Dashboard Page')

@section('content') 
                <hr class="mx-2">
                <div class="container-fluid px-3">
                    <div class="col-md-12 m-2">
                        <div class="row">
                            <h5 class="p-0">Activity Logs</h5>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="table-container table-responsive">
                                <table id="activityLogs"class="table table-striped table-hover table-bordered projectInfo">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Activity</th>
                                            <th>Role</th>
                                            <th>Time and Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Juan Dela Cruz logged in</td>
                                            <td>SuperAdmin</td>
                                            <td>March 9, 2025 - 08:15 AM</td>
                                        </tr>
                                        <tr>
                                            <td>Maria Santos updated project details (Project ID: 1023)</td>
                                            <td>Personnel Admin</td>
                                            <td>March 9, 2025 - 09:05 AM</td>
                                        </tr>
                                        <tr>
                                            <td>Carlos Reyes uploaded a document (Filename: contract.pdf)</td>
                                            <td>Staff</td>
                                            <td>March 9, 2025 - 09:30 AM</td>
                                        </tr>
                                        <tr>
                                            <td>Anna Mendoza deleted a record (User ID: 57)</td>
                                            <td>Admin</td>
                                            <td>March 9, 2025 - 10:12 AM</td>
                                        </tr>
                                        <tr>
                                            <td>Mark Villanueva logged out</td>
                                            <td>Staff</td>
                                            <td>March 9, 2025 - 10:45 AM</td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

@endsection