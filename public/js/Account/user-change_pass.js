$(document).ready(function () {
    $('#getOtpBtn').on('click', function () {
        const username = $('#username').val().trim();

        if (!username) {
            Swal.fire({
                icon: "warning",
                title: "Missing Username",
                text: "Please enter your username to receive an OTP."
            });
            return;
        }

        $.ajax({
            url: '/password/send-otp',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { username: username },
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        icon: "success",
                        title: "OTP Sent",
                        text: res.message
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Something went wrong. Please try again."
                });
            }
        });
    });

    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault();

        const username = $('#username').val().trim();
        const otp = $('#otp').val().trim();
        const newPassword = $('#newPassword').val().trim();
        const confirmPassword = $('#confirmPassword').val().trim();

        if (!username || !otp || !newPassword || !confirmPassword) {
            Swal.fire({
                icon: "warning",
                title: "Missing Fields",
                text: "Please fill in all required fields."
            });
            return;
        }

        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: "error",
                title: "Mismatch",
                text: "Passwords do not match. Please try again."
            });
            return;
        }

        $.ajax({
            url: '/password/change-password',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                username: username,
                otp: otp,
                new_password: newPassword,
                confirm_password: confirmPassword
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Password Changed",
                        text: res.message
                    });
                    $('#changePassword-LoginModal').modal('hide');
                    $('#changePasswordForm')[0].reset();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message
                    });
                }
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Something went wrong. Please try again."
                });
            }
        });
    });
});
