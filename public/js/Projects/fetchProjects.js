function fetchProjectDetails() {
    const project_id = sessionStorage.getItem("project_id"); // You may still need this line if the ID is stored here

    if (!project_id) {
        console.error("Project ID not found in sessionStorage.");
        return;
    }

    $.ajax({
        url: `/projects/getProject/${project_id}`,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.status === "success") {
                const project = data.project;

                updateProjectUI(project);
                updateProjectForm(project);
            } else {
                console.error("Error fetching project details:", data.message);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to load project details. Please try again.",
                    confirmButtonText: "OK"
                });
            }
        },
        error: function(xhr) {
            console.error("Error fetching project data:", xhr.responseText);
            Swal.fire({
                icon: "error",
                title: "Request Failed",
                text: "Could not connect to the server. Please try again later.",
                confirmButtonText: "OK"
            });
        }
    });
}
