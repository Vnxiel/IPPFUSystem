$(document).ready(function() {
    $("#confirmGenerateBtn").click(function(event) {
        event.preventDefault();

        // Fetch project ID first
        $.ajax({
            url: "/get-project-id", // Ensure this route exists in Laravel
            method: "GET",
            dataType: "json",
            success: function(response) {
                if (!response.projectID) {
                    Swal.fire({
                        title: "Error",
                        text: "No project ID found. Please select a project first.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                let projectID = response.projectID;
                console.log("Retrieved Project ID:", projectID);

                // Close the modal before redirecting
                $("#generateProjectModal").modal("hide");

                // Redirect to the PDF generation route
                window.location.href = "/generateProject/" + projectID;

            },
            error: function(xhr) {
                console.error("Project ID Fetch Error:", xhr.responseText);
                Swal.fire({
                    title: "Error",
                    text: "Failed to retrieve project ID. Please try again.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    });
});
