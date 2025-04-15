$(document).ready(function () {
    // Delegate click event for dynamically added button
    $(document).on("click", "#addStatusBtnInside", function () {
        const project_id = sessionStorage.getItem("project_id");
        const projectDetails = JSON.parse(sessionStorage.getItem("projectDetails"));

        if (!project_id || !projectDetails) {
            Swal.fire({
                icon: "error",
                title: "Missing Project Info",
                text: "Cannot load project details. Please try again or reload the page.",
                confirmButtonText: "OK"
            });
            return;
        }

        // Set modal fields
        $("#projectTitleDisplay").text(projectDetails.projectTitle || "Untitled Project");
        $("#projectID").text(project_id);

        // Set default values
        $("#progress").val("Ongoing");
        $("#percentage").val("");
        $("#autoDate").prop("checked", true);
        $("#date").prop("disabled", true).val(new Date().toISOString().split("T")[0]);

        // Show modal
        $("#addStatusModal").modal("show");
    });

    // Handle checkbox to toggle date input
    $("#autoDate").on("change", function () {
        if ($(this).is(":checked")) {
            $("#date").prop("disabled", true).val(new Date().toISOString().split("T")[0]);
        } else {
            $("#date").prop("disabled", false).val("");
        }
    });

    // Handle form submission
    $("#addStatusForm").on("submit", function (e) {
        e.preventDefault();

        const project_id = sessionStorage.getItem("project_id");
        const progress = $("#progress").val();
        const percentage = $("#percentage").val();
        const date = $("#autoDate").is(":checked") 
            ? new Date().toISOString().split("T")[0] 
            : $("#date").val();

        if (!percentage || isNaN(percentage) || percentage < 0 || percentage > 100) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Percentage",
                text: "Please enter a valid percentage between 0 and 100.",
                confirmButtonText: "OK"
            });
            return;
        }

        // You can send the data to your backend here
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: `/project-status/addStatus`,
            method: "POST",
            data: {
                project_id,
                progress,
                percentage,
                date
            },
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Status Added",
                    text: "Project status successfully updated.",
                    confirmButtonText: "OK"
                });
                $("#addStatusModal").modal("hide");
                // Optionally, refresh status cards:
                fetchProjectStatus(project_id);
            },
            error: function (xhr) {
                console.error("Status update failed:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Failed to Add Status",
                    text: "An error occurred. Please try again later.",
                    confirmButtonText: "OK"
                });
            }
        });
    });
});
