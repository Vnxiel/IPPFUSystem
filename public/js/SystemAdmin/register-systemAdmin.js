$(document).ready(function() {
    $(document).on("submit", "#registerForm", function(e) {
        e.preventDefault();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/registerSystemAdmin",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.message + "  registered successfully.",
                    }).then(() => {
                        window.location.href = "/";
                    });
                } else if (response.status == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Warning!",
                        text: "Please try again."
                    }); 
                } else if (response.status == 2) {
                    Swal.fire({
                        icon: "error",
                        title: "Warning!",
                        text: "An error occurred while saving your data."
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: "error",
                    title: "Server Error!",
                    text: "Something went wrong. Please try again later."
                });
            }
        });
    });
});

$(document).on('click', '.toggle-password', function () {
    const input = $(this).prev('input');
    const type = input.attr('type') === 'password' ? 'text' : 'password';
    input.attr('type', type);
    $(this).toggleClass('fa-eye fa-eye-slash');
});
