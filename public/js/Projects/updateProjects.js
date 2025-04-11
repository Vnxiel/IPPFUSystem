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
        "abcOriginalDisplay": project.abc,
        "mqcOriginalDisplay": project.mqc,
        "contractAmountOriginalDisplay": project.contractAmount,
        "bidDiffOriginalDisplay": project.bid,
        "engineeringOriginalDisplay": project.engineering,
        "contingencyOriginalDisplay": project.contingency,
        "appropriationDisplay": project.appropriation,
        "totalExpenditureOriginalDisplay": project.totalExpenditure,
        "sourceOfFundsDisplay": project.sourceOfFunds,
        "otherFundDisplay": project.otherFund,
        "noaIssuedDateDisplay": project.noaIssuedDate,
        "noaReceivedDateDisplay": project.noaReceivedDate,
        "ntpIssuedDateDisplay": project.ntpIssuedDate,
        "ntpReceivedDateDisplay": project.noaReceivedDate,
        "projectSlippageDisplay": project.projectSlippage
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

    let sourceOfFundsElem = document.getElementById("sourceOfFundsDisplay");

    if (sourceOfFundsElem) {
        let sourceOfFundsRaw = project.sourceOfFunds || "";
        let sourceOfFunds = sourceOfFundsRaw.trim().toLowerCase();
    
        let displayValue = (sourceOfFunds === "others")
            ? (project.otherFund?.trim() || "No other funds specified")
            : (sourceOfFundsRaw || "No source of funds specified");
    
        sourceOfFundsElem.textContent = displayValue;
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


      // ✅ Populate dynamic orderDetails fields (like suspensionOrderNo1, resumeOrderNo2, etc.)
      if (project.orderDetails && typeof project.orderDetails === 'object') {
        for (const [field, value] of Object.entries(project.orderDetails)) {
            let input = form.querySelector(`#${field}`);
            
            // If the input doesn't exist, create it dynamically
            if (!input) {
                console.warn(`Input with id '${field}' not found. Creating it.`);
                
                input = document.createElement('input');
                input.type = 'date'; // assuming date fields
                input.id = field;
                input.name = field;
                input.className = 'form-control'; // adjust class as needed
                
                // Optional: wrap in a div or label for styling/layout
                const wrapper = document.createElement('div');
                wrapper.className = 'form-group';
                const label = document.createElement('label');
                label.htmlFor = field;
                label.innerText = field;

                wrapper.appendChild(label);
                wrapper.appendChild(input);
                form.appendChild(wrapper); // Add to the form
            }

            input.value = value ?? "";
        }
    }


    // Set values for form fields within the specific form
    form.querySelector("#projectTitle").value = project.projectTitle ?? "";
    form.querySelector("#projectLoc").value = project.projectLoc ?? "";
    form.querySelector("#projectID").value = project.projectID ?? "";
    form.querySelector("#projectContractor").value = project.projectContractor ?? "";
    form.querySelector("#sourceOfFunds").value = project.sourceOfFunds ?? "";
    form.querySelector("#modeOfImplementation").value = project.modeOfImplementation ?? "";
    form.querySelector("#projectDescription").value = project.projectDescription ?? "";
    form.querySelector("#projectContractDays").value = project.projectContractDays ?? "";
    form.querySelector("#officialStart").value = formatDateForInput(project.officialStart);
    form.querySelector("#targetCompletion").value = formatDateForInput(project.targetCompletion);
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
    form.querySelector("#projectSlippage").value = project.projectSlippage ?? "";
    form.querySelector("#ntpIssuedDate").value = project.ntpIssuedDate ?? "";
    form.querySelector("#ntpReceivedDate").value = project.ntpReceivedDate ?? "";
    form.querySelector("#noaIssuedDate").value = project.noaIssuedDate ?? "";
    form.querySelector("#noaReceivedDate").value = project.noaReceivedDate ?? "";
    form.querySelector("#totalExpenditure").value = project.totalExpenditure ?? "";
    form.querySelector("#contractCost").value = project.contractCost ?? "";
    

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



$(document).ready(function () {
    $("#updateProjectForm").on("submit", function (event) {
        event.preventDefault();

        $.ajax({
            url: "/get-project-id",
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (!data.projectID) {
                    console.error("No project ID found in session.");
                    return;
                }

                let updatedData = {};
                let fieldIDs = [
                    "projectTitle", "projectLoc", "projectID", "projectContractor", "sourceOfFunds", "modeOfImplementation",
                    "projectStatus", "ongoingStatus", "projectDescription", "projectContractDays", "noticeOfAward",
                    "noticeToProceed", "officialStart", "targetCompletion", "timeExtension", "revisedTargetCompletion",
                    "completionDate", "abc", "contractAmount", "engineering", "mqc", "contingency", "bid", "appropriation",
                    "noaIssuedDate", "noaReceivedDate", "ntpIssuedDate", "ntpReceivedDate", "totalExpenditure", "projectSlippage"
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
            },
            error: function (xhr) {
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
