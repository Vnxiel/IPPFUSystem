@extends('systemAdmin.layout')

@section('title', 'Dashboard Page')

@section('content') 
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="card mb-2 border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                        <div class="icon-circle me-3" style="background: rgba(33, 150, 243, 0.1); padding: 12px; border-radius: 50%;">
                            <i class="fas fa-chart-line" style="font-size: 24px; color: #2196F3;"></i>
                        </div>
                        <div>
                            <h4 class="m-0" style="color: #2c3e50; font-weight: 600;">Dashboard</h4>
                            <small class="text-muted">Project Management Overview</small>
                        </div>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNewProjectModal" 
                        style="background: linear-gradient(45deg, #2196F3, #1976D2); border: none; box-shadow: 0 2px 5px rgba(33, 150, 243, 0.3); padding: 10px 20px; font-weight: 500;">
                        <i class="fas fa-plus-circle me-2"></i>Add New Project
                    </button>
                </div>
            </div>
        </div>
    <div class="container py-4">
        <div class="row mt-1">
            <div class="col-12">
                <!-- Project Status Cards -->
                <div class="row g-4 mb-5">
                    <!-- Total Projects -->
                    <div class="col-md-4">
                        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">Total Projects</div>
                                    <div class="icon-circle" style="background: rgba(76, 175, 80, 0.1); padding: 12px; border-radius: 50%;">
                                        <i class="fas fa-folder-open" style="font-size: 28px; color: #4CAF50;"></i>
                                    </div>
                                </div>
                                <div id="totalProjects" style="font-size: 32px; font-weight: bold; color: #2c3e50; margin-top: auto;">0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Started Projects -->
                    <div class="col-md-4">
                        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">Started Projects</div>
                                    <div class="icon-circle" style="background: rgba(33, 150, 243, 0.1); padding: 12px; border-radius: 50%;">
                                        <i class="fas fa-lightbulb" style="font-size: 28px; color: #2196F3;"></i>
                                    </div>
                                </div>
                                <div id="startedProjects" style="font-size: 32px; font-weight: bold; color: #2c3e50; margin-top: auto;">0</div>
                            </div>
                        </div>
                    </div>

                    <!-- On-going Projects -->
                    <div class="col-md-4">
                        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">On-going Projects</div>
                                    <div class="icon-circle" style="background: rgba(255, 152, 0, 0.1); padding: 12px; border-radius: 50%;">
                                        <i class="fas fa-spinner" style="font-size: 28px; color: #FF9800;"></i>
                                    </div>
                                </div>
                                <div id="ongoingProjects" style="font-size: 32px; font-weight: bold; color: #2c3e50; margin-top: auto;">0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Projects -->
                    <div class="col-md-4">
                        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">Completed Projects</div>
                                    <div class="icon-circle" style="background: rgba(76, 175, 80, 0.1); padding: 12px; border-radius: 50%;">
                                        <i class="fas fa-check-double" style="font-size: 28px; color: #4CAF50;"></i>
                                    </div>
                                </div>
                                <div id="completedProjects" style="font-size: 32px; font-weight: bold; color: #2c3e50; margin-top: auto;">0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Discontinued Projects -->
                    <div class="col-md-4">
                        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">Discontinued Projects</div>
                                    <div class="icon-circle" style="background: rgba(244, 67, 54, 0.1); padding: 12px; border-radius: 50%;">
                                        <i class="fas fa-ban" style="font-size: 28px; color: #F44336;"></i>
                                    </div>
                                </div>
                                <div id="discontinuedProjects" style="font-size: 32px; font-weight: bold; color: #2c3e50; margin-top: auto;">0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Suspended Projects -->
                    <div class="col-md-4">
                        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">Suspended Projects</div>
                                    <div class="icon-circle" style="background: rgba(156, 39, 176, 0.1); padding: 12px; border-radius: 50%;">
                                        <i class="fas fa-pause" style="font-size: 28px; color: #9C27B0;"></i>
                                    </div>
                                </div>
                                <div id="suspendedProjects" style="font-size: 32px; font-weight: bold; color: #2c3e50; margin-top: auto;">0</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Budget Cards -->
                <div class="row g-4">
                    <!-- Total Budget Allocated -->
                    <div class="col-md-4">
                        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">Budget Allocated</div>
                                    <div class="icon-circle" style="background: rgba(0, 150, 136, 0.1); padding: 12px; border-radius: 50%;">
                                        <i class="fas fa-hand-holding-usd" style="font-size: 28px; color: #009688;"></i>
                                    </div>
                                </div>
                                <div id="totalBudget" style="font-size: 28px; font-weight: bold; color: #2c3e50; margin-top: auto;">₱0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Budget Used -->
                    <div class="col-md-4">
                        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">Budget Used</div>
                                    <div class="icon-circle" style="background: rgba(63, 81, 181, 0.1); padding: 12px; border-radius: 50%;">
                                        <i class="fas fa-money-bill-wave" style="font-size: 28px; color: #3F51B5;"></i>
                                    </div>
                                </div>
                                <div id="totalUsed" style="font-size: 28px; font-weight: bold; color: #2c3e50; margin-top: auto;">₱0</div>
                            </div>
                        </div>
                    </div>

                    <!-- Remaining Balance -->
                    <div class="col-md-4">
                        <div class="card h-100" style="border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">Remaining Balance</div>
                                    <div class="icon-circle" style="background: rgba(96, 125, 139, 0.1); padding: 12px; border-radius: 50%;">
                                        <i class="fas fa-wallet" style="font-size: 28px; color: #607D8B;"></i>
                                    </div>
                                </div>
                                <div id="remainingBalance" style="font-size: 28px; font-weight: bold; color: #2c3e50; margin-top: auto;">₱0</div>
                            </div> 
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
