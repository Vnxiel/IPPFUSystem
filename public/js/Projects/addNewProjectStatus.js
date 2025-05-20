$(document).ready(function () {
    // Handle Add Status button click
    $(document).on("click", "#addStatusBtn", function () {
        const project_id = sessionStorage.getItem("project_id");

        if (!project_id) {
            return Swal.fire({ icon: "error", title: "Missing Info", text: "Cannot load project." });
        }

        // Clear previous inputs
        $("#progress").val("");
        $("#percentage").val("").prop("disabled", false);
        $("#autoDate").prop("checked", true).trigger("change");

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

    // Handle progress change (e.g., Completed auto-fills percentage)
    $("#progress").on("change", function () {
        const selected = $(this).val();
        const statusData = JSON.parse(sessionStorage.getItem("latestStatusData") || "{}");
        const prevPercentage = parseFloat(statusData.percentage || 0);
        const remaining = 100 - prevPercentage;

        if (selected === "Completed") {
            $("#percentage").val(remaining).prop("disabled", true);
        } else {
            $("#percentage").val("").prop("disabled", false);
        }
    });

    // Submit new status
    $("#addStatusForm").on("submit", function (e) {
        e.preventDefault();

        const project_id = sessionStorage.getItem("project_id");
        const progress = $("#progress").val();
        let percentage = parseFloat($("#percentage").val());
        const statusData = JSON.parse(sessionStorage.getItem("latestStatusData") || "{}");
        const prevPercentage = parseFloat(statusData.percentage || 0);
        const remaining = 100 - prevPercentage;

        if (progress === "Completed") {
            percentage = remaining;
        }

        const date = $("#autoDate").is(":checked")
            ? new Date().toISOString().split("T")[0]
            : $("#date").val();

        if (!progress || isNaN(percentage) || percentage <= 0 || percentage > 100) {
            return Swal.fire({
                icon: "warning",
                title: "Invalid Input",
                text: "Please provide valid progress and percentage (1-100)."
            });
        }

        if (percentage > remaining) {
            return Swal.fire({
                icon: "warning",
                title: "Exceeded Limit",
                text: `Only ${remaining}% progress is remaining.`
            });
        }

        if (statusData.date) {
            const lastDate = new Date(statusData.date).toISOString().split("T")[0];
            const newDate = new Date(date).toISOString().split("T")[0];

            if (newDate <= lastDate) {
                return Swal.fire({
                    icon: "error",
                    title: "Invalid Date",
                    text: `New status date must be later than the last recorded date: ${lastDate}.`
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
