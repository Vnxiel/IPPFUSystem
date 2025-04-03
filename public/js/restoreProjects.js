$(document).ready(function() {
  // Function to Restore a Project
  $(document).on('click', '.restore-btn', function() {
    let projectID = $(this).data('id');

    Swal.fire({
        title: "Restore Project?",
        text: "Are you sure you want to restore this project?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, restore it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/projects/restore/${projectID}`,
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    if (response.status === "success") {
                        Swal.fire("Restored!", "The project has been restored.", "success")
                            .then(() => fetchTrashedProjects()); // Refresh table without reloading
                    } else {
                        Swal.fire("Error!", response.message, "error");
                    }
                },
                error: function() {
                    Swal.fire("Error!", "Failed to restore the project. Please try again.", "error");
                }
            });
        }
    });
});
});