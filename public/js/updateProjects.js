//  Update UI with Project Data
function updateProjectUI(project) {
    let fields = {
        "projectTitleDisplay": project.projectTitle,
        "projectLocDisplay": project.projectLoc,
        "projectIDDisplay": project.projectID,
        "projectDescriptionDisplay": project.projectDescription,
        "projectContractorDisplay": project.projectContractor,
        "projectStatusDisplay": project.projectStatus,
        "ongoingStatusDisplay": project.ongoingStatus,
        "noticeOfAwardDisplay": project.noticeOfAward,
        "modeOfImplementationDisplay": project.modeOfImplementation,
        "officialStartDisplay": project.officialStart,
        "targetCompletionDisplay": project.targetCompletion,
        "suspensionOrderNoDisplay": project.suspensionOrderNo,
        "resumeOrderNoDisplay": project.resumeOrderNo,
        "timeExtensionDisplay": project.timeExtension,
        "revisedTargetCompletionDisplay": project.revisedTargetCompletion,
        "completionDateDisplay": project.completionDate,
        "abcDisplay": project.abc,
        "mqcDisplay": project.mqc,
        "contractAmountDisplay": project.contractAmount,
        "bidDisplay": project.bid,
        "engineeringDisplay": project.engineering,
        "contingencyDisplay": project.contingency,
        "appropriationDisplay": project.appropriation
    };

    for (let id in fields) {
        let element = document.getElementById(id);
        if (element) {
            let value = fields[id] !== null && fields[id] !== undefined ? fields[id] : " ";

            // Preserve currency formatting for financial fields
            if (element.classList.contains("currency-input")) {
                element.textContent = formatCurrency(value);
            } else {
                element.textContent = value;
            }
        }
    }

    //  Extract & display ongoing project status (if applicable)
    let ongoingStatusDisplay = project.ongoingStatus || "";
    let percentage = "", date = "";

    if (ongoingStatusDisplay.includes(" - ")) {
        let parts = ongoingStatusDisplay.split(" - ");
        percentage = parts[0].trim() + "%";
        date = formatDate(parts[1].trim());
    }

    let ongoingStatusElem = document.getElementById("ongoingStatusDisplay");
    if (ongoingStatusElem) {
        ongoingStatusElem.textContent = percentage ? `${percentage} as of ${date}` : " ";
    }
}

function updateProjectForm(project) {
    if (!project) {
        console.error("Error: Project data is undefined or null.");
        return;
    }

    console.log("Populating form with project data:", project);

    // Get the specific form by ID
    let form = document.getElementById("updateProjectForm");
    if (!form) {
        console.error("Error: Form with ID 'updateProjectForm' not found.");
        return;
    }

    // Set values for form fields within the specific form
    form.querySelector("#projectTitle").value = project.projectTitle ?? "";
    form.querySelector("#projectLoc").value = project.projectLoc ?? "";
    form.querySelector("#projectID").value = project.projectID ?? "";
    form.querySelector("#projectContractor").value = project.projectContractor ?? "";
    form.querySelector("#sourceOfFunds").value = project.sourceOfFunds ?? "";
    form.querySelector("#modeOfImplementation").value = project.modeOfImplementation ?? "";
    form.querySelector("#projectStatus").value = project.projectStatus ?? "";
    form.querySelector("#projectDescription").value = project.projectDescription ?? "";
    form.querySelector("#projectContractDays").value = project.projectContractDays ?? "";
    form.querySelector("#noticeToProceed").value = formatDateForInput(project.noticeToProceed);
    form.querySelector("#officialStart").value = formatDateForInput(project.officialStart);
    form.querySelector("#targetCompletion").value = formatDateForInput(project.targetCompletion);
    form.querySelector("#suspensionOrderNo").value = project.suspensionOrderNo ?? "";
    form.querySelector("#resumeOrderNo").value = project.resumeOrderNo ?? "";
    form.querySelector("#timeExtension").value = project.timeExtension ?? "";
    form.querySelector("#revisedTargetCompletion").value = formatDateForInput(project.revisedTargetCompletion);
    form.querySelector("#completionDate").value = formatDateForInput(project.completionDate);
    form.querySelector("#abc").value = project.abc ?? "";
    form.querySelector("#contractAmount").value = project.contractAmount ?? "";
    form.querySelector("#engineering").value = project.engineering ?? "";
    form.querySelector("#mqc").value = project.mqc ?? "";
    form.querySelector("#contingency").value = project.contingency ?? "";
    form.querySelector("#bid").value = project.bid ?? "";
    form.querySelector("#appropriation").value = project.appropriation ?? "";

    // Handle dropdown values separately
    setDropdownValue(form.querySelector("#sourceOfFunds"), project.sourceOfFunds);
    setDropdownValue(form.querySelector("#projectStatus"), project.projectStatus);

    // Handle "Ongoing" status
    let ongoingContainer = form.querySelector("#ongoingStatusContainer");
    let ongoingInput = form.querySelector("#ongoingStatus");
    let ongoingDateInput = form.querySelector("#ongoingDate");

    if (project.projectStatus === "Ongoing") {
        ongoingContainer.style.display = "block";

        if (project.ongoingStatus) {
            let parts = project.ongoingStatus.split(" - ");
            let percentage = parts[0]?.trim() || "";
            let date = parts[1]?.trim() || "";

            ongoingInput.value = percentage;
            ongoingDateInput.value = formatDateForInput(date);
        } else {
            ongoingInput.value = "";
            ongoingDateInput.value = "";
        }
    } else {
        ongoingContainer.style.display = "none";
        ongoingInput.value = "";
        ongoingDateInput.value = "";
    }
}

function setDropdownValue(dropdownID, value) {
    let dropdown = document.getElementById(dropdownID);
    if (dropdown) {
        let optionExists = [...dropdown.options].some(option => option.value === value);
        if (optionExists) {
            dropdown.value = value;
        } else {
            console.warn(`Dropdown '${dropdownID}' does not have an option for value: '${value}'`);
            dropdown.value = ""; // Set to default if value not found
        }
    } else {
        console.error(`Dropdown '${dropdownID}' not found.`);
    }
}



$(document).ready(function() {
    $("#updateProjectForm").on("submit", function(event) {
        event.preventDefault();

        $.ajax({
            url: "/get-project-id",
            method: "GET",
            dataType: "json",
            success: function(data) {
                if (!data.projectID) {
                    console.error("No project ID found in session.");
                    return;
                }

                let updatedData = {};
                let fieldIDs = [
                    "projectTitle", "projectLoc", "projectID", "projectContractor", "sourceOfFunds", "modeOfImplementation", 
                    "projectStatus", "ongoingStatus", "projectDescription", "projectContractDays", "noticeOfAward", 
                    "noticeToProceed", "officialStart", "targetCompletion", "suspensionOrderNo", "resumeOrderNo", 
                    "timeExtension", "revisedTargetCompletion", "completionDate", "abc", "contractAmount", "engineering", 
                    "mqc", "contingency", "bid", "appropriation"
                ];

                fieldIDs.forEach(id => {
                    let input = $("#" + id);
                    updatedData[id] = input.length ? input.val() : null;
                });

                // Handle "Ongoing" status fields
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

                console.log("Updating project with ID:", data.projectID);

                // AJAX request to update the project
                $.ajax({
                    url: `/projects/update/${data.projectID}`,
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    contentType: "application/json",
                    data: JSON.stringify(updatedData),
                    success: function(response) {
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
                    error: function(xhr) {
                        console.error("Error updating project:", xhr.responseText);
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to update project. Please try again.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                });
            },
            error: function(xhr) {
                console.error("Error fetching project ID:", xhr.responseText);
                Swal.fire({
                    title: "Error!",
                    text: "Unable to retrieve project ID. Please try again.",
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
