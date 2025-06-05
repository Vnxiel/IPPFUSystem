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

        let updatedData = {};
        let fieldIDs = [
            "title", "location", "projectID", "firm_name", "source_of_funds", "mode_of_implementation",
            "description", "contract_days", "contractor_name",
            "contractor_address", "official_starting_date", "target_completion_date", "timeExtension", "revised_target_date", "revisedCompletionDate",
            "actual_completion_date", "abc", "orig_contract_amount", "engineering", "mqc", "contingency", "bid", "appropriation",
            "noa_issued_date", "noa_received_date", "ntp_issued_date", "ntp_received_date", "total_expenditure", "project_slippage", "engineer_name", "engineer_position", "actual_length", "othersContractor", "year", "fpp", "responsibility_center"
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

        // Add dynamic Time Extension fields
        let timeExtensions = [];

        for (let i = 1; i <= extensionCounter; i++) {
            let extension = {
                days: $(`#timeExtension${i}`).val(),
                reason: $(`#extensionReason${i}`).val(),
                revised: $(`#revisedExpiry${i}`).val(),
            };
        
            timeExtensions.push(extension);
        }
        
        updatedData.time_extensions = timeExtensions;
        

        // Handle "Ongoing" status formatting
        if (updatedData.physical_status === "Ongoing") {
            let ongoing_status = $("#ongoing_status").val();
            let ongoingDate = $("#ongoingDate").val();

            if (ongoing_status && ongoingDate) {
                if (!ongoing_status.includes(" - ")) {
                    updatedData.ongoing_status = `${ongoing_status} - ${ongoingDate}`;
                }
            }
        } else {
            updatedData.ongoing_status = null;
        }

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
