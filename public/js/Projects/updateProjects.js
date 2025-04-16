// Update UI with Project Data
function updateProjectUI() {
    const project = JSON.parse(sessionStorage.getItem("projectDetails"));

    if (!project) {
        console.error("No project data found in session.");
        return;
    }

    // --- Project Descriptions (Bullet format) ---
    const descriptionContainer = document.getElementById("projectDescriptionDisplay");
    if (descriptionContainer) {
        const descriptions = project.projectDescriptions || [];
        descriptionContainer.innerHTML = "";

        if (descriptions.length > 0) {
            const list = document.createElement("ul");
            list.style.paddingLeft = "20px";
            descriptions.forEach(desc => {
                const li = document.createElement("li");
                li.textContent = desc;
                list.appendChild(li);
            });
            descriptionContainer.appendChild(list);
        } else {
            descriptionContainer.textContent = "No descriptions available.";
        }
    }

    // --- Suspension & Resumption Order Dates Display ---
    const orderDetails = project.orderDetails || {};
    for (const [key, value] of Object.entries(orderDetails)) {
        const elem = document.getElementById(`${key}Display`);
        if (elem) {
            elem.textContent = value || " ";
        }
    }

    // --- Determine contractor value ---
    const contractorValue = (project.otherContractor && project.otherContractor.trim() !== "")
        ? project.otherContractor
        : project.projectContractor;

    // --- Default field mapping ---
    const fields = {
        "projectTitleDisplay": project.projectTitle,
        "projectLocDisplay": project.projectLoc,
        "projectIDDisplay": project.projectID,
        "projectContractorDisplay": contractorValue,
        "contractDaysDisplay": project.projectContractDays,
        "projectStatusDisplay": project.projectStatus,
        "noticeOfAwardDisplay": project.noticeOfAward,
        "modeOfImplementationDisplay": project.modeOfImplementation,
        "officialStartDisplay": project.officialStart,
        "targetCompletionDisplay": project.targetCompletion,
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
        "ntpReceivedDateDisplay": project.ntpReceivedDate,
        "projectSlippageDisplay": project.projectSlippage
    };

    // --- Fill in fields ---
    for (const id in fields) {
        const element = document.getElementById(id);
        if (element) {
            const value = fields[id] !== null && fields[id] !== undefined ? fields[id] : " ";

            // Format currency if needed
            if (element.classList.contains("currency-input")) {
                element.textContent = formatCurrency(value);
            } else {
                element.textContent = value;
            }
        }
    }

    // --- Contractor display if marked as 'others' ---
    const contractorsElem = document.getElementById("projectContractorDisplay");
    if (contractorsElem) {
        const contractorRaw = project.projectContractor || "";
        const contractorClean = contractorRaw.trim().toLowerCase();

        const displayVal = contractorClean === "others"
            ? (project.otherContractor?.trim() || "No other project contractor specified")
            : (contractorRaw || "No project contractor specified");

        contractorsElem.textContent = displayVal;
    }

    // --- Source of Funds display if marked as 'others' ---
    const sourceFundsElem = document.getElementById("sourceOfFundsDisplay");
    if (sourceFundsElem) {
        const sourceRaw = project.sourceOfFunds || "";
        const sourceClean = sourceRaw.trim().toLowerCase();

        const displayVal = sourceClean === "others"
            ? (project.otherFund?.trim() || "No other funds specified")
            : (sourceRaw || "No source of funds specified");

        sourceFundsElem.textContent = displayVal;
    }

    // --- Ongoing project status formatting ---
    const ongoingStatus = project.ongoingStatus || "";
    const ongoingStatusElem = document.getElementById("ongoingStatusDisplay");

    if (ongoingStatusElem) {
        if (ongoingStatus.includes(" - ")) {
            const [percent, date] = ongoingStatus.split(" - ");
            ongoingStatusElem.textContent = `${percent.trim()}% as of ${formatDate(date.trim())}`;
        } else {
            ongoingStatusElem.textContent = ongoingStatus;
        }
    }
}



// Update Project Form
function updateProjectForm() {
    let project = JSON.parse(sessionStorage.getItem("projectDetails"));

    if (!project) {
        console.error("Error: Project data is undefined or null.");
        return;
    }

    console.log("Populating form with project data:", project);

    let form = document.getElementById("updateProjectForm");
    if (!form) {
        console.error("Error: Form with ID 'updateProjectForm' not found.");
        return;
    }

    // Populate dynamic orderDetails fields
    if (project.orderDetails && typeof project.orderDetails === 'object') {
        for (const [field, value] of Object.entries(project.orderDetails)) {
            let input = form.querySelector(`#${field}`);
            if (!input) {
                console.warn(`Input with id '${field}' not found. Creating it.`);
                input = document.createElement('input');
                input.type = 'date';
                input.id = field;
                input.name = field;
                input.className = 'form-control';

                const wrapper = document.createElement('div');
                wrapper.className = 'form-group';
                const label = document.createElement('label');
                label.htmlFor = field;
                label.innerText = field;

                wrapper.appendChild(label);
                wrapper.appendChild(input);
                form.appendChild(wrapper);
            }
            input.value = value ?? "";
        }
    }

    // Clear the order container first
const orderContainer = document.getElementById("orderContainer");
orderContainer.innerHTML = ""; // Clear old content

if (project.orderDetails && typeof project.orderDetails === "object") {
    let orderPairs = {};

    // Group suspension/resumption orders by their number (e.g., 1, 2)
    Object.entries(project.orderDetails).forEach(([key, value]) => {
        const match = key.match(/(suspensionOrderNo|resumeOrderNo)(\d+)/);
        if (match && value) {
            const type = match[1]; // suspensionOrderNo or resumeOrderNo
            const index = match[2];

            if (!orderPairs[index]) {
                orderPairs[index] = {};
            }

            orderPairs[index][type] = value;
        }
    });

    // Now loop through the grouped order pairs and build the DOM
    Object.keys(orderPairs).sort((a, b) => a - b).forEach(index => {
        const pair = orderPairs[index];

        if (pair.suspensionOrderNo || pair.resumeOrderNo) {
            const rowDiv = document.createElement("div");
            rowDiv.className = "row mb-3 order-set";

            const suspDiv = document.createElement("div");
            suspDiv.className = "col-md-6 mb-1";

            const suspLabel = document.createElement("label");
            suspLabel.className = "form-label";
            suspLabel.innerText = `Suspension Order No. ${index}`;
            suspLabel.setAttribute("for", `suspensionOrderNo${index}`);

            const suspInput = document.createElement("input");
            suspInput.type = "date";
            suspInput.className = "form-control";
            suspInput.id = `suspensionOrderNo${index}`;
            suspInput.name = `suspensionOrderNo${index}`;
            suspInput.value = pair.suspensionOrderNo ?? "";

            suspDiv.appendChild(suspLabel);
            suspDiv.appendChild(suspInput);

            const resumeDiv = document.createElement("div");
            resumeDiv.className = "col-md-6 mb-1";

            const resumeLabel = document.createElement("label");
            resumeLabel.className = "form-label";
            resumeLabel.innerText = `Resumption Order No. ${index}`;
            resumeLabel.setAttribute("for", `resumeOrderNo${index}`);

            const resumeInput = document.createElement("input");
            resumeInput.type = "date";
            resumeInput.className = "form-control";
            resumeInput.id = `resumeOrderNo${index}`;
            resumeInput.name = `resumeOrderNo${index}`;
            resumeInput.value = pair.resumeOrderNo ?? "";

            resumeDiv.appendChild(resumeLabel);
            resumeDiv.appendChild(resumeInput);

            rowDiv.appendChild(suspDiv);
            rowDiv.appendChild(resumeDiv);
            orderContainer.appendChild(rowDiv);
        }
    });
}


    form.querySelector("#projectTitle").value = project.projectTitle ?? "";
    form.querySelector("#projectLoc").value = project.projectLoc ?? "";
    form.querySelector("#projectID").value = project.projectID ?? "";
    form.querySelector("#projectContractor").value = project.projectContractor ?? "";
    form.querySelector("#sourceOfFunds").value = project.sourceOfFunds ?? "";
    form.querySelector("#modeOfImplementation").value = project.modeOfImplementation ?? "";

    // Combine projectDescriptions array into one string
    const descriptions = Array.isArray(project.projectDescriptions)
        ? project.projectDescriptions.join("\n")
        : "";
    form.querySelector("#projectDescription").value = descriptions;

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
    form.querySelector("#otherFund").value = project.otherFund ?? "";

    setDropdownValue("sourceOfFunds", project.sourceOfFunds);
    setDropdownValue("projectStatus", project.projectStatus);

    let sourceOfFundsField = form.querySelector("#sourceOfFunds");
    if (sourceOfFundsField) {
        if (project.sourceOfFunds === "Others") {
            sourceOfFundsField.value = project.otherFund ?? "";
            setDropdownValue(sourceOfFundsField, project.otherFund);
        } else {
            sourceOfFundsField.value = project.sourceOfFunds ?? "";
            setDropdownValue(sourceOfFundsField, project.sourceOfFunds);
        }
    }

    // Ongoing status handling
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
            dropdown.value = "";
        }
    } else {
        console.error(`Dropdown '${dropdownID}' not found.`);
    }
}


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
            "noaIssuedDate", "noaReceivedDate", "ntpIssuedDate", "ntpReceivedDate", "totalExpenditure", "projectSlippage", "ea", "othersContractor"
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
