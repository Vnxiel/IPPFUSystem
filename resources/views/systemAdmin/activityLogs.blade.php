@extends('systemAdmin.layout')

@section('title', 'Activity Logs Page')

@section('content') 
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card mb-2 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="icon-circle me-3" style="background: rgba(33, 150, 243, 0.1); padding: 12px; border-radius: 50%;">
                    <i class="fas fa-history" style="font-size: 24px; color: #2196F3;"></i>
                </div>
                <div>
                    <h4 class="mb-0">Activity Logs</h4>
                    <small class="text-muted">Track all system activities and changes</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Logs Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="activityLogs" class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 10%;" class="py-3">ID</th>
                            <th style="width: 20%;" class="py-3">Performed By</th>
                            <th style="width: 10%;" class="py-3">Role</th>
                            <th style="width: 40%;" class="py-3">Activity</th>
                            <th style="width: 20%;" class="py-3">Time and Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activityLogs as $log)
                            <tr>
                                <td>
                                    <span class="badge bg-light text-dark">#{{ $log->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle me-2" style="background: rgba(33, 150, 243, 0.1); padding: 8px; border-radius: 50%;">
                                            <i class="fas fa-user" style="color: #2196F3;"></i>
                                        </div>
                                        <span>{{ $log->performedBy }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $log->role }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle me-2 text-muted"></i>
                                        {{ $log->action }}
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="far fa-clock me-2"></i>
                                        {{ date('M d, Y g:i A', strtotime($log->created_at)) }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
