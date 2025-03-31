


document.addEventListener("DOMContentLoaded", function () {  
    let currencyDivs = document.querySelectorAll(".currency-input");

    currencyDivs.forEach(div => {
        div.setAttribute("contenteditable", "true"); // Make div editable
        div.addEventListener("keydown", function (event) {
            if (!isValidKey(event)) {
                event.preventDefault(); // Prevent invalid keypresses
            }
        });

        div.addEventListener("input", function () {
            formatCurrencyInput(this);
        });

        div.addEventListener("blur", function () {
            formatCurrencyOnBlur(this);
        });

        div.addEventListener("focus", function () {
            restoreNumericValue(this);
        });

        // Ensure the div always has the "₱" symbol
        if (div.textContent.trim() === "" || div.textContent.trim() === "Loading...") {
            div.textContent = "₱ 0.00";
        }
    });
});

// Function to format currency input as user types
function formatCurrencyInput(element) {
    let value = element.textContent.replace(/[^\d.]/g, ''); // Remove non-numeric characters except decimal
    let formattedValue = parseFloat(value).toLocaleString('en-PH', { minimumFractionDigits: 2 });

    if (!isNaN(formattedValue)) {
        element.textContent = "₱ " + formattedValue;
    } else {
        element.textContent = "₱ 0.00";
    }
}

// Function to format currency on blur (when user exits input)
function formatCurrencyOnBlur(element) {
    let value = element.textContent.replace(/[^\d.]/g, '');
    
    if (value === "" || isNaN(parseFloat(value))) {
        element.textContent = "₱ 0.00";
    } else {
        element.textContent = "₱ " + parseFloat(value).toLocaleString('en-PH', { minimumFractionDigits: 2 });
    }
}

// Function to restore raw numeric value on focus (so user can edit easily)
function restoreNumericValue(element) {
    let value = element.textContent.replace(/[^\d.]/g, ''); // Remove non-numeric characters
    element.textContent = value;
}

// Function to restrict allowed key inputs (numbers, decimal, backspace, arrows)
function isValidKey(event) {
    const allowedKeys = ["Backspace", "ArrowLeft", "ArrowRight", "Delete", "Tab"];
    const isNumber = /^[0-9.]$/.test(event.key);

    return isNumber || allowedKeys.includes(event.key);
}
// Show Image Preview Before Upload
function setupUploadModal() {
    document.getElementById("file").addEventListener("change", function (event) {
        let file = event.target.files[0];
        let previewContainer = document.getElementById("imagePreviewContainer");
        let previewImage = document.getElementById("imagePreview");

        if (file && file.type.startsWith("image/")) {
            let reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = "none";
        }
    });
}

document.getElementById("uploadForm").addEventListener("submit", function (e) {
    e.preventDefault();

    // Fetch `projectID` first
    fetch("/get-project-id", {
        method: "GET",
        headers: { "Accept": "application/json" }
    })
    .then(response => response.json())
    .then(data => {
        if (!data.projectID) {
            Swal.fire({
                title: "Error",
                text: "No project ID found in session. Please select a project first.",
                icon: "error",
                confirmButtonText: "OK"
            });
            throw new Error("Project ID is missing");
        }

        let projectID = data.projectID;
        console.log("✅ Retrieved Project ID:", projectID);

        let fileInput = document.getElementById("file");
        if (!fileInput.files.length) {
            Swal.fire({
                title: "Warning",
                text: "Please select a file to upload.",
                icon: "warning",
                confirmButtonText: "OK"
            });
            throw new Error("No file selected");
        }

        let formData = new FormData();
        formData.append("projectID", projectID);
        formData.append("file", fileInput.files[0]); // ✅ Removed username

        console.log("✅ Uploading file:", fileInput.files[0].name);

        return fetch("/uploadFile", {
            method: "POST",
            headers: { 
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: formData
        });
    })
    .then(response => response.text())  // ✅ Ensure the response is plain text first
    .then(text => {
        try {
            return JSON.parse(text); // ✅ Try parsing as JSON
        } catch (error) {
            console.error("❌ Server returned non-JSON response:", text);
            throw new Error("Unexpected response from server.");
        }
    })
    .then(data => {
        console.log("✅ Upload Response:", data);

        if (data.status === "error" && data.message === "File already exists") {
            Swal.fire({
                title: "Duplicate File",
                text: "A file with the same name already exists for this project. Please rename your file or choose a different one.",
                icon: "warning",
                confirmButtonText: "OK"
            });
            return;
        }

        if (data.status === "success") {
            Swal.fire({
                title: "Success!",
                text: "File uploaded successfully.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                location.reload(); // Reload the page after clicking "OK"
            });
        
        } else {
            Swal.fire({
                title: "Upload Failed",
                text: data.message || "Something went wrong!",
                icon: "error",
                confirmButtonText: "OK"
            });
        }
    })
    .catch(error => {
        console.error("❌ Upload Error:", error);
        Swal.fire({
            title: "Error",
            text: "Failed to upload file. Please check Laravel logs.",
            icon: "error",
            confirmButtonText: "OK"
        });
    });
});

document.getElementById("trashProjectBtn").addEventListener("click", function () {
    Swal.fire({
        title: "Are you sure?",
        text: "This project will be archived (hidden). You can restore it later.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, archive it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("/get-project-id", {
                method: "GET",
                headers: { "Accept": "application/json" }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.projectID) {
                    console.error("No project ID found in session.");
                    Swal.fire("Error!", "Project ID not found.", "error");
                    return;
                }

                let projectID = data.projectID;

                return fetch(`/projects/trash/${projectID}`, {
                    method: "PUT",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                    },
                    body: JSON.stringify({ is_hidden: 1 }) // Set is_hidden to 1
                });
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP Error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.status === "success") {
                    Swal.fire("Archived!", "The project has been hidden.", "success")
                        .then(() => {
                            window.location.href = "{{ route('main.index') }}"; // Redirect to main.index
                        });
                } else {
                    Swal.fire("Error!", data.message, "error");
                }
                
            })
            .catch(error => {
                console.error("Error hiding project:", error);
                Swal.fire("Error!", "Failed to archive the project. Please try again.", "error");
            });
        }
    });
});
          

// Delete File
function deleteFile(fileID) {
    fetch(`/delete/${fileID}`, { 
        method: "DELETE",
        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadFiles(document.getElementById("projectID").value); // Reload files
    })
    .catch(error => console.error("Error deleting file:", error));
}



document.addEventListener("DOMContentLoaded", function () {
    fetchProjectDetails(); // Fetch project details when page loads
    loadFiles(); 
});

//  Fetch Project ID & Details
function fetchProjectDetails() {
    fetch("/get-project-id", {
        method: "GET",
        headers: { "Accept": "application/json" }
    })
    .then(response => {
        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
        return response.json();
    })
    .then(data => {
        if (!data.projectID) {
            console.error("No project ID found in session. Redirecting...");
            window.location.href = "{{ route('main.index') }}"; // Redirect if no ID
            return;
        }
        
        console.log("Project ID:", data.projectID);
        fetch(`/projects/getProject/${data.projectID}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    console.log(" Fetched Project Data:", data.project);
                    updateProjectUI(data.project); // Populate UI
                    updateProjectForm(data.project); // Populate form in modal
                } else {
                    console.error(" Error fetching project details:", data.message);
                }
            })
            .catch(error => console.error(" Error fetching project data:", error));
    })
    .catch(error => console.error(" Error fetching project ID:", error));
}

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

// ✅ Function to format currency (₱ 1,234.56)
function formatCurrency(value) {
    let number = parseFloat(value);
    return isNaN(number) ? "₱ 0.00" : `₱ ${number.toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;
}


//  Open Edit Modal & Populate Form
document.getElementById("editProjectBtn").addEventListener("click", function () {
    let projectModal = new bootstrap.Modal(document.getElementById("projectModal"));
    projectModal.show();
});

function formatDateForInput(dateString) {
    if (!dateString) return "";
    const date = new Date(dateString);
    return date.toISOString().split("T")[0]; // Converts to YYYY-MM-DD
}
 
function updateProjectForm(project) {
    if (!project) {
        console.error("Error: Project data is undefined or null.");
        return;
    }

    console.log("Populating form with project data:", project);

    // Set values for form fields
    document.getElementById("projectTitle").value = project.projectTitle ?? "";
    document.getElementById("projectLoc").value = project.projectLoc ?? "";
    document.getElementById("projectID").value = project.projectID ?? "";
    document.getElementById("projectContractor").value = project.projectContractor ?? "";
    document.getElementById("sourceOfFunds").value = project.sourceOfFunds ?? "";
    document.getElementById("modeOfImplementation").value = project.modeOfImplementation ?? "";
    document.getElementById("projectStatus").value = project.projectStatus ?? "";
    document.getElementById("projectDescription").value = project.projectDescription ?? "";
    document.getElementById("projectContractDays").value = project.projectContractDays ?? "";
    document.getElementById("noticeToProceed").value = formatDateForInput(project.noticeToProceed);
    document.getElementById("officialStart").value = formatDateForInput(project.officialStart);
    document.getElementById("targetCompletion").value = formatDateForInput(project.targetCompletion);
    document.getElementById("suspensionOrderNo").value = project.suspensionOrderNo ?? "";
    document.getElementById("resumeOrderNo").value = project.resumeOrderNo ?? "";
    document.getElementById("timeExtension").value = project.timeExtension ?? "";
    document.getElementById("revisedTargetCompletion").value = formatDateForInput(project.revisedTargetCompletion);
    document.getElementById("completionDate").value = formatDateForInput(project.completionDate);
    document.getElementById("abc").value = project.abc ?? "";
    document.getElementById("contractAmount").value = project.contractAmount ?? "";
    document.getElementById("engineering").value = project.engineering ?? "";
    document.getElementById("mqc").value = project.mqc ?? "";
    document.getElementById("contingency").value = project.contingency ?? "";
    document.getElementById("bid").value = project.bid ?? "";
    document.getElementById("appropriation").value = project.appropriation ?? "";

    // Handle dropdown values separately
    setDropdownValue("sourceOfFunds", project.sourceOfFunds);
    setDropdownValue("projectStatus", project.projectStatus);

    // Handle "Ongoing" status
    let ongoingContainer = document.getElementById("ongoingStatusContainer");
    let ongoingInput = document.getElementById("ongoingStatus");
    let ongoingDateInput = document.getElementById("ongoingDate");

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

// Function to format date properly for input fields
function formatDateForInput(dateString) {
    if (!dateString) return "";
    let date = new Date(dateString);
    return isNaN(date.getTime()) ? "" : date.toISOString().split("T")[0];
}


// Handle Project Updates
document.getElementById("updateProjectForm").addEventListener("submit", function (event) {
    event.preventDefault();

    fetch("/get-project-id", { method: "GET", headers: { "Accept": "application/json" } })
    .then(response => response.json())
    .then(data => {
        if (!data.projectID) {
            console.error("No project ID found in session.");
            return;
        }

        let updatedData = {};
        let fieldIDs = [
            "projectTitle",  "projectLoc",  "projectID", "projectContractor", "sourceOfFunds", "modeOfImplementation", "projectStatus",
            "projectDescription", "projectContractDays", "noticeOfAward", "noticeToProceed",
            "officialStart", "targetCompletion", "suspensionOrderNo", "resumeOrderNo",
            "timeExtension", "revisedTargetCompletion", "completionDate", "abc",
            "contractAmount", "engineering", "mqc", "contingency", "bid", "appropriation"
        ];

        fieldIDs.forEach(id => {
            let input = document.getElementById(id);
            updatedData[id] = input ? input.value : null;
        });

        // Remove peso sign (₱) and commas from currency fields
        let currencyFields = ["abc", "contractAmount", "engineering", "mqc", "contingency", "bid", "appropriation"];
        currencyFields.forEach(field => {
            if (updatedData[field]) {
                updatedData[field] = updatedData[field].replace(/[₱,]/g, ""); // Remove ₱ and commas
            }
        });

        // Handle "Ongoing" status fields
        if (updatedData.projectStatus === "Ongoing") {
            let ongoingStatus = document.getElementById("ongoingStatus").value;
            let ongoingDate = document.getElementById("ongoingDate").value;
            updatedData.ongoingStatus = `${ongoingStatus} - ${ongoingDate}`;
        } else {
            updatedData.ongoingStatus = null;
        }

        console.log("Updating project with ID:", data.projectID);

        return fetch(`/projects/update/${data.projectID}`, {
            method: "PUT",  // FIX: Use PUT instead of POST
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify(updatedData)
        });
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP Error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.status === "success") {
            Swal.fire({ title: "Updated Successfully!", text: data.message, icon: "success", confirmButtonText: "OK" })
                .then(() => location.reload());
        } else {
            Swal.fire({ title: "Error!", text: data.message, icon: "error", confirmButtonText: "OK" });
        }
    })
    .catch(error => {
        console.error("Error updating project:", error);
        Swal.fire({ title: "Error!", text: "Failed to update project. Please try again.", icon: "error", confirmButtonText: "OK" });
    });
});


// Helper function to format date inputs correctly
function formatDateForInput(dateString) {
    if (!dateString) return "";
    return dateString.split(" ")[0]; // Extract YYYY-MM-DD format
}

// Helper function to set dropdown values
function setDropdownValue(elementID, value) {
    let selectElement = document.getElementById(elementID);
    if (!selectElement) return;

    value = value ?? "";
    let options = Array.from(selectElement.options).map(option => option.value);
    selectElement.value = options.includes(value) ? value : "";
}


// Helper: Format Date to "Month Day, Year"
function formatDate(inputDate) {
    if (!inputDate || inputDate === "N/A") return "N/A";

    let dateObj = new Date(inputDate);
    if (isNaN(dateObj.getTime())) {
        console.error("Invalid Date Format:", inputDate);
        return inputDate;
    }

    return dateObj.toLocaleDateString("en-US", { year: "numeric", month: "long", day: "numeric" });
}

// Handle Status Change Animation
$(document).ready(function () {
    $('#editStatus').on('change', function () {
        $(this).val() === 'Ongoing' ? $('#ongoingStatusContainer').slideDown() : $('#ongoingStatusContainer').slideUp();
    });

    $('#sourceOfFunds').on('change', function () {
        $(this).val() === 'Others' ? $('#otherFundContainer').slideDown() : $('#otherFundContainer').slideUp();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    let projectModal = document.getElementById("projectModal");

    projectModal.addEventListener("hidden.bs.modal", function () {
        location.reload(); // Reload the page after the modal is closed
    });
});

$(document).ready(function() {
    $('#generateProjectBtn').click(function() {
        let projectID = prompt("Enter Project ID to generate PDF:");
        if (projectID) {
            window.open(`/projects/generate-pdf/${projectID}`, '_blank');
        }
    });
});

