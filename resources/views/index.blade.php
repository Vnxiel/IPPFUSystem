<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>IPPFU</title>
        <style>
            .montserrat{
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            /* font-weight: <weight>; */
            font-style: normal;
            }
        </style>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" type="image/x-icon" href="{{ asset('img/temp_logo.png') }}">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css" rel="stylesheet">
    </head>
    <body style="background-color: #F8F2DE;" class="montserrat">
        <div class="container-fluid">
            <div class="position-absolute top-50 start-50 translate-middle">
                <div class="mx-auto d-block">
                    <div class="card shadow-lg" style="width: 25rem;">
                        <div class="card-header bg-light p-2" style="font-size: 10px;">
                            &copy; 2022 - Provincial Information Technology Division
                        </div>
                        <div class="text-center p-3">
                            <img src="{{ asset('img/temp_logo.png') }}" style="height:9rem; width:10rem" class="img-fluid rounded">
                        </div>
                        <div class="text-center m-3" style="background-color: #006400; padding: 10px">
                            <div style="font-size: 40px; color: white; font-family: 'Times New Roman', serif; font-weight: bold;">.PGIS.</div>
                            <div style="color: #FFD700; font-family: Arial, sans-serif;">Provincial Government Information System</div>
                        </div>
                        <div class="text-center pt-2">
                            <div style="color:#006400;"> Login to Access (IPPFUv1.1.0.0.413)</div>
                        </div>
                        <div class="card-body">
                        <form id="loginForm" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="username" class="form-control" placeholder="Username" aria-label="Username" id="username" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Password" aria-label="Password" id="password" required>
                                <span class="input-group-text" style="cursor:pointer;">
                                    <i class="fa fa-eye toggle-password" id="toggleLoginPassword"></i>
                                </span>
                            </div>
                            <div class="d-flex justify-content-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                                </div>
                            </div>
                            <button type="submit" class="btn w-100" style="background-color:#006400; color:white;">Login</button>
                        </form>
                        </div>
                        <div class="card-footer d-flex align-items-center" style="font-size: 0.750rem;">
                            <span class="me-2">Forgot Password?</span>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#passwordRequestModal">Request new password.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
        <script src="{{ asset('js/Account/login.js') }}"></script>
        <script src="{{ asset('js/Account/request-user_pass.js') }}"></script>
        <script src="{{ asset('js/Account/fetch-pass._requests.js') }}"></script>
    </body>
</html>

@include('systemAdmin.modals.Account.request-newpass')

