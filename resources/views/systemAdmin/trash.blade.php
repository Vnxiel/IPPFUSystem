@extends('systemAdmin.layout')

@section('title', 'Archived Projects')

@section('content') 
<div class="container-fluid py-4">
        <div class="card mb-2 border-0 shadow-sm">
            <div class="card-body p-2">
                <div class="d-flex align-items-center">
                    <div class="icon-circle me-3" style="background: rgba(158, 158, 158, 0.1); padding: 12px; border-radius: 50%;">
                        <i class="fas fa-archive" style="font-size: 24px; color: #757575;"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">Archived Projects</h4>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Projects Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table id="trashList" class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 25%;">Project Title</th>
                                <th style="width: 15%;">Location</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 10%;">Contract Amount</th>
                                <th style="width: 15%;">Contractor</th>
                                <th style="width: 12%;">Duration</th>
                                <th style="width: 8%;">Action</th>
                            </tr>   
                        </thead>
                        <tbody>
                                    <tr>
                                        <td colspan="7" class="text-center">Loading projects...</td>
                                    </tr>
                                </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
