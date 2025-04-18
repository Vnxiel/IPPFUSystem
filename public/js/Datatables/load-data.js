
document.addEventListener("DOMContentLoaded", function () {
    fetchRecentProjects(); //  Fetch projects table data
});


$(document).ready(function () {
    function fetchRecentProjects() {
        $.ajax({
            url: "/projects/showDetails",
            type: "GET",
            dataType: "json",
            success: function (data) {
                console.log("Fetched Projects:", data);

                if (data.status === "success" && Array.isArray(data.projects)) {
                    let tbody = $("#projectTableBody");
                    tbody.empty(); // Clear old data

                    if (data.projects.length === 0) {
                        tbody.html(`<tr><td colspan="7" class="text-center">No projects available.</td></tr>`);
                        return;
                    }

                    let projects = data.projects.map(project => [
                        project.projectTitle || "N/A",
                        project.projectLoc || "N/A",
                        project.projectStatus || "N/A",
                        `₱${parseFloat(project.contractAmount || 0).toLocaleString()}`,
                        project.projectContractor || "N/A",
                        project.projectContractDays ? `${project.projectContractDays} days` : "N/A",
                        `<button class="btn btn-primary btn-sm overview-btn" data-id="${project.projectID}">Overview</button>`
                    ]);

                    console.log("Processed Data for Table:", projects);

                    // Destroy existing DataTable before reloading
                    if ($.fn.DataTable.isDataTable("#recentProjects")) {
                        $('#recentProjects').DataTable().clear().destroy();
                        console.log("Existing DataTable destroyed.");
                    }

                    // Initialize DataTable with fetched projects
                    $('#recentProjects').DataTable({
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
                        responsive: true,
                        scrollX: true,
                        paging: true,
                        searching: true,
                        autoWidth: false,
                        aLengthMenu: [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
                        pageLength: 10,
                        order: [[3, 'desc']],  // Sorting based on the 4th column (Contract Amount)
                        columnDefs: [
                            {
                                targets: '_all',   // Apply to all columns
                                orderable: true     // Ensure columns can still be ordered
                            }
                        ],
                        fixedColumns: {
                            leftColumns: 1  // Freezes the first column
                        }
                    });

                    console.log("DataTable Reloaded Successfully!");
                } else {
                    console.error("Invalid project data received.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error loading projects:", error);
            }
        });
    }

    // Call fetchRecentProjects when the page is ready
    fetchRecentProjects();
});


$(document).ready(function() {
    // Initially hide the table
    $("#projects-container").hide(); 

    // Load projects and initialize DataTable
    loadProjects();
});

function loadProjects() {
    // Show loading message
    $("#loading-message").text("Fetching projects...").show();
    
    $.ajax({
        url: "/projects/showDetails", // Matches Laravel route
        method: "GET",
        dataType: "json",
        success: function(response) {
            console.log("API Response:", response);
            
            // Validate response structure
            if (!response || typeof response !== "object" || !Array.isArray(response.projects) || response.projects.length === 0) {
                console.error("Invalid API Response Structure:", response);
                showError("No valid projects found.");
                return;
            }

            let projects = response.projects.map(project => [
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
                `<button class="btn btn-primary btn-sm overview-btn" data-id="${project.projectID}">
                    Overview
                </button>`
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
                order: [[3, 'desc']], // Sorting based on Contract Amount
                scrollX: true,  // Enables horizontal scrolling
                responsive: true, // Ensures responsiveness
                autoWidth: false, // Disable auto width setting
                columnDefs: [
                    {
                        targets: '_all',
                        orderable: true // Allow sorting on all columns
                    }
                ],
                fixedColumns: {
                    leftColumns: 1 // Freezes the first column
                }
            });

            console.log("DataTable Reloaded Successfully!");

            // Hide loading message and show table
            $("#loading-message").hide();
            $("#projects-container").show();
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
            let errorMessage = "Failed to load project data.";

            if (xhr.status === 404) {
                errorMessage = "No project data found.";
            } else if (xhr.status === 500) {
                errorMessage = "Internal Server Error. Please try again later.";
            }

            showError(errorMessage);
        }
    });
}

// Function to show errors
function showError(message) {
    $("#loading-message").text(message).addClass("text-danger").show();
    $("#projects-container").hide(); // Ensure table remains hidden if there's an error
}

$(document).ready(function() {
    $('#userList').DataTable({
        "aLengthMenu": [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
        "pageLength": 10,
        "order": [[3, 'desc']],  // Sorting based on the 4th column (Appropriation)
        "scrollX": true,  // Enables horizontal scrolling
        "responsive": true, // Ensures responsiveness
        autoWidth: false,   // Disable the auto width setting to make it flexible
        "columnDefs": [
            {
                targets: '_all',   // Apply this to all columns
                orderable: true     // Ensure columns can still be ordered
            }
        ],
        "fixedColumns": {
            leftColumns: 1  // Freezes the first column
        }
    });
});

$(document).ready(function() {
    let table = $('#trashList').DataTable();

    // Function to Fetch Trashed Projects via AJAX
    function fetchTrashedProjects() {
        $.ajax({
            url: "/projects/fetch-trash", // Update with your route
            method: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    let projects = response.projects;
                    table.clear(); // Clear existing rows

                    if (projects.length === 0) {
                        table.row.add([
                            'No trashed projects found.',
                            '',
                            '',
                            '',
                            '',
                            '',
                            ''
                        ]).draw();
                    } else {
                        projects.forEach(function(project) {
                            table.row.add([
                                project.projectTitle,
                                project.projectLoc,
                                project.projectStatus,
                                `₱${parseFloat(project.contractAmount).toLocaleString()}`,
                                project.projectContractor,
                                `${project.projectContractDays} calendar days`,
                                `<td>
                                    <button class="btn btn-primary btn-sm restore-btn" data-id="${project.projectID}">Restore</button>
                                </td>`
                            ]).draw();
                        });
                    }
                } else {
                    Swal.fire("Error!", response.message, "error");
                }
            },
            error: function() {
                Swal.fire("Error!", "Failed to fetch trashed projects. Please try again.", "error");
            }
        });
    }
  
});




$(document).ready(function() {
    $('#activityLogs').DataTable({
        "aLengthMenu": [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
        "pageLength": 10,
        "order": [[3, 'desc']],  // Sorting based on the 4th column (Appropriation)
        "scrollX": true,  // Enables horizontal scrolling
        "responsive": true, // Ensures responsiveness
        autoWidth: false,   // Disable the auto width setting to make it flexible
        "columnDefs": [
            {
                targets: '_all',   // Apply this to all columns
                orderable: true     // Ensure columns can still be ordered
            }
        ],
        "fixedColumns": {
            leftColumns: 1  // Freezes the first column
        }
    });
});

$(document).ready(function () {
    let projectFilesTable = $('#projectFiles').DataTable({
        "aLengthMenu": [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
        "pageLength": 10,
        "order": [[4, 'desc']],  // Sorting based on the 5th column (Upload Date)
        "scrollX": true,  
        "responsive": true, 
        "autoWidth": false,  
        "columnDefs": [
            { targets: '_all', orderable: true }
        ],
        "fixedColumns": {
            leftColumns: 1 
        },
        "processing": true,  // Show loading indicator
        "serverSide": false, // Fetch data manually
        "ajax": function (data, callback, settings) {
            fetch("/get-project-id", { method: "GET", headers: { "Accept": "application/json" } })
                .then(response => response.json())
                .then(data => {
                    if (!data.projectID) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "No project ID was found in the session. Please try again.",
                            confirmButtonColor: "#d33"
                        });
                        return;
                    }

                    let projectID = data.projectID;
                    console.log("Fetching files for Project ID:", projectID);

                    return fetch(`/files/${projectID}`);
                })
                .then(response => response.json())
                .then(data => {
                    console.log("API Response:", data);

                    if (!data || !Array.isArray(data.files)) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Invalid file data received.",
                            confirmButtonColor: "#d33"
                        });
                        return;
                    }

                    // Convert fetched data into DataTables format
                    let filesData = data.files.map(file => {
                        let fileType = file.fileName.split('.').pop().toUpperCase();
                        let uploadDate = file.created_at ? new Date(file.created_at).toLocaleDateString() : "N/A";

                        return [
                            file.fileName,
                            fileType,
                            file.actionBy || "Unknown",
                            uploadDate,
                            `<a href="/storage/${file.fileID}" download class="btn btn-success btn-sm">
                                <i class="fa fa-download"></i>
                            </a>
                            <button onclick="deleteFile('${file.id}')" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>`
                        ];
                    });

                    // Pass the formatted data to DataTables
                    callback({ data: filesData });
                })
                .catch(error => {
                    console.error("Fetch Error:", error);
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "Error loading project files: " + error.message,
                        confirmButtonColor: "#d33"
                    });
                });
        }
    });
});
