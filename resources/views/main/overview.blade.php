@extends('main.layout')

@section('title', 'Dashboard Page')

@section('content') 
                
                <hr class="mx-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 d-flex align-items-center gap-2">
                            <a href="{{ route('main.projects') }}" type="button" class="btn btn-danger btn-sm"><span class="fa fa-arrow-left"></span></a>
                            <h5 class="m-0">Project Overview</h5>
                        </div>
                        <hr class="mt-2">
                    </div>
                    <div class="row">
                        <div class="col-md-11">
                            <div class="card bg-light mb-1">
                                <div class="card-header">
                                    <strong>Construction of Barangay Multi-Purpose Hall</strong>
                                </div>
                                <div class="card-body" style="font-size: 14px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Project Details -->
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Location:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    Barangay San Isidro, Quezon City
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Project Description:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    Expansion of a 4-lane road to 6 lanes
                                                </div>                                                 
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Contractor:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    JKL Builders & Co.
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Project ID:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    003102025-01
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Mode of Implementation:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    Public Bidding
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Status:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    <span class="badge bg-success">On-going</span>&nbsp;50% as of January 31, 2025
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Notice of Award:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    January 8, 2024
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Official Start:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    February 5, 2024
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Target Completion:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    June 30, 2024
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Suspension Order No. 1:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    March 15, 2024
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Resume Order No. 1:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    April 10, 2024
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Time Extension:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    30 Days
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Revised Target Completion:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    July 30, 2024
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Completion Date:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    ----
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Financial Details -->
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>ABC:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    PHP 6,000,000.00
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Contract Amount:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    PHP 5,500,000.00
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Engineering:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    PHP 300,000.00
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>MQC:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    PHP 200,000.00
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Contingency:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    PHP 500,000.00
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Bid Difference:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    PHP 100,000.00
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-1 d-flex flex-column align-items-center">
                            <button class="btn btn-success btn-sm mb-2 w-100"><i class="fa fa-upload"></i></button>  <!-- Upload -->
                            <button type="button" class="btn btn-info btn-sm mb-2 w-100"><i class="fa fa-file"></i></button>  <!-- Generate -->
                            <button type="button" class="btn btn-warning btn-sm mb-2 w-100" data-bs-toggle="modal" data-bs-target="#projectModal"><span class="fa fa-edit"></button>  <!-- Edit -->
                            <button class="btn btn-primary btn-sm mb-2 w-100"><i class="fa fa-download"></i></button>  <!-- Download -->
                            <button class="btn btn-danger btn-sm w-100"><i class="fa fa-trash"></i></button>  <!-- Delete -->
                        </div>
                    </div> 
                </div>


                <div class="container-fluid px-3">
                    <div class="col-md-12 m-1">
                        <div class="row">
                            <hr>
                            <h5 class="p-0">Project Files</h5>
                            <hr>
                        </div>
                        <div class="row projectInfo">
                            <div class="table-container table-responsive">
                                <table id="projectFiles" class="table table-striped table-hover table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width:30%;">File Name</th>
                                            <th style="width:10%;">Type</th>
                                            <th style="width:10%;">Size</th>
                                            <th style="width:20%;">Uploaded By</th>
                                            <th style="width:15%;">Upload Date</th>
                                            <th style="width:10%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Project_Plan.pdf</td>
                                            <td>PDF</td>
                                            <td>1.2 MB</td>
                                            <td>John Doe</td>
                                            <td>2025-03-08</td>
                                            <td>
                                                <button class="btn btn-success btn-sm"><span class="fa fa-download"></span></button>
                                                <button class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Blueprints.zip</td>
                                            <td>ZIP</td>
                                            <td>15 MB</td>
                                            <td>Jane Smith</td>
                                            <td>2025-03-07</td>
                                            <td>
                                                <button class="btn btn-success btn-sm"><span class="fa fa-download"></span></button>
                                                <button class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Budget_Report.xlsx</td>
                                            <td>Excel</td>
                                            <td>500 KB</td>
                                            <td>Michael Johnson</td>
                                            <td>2025-03-06</td>
                                            <td>
                                                <button class="btn btn-success btn-sm"><span class="fa fa-download"></span></button>
                                                <button class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Site_Photos.zip</td>
                                            <td>ZIP</td>
                                            <td>50 MB</td>
                                            <td>Emily Brown</td>
                                            <td>2025-03-05</td>
                                            <td>
                                                <button class="btn btn-success btn-sm"><span class="fa fa-download"></span></button>
                                                <button class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>




<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel">Edit Project Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label for="location" class="form-label">Project Title</label>
                                <input type="text" class="form-control" id="projectTitle" value="Construction of Barangay Multi-Purpose Hall" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="location" value="Barangay San Isidro, Quezon City" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="projectID" class="form-label">Project ID</label>
                                <input type="text" class="form-control" id="projectID" value="003102025-01" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="contractor" class="form-label">Contractor</label>
                                <input type="text" class="form-control" id="contractor" value="JKL Builders & Co.">
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
                                <input type="text" class="form-control" id="" value="JKL Builders & Co.">
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
                                    <input type="text" id="ongoingStatus" class="form-control" placeholder="Enter fund source">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label for="projectDescription" class="form-label">Project Description</label>
                                <textarea class="form-control" id="projectDescription" rows="3" style="width:100%">Expansion of a 4-lane road to 6 lanes</textarea>
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
                                <input type="text" class="form-control" id="abc" value="PHP 6,000,000.00">
                            </div>
                            <div class="mb-1">
                                <label for="contractAmount" class="form-label">Contract Amount</label>
                                <input type="text" class="form-control" id="contractAmount" value="PHP 5,500,000.00">
                            </div>
                            <div class="mb-1">
                                <label for="engineering" class="form-label">Engineering</label>
                                <input type="text" class="form-control" id="engineering" value="PHP 300,000.00">
                            </div>
                            <div class="mb-1">
                                <label for="mqc" class="form-label">MQC</label>
                                <input type="text" class="form-control" id="mqc" value="PHP 200,000.00">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="contingency" class="form-label">Contingency</label>
                                <input type="text" class="form-control" id="contingency" value="PHP 500,000.00">
                            </div>
                            <div class="mb-1">
                                <label for="bid" class="form-label">Bid Difference</label>
                                <input type="text" class="form-control" id="bid" value="PHP 2000.00">
                            </div>
                            <div class="mb-1">
                                <label for="appropriate" class="form-label">Appropriation</label>
                                <input type="text" class="form-control" id="appropriate" value="PHP 2,500,000.00">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
        $(document).ready(function() {
            $('#editStatus').on('change', function() {
                if ($(this).val() === 'Ongoing') {
                    $('#ongoingStatusContainer').stop(true, true).slideDown();
                } else {
                    $('#ongoingStatusContainer').stop(true, true).slideUp();
                }
            });
        });
        $(document).ready(function() {
                $('#fundSource').on('change', function() {
                    if ($(this).val() === 'Others') {
                        $('#otherFundContainer').slideDown(); // Show input with animation
                    } else {
                        $('#otherFundContainer').slideUp(); // Hide input with animation
                    }
                });
            });     
</script>
@endsection