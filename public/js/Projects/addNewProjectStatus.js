$(document).ready(function () {
    // Handle Add Status button click
    $(document).on("click", "#addStatusBtn", function () {
        const project_id = sessionStorage.getItem("project_id");

        if (!project_id) {
            return Swal.fire({ icon: "error", title: "Missing Info", text: "Cannot load project." });
        }

        // Clear previous inputs
        $("#progress").val("");
        $("#percentage").val("");
        $("#autoDate").prop("checked", true).trigger("change");

        // Show the Add Status Modal
        $("#addStatusModal").modal("show");
    });

    // Toggle manual date
    $("#autoDate").on("change", function () {
        if ($(this).is(":checked")) {
            $("#date").prop("disabled", true).val(new Date().toISOString().split("T")[0]);
        } else {
            $("#date").prop("disabled", false).val("");
        }
    });

    // Submit new status
    $("#addStatusForm").on("submit", function (e) {
        e.preventDefault();

        const project_id = sessionStorage.getItem("project_id");
        const progress = $("#progress").val();
        const percentage = parseFloat($("#percentage").val());
        const date = $("#autoDate").is(":checked")
            ? new Date().toISOString().split("T")[0]
            : $("#date").val();

            if (isNaN(percentage) || percentage < 0 || percentage > 100) {
                return Swal.fire({
                    icon: "warning",
                    title: "Invalid Percentage",
                    text: "Please enter a value between 0 and 100."
                });
            }
            
            if (percentage === 0) {
                return Swal.fire({
                    icon: "warning",
                    title: "Invalid Progress",
                    text: "0% progress is not allowed."
                });
            }
            

        if (percentage === 100 && progress.trim().toLowerCase() !== "completed") {
            return Swal.fire({
                icon: "warning",
                title: "Status Mismatch",
                text: 'Progress must be set to "Completed" if percentage is 100%.'
            });
        }

        if (progress.trim().toLowerCase() === "completed" && percentage < 100) {
            return Swal.fire({
                icon: "warning",
                title: "Percentage Mismatch",
                text: 'Percentage must be 100% if progress is marked "Completed".'
            });
        }

        const latestStatus = JSON.parse(sessionStorage.getItem("latestStatusData") || "{}");

        if (latestStatus.percentage !== undefined) {
            const lastDate = new Date(latestStatus.date).toISOString().split("T")[0];
            const newDate = new Date(date).toISOString().split("T")[0];

            if (latestStatus.percentage === 100) {
                return Swal.fire({
                    icon: "error",
                    title: "Invalid Status",
                    text: "Cannot add updates after project is already completed (100%)."
                });
            }

            if (percentage <= latestStatus.percentage) {
                return Swal.fire({
                    icon: "error",
                    title: "Invalid Percentage",
                    text: "New percentage must be greater than the last recorded percentage."
                });
            }

            if (newDate <= lastDate) {
                return Swal.fire({
                    icon: "error",
                    title: "Invalid Date",
                    text: "New status date must be later than the last recorded date."
                });
            }
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
                    location.reload();
                });
            },
            error: function (xhr) {
                console.error(xhr.responseText);

                let errorMessage = "Could not update status. Please try again later.";
                try {
                    const response = JSON.parse(xhr.responseText);

                    // Concatenate all validation messages into a single string
                    if (response.errors) {
                        errorMessage = Object.values(response.errors).flat().join("\n");
                    } else if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error("Failed to parse error response:", e);
                }

                Swal.fire({
                    icon: "error",
                    title: "Error Adding New Status",
                    text: errorMessage
                });
            }
        });
    });
});
