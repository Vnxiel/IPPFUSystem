@extends('systemAdmin.layout')

@section('title', 'Dashboard Page')

@section('content') 
                <!-- Summary of No. of Projects Area -->
                <div class="jumbotron jumbotron-fluid">
                    <div class="container">
                        <div class="row mt-1">
                            <div class="col-12 d-flex flex-nowrap justify-content-center justify-content-md-between align-items-center overflow-auto">
                             <!-- Total No. of Projects -->
                            <div class="card m-1" style="width: 12rem; height: 8rem;">
                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                    <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Total No. of Projects</h6>
                                    <p class="card-text fs-5 fs-md-3 fw-bold pt-2" id="totalProjects">0</p>
                                </div>
                            </div>

                            <!-- On-going Projects -->
                            <div class="card m-1" style="width: 12rem; height: 8rem;">
                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                    <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">On-going Projects</h6>
                                    <p class="card-text fs-5 fs-md-3 fw-bold pt-2" id="ongoingProjects">0</p>
                                </div>
                            </div>

                            <!-- Completed Projects -->
                            <div class="card m-1" style="width: 12rem; height: 8rem;">
                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                    <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Completed Projects</h6>
                                    <p class="card-text fs-5 fs-md-3 fw-bold pt-2" id="completedProjects">0</p>
                                </div>
                            </div>

                            <!-- Total Budget Allocated -->
                            <div class="card m-1" style="width: 16rem; height: 8rem;">
                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                    <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Total Budget Allocated</h6>
                                    <p class="card-text fs-5 fs-md-3 fw-bold pt-2 text-break" id="totalBudget">₱0</p>
                                </div>
                            </div>

                            <!-- Total Budget Used -->
                            <div class="card m-1" style="width: 16rem; height: 8rem;">
                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                    <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Total Budget Used</h6>
                                    <p class="card-text fs-5 fs-md-3 fw-bold pt-2 text-break" id="totalUsed">₱0</p>
                                </div>
                            </div>

                            <!-- ResystemAdmining Balance -->
                            <div class="card m-1" style="width: 16rem; height: 8rem;">
                                <div class="card-body text-center d-flex flex-column justify-content-between">
                                    <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">ResystemAdmining Balance</h6>
                                    <p class="card-text fs-5 fs-md-3 fw-bold pt-2 text-break" id="resystemAdminingBalance">₱0</p>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mx-2">
                <div class="container-fluid px-3">
                    <div class="col-md-12 m-2">
                        <div class="row">
                            <h5 class="p-0">Recent Projects</h5>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="table-container table-responsive">
                                <table id="recentProjects" class="table table-striped table-hover table-bordered">
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
                                    <tbody id="projectTableBody">
                                        <tr>
                                            <td colspan="7" class="text-center">Loading projects...</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>



        <!-- Add New Project Modal -->
        <div class="modal fade" id="addNewProjectModal" tabindex="-1" aria-labelledby="addNewProjectLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="appNewProjectLabel">Add New Project</h1>
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
                                <button type="button" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>




        <!-- DataTable Initialization -->
        <script>    
         document.addEventListener("DOMContentLoaded", function () {
            fetchProjectSummary(); //  Fetch project summary stats
            fetchRecentProjects(); //  Fetch projects table data
        });

//  Fetch Project Summary (Total Projects, Ongoing, Completed, Budget)
function fetchProjectSummary() {
    fetch("/projects/summary")
        .then(response => response.json())
        .then(data => {
            console.log("Project Summary Data:", data);

            if (data.status === "success" && data.data) {
                let summary = data.data;
                document.getElementById("totalProjects").textContent = summary.totalProjects;
                document.getElementById("ongoingProjects").textContent = summary.ongoingProjects;
                document.getElementById("completedProjects").textContent = summary.completedProjects;

                //  Update budget values
                document.getElementById("totalBudget").textContent = `₱${summary.totalBudget}`;
                document.getElementById("totalUsed").textContent = `₱${summary.totalUsed}`;
                document.getElementById("resystemAdminingBalance").textContent = `₱${summary.resystemAdminingBalance}`;
            } else {
                console.error("Invalid summary data received.");
            }
        })
        .catch(error => {
            console.error("Error fetching project summary:", error);
        });
}


//  Handle Overview Button Click
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("overview-btn")) {
        let projectID = e.target.getAttribute("data-id");

        //  Store projectID in session via AJAX
        fetch("/store-project-id", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") // Laravel CSRF token
            },
            body: JSON.stringify({ projectID })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Project ID stored successfully, redirecting...");

                //  Redirect to systemAdmin.overview (correct Laravel route)
                window.location.href = "/systemAdmin/overview";
            } else {
                console.error("Failed to store project ID:", data);
            }
        })
        .catch(error => console.error("Error storing project ID:", error));
    }
});




$(document).ready(function() {
                $('#sourceOfFunds').on('change', function() {
                    if ($(this).val() === 'Others') {
                        $('#otherFundContainer').slideDown(); // Show input with animation
                    } else {
                        $('#otherFundContainer').slideUp(); // Hide input with animation
                    }
                });
            });        
        
        </script>
@endsection