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
                // Save role to sessionStorage
                sessionStorage.setItem('user_role', response.role);

                Swal.fire({
                    icon: "success",
                    title: "Logging in...",
                    showConfirmButton: false,
                    timer: 2000,
                }).then(function(){
                    // Redirect based on backend-provided URL
                    window.location = response.redirect;
                });
            },
            error: function(xhr) {
                let errorMsg = 'An unexpected error occurred.';

                if (xhr.status === 404) {
                    errorMsg = 'User does not exist.';
                } else if (xhr.status === 401) {
                    errorMsg = 'Username or password is incorrect.';
                } else if (xhr.status === 403) {
                    errorMsg = 'Unauthorized role. Contact system administrator.';
                } else if (xhr.status === 422 && xhr.responseJSON?.message) {
                    errorMsg = Object.values(xhr.responseJSON.message).flat().join('\n');
                } else if (xhr.responseJSON?.error) {
                    errorMsg = xhr.responseJSON.error;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Login failed!',
                    text: errorMsg,
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    });
});


    $(document).on('click', '#toggleLoginPassword', function () {
        const input = $('#password');
        const type = input.attr('type') === 'password' ? 'text' : 'password';
        input.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });


