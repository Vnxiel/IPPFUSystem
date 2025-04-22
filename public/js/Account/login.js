$(document).ready(function() { 
    $(document).on('submit', '#loginForm', function(event){
        event.preventDefault();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "/login",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                // Store role in sessionStorage
                sessionStorage.setItem('user_role', response.role);

                Swal.fire({
                    icon: "success",
                    title: "Logging in!",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(function(){
                    if (response.role === 'System Admin') {
                        window.location = "/systemAdmin/index";
                    } else if (response.role === 'Admin') {
                        window.location = "/admin/index";
                    } else if (response.role === 'Staff') {
                        window.location = "/staff/index";
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Login failed!',
                            text: 'Unknown role or invalid credentials!',
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                });
            },
            error: function(xhr) {
                let errorMsg = 'An unexpected error occurred.';

                if (xhr.status === 422 && xhr.responseJSON?.message) {
                    // Laravel validation error
                    errorMsg = Object.values(xhr.responseJSON.message).flat().join('\n');
                } else if (xhr.responseJSON?.error) {
                    errorMsg = xhr.responseJSON.error;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Login failed!',
                    text: errorMsg,
                    showConfirmButton: false,
                    timer: 3000,
                });
            }
        });
    });
});
