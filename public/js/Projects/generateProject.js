$(document).ready(function () {
    $("#confirmGenerateBtn").click(function (event) {
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

        // Open PDF in a new tab
        window.open("/generateProject/" + projectID, "_blank");
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

        // Open PDF with pictures in a new tab
        window.open("/generateProject/" + projectID + "?with_pictures=true", "_blank");
    });
});
