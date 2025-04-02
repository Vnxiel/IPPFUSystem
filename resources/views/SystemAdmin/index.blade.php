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
                                        <p class="card-text fs-5 fs-md-3 fw-bold pt-2">10</p>
                                    </div>
                                </div>

                                <!-- On-going Projects -->
                                <div class="card m-1" style="width: 12rem; height: 8rem;">
                                    <div class="card-body text-center d-flex flex-column justify-content-between">
                                        <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">On-going Projects</h6>
                                        <p class="card-text fs-5 fs-md-3 fw-bold pt-2">0</p>
                                    </div>
                                </div>

                                <!-- Completed Projects -->
                                <div class="card m-1" style="width: 12rem; height: 8rem;">
                                    <div class="card-body text-center d-flex flex-column justify-content-between">
                                        <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Completed Projects</h6>
                                        <p class="card-text fs-5 fs-md-3 fw-bold pt-2">0</p>
                                    </div>
                                </div>

                                <!-- Discontinued Projects -->
                                <div class="card m-1" style="width: 12rem; height: 8rem;">
                                    <div class="card-body text-center d-flex flex-column justify-content-between">
                                        <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Discontinued Projects</h6>
                                        <p class="card-text fs-5 fs-md-3 fw-bold pt-2">0</p>
                                    </div>
                                </div>

                                <!-- Total Budget Allocated -->
                                <div class="card m-1" style="width: 16rem; height: 8rem;">
                                    <div class="card-body text-center d-flex flex-column justify-content-between">
                                        <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Total Budget Allocated</h6>
                                        <p class="card-text fs-5 fs-md-3 fw-bold pt-2 text-break">₱1,000,000,000</p>
                                    </div>
                                </div>

                                <!-- Total Budget Used -->
                                <div class="card m-1" style="width: 16rem; height: 8rem;">
                                    <div class="card-body text-center d-flex flex-column justify-content-between">
                                        <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Total Budget Used</h6>
                                        <p class="card-text fs-5 fs-md-3 fw-bold pt-2 text-break">₱500,000,000</p>
                                    </div>
                                </div>

                                <!-- Remaining Balance -->
                                <div class="card m-1" style="width: 16rem; height: 8rem;">
                                    <div class="card-body text-center d-flex flex-column justify-content-between">
                                        <h6 class="card-title border-bottom fw-bolder fs-6 fs-md-5">Remaining Balance</h6>
                                        <p class="card-text fs-5 fs-md-3 fw-bold pt-2 text-break">₱500,000,000</p>
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
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
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