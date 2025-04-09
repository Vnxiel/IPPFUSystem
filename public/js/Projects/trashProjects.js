$(document).ready(function() {
    $(document).on("click", "#trashProjectBtn", function() {
        Swal.fire({
            title: "Are you sure?",
            text: "This project will be archived (hidden). You can restore it later.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, archive it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Fetch project ID
                $.ajax({
                    url: "/get-project-id",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (!response.projectID) {
                            console.error("No project ID found in session.");
                            Swal.fire("Error!", "Project ID not found.", "error");
                            return;
                        }

                        let projectID = response.projectID;
                        console.log("Retrieved Project ID:", projectID);

                        // Archive the project
                        $.ajax({
                            url: `/projects/trash/${projectID}`,
                            method: "PUT",
                            contentType: "application/json",
                            data: JSON.stringify({ is_hidden: 1 }),
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                            },
                            success: function(data) {
                                if (data.status === "success") {
                                    Swal.fire("Archived!", "The project has been hidden.", "success")
                                        .then(() => {
                                            window.location.href = "/main/trash"; // Ensure correct Laravel route
                                        });
                                } else {
                                    Swal.fire("Error!", data.message || "Something went wrong!", "error");
                                }
                            },
                            error: function(xhr) {
                                console.error("Error hiding project:", xhr.responseText);
                                Swal.fire("Error!", "Failed to archive the project. Please try again.", "error");
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error("Project ID Fetch Error:", xhr.responseText);
                        Swal.fire("Error!", "Failed to retrieve project ID. Please try again.", "error");
                    }
                });
            }
        });
    });
});
