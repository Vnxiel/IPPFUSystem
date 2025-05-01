$(document).ready(function () {
    // Fetch status before showing modal
    $(document).on("click", "#addStatusBtnInside", function () {
        const project_id = sessionStorage.getItem("project_id");
      
        if (!project_id) {
            return Swal.fire({ icon: "error", title: "Missing Info", text: "Cannot load project." });
        }

        // ✅ FIXED: Missing backtick added
        $.get(`/project-status/${encodeURIComponent(project_id)}`, function (response) {
            if (["Completed", "Discontinued"].includes(response.projectStatus)) {
                return Swal.fire({
                    icon: "warning",
                    title: "Status Locked",
                    text: "This project is already completed or discontinued.",
                    confirmButtonText: "OK"
                });
            }

            // Store current latest status data in memory
            sessionStorage.setItem("latestStatusData", JSON.stringify({
                percentage: parseFloat(response.latestPercentage ?? 0),
                date: response.updatedAt
            }));

            // Fill modal fields
            $("#projectID").text(project_id);
            $("#progress").val("Ongoing");
            $("#percentage").val("");
            $("#autoDate").prop("checked", true);
            $("#date").prop("disabled", true).val(new Date().toISOString().split("T")[0]);

            $("#addStatusModal").modal("show");
        });
    });

    // Toggle auto/manual date input
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
        const percentage = parseFloat($("#percentage").val());
        const date = $("#autoDate").is(":checked")
            ? new Date().toISOString().split("T")[0]
            : $("#date").val();

        // ✅ FIXED: Allow 0 and properly validate number
        if (isNaN(percentage) || percentage < 0 || percentage > 100) {
            return Swal.fire({
                icon: "warning",
                title: "Invalid Percentage",
                text: "Please enter a valid percentage between 0 and 100."
            });
        }

        const latestStatus = JSON.parse(sessionStorage.getItem("latestStatusData") || "{}");

        // ✅ ENFORCE strictly greater condition
        if (latestStatus.percentage !== undefined && (
            percentage <= latestStatus.percentage ||
            new Date(date) <= new Date(latestStatus.date)
        )) {
            return Swal.fire({
                icon: "error",
                title: "Invalid Update",
                text: "New percentage and date must be strictly greater than the latest entry.",
                confirmButtonText: "OK"
            });
        }
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: `/project-status/addStatus`,
            method: "POST",
            data: { project_id, progress, percentage, date },
            success: function () {
                Swal.fire({ icon: "success", title: "Status Added" }).then(() => {
                    $("#addStatusModal").modal("hide");
                    fetchProjectStatus(project_id);
                    location.reload();
                });
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Failed",
                    text: "Could not update status. Please try again later."
                });
            }
        });
        
    });
});
