@extends('systemAdmin.layout')

@section('title', 'Projects Page')

    @section('content')
        <hr class="mx-2">
        <div class="container-fluid px-3">
            <div class="row">
                <!-- Custom Filters -->
                <div class="col-md-12">
                    <div class="filter-container">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <label for="location_filter">Location:</label>
                                <select id="location_filter" class="form-select">
                                    <option value="">All Locations</option>
                                    <option value="Alfonso Castañeda, Nueva Vizcaya">Alfonso Castañeda, Nueva Vizcaya</option>
                                    <option value="Ambaguio, Nueva Vizcaya">Ambaguio, Nueva Vizcaya</option>
                                    <option value="Aritao, Nueva Vizcaya">Aritao, Nueva Vizcaya</option>
                                    <option value="Bagabag, Nueva Vizcaya">Bagabag, Nueva Vizcaya</option>
                                    <option value="Bambang, Nueva Vizcaya">Bambang, Nueva Vizcaya</option>
                                    <option value="Bayombong, Nueva Vizcaya">Bayombong, Nueva Vizcaya</option>
                                    <option value="Diadi, Nueva Vizcaya">Diadi, Nueva Vizcaya</option>
                                    <option value="Dupax del Norte, Nueva Vizcaya">Dupax del Norte, Nueva Vizcaya</option>
                                    <option value="Dupax del Sur, Nueva Vizcaya">Dupax del Sur, Nueva Vizcaya</option>
                                    <option value="Kasibu, Nueva Vizcaya">Kasibu, Nueva Vizcaya</option>
                                    <option value="Kayapa, Nueva Vizcaya">Kayapa, Nueva Vizcaya</option>
                                    <option value="Quezon, Nueva Vizcaya">Quezon, Nueva Vizcaya</option>
                                    <option value="Santa Fe, Nueva Vizcaya">Santa Fe, Nueva Vizcaya</option>
                                    <option value="Solano, Nueva Vizcaya">Solano, Nueva Vizcaya</option>
                                    <option value="Villaverde, Nueva Vizcaya">Villaverde, Nueva Vizcaya</option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label for="contractor_filter">Contractor:</label>
                                <input list="contractors_list" id="contractor_filter" name="contractor" class="form-select"
                                    placeholder="Select or type a contractor" required>
                                <datalist id="contractors_list">
                                    <option value="">All Contractors</option>
                                    @foreach($contractors as $contractor)
                                        <option value="{{ $contractor->name }}"></option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="col-md-3 mb-2">
                                <label for="amount_filter">Amount:</label>
                                <input type="text" class="form-control" id="amount_filter" name="amount_filter" required>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label for="status_filter">Status:</label>
                                <select id="status_filter" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="Active">Ongoing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Pending">Discontinued</option>
                                </select>
                            </div>
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
                <div class="col-auto">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewProjectModal">
                        <span class="fa fa-plus"></span>&nbsp;Add New Project
                    </button>
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


        @include('systemAdmin.modals.add-project')

    @endsection
