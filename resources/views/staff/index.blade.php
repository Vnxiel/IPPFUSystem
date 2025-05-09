@extends('staff.layout')

@section('title', 'Dashboard Page')

@section('content') 
<div class="container-fluid py-4" style="background-color: transparent;">
    <!-- Header Section -->
    <!-- <div class="card mb-1 border-0 shadow-lg" >
        <div class="card-body p-2">
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
    </div> -->
    <div class="container py-4">
        <div class="row mt-1">
            <div class="col-12">
                <!-- Project Status Cards -->
                <div class="row g-2 mb-5">
                   <!-- Total Projects -->
                    <div class="col-md-4">
                        <a href="/systemAdmin/projects" class="card-click-animate" style="text-decoration: none;">
                        <div class="card status-card h-100" style="cursor: pointer; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
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
                        </a>
                    </div>

                    <!-- Started Projects -->
                    <div class="col-md-4">
                        <a href="/systemAdmin/projects?page=tobestarted" class="card-click-animate" style="text-decoration: none;">
                        <div class="card status-card h-100" style="cursor: pointer; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
                             <div class="card-body d-flex flex-column p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div style="font-weight: 600; font-size: 16px; color: #2c3e50;">Not Started Projects</div>
                                        <div class="icon-circle" style="background: rgba(33, 150, 243, 0.1); padding: 12px; border-radius: 50%;">
                                            <i class="fas fa-lightbulb" style="font-size: 28px; color: #2196F3;"></i>
                                        </div>
                                    </div>
                                    <div id="toBeStartedProjects" style="font-size: 32px; font-weight: bold; color: #2c3e50; margin-top: auto;">0</div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- On-going Projects -->
                    <div class="col-md-4">
                        <a href="/systemAdmin/projects?page=ongoing" class="card-click-animate" style="text-decoration: none;">
                        <div class="card status-card h-100" style="cursor: pointer; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
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
                        </a>
                    </div>

                    <!-- Completed Projects -->
                    <div class="col-md-4">
                        <a href="/systemAdmin/projects?page=completed" class="card-click-animate" style="text-decoration: none;">
                        <div class="card status-card h-100" style="cursor: pointer; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
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
                        </a>
                    </div>

                    <!-- Discontinued Projects -->
                    <div class="col-md-4">
                        <a href="/systemAdmin/projects?page=discontinued" class="card-click-animate" style="text-decoration: none;">
                        <div class="card status-card h-100" style="cursor: pointer; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
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
                        </a>
                    </div>

                    <!-- Suspended Projects -->
                    <div class="col-md-4">
                        <a href="/systemAdmin/projects?page=suspended" class="card-click-animate" style="text-decoration: none;">
                        <div class="card status-card h-100" style="cursor: pointer; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border: none; background: linear-gradient(135deg, #ffffff, #f8f9fa);">
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
                        </a>
                    </div>


                <!-- Budget Cards -->
                <div class="row g-2 mb-5">
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

<!-- DataTable Initialization -->
<script>    
         document.addEventListener("DOMContentLoaded", function () {
            fetchProjectSummary(); //  Fetch project summary stats
          
        });
        function fetchProjectSummary() {
    fetch("/projects/summary")
        .then(response => response.json())
        .then(data => {

            if (data.status === "success" && data.data) {
                const summary = data.data;

                // Project Status Counts
                document.getElementById("totalProjects").textContent = summary.totalProjects ?? 0;
                document.getElementById("ongoingProjects").textContent = summary.ongoingProjects ?? 0;
                document.getElementById("completedProjects").textContent = summary.completedProjects ?? 0;
                document.getElementById("discontinuedProjects").textContent = summary.discontinuedProjects ?? 0;
                document.getElementById("startedProjects").textContent = summary.startedProjects;
                document.getElementById("suspendedProjects").textContent = summary.suspendedProjects;
           
              

                // Budget Values
                document.getElementById("totalBudget").textContent = `₱${summary.totalBudget ?? '0.00'}`;
                document.getElementById("totalUsed").textContent = `₱${summary.totalUsed ?? '0.00'}`;
                document.getElementById("remainingBalance").textContent = `₱${summary.remainingBalance ?? '0.00'}`;
            } else {
                console.error("Invalid summary data received.");
            }
        })
        .catch(error => {
            console.error("Error fetching project summary:", error);
        });
}

        </script>
@endsection
