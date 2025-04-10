$("#submitStatusForm").on("submit", function (e) {
    e.preventDefault();
    const progress = $("#progress").val();
    const percentage = $("#percentage").val();
    const date = $("#date").val();
    const projectID = $("#projectID").text(); // Get project ID from modal
    const projectTitle = $("#projectTitle").text(); // Get project title from modal

    // Send data to server
    $.ajax({
        url: "/update-project-status",  // Endpoint to update status
        method: "POST",
        data: {
            projectID: projectID,
            progress: progress,
            percentage: percentage,
            date: date,
            projectTitle: projectTitle  // Optionally send project title
        },
        success: function (response) {
            console.log("Status updated successfully!");
            // Close modal after submission
            $("#statusModal").modal("hide");
            // Optionally, refresh project status
            fetchProjectStatus(projectID, projectTitle);
        },
        error: function (xhr, status, error) {
            console.error("Error updating status:", error);
        }
    });
});
