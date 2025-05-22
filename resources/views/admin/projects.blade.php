@extends('admin.layout')

@section('title', 'Projects Page')

@section('content')
<div class="container-fluid py-4" style="background-color: transparent;">
    <!-- Header Section -->
    <div class="card mb-1 border-0 shadow-lg" style="margin-top:75px;">
        <div class="card-body p-2">
            <div class="row g-3 ">
                <!-- Filters Section - Left Sidebar -->
                <div class="card border-0 shadow-sm mb-1">
                    <div class="card-body p-1">
                        <div class="d-flex align-items-center justify-content-between mb-1" style="color: #2c3e50; font-weight: 600;">
                            <h6 class="mb-0">
                                <i class="fas fa-filter me-2"></i>Filter Projects
                            </h6>
                        </div>

                        <div class="row g-3">
                        <!-- Location Dropdown -->
                        <div class="col-md-2 position-relative">
                            <input type="text" class="form-control" id="location_filter" name="location_filter"
                                placeholder="Select or type location" autocomplete="off" onfocus="showLocationDropdown()" oninput="showLocationDropdown()" />
                            <div id="location_filter_dropdown"
                                class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                @foreach($locations as $location)
                                    <button type="button" class="list-group-item list-group-item-action"
                                        onclick="selectLocation('{{ $location }}')">
                                        {{ $location }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- CONTRACTOR INPUT + DROPDOWN -->
                        <div class="col-md-3 position-relative">
                            <div class="input-group">
                                <input type="text" class="form-control" id="contractor_filter" name="contractor"
                                    placeholder="Select or enter contractor" autocomplete="off" />
                                <button class="btn btn-outline-secondary" type="button" id="contractorToggleBtn">
                                    ▼
                                </button>
                            </div>
                            <div id="contractorDropdown" class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                
                                @foreach($contractors as $contractor)
                                    <button type="button" class="list-group-item list-group-item-action"
                                        onclick="selectContractor('{{ $contractor->name }}')">{{ $contractor->name }}</button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Amount Filter -->
                        <div class="col-md-2">
                            <div class="">
                                <input type="text" class="form-control" id="amount_filter" name="amount_filter"
                                    placeholder="Enter amount"> <!-- Keep this non-empty -->
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="col-md-2">
                            <div class="">
                                <select id="status_filter" class="form-select">
                                    <option value="">Select Status</option>
                                    <option value="Not Started">Not Started</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Discontinued">Discontinued</option>
                                    <option value="Suspended">Suspended</option>
                                </select>
                            </div>
                        </div>
                            
                        <!-- Add Project -->
                        <div class="col-md-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="ms-auto">
                                    <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addNewProjectModal"
                                            style="background: linear-gradient(45deg, #2196F3, #1976D2); border: none; box-shadow: 0 2px 5px rgba(33, 150, 243, 0.3); padding: 10px 20px; font-weight: 500;">
                                        <i class="fas fa-plus-circle me-2"></i>Add New Project
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <!-- View All Projects Checkbox -->
                            <div class="form-check mx-2">
                                <input class="form-check-input" type="checkbox" id="view_all_checkbox" onchange="filterProjects()">
                                <label class="form-check-label fw-semibold mr-1" for="view_all_checkbox">
                                    View All Projects
                                </label>
                            </div>
                            <button type="button" id="clear_filters_btn" class="btn btn-sm btn-secondary">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Table Section - Main Content -->
<div class="col-md-12">
    <div class="card border-0 shadow-sm h-100">
        <div class="card-body p-2">
            <!-- Responsive Table Wrapper-->
            <div class="table-responsive">
                <table id="projects" 
                       class="table table-hover table-bordered table-sm mb-0"
                       style="width: 100%; font-size: 1rem;">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 4%; white-space: nowrap;"><small>ID</small></th>
                            <th style="width: 23%; white-space: nowrap;"><small>Project Title</small></th>
                            <th style="width: 18%; white-space: nowrap;"><small>Location</small></th>
                            <th style="width: 8%; white-space: nowrap;"><small>Status</small></th>
                            <th style="width: 10%; white-space: nowrap;"><small>Contract Amount</small></th>
                            <th style="width: 12%; white-space: nowrap;"><small>Contractor</small></th>
                            <th style="width: 6%; white-space: nowrap;"><small>Duration</small></th>
                            <th style="width: 15%; white-space: nowrap;"><small>Action</small></th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($mappedProjects as $project)
                            <tr data-id="{{ $project['id'] }}">
                                <td class="text-muted">{{ $project['id'] }}</td>
                                <td>{{ $project['title'] }}</td>
                                <td>{{ $project['location'] }}</td>
                                <td>{{ $project['status'] }}</td>
                                <td>₱{{ $project['amount'] }}</td>
                                <td>{{ $project['contractor'] }}</td>
                                <td>{{ $project['duration'] }}</td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <!-- View Button -->
                                        <button class="btn btn-primary btn-sm overview-btn d-flex align-items-center gap-1"
                                                data-id="{{ $project['id'] }}">
                                            <i class="fas fa-eye fa-sm"></i>
                                            <span class=" d-md-inline">View</span>
                                        </button>
                                        <!-- Report Button -->
                                        <button type="button"
                                                id="generateProjectBtn"
                                                class="btn btn-info btn-sm d-flex align-items-center gap-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#generateProjectModal"
                                                title="Generate/Download Report">
                                            <i class="fa fa-download"></i>
                                            <span class=" d-md-inline">Report</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">There are no currently added projects.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



    @include('admin.modals.Projects.add-project')
    @include('admin.modals.Projects.generate-report')
@endsection