$(document).ready(function() {
    console.log("JS loaded ✅"); // Debug

    $('#requestPassForm').on('submit', function(e) {
        e.preventDefault(); // ✅ Prevent native submission

        let form = $(this);
        let formData = form.serialize();

        $.ajax({
            url: '/password/request',
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: "Password change request sent successfully."
                    });
                    form.trigger('reset');
                    $('#passwordRequestModal').modal('hide');
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: 'Error: ' + data.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Request Failed",
                    text: "An unexpected error occurred."
                });
                console.error(xhr.responseText);
            }
        });
    });
});

