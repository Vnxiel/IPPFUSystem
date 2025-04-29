@extends('systemAdmin.layout')

@section('title', 'Dashboard Page')

@section('content') 
                <!-- Summary of No. of Projects Area -->
                <div class="jumbotron jumbotron-fluid">
                    <div class="container mt-2">
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
                                    <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Remaining Balance</h6>
                                    <p class="card-text fs-5 fs-md-3 fw-bold pt-2 text-break" id="remainingBalance">₱0</p>
                                </div>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mx-2">
                
                @include('systemAdmin.modals.add-project')



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
                document.getElementById("remainingBalance").textContent = `₱${summary.remainingBalance}`;
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
        let project_id = e.target.getAttribute("data-id");

        //  Store projectID in session via AJAX
        fetch("/store-project-id", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") // Laravel CSRF token
            },
            body: JSON.stringify({ project_id })
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