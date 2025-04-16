<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPPFU</title>
    <!-- Bootstrap CSS -->


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts & FontAwesome -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.css" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.min.css">

    <link href="{{ asset('css/ippfu-css.css') }}" rel="stylesheet">

</head>
<!-- <body style="background-color: #F8F2DE;" class="montserrat"> -->

<body class="montserrat d-flex flex-column min-vh-100">
    <div class="wrapper d-flex flex-column flex-grow-1">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg rounded" style="background-color: #F8F2DE;"
            aria-label="Thirteenth navbar example">
            <div class="container-fluid">
                <button class="navbar-toggler" style="background-color: #F8F2DE;" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarsExample11" aria-controls="navbarsExample11"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse d-lg-flex" id="navbarsExample11">
                    <a href="{{ url('/staff/index') }}"
                        class="navbar-brand col-lg-3 me-0 d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                        <img src="{{ asset('img/temp_logo.png') }}" alt="Logo" width="50" height="40"
                            class="img-fluid d-inline-block align-text-top me-2">
                        <div>
                            <h5 class="mb-0">Provincial Engineering Office</h5>
                            <h6 class="mt-0">Province of Nueva Vizcaya</h6>
                        </div>
                    </a>

                    <ul class="navbar-nav col-lg-6 justify-content-lg-center">
                        <li class="nav-item">
                            <a class="nav-link active {{ Request::is('staff/index') ? 'fw-bold text-danger' : 'inactive' }}"
                                aria-current="page" href="{{ url('/staff/index') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active {{ Request::is('staff/projects') ? 'fw-bold text-danger' : 'inactive' }} || {{ Request::is('staff/overview') ? 'fw-bold text-danger' : 'inactive' }}"
                                aria-current="page" href="{{ url('/staff/projects') }}">Projects</a>
                        </li>
                    </ul>
                    <div class="d-lg-flex align-items-center justify-content-lg-end col-lg-3 gap-3 pe-lg-3">
                        <div class="dropdown">
                            <a href="#" id="dropdownMenuButton"
                                class="d-block link-body-emphasis text-decoration-none dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                <span class="fa fa-user me-1"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end text-small" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="javascript:void(0);" onclick="logout()">Sign out</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="container-fluid flex-grow-1">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center p-2 bg-light mt-auto">
        <p>&copy; {{ date('Y') }} PEO. All Rights Reserved.</p>
    </footer>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Your Custom Scripts -->
    <script src="{{ asset('js/Account/getData.js') }}"></script>
    <script src="{{ asset('js/Account/load-data.js') }}"></script>
    <script src="{{ asset('js/Account/projects.js') }}"></script>
    <script src="{{ asset('js/Account/logout.js') }}"></script>

</body>

</html>