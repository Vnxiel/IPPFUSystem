@extends('main.layout')

@section('title', 'Dashboard Page')

@section('content') 
                <hr class="mx-2">
                <div class="container-fluid px-3">
                    <div class="col-md-12 m-2">
                        <div class="row">
                            <h5 class="p-0">Trash</h5>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="table-container table-responsive">
                            <table id="projects" class="table table-striped table-hover table-bordered">
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
                                            <td>Road Widening Project</td>
                                            <td>Quezon City</td>
                                            <td>Ongoing <br>as of March 10, 2025 </td>
                                            <td>₱2, 109,765.55</td>
                                            <td>XYZ Construction Inc.</td>
                                            <td>12 calendar days</td>
                                            <td>
                                                <a href="" class="btn btn-primary btn-sm">Restore</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Rehabilation/Improvement of Palabotan-Banila-Caino-Anayo-Canarem</td>
                                            <td>Aritao, Nueva Vizcaya</td>
                                            <td>Ongoing <br>as of March 10, 2025 </td>
                                            <td>₱50,000,000</td>
                                            <td>XYZ Construction Inc.</td>
                                            <td>82 calendar Days</td>
                                            <td>
                                                <a href="" class="btn btn-primary btn-sm">Restore</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



        <!-- Update Project Modal -->
        <div class="modal fade" id="addNewProjectModal" tabindex="-1" aria-labelledby="addNewProjectLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="appNewProjectLabel">Update Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label fw-bolder">Project Title</label>
                                        <input type="text" class="form-control" id="projectTitle" aria-describedby="projectTitle" placeholder="Project Title">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="location" class="form-label fw-bolder">Location</label>
                                        <input type="text" class="form-control" id="location" placeholder="Location">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="fundSource" class="form-label fw-bolder">Select Fund Source</label>
                                        <select id="fundSource" class="form-select" alt="source">
                                            <option value="">-- --</option>
                                            <option value="Wages">Wages</option>
                                            <option value="% Mobilization">% Mobilization</option>
                                            <option value="1st Partial Billing">1st Partial Billing</option>
                                            <option value="Trust Fund">Trust Fund</option>
                                            <option value="Final Billing">Final Billing</option>
                                            <option value="Others" id="otherFundContainer">Others</option>
                                        </select>

                                        <!-- Hidden text input for 'Others' -->
                                        <div id="otherFundContainer" class="mt-2 fw-bolder" style="display: none;">
                                            <label for="otherFund" class="form-label">Please specify:</label>
                                            <input type="text" id="otherFund" class="form-control" placeholder="Enter fund source">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Appropriation -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="appropriation" class="form-label fw-bolder">Appropriation</label>
                                            <input type="number" id="appropriation" class="form-control" placeholder="Enter appropriation amount">
                                        </div>
                                    </div>

                                    <!-- Contract Amount -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contract" class="form-label fw-bolder">Contract</label>
                                            <input type="text" id="contract" class="form-control" placeholder="Enter contract">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Revised Contract Amount -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="revContract" class="form-label fw-bolder">Revised Contract</label>
                                            <input type="text" id="revContract" class="form-control" placeholder="Enter revised contract">
                                        </div>
                                    </div>

                                    <!-- Expenditure -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="expenditure" class="form-label fw-bolder">Expenditure</label>
                                            <input type="number" id="expenditure" class="form-control" placeholder="Enter expenditure">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Date Started -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dateStarted" class="form-label fw-bolder">Date Started</label>
                                            <input type="date" id="dateStarted" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Original Expiry -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="originalExpiry" class="form-label fw-bolder">Original Expiry</label>
                                            <input type="text" id="originalExpiry" class="form-control" placeholder="Enter original expiry">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Revised Expiry -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="revExpiry" class="form-label fw-bolder">Revised Expiry</label>
                                            <input type="date" id="revExpiry" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label fw-bolder">Status</label>
                                            <select id="status" class="form-select">
                                                <option value="Ongoing">Ongoing</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Cancelled">Discontinued</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Date Completed -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="dateCompleted" class="form-label fw-bolder">Date Completed</label>
                                            <input type="date" id="dateCompleted" class="form-control">
                                        </div>
                                    </div>

                                    <!-- Project Duration -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="projectDuration" class="form-label fw-bolder">Project Duration (Days)</label>
                                            <input type="number" id="projectDuration" class="form-control" placeholder="Enter project duration">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Mode of Implementation -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="modeOfImplementation" class="form-label fw-bolder">Mode of Implementation</label>
                                            <input type="text" id="modeOfImplementation" class="form-control" placeholder="Enter mode of implementation">
                                        </div>
                                    </div>

                                    <!-- Contractor -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="contractor" class="form-label fw-bolder">Contractor</label>
                                            <input type="text" id="contractor" class="form-control" placeholder="Enter contractor name">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Description -->
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-bolder">Project Description</label>
                                            <textarea id="description" class="form-control" rows="3" placeholder="Enter project description"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


@endsection