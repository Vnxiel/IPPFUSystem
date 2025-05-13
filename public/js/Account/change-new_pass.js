$(document).ready(function () {
    // Auto-fill user ID when modal is shown
    $('#changePassModal').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const userId = button.data('id');
        $('#change-password-user-id').val(userId);
    });

    // Toggle password visibility
$('.toggle-password').on('click', function () {
    const targetId = $(this).data('target');
    const input = $('#' + targetId);
    const icon = $(this).find('i');

    if (input.attr('type') === 'password') {
        input.attr('type', 'text');
        icon.removeClass('bi-eye-slash').addClass('bi-eye');
    } else {
        input.attr('type', 'password');
        icon.removeClass('bi-eye').addClass('bi-eye-slash');
    }
});

// Form submission with SweetAlert validation
$('#changePassModal form').on('submit', function (e) {
    e.preventDefault();

    const userId = $('#change-password-user-id').val().trim();
    const newPassword = $('#newPassword').val().trim();
    const confirmPassword = $('#confirmPassword').val().trim();

    if (!newPassword || !confirmPassword) {
        Swal.fire({
            icon: "warning",
            title: "Missing Fields",
            text: "Please enter both password fields."
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

    // Proceed with AJAX request
    $.ajax({
        url: '/password/change-password',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            user_id: userId,
            new_password: newPassword,
            confirm_password: confirmPassword
        },
        success: function (res) {
            if (res.success) {
                Swal.fire({
                    icon: "success",
                    title: "Password Changed",
                    text: "User password has been updated and emailed."
                });
                $('#changePassModal').modal('hide');
                $('#changePassModal form')[0].reset();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: res.message || "Password change failed."
                });
            }
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            Swal.fire({
                icon: "error",
                title: "Server Error",
                text: "Something went wrong. Please try again."
            });
        }
    });
});

});
