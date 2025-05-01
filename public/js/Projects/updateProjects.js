$(document).ready(function () {
    $("#updateProjectForm").on("submit", function (event) {
        event.preventDefault();

        // Fetch projectID from sessionStorage
        let project_id = sessionStorage.getItem("project_id");

        if (!project_id) {
            Swal.fire({
                title: "Error",
                text: "No project ID found in session. Please select a project first.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return;
        }

        console.log("Retrieved Project ID:", project_id);

        let updatedData = {};
        let fieldIDs = [
            "projectTitle", "projectLoc", "projectID", "projectContractor", "sourceOfFunds", "modeOfImplementation",
            "projectDescription", "projectContractDays", "noticeOfAward",
            "noticeToProceed", "officialStart", "targetCompletion", "timeExtension", "revisedTargetCompletion",
            "completionDate", "abc", "contractAmount", "engineering", "mqc", "contingency", "bid", "appropriation",
            "noaIssuedDate", "noaReceivedDate", "ntpIssuedDate", "ntpReceivedDate", "totalExpenditure", "projectSlippage", "ea", "ea_position", "ea_monthlyRate", "othersContractor"
        ];

        // Collect fixed fields
        fieldIDs.forEach(id => {
            let input = $("#" + id);
            updatedData[id] = input.length ? input.val() : null;
        });

        // Add dynamic fields (suspensionOrderNo* and resumeOrderNo*)
        $("[id^=suspensionOrderNo], [id^=resumeOrderNo]").each(function () {
            let fieldID = $(this).attr("id");
            updatedData[fieldID] = $(this).val();
        });

        // Handle "Ongoing" status formatting
        if (updatedData.projectStatus === "Ongoing") {
            let ongoingStatus = $("#ongoingStatus").val();
            let ongoingDate = $("#ongoingDate").val();

            if (ongoingStatus && ongoingDate) {
                if (!ongoingStatus.includes(" - ")) {
                    updatedData.ongoingStatus = `${ongoingStatus} - ${ongoingDate}`;
                }
            }
        } else {
            updatedData.ongoingStatus = null;
        }

        console.log("Updating project with ID:", project_id);

        // AJAX request to update the project
        $.ajax({
            url: `/projects/update/${project_id}`,
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            contentType: "application/json",
            data: JSON.stringify(updatedData),
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        title: "Updated Successfully!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: response.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function (xhr) {
                console.error("Error updating project:", xhr.responseText);
                Swal.fire({
                    title: "Error!",
                    text: "Failed to update project. Please try again.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    });
});

// Helper function to format date inputs correctly
function formatDateForInput(dateString) {
    if (!dateString) return "";
    return dateString.split(" ")[0]; // Extract YYYY-MM-DD format
}
