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
                                            <th style="width: 10%;">ID</th>
                                            <th style="width: 20%">Performed By</th>
                                            <th style="width: 10%;">Role</th>
                                            <th style="width: 40%;">Activity</th>
                                            <th style="width: 20%;">Time and Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($activityLogs as $log)
                                        <tr>
                                            <td>${log.id}</td>
                                            <td>${log.performedBy}</td>
                                            <td>${log.role}</td>
                                            <td>${log.action}</td>
                                            <td>${new Date(log.created_at).toLocaleString()}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

@endsection
