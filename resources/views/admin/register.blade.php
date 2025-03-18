<!doctype html>
<html lang="en">
    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title</title>
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
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.min.css" rel="stylesheet">
    </head>
    <body style="background-color: #F8F2DE;" class="montserrat">
        <div class="container-fluid">
            <div class="position-absolute top-50 start-50 translate-middle">
                <div class="mx-auto d-block">
                    <div class="card p-3 shadow-lg" style="width: 25rem;">
                        <div class="text-center">
                            <img src="{{ asset('img/temp_logo.png') }}" style="height:9rem; width:10rem" class="img-fluid rounded">
                            <div class="h5">Provincial Engineering Office</div>
                            <div class="h6">Province of Nueva Vizcaya</div>
                        </div>
                        <form action="" id="registerForm">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="fullname" class="form-label fw-bolder">Full Name:</label>
                                                        <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Full Name" required>
                                                        @error('fullname') <small class="text-danger">{{ $message }}</small> @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="position" class="form-label fw-bolder">Position:</label>
                                                    <input type="text" class="form-control" name="position" id="position" aria-describedby="position" placeholder="Position" required>
                                                    @error('position') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="username" class="form-label fw-bolder">Username:</label>
                                                    <input type="text" class="form-control" name="username" id="username" aria-describedby="username" placeholder="Username" required>
                                                    @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="password" class="form-label fw-bolder">Password:</label>
                                                    <input type="password" class="form-control" name="password" id="password" aria-describedby="password" placeholder="Password"  required minlength="6" required>
                                                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="password_confirmation" class="form-label fw-bolder">Confirm Password:</label>
                                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" aria-describedby="password_confirmation" placeholder="Confirm Password"  required minlength="6" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- OFMIS Button -->
                                    <div class="col-md-3 p-2">
                                        <button type="button" class="btn btn-primary" id="ofmisBtn">
                                            <span class="fa-solid fa-user-group"></span>OFMIS
                                        </button>
                                    </div>    
                                </div>
                            </div>
                        </div> 
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>

        <script src="{{ asset('js/register.js') }}"></script>
    </body>
</html>

