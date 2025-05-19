@extends('systemAdmin.layout')

@section('title', 'Archived Projects')

@section('content') 
<div class="container-fluid py-4" style="top-margin:25px;">
        <!-- Header Section -->
        <div class="card mb-2 border-0 shadow-sm" >
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="icon-circle me-3" style="background: rgba(158, 158, 158, 0.1); padding: 12px; border-radius: 50%;">
                        <i class="fas fa-archive" style="font-size: 24px; color: #757575;"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">Archived Projects</h4>
                        <small class="text-muted">View and manage archived project records</small>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Projects Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="trashList" class="table table-hover table-bordered table-sm mb-0"
                       style="width:100%; font-size: 1rem; white-space: nowrap;">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%; white-space: nowrap;">Project Title</th>
                                <th style="width: 15%; white-space: nowrap;">Location</th>
                                <th style="width: 15%; white-space: nowrap;">Status</th>
                                <th style="width: 10%; white-space: nowrap;">Contract Amount</th>
                                <th style="width: 15%; white-space: nowrap;">Contractor</th>
                                <th style="width: 12%; white-space: nowrap;">Duration</th>
                                <th style="width: 8%; white-space: nowrap;">Action</th>
                            </tr>   
                        </thead>
                        <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td>{{ $project['title'] }}</td>
                                    <td>{{ $project['location'] }}</td>
                                    <td>{{ $project['status'] }}</td>
                                    <td>₱{{ $project['amount'] }}</td>
                                    <td>{{ $project['contractor'] }}</td>
                                    <td>{{ $project['duration'] }}</td>
                                    <td>{!! $project['action'] !!}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No trashed projects found.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
