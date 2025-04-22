


$(document).ready(function () {
    function fetchRecentProjects() {
        $.ajax({
            url: "/projects/ProjectDetails",
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data.status === "success" && Array.isArray(data.projects)) {
                    // Destroy DataTable before reload
                    if ($.fn.DataTable.isDataTable("#recentProjects")) {
                        $('#recentProjects').DataTable().clear().destroy();
                    }

                    $('#recentProjects').DataTable({
                        data: data.projects,
                        columns: [
                            { data: 'title', title: "Project Title" },
                            { data: 'location', title: "Location" },
                            { data: 'status', title: "Status" },
                            { data: 'amount', title: "Contract Amount" },
                            { data: 'contractor', title: "Contractor" },
                            { data: 'duration', title: "Duration" },
                            { data: 'action', title: "Action", orderable: false }
                        ],
                        responsive: true,
                        scrollX: true,
                        paging: true,
                        searching: true,
                        autoWidth: false,
                        aLengthMenu: [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
                        pageLength: 10,
                        processing: true,
                        order: [[3, 'desc']],
                        columnDefs: [{
                            targets: '_all',
                            orderable: true
                        }],
                        fixedColumns: {
                            leftColumns: 1
                        }
                    });
                } else {
                    console.error("Invalid project data received.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error loading projects:", error);
            }
        });
    }

    fetchRecentProjects();
});


// Initially hide the table
$("#projects-container").hide(); 

// Load projects and initialize DataTable
loadProjects();
$('#location_filter, #contractor_filter, #amount_filter, #status_filter').on('input change', function () {
    filterProjects();
});



function loadProjects() {
    $("#loading-message").text("Fetching projects...").show();

    $.ajax({
        url: "/projects/ProjectDetails", // 🔄 Using the cleaned-up endpoint
        method: "GET",
        dataType: "json",
        success: function (response) {
            console.log("API Response:", response);

            if (!response || typeof response !== "object" || !Array.isArray(response.projects) || response.projects.length === 0) {
                console.error("Invalid API Response Structure:", response);
                showError("No valid projects found.");
                return;
            }

            const projects = response.projects.map(project => [
                project.title || "N/A",
                project.location || "N/A",
                project.status || "N/A",
                `₱${project.amount || "0.00"}`,
                project.contractor || "N/A",
                project.duration || "N/A",
                project.action
            ]);

            if ($.fn.DataTable.isDataTable("#projects")) {
                $('#projects').DataTable().clear().destroy();
                console.log("Existing DataTable destroyed.");
            }

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
                responsive: true,
                scrollX: true,
                paging: true,
                searching: true,
                autoWidth: false,
                aLengthMenu: [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
                pageLength: 10,
                order: [[3, 'desc']],
                processing: true,
                columnDefs: [
                    { targets: '_all', orderable: true }
                ],
                fixedColumns: {
                    leftColumns: 1
                }
            });

            // Only bind this once — leave it here, not inside AJAX success
            $(document).off('click', '.overview-btn').on('click', '.overview-btn', function () {
                const projectId = $(this).data('id');
                sessionStorage.setItem('project_id', projectId);

                const role = sessionStorage.getItem('user_role');
                if (role === 'Admin') {
                    window.location.href = "/admin/overview";
                } else if (role === 'System Admin') {
                    window.location.href = "/systemAdmin/overview";
                } else if (role === 'Staff') {
                    window.location.href = "/staff/overview";
                } else {
                    alert("Unauthorized: Unknown role.");
                }
            });

            $("#loading-message").hide();
            $("#projects-container").show();
        },
        error: function (xhr) {
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

window.fetchTrashedProjects = function() {
    $.ajax({
        url: "/projects/fetch-trash",
        method: "GET",
        dataType: "json",
        success: function(response) {
            let table = $('#trashList').DataTable();
            table.clear(); // Clear existing rows

            if (response.status === "success") {
                let projects = response.projects;

                if (projects.length === 0) {
                    table.row.add([
                        'No trashed projects found.', '', '', '', '', '', ''
                    ]).draw();
                } else {
                    projects.forEach(function(project) {
                        table.row.add([
                            project.title,
                            project.location,
                            project.status,
                            `₱${project.amount}`,
                            project.contractor,
                            project.duration,
                            project.action
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
};




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
        "order": [[3, 'desc']], // Sorting based on upload date
        "scrollX": true,
        "responsive": true,
        "autoWidth": false,
        "columnDefs": [{ targets: '_all', orderable: true }],
        "fixedColumns": { leftColumns: 1 },
        "processing": true,
        "serverSide": false,
        "ajax": function (data, callback, settings) {
            let project_id = sessionStorage.getItem("project_id");

            if (!project_id) {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No project ID was found in the session. Please select a project first.",
                    confirmButtonColor: "#d33"
                });
                return;
            }

            console.log("Fetching files for Project ID:", project_id);

            // Fetch project files
            fetch(`/files/${project_id}`)
                .then(response => response.json())
                .then(data => {
                    if (!data || !Array.isArray(data.files)) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Invalid file data received.",
                            confirmButtonColor: "#d33"
                        });
                        return;
                    }

                    let filesData = data.files.map(file => {
                        let fileType = file.fileName.split('.').pop().toUpperCase();
                        let uploadDate = file.created_at ? new Date(file.created_at).toLocaleDateString() : "N/A";

                        return [
                            file.fileName,
                            fileType,
                            file.actionBy || "Unknown",
                            uploadDate,
                            `<button class="btn btn-success btn-sm" onclick="downloadFile('${file.fileName}')">
                                <i class="fa fa-download"></i>
                            </button>
                            <button class="btn btn-danger btn-sm delete-file-btn" data-file-id="${file.fileName}">
                                <i class="fa fa-trash"></i>
                            </button>`
                        ];
                    });

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

    // Event delegation for delete buttons
    $('#projectFiles').on('click', '.delete-file-btn', function () {
        const fileName = $(this).data('file-id');
        deleteFile(fileName); // Call the deleteFile function from deleteFile.js
    });
});
