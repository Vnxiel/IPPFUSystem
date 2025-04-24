@extends('staff.layout')

@section('title', 'Projects Page')

@section('content') 
            <hr class="mx-2">
            <div class="container-fluid px-3">
        <div class="row">
   <!-- Custom Filters -->
<div class="col-md-12">
    <div class="filter-container">
        <div class="row">

            <!-- Location -->
            <div class="col-md-3 mb-2">
                <label for="location_filter">Location:</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-geo-alt"></i> <!-- Bootstrap icon -->
                    </span>
                    <input type="text" class="form-control" id="location_filter" name="location_filter"
                        placeholder="Enter Location" onkeyup="filterSuggestions(this.value)" autocomplete="off">
                </div>
                <div id="suggestionsBox" class="list-group position-absolute w-100 shadow"
                    style="display:none; max-height: 200px; overflow-y: auto; z-index: 10;">
                    @foreach($locations as $location)
                    <button type="button" class="list-group-item list-group-item-action suggestion-item">
                        {{ $location->location }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Contractor -->
            <div class="col-md-3 mb-2">
                <label for="contractor_filter">Contractor:</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person-workspace"></i>
                    </span>
                    <input list="contractors_list" id="contractor_filter" name="contractor" class="form-select"
                        placeholder="Select or type a contractor" required>
                    <datalist id="contractors_list">
                        <option value="">All Contractors</option>
                        @foreach($contractors as $contractor)
                        <option value="{{ $contractor->name }}"></option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <!-- Amount -->
            <div class="col-md-3 mb-2">
                <label for="amount_filter">Amount:</label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="text" class="form-control" id="amount_filter" name="amount_filter"
                        placeholder="Enter amount" required>
                </div>
            </div>

            <!-- Status -->
            <div class="col-md-3 mb-2">
                <label for="status_filter">Status:</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-info-circle"></i>
                    </span>
                    <select id="status_filter" class="form-select">
                        <option value="">All Status</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                        <option value="Discontinued">Discontinued</option>
                    </select>
                </div>
            </div>

        </div>
    </div>
</div>

                    <div class="col-md-12 m-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0">Projects</h5>
                            </div>
                            <hr class="mt-2">
                        </div>
                        <div class="row">
                            <div class="table-container table-responsive">
                            <table id="projects" class="table table-striped table-hover table-bordered" style="width:100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:15%">Project Title</th>
                                        <th style="width:5%">Location</th>
                                        <th style="width:5%">Status</th>
                                        <th style="width:5%">Contract Amount</th>
                                        <th style="width:5%">Contractor</th>
                                        <th style="width:5%">Duration</th>
                                        <th style="width:5%">Action</th>
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
