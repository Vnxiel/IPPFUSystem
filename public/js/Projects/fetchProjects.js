function fetchProjectDetails() {
    $.ajax({
        url: "/get-project-id",
        method: "GET",
        dataType: "json",
        success: function(response) {
            if (!response.projectID) {
                console.error("No project ID found in session. Redirecting...");
                window.location.href = "/main/index"; // Ensure correct Laravel route
                return;
            }

            let projectID = response.projectID;
            console.log("Project ID:", projectID);

            // Fetch project details
            $.ajax({
                url: `/projects/getProject/${projectID}`,
                method: "GET",
                dataType: "json",
                success: function(data) {
                    if (data.status === "success") {
                        console.log("Fetched Project Data:", data.project);
                        updateProjectUI(data.project); // Populate UI
                        updateProjectForm(data.project); // Populate form in modal
                    } else {
                        console.error("Error fetching project details:", data.message);
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching project data:", xhr.responseText);
                }
            });
        },
        error: function(xhr) {
            console.error("Error fetching project ID:", xhr.responseText);
        }
    });
}
