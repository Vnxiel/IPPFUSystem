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
                // Check the role in the response
                if (response.role === 'System Admin') {
                    console.log("Redirecting to:", "/systemAdmin/index"); // Debugging
                    Swal.fire({
                        icon: "success",
                        title: "Logging in!",
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(function(){
                        window.location = "/systemAdmin/index";
                    });
                } else if (response.role === 'Admin') {
                    Swal.fire({
                        icon: "success",
                        title: "Logging in!",
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(function(){
                        window.location = "/admin/index"; // Redirect to admin page
                    });
                } else if (response.role === 'Staff') {
                    Swal.fire({
                        icon: "success",
                        title: "Logging in!",
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(function(){
                        window.location = "/staff/index"; // Redirect to staff page
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login failed!',
                        text: 'Unknown role or invalid credentials!',
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
