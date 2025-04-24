$(document).ready(function () {
    $(document).on("submit", "#registerForm", function (e) {
        e.preventDefault();

        // Check if passwords match before submitting
        const password = $('#password').val();
        const confirmPassword = $('#password_confirmation').val();

        if (password !== confirmPassword) {
            Swal.fire({
                icon: "warning",
                title: "Password Mismatch",
                text: "Password and Confirm Password do not match. Please check and try again.",
            });
            return; // Stop the form from submitting
        }

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/registerSystemAdmin",
            method: "POST",
            data: $(this).serialize(),
            success: function (response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.message + " registered successfully.",
                    }).then(() => {
                        window.location.href = "/";
                    });
                } else if (response.status == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Warning!",
                        text: "Registration failed. Please try again.",
                    });
                } else if (response.status == 2) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "An error occurred while saving your data.",
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Server Error!",
                    text: "Something went wrong. Please try again later.",
                });
            }
        });
    });

    // Show/hide password toggle
    $(document).on('click', '.toggle-password', function () {
        const targetInput = $($(this).data('target'));
        const type = targetInput.attr('type') === 'password' ? 'text' : 'password';
        targetInput.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
});
