$(document).ready(function() {
    $(document).on('submit', '#loginForm', function(event){
        event.preventDefault();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/login", // Matches Laravel route
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if(response == 1){
                    console.log("Redirecting to:", "/main/index"); // Debugging

                    Swal.fire({
                        icon: "success",
                        title: "Logging in!",
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(function(){
                        window.location = "/main/index";
                    });
                }else if(response.message){
                    var errorMessages = Object.values(response.message).join('<br>');
                    Swal.fire({
                        icon: 'error',
                        title: 'Login validation failed!',
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }else if(response == 401){
                    Swal.fire({
                        icon: 'error',
                        title: 'Login failed!',
                        text: 'Invalid username or password!',
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }else if(response == 404){
                    Swal.fire({
                        icon: 'error',
                        title: 'Login failed!',
                        text: 'Invalid username or password!',
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }else if(response == 402){
                    Swal.fire({
                        icon: 'error',
                        title: 'Login failed!',
                        text: 'Your account was deactivated, please contact the administrator thank you!',
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!',
                        text: 'Please try again later!',
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            },
            error: function(xhr) {
                console.log(xhr.responseJSON);
            }

        });
    });
});
