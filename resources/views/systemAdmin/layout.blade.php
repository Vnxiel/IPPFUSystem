<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IPPFU</title>
        <!-- Bootstrap CSS -->
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Google Fonts & FontAwesome -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.css" />

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/colreorder/1.5.0/css/colReorder.dataTables.min.css">
    
        <link href="{{ asset('css/ippfu-css.css') }}" rel="stylesheet">

    </head>
    <!-- <body style="background-color: #F8F2DE;" class="montserrat"> -->
    <body class="montserrat d-flex flex-column min-vh-100">
        <div class="wrapper d-flex flex-column flex-grow-1">
            <!-- Enhanced Navbar -->
            <nav class="navbar navbar-expand-lg shadow-sm fixed-top" style="background: linear-gradient(to right, #ffffff, #F8F2DE);">
                <div class="container-fluid px-4">
                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
                        <a href="{{ route('systemAdmin.index') }}" class="navbar-brand col-lg-3 me-0 d-flex align-items-center mb-2 mb-lg-0">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('img/temp_logo.png') }}" alt="Logo" width="50" height="40" class="img-fluid me-3">
                                <div>
                                    <h5 class="mb-0 fw-bold" style="color: #2c3e50;">Provincial Engineering Office</h5>
                                    <h6 class="mt-1 text-muted" style="font-size: 0.9rem;">Province of Nueva Vizcaya</h6>
                                </div>
                            </div>
                        </a>

                        <div class="d-lg-flex align-items-center ms-auto gap-lg-3">
                            <ul class="navbar-nav gap-lg-2">
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('systemAdmin/index') ? 'fw-bold text-white' : '' }}" 
                                    style="{{ Request::is('systemAdmin/index') ? 'background: #2196F3;' : 'color: #2c3e50;' }}"
                                    href="{{ url('/systemAdmin/index') }}">
                                    <i class="fas fa-chart-line me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('systemAdmin/projects') ? 'fw-bold text-white' : '' }}"
                                    style="{{ Request::is('systemAdmin/projects') ? 'background: #2196F3;' : 'color: #2c3e50;' }}"
                                    href="{{ url('/systemAdmin/projects') }}">
                                    <i class="fas fa-project-diagram me-2"></i>Projects
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link px-3 py-2 rounded-3 {{ Request::is('systemAdmin/userManagement') ? 'fw-bold text-white' : '' }}"
                                    style="{{ Request::is('systemAdmin/userManagement') ? 'background: #2196F3;' : 'color: #2c3e50;' }}"
                                    href="{{ url('/systemAdmin/userManagement') }}">
                                    <i class="fas fa-users me-2"></i>User Management
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle px-3 py-2 rounded-3 {{ Request::is('systemAdmin/trash') || Request::is('systemAdmin/activityLogs') ? 'fw-bold text-white' : '' }}"
                                    style="{{ Request::is('systemAdmin/trash') || Request::is('systemAdmin/activityLogs') ? 'background: #2196F3;' : 'color: #2c3e50;' }}"
                                    href="#" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog me-2"></i>Settings
                                    </a>
                                    <ul class="dropdown-menu border-0 shadow-sm mt-2">
                                        <li>
                                            <a class="dropdown-item py-2 {{ Request::is('systemAdmin/trash') ? 'fw-bold text-primary' : '' }}" href="{{ url('/systemAdmin/trash') }}">
                                                <i class="fas fa-archive me-2"></i>Archive
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item py-2 {{ Request::is('systemAdmin/activityLogs') ? 'fw-bold text-primary' : '' }}" href="{{ url('/systemAdmin/activityLogs') }}">
                                                <i class="fas fa-history me-2"></i>Activity Logs
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <div class="dropdown">
                                <?php $username = session()->has('loggedIn') ? session('loggedIn.username') : 'Guest'; ?>
                                <a href="#" id="dropdownMenuButton" 
                                class="d-flex align-items-center text-decoration-none dropdown-toggle px-3 py-2 rounded-3"
                                style="color: #2c3e50;"
                                data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-circle me-2" style="background: rgba(33, 150, 243, 0.1); padding: 8px; border-radius: 50%;">
                                            <i class="fas fa-user" style="color: #2196F3;"></i>
                                        </div>
                                        <span class="fw-medium"><?php echo htmlspecialchars($username); ?></span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm mt-2">
                                    <li>
                                        <a class="dropdown-item py-2 text-danger" href="javascript:void(0);" onclick="logout()">
                                            <i class="fas fa-sign-out-alt me-2"></i>Sign out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Content -->
            <div class="container-fluid flex-grow-1" style="background: #F8F2DE;">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="text-center p-2 bg-light mt-auto">
            <p>&copy; {{ date('Y') }} PEO. All Rights Reserved.</p>
        </footer>



        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
       
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
        <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>

        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Your Custom Scripts -->
        
        <script src="{{ asset('js/Datatables/load-data.js') }}"></script>
        <script src="{{ asset('js/Account/register-user.js') }}"></script>
        <script src="{{ asset('js/Account/fetch-pass_requests.js') }}"></script>
        <script src="{{ asset('js/Account/change-new_pass.js') }}"></script>
        <script src="{{ asset('js/Datatables/search-filter.js') }}"></script>
        <script src="{{ asset('js/Filters/clear-filters.js') }}"></script>
        <script src="{{ asset('js/activityLogs.js') }}"></script>

       
        <script src="{{ asset('js/Projects/trashProjects.js') }}"></script>
        <script src="{{ asset('js/Projects/updateProjects.js') }}"></script>
        <script src="{{ asset('js/Projects/restoreProjects.js') }}"></script>
        <script src="{{ asset('js/Projects/generateProject.js') }}"></script>
        <script src="{{ asset('js/Projects/fetchProjectStatus.js') }}"></script>
        <script src="{{ asset('js/Projects/addNewProjectStatus.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-total_savings.js') }}"></script>


        <script src="{{ asset('js/Filters/clear-filters.js') }}"></script>
        <script src="{{ asset('js/Filters/location-search.js') }}"></script>
        <script src="{{ asset('js/Filters/contractor-search.js') }}"></script>
        <script src="{{ asset('js/Filters/sourceOfFund-search.js') }}"></script>
        <script src="{{ asset('js/Filters/engineer-search.js') }}"></script>  

         <script src="{{ asset('js/Files/uploadFiles.js') }}"></script>
        <script src="{{ asset('js/Files/downloadFile.js') }}"></script>
        <script src="{{ asset('js/Files/deleteFile.js') }}"></script>
        <script src="{{ asset('js/Account/logout.js') }}"></script>

        @yield('page-scripts') <!-- Add this line here -->

    </body>
</html>


     <!-- Update Project Modal -->
     <div class="modal fade" id="filterSearch" tabindex="-1" aria-labelledby="newProjectLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="newProjectLabel"><span class="fa fa-filter"></span>&nbsp;Filter</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <!-- Date Range -->
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label for="dateRangeStart" class="form-label fw-bolder">Date Range</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="date" id="dateRangeStart" class="form-control flex-grow-1" placeholder="Start Date">
                                        <span>-</span>
                                        <input type="date" id="dateRangeEnd" class="form-control flex-grow-1" placeholder="End Date">
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- Source of Fund -->
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label fw-bolder">Source of Fund</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="trustFund">
                                        <label class="form-check-label" for="trustFund">Trust Fund</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="rfFund">
                                        <label class="form-check-label" for="rfFund">RF</label>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- Project Status -->
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label fw-bolder">Project Status</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="ongoing">
                                        <label class="form-check-label" for="ongoing">On-going</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="completed">
                                        <label class="form-check-label" for="completed">Completed</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="discontinued">
                                        <label class="form-check-label" for="discontinued">Discontinued</label>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- Amount Range -->
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label fw-bolder">Amount Range</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="number" id="min" class="form-control flex-grow-1" placeholder="Min">
                                        <span>-</span>
                                        <input type="number" id="max" class="form-control flex-grow-1" placeholder="Max">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
