function fetchProjectDetails() {
    
    const project_id = sessionStorage.getItem("project_id");

    // Fetch project details directly using stored ID
    $.ajax({
        url: `/projects/getProject/${project_id}`,
        method: "GET",
        dataType: "json",
        success: function(data) {
            if (data.status === "success") {
                // Store project details in sessionStorage
                sessionStorage.setItem("projectDetails", JSON.stringify(data.project));
                
                // Optionally populate UI directly
                updateProjectUI(data.project); 
                updateProjectForm(data.project); 
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
