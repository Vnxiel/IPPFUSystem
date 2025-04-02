document.addEventListener("DOMContentLoaded", function () {
    // Select all input fields with the "currency-input" class
    let currencyInputs = document.querySelectorAll(".currency-input");

    currencyInputs.forEach(input => {
        input.addEventListener("input", function () {
            formatCurrencyInput(this);
        });

        input.addEventListener("blur", function () {
            formatCurrencyOnBlur(this);
        });

        //  Format existing values on page load
        if (input.value.trim() !== "") {
            formatCurrencyOnBlur(input);
        }
    });

    function formatCurrencyInput(input) {
        // Remove non-numeric characters except decimal
        let value = input.value.replace(/[^0-9.]/g, "");

        // Ensure there's only one decimal point
        let parts = value.split(".");
        if (parts.length > 2) {
            value = parts[0] + "." + parts.slice(1).join("");
        }

        input.value = value;
    }

    function formatCurrencyOnBlur(input) {
        let value = input.value.trim();

        if (value === "" || isNaN(value)) {
            input.value = "";
            return;
        }

        let formattedValue = parseFloat(value).toLocaleString("en-PH", {
            style: "currency",
            currency: "PHP",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        input.value = formattedValue;
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const projectsDetailsUrl = "/projects/showDetails"; // Replace with the correct URL

    fetch(projectsDetailsUrl)
        .then(response => response.json())
        .then(data => {
            console.log("Projects Data:", data); // Debugging
            if (data.status === "success") {
                loadProjects(data.projects);
            } else {
                console.error("Error fetching projects:", data.message);
            }
        })
        .catch(error => console.error("Error fetching projects:", error));

    loadProjects(); // Load projects when the page loads
});

// Handle Add Project Form Submission
document.getElementById("addProjectForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent normal form submission
    var statusValue = document.getElementById("projectStatus").value;
    var ongoingInput = document.getElementById("ongoingStatus");

    if (statusValue === "Ongoing") {
        var percentage = ongoingInput.value.trim();
        var date = document.getElementById("ongoingDate").value;

        if (percentage && date) {
            // Prevent duplicate concatenation
            if (!ongoingInput.value.includes(" - ")) {
                ongoingInput.value = percentage + " - " + date;
            }
        }
    }
    let formData = new FormData(this);

    fetch("addProject", {
        method: "POST",
        body: formData,
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            "Accept": "application/json"
        }
    })
        .then(response => {
            if (!response.ok) {
                return response.json().then(data => {
                    throw new Error(data.message || "An unexpected error occurred.");
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.status === "success") {
                Swal.fire({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    $("#addNewProjectModal").modal("hide"); // Hide modal
                    document.getElementById("addProjectForm").reset(); // Reset form
                    loadProjects(); // Reload projects without refreshing page
                });
            } else {
                throw new Error(data.message || "An unexpected error occurred.");
            }
        })
        .catch(error => {
            Swal.fire({
                title: "Error!",
                text: error.message,
                icon: "error",
                confirmButtonText: "OK"
            });
            console.error("Error:", error);
        });
});

document.addEventListener("DOMContentLoaded", function () {
    loadProjects(); // Load projects on page load
});

function loadProjects() {
    const projectsDetailsUrl = "/projects/showDetails"; // Replace with the correct URL

    fetch(projectsDetailsUrl)
        .then(response => response.json())
        .then(data => {
            console.log("API Response:", data);

            if (!data || typeof data !== "object" || !Array.isArray(data.projects)) {
                console.error("Invalid API Response Structure:", data);
                showError("No valid projects found.");
                return;
            }

            let projects = data.projects.map(project => [
                project.projectTitle || "N/A",
                project.projectLoc || "N/A",
                project.projectStatus || "N/A",
                project.contractAmount
                    ? `₱${parseFloat(project.contractAmount).toLocaleString()}`
                    : "N/A",
                project.projectContractor || "N/A",
                project.projectContractDays
                    ? `${project.projectContractDays} days`
                    : "N/A",
                `<button class="btn btn-primary btn-sm overview-btn" data-id="${project.projectID}">Overview</button>`
            ]);

            console.log("Processed Data:", projects);

            // Destroy existing DataTable before reloading
            if ($.fn.DataTable.isDataTable("#projects")) {
                $('#projects').DataTable().clear().destroy();
                console.log("Existing DataTable destroyed.");
            }

            // Initialize DataTable with updated settings
            $('#projects').DataTable({
                data: projects,
                columns: [
                    { title: "Project Title" },
                    { title: "Location" },
                    { title: "Status" },
                    { title: "Contract Amount" },
                    { title: "Contractor" },
                    { title: "Duration" },
                    { title: "Action", orderable: false }
                ],
                aLengthMenu: [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
                pageLength: 10,
                order: [[3, 'desc']], // Sorting based on the 4th column (Contract Amount)
                scrollX: true,  // Enables horizontal scrolling
                responsive: true, // Ensures responsiveness
                autoWidth: false,   // Disable auto width setting
                columnDefs: [
                    {
                        targets: '_all',   // Apply this to all columns
                        orderable: true     // Ensure columns can still be sorted
                    }
                ],
                fixedColumns: {
                    leftColumns: 1  // Freezes the first column
                }
            });

            console.log("DataTable Reloaded Successfully!");
        })
        .catch(error => {
            console.error("Fetch Error:", error);
            showError("Failed to load project data.");
        });
}

// Show an error message inside the table if data fetching fails
function showError(message) {
    document.querySelector("#projects tbody").innerHTML = `
<tr><td colspan="7" class="text-center text-danger">${message}</td></tr>
`;
}

// Attach event listener for overview button clicks (event delegation)
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("overview-btn")) {
        let projectID = e.target.getAttribute("data-id");

        // Store projectID in session via AJAX
        fetch("/store-project-id", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") // Laravel CSRF token
            },
            body: JSON.stringify({ projectID })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Project ID stored successfully, redirecting...");
                    window.location.href = "{{ route('main.overview') }}"; // Redirect without ID in URL
                } else {
                    console.error("Failed to store project ID:", data);
                }
            })
            .catch(error => console.error("Error storing project ID:", error));
    }
});

// Handle "Other Fund" Selection Toggle
function toggleOtherFund() {
    var sourceOfFunds = document.getElementById("sourceOfFunds").value;
    var otherFundContainer = document.getElementById("otherFundContainer");

    if (sourceOfFunds === "Others") {
        otherFundContainer.style.display = "block";
    } else {
        otherFundContainer.style.display = "none";
    }
}

// Handle "Ongoing Status" Selection Toggle
function toggleOngoingStatus() {
    var projectStatus = document.getElementById("projectStatus").value;
    var ongoingStatusContainer = document.getElementById("ongoingStatusContainer");

    if (projectStatus === "Ongoing") {
        ongoingStatusContainer.style.display = "block";
    } else {
        ongoingStatusContainer.style.display = "none";
    }
}

// Add Event Listener for Project Status Dropdown
const projectStatusElement = document.getElementById("projectStatus");
if (projectStatusElement) {
    projectStatusElement.addEventListener("change", function () {
        toggleOngoingStatus();
    });
}

// Handle "Other Fund" Dropdown Change
$('#sourceOfFunds').on('change', function () {
    if ($(this).val() === 'Others') {
        $('#otherFundContainer').slideDown(); // Show input with animation
    } else {
        $('#otherFundContainer').slideUp(); // Hide input with animation
    }
});
