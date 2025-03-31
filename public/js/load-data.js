$(document).ready(function() {
    $('#recentProjectss').DataTable({
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
    $('#projectsdata').DataTable({
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

    // Call the function to fetch projects on page load
    fetchTrashedProjects();

    // Function to Restore a Project
    $(document).on('click', '.restore-btn', function() {
        let projectID = $(this).data('id');

        Swal.fire({
            title: "Restore Project?",
            text: "Are you sure you want to restore this project?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, restore it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/projects/restore/${projectID}`,
                    method: "PUT",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire("Restored!", "The project has been restored.", "success")
                                .then(() => fetchTrashedProjects()); // Refresh table without reloading
                        } else {
                            Swal.fire("Error!", response.message, "error");
                        }
                    },
                    error: function() {
                        Swal.fire("Error!", "Failed to restore the project. Please try again.", "error");
                    }
                });
            }
        });
    });
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
