$(document).ready(function () {
    $("#confirmGenerateBtn").click(function (event) {
        event.preventDefault();

        // Get project ID from sessionStorage
        let projectID = sessionStorage.getItem("project_id");

        if (!projectID) {
            Swal.fire({
                title: "Error",
                text: "No project ID found. Please select a project first.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return;
        }

        console.log("Retrieved Project ID from sessionStorage:", projectID);

        // Close the modal before redirecting
        $("#generateProjectModal").modal("hide");

        // Redirect to the PDF generation route
        window.location.href = "/generateProject/" + projectID;
    });

    $("#generatePdfWithPicsBtn").click(function (event) {
        event.preventDefault();
        let projectID = sessionStorage.getItem("project_id");
    
        if (!projectID) {
            Swal.fire({
                title: "Error",
                text: "No project ID found. Please select a project first.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return;
        }
    
        $("#generateProjectModal").modal("hide");
        window.location.href = "/generateProject/" + projectID + "?with_pictures=true";
    });
    
});
