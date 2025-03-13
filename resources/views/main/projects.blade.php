@extends('main.layout')

@section('title', 'Dashboard Page')

@section('content') 
                <hr class="mx-2">
                <div class="container-fluid px-3">
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
                                                <a href={{ route('main.overview') }} class="btn btn-primary btn-sm">Overview</a>
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
                                                <a href={{ route('main.overview') }} class="btn btn-primary btn-sm">Overview</a>
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
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="location" class="form-label">Project Title</label>
                                        <input type="text" class="form-control" id="projectTitle" value="Enter project title." disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" class="form-control" id="location" value="Enter Location." disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="projectID" class="form-label">Project ID</label>
                                        <input type="text" class="form-control" id="projectID" value="Enter project ID." disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="contractor" class="form-label">Contractor</label>
                                        <input type="text" class="form-control" id="contractor" value="Enter contractor.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
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
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="contractor" class="form-label">Mode of Implementation</label>
                                        <input type="text" class="form-control" id="" value="Enter mode of implementation.">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="editStatus" class="form-label fw-bolder">Status</label>
                                        <select id="editStatus" class="form-select">
                                            <option value="---">---</option>
                                            <option id="ongoingStatusContainer" value="Ongoing">Ongoing</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Cancelled">Discontinued</option>
                                        </select>

                                        <!-- Hidden text input for 'Ongoing' -->
                                        <div id="ongoingStatusContainer" class="mt-2 fw-bolder" style="display: none;">
                                            <label for="ongoingStatus" class="form-label">Please specify:</label>
                                            <input type="text" id="ongoingStatus" class="form-control" placeholder="Enter status percentage.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="projectDescription" class="form-label">Project Description</label>
                                        <textarea class="form-control" id="projectDescription" rows="3" style="width:100%" placeholder="Enter project description."></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">Contract Details</h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="contractDays" class="form-label">Contract Days</label>
                                        <input type="text" class="form-control" id="contractDays" value="73 Calendar Days">
                                    </div>   
                                    <div class="mb-1">
                                        <label for="noticeOfAward" class="form-label">Notice of Award</label>
                                        <input type="date" class="form-control" id="noticeOfAward" value="">
                                    </div>  
                                    <div class="mb-1">
                                        <label for="noticeToProceed" class="form-label">Notice to Proceed</label>
                                        <input type="date" class="form-control" id="noticeToProceed" value="">
                                    </div>  
                                    <div class="mb-1">
                                        <label for="officialStart" class="form-label">Official Start</label>
                                        <input type="date" class="form-control" id="officialStart" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="targetCompletion" class="form-label">Target Completion</label>
                                        <input type="date" class="form-control" id="targetCompletion" value="">
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="SuspeOrder" class="form-label">Suspension Order No.1</label>
                                        <input type="date" class="form-control" id="SuspeOrder" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="resumeOrder" class="form-label">Resume Order No.1</label>
                                        <input type="date" class="form-control" id="resumeOrder" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="timeExtension" class="form-label">Time Extension</label>
                                        <input type="text" class="form-control" id="timeExtension" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="revisedTargetCompletion" class="form-label">Revised Target Completion</label>
                                        <input type="text" class="form-control" id="" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="CompletionDate" class="form-label">Completion Date</label>
                                        <input type="text" class="form-control" id="" value="">
                                    </div> 
                                </div>
                            </div>
                            <div class="row text-center">
                                <h6 class="m-1 fw-bold">Financial Details</h6>
                            </div>
                                <!-- Financial Details -->
                            <div class="row">
                                <div class="col-md-6 border-bottom">
                                    <div class="mb-1">
                                        <label for="abc" class="form-label">ABC</label>
                                        <input type="text" class="form-control" id="abc" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="contractAmount" class="form-label">Contract Amount</label>
                                        <input type="text" class="form-control" id="contractAmount" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="engineering" class="form-label">Engineering</label>
                                        <input type="text" class="form-control" id="engineering" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="mqc" class="form-label">MQC</label>
                                        <input type="text" class="form-control" id="mqc" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="contingency" class="form-label">Contingency</label>
                                        <input type="text" class="form-control" id="contingency" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Bid Difference</label>
                                        <input type="text" class="form-control" id="bid" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="appropriate" class="form-label">Appropriation</label>
                                        <input type="text" class="form-control" id="appropriate" value="">
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

   

        <!-- DataTable Initialization -->
        <script>    
            $(document).ready(function() {
                $('#fundSource').on('change', function() {
                    if ($(this).val() === 'Others') {
                        $('#otherFundContainer').slideDown(); // Show input with animation
                    } else {
                        $('#otherFundContainer').slideUp(); // Hide input with animation
                    }
                });
            });        
            $(document).ready(function() {
                $('#projectdata').DataTable({
                    responsive: true,
                    scrollX: true, // Optional: enables horizontal scrolling if needed
                    paging: true,  // Optional: enables pagination
                    searching: true, // Optional: enables searching
                });
            });
        </script>
@endsection