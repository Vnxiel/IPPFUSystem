$(document).ready(function() {
    $(document).on("submit", "#registerForm", function(e) {
        e.preventDefault();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/register",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "System Admin saved successfully."
                    }).then(() => {
                        window.location.href = "{{ route('/index') }}";
                    });
                } else if (response == 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Validation Error!",
                        text: "Please check all fields."
                    });
                } else if (response == 2) {
                    Swal.fire({
                        icon: "error",
                        title: "Database Error!",
                        text: "An error occurred while saving the data."
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
