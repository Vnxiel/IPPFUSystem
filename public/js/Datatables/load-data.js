$(document).ready(function () {
    const urlParams = new URLSearchParams(window.location.search);
    const statusFilter = urlParams.get('page'); // e.g., 'ongoing', 'started', etc.

    // Hide table initially
    $("#projects-container").hide();

    // Load and display projects
    loadProjects();

    // Filter event listeners
    $('#location_filter, #contractor_filter, #amount_filter, #status_filter').on('input change', function () {
        filterProjects(); // if you have a filterProjects() function
    });

    function loadProjects() {
        $.ajax({
            url: "/projects/ProjectDetails",
            type: "GET",
            dataType: "json",
            success: function (data) {
                Swal.close();

                if (!data || typeof data !== 'object' || data.status !== "success" || !Array.isArray(data.projects)) {
                    return showError(data.message || "Unexpected server response.");
                }

                let projects = data.projects;

                if (projects.length === 0) {
                    return Swal.fire({
                        icon: 'info',
                        title: 'No Projects Found',
                        text: data.message || 'There are no recently added projects.',
                        timer: 10000,
                        showConfirmButton: false
                    });
                }

                // If filtering by status
                if (statusFilter) {
                    const statusMap = {
                        tobestarted: 'To Be Started',
                        ongoing: 'Ongoing',
                        completed: 'Completed',
                        discontinued: 'Discontinued',
                        suspended: 'Suspended'
                    };
                    const filterVal = statusMap[statusFilter.toLowerCase()];
                    projects = projects.filter(p => p.status === filterVal);
                }

                if (projects.length === 0) {
                    showNoProjectsTable(`There are no currently ${statusFilter.toLowerCase()} projects.`);
                    return;
                }

                const formattedProjects = projects.map(project => [
                    project.title || "N/A",
                    project.location || "N/A",
                    project.status || "N/A",
                    `₱${project.amount || "0.00"}`,
                    project.contractor || "N/A",
                    project.duration || "N/A",
                    project.action
                ]);

                // Destroy old table if it exists
                if ($.fn.DataTable.isDataTable("#projects")) {
                    $('#projects').DataTable().clear().destroy();
                }

                $('#projects').DataTable({
                    data: formattedProjects,
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
                    processing: true,
                    order: [[3, 'desc']],
                    columnDefs: [{ targets: '_all', orderable: true }],
                    fixedColumns: { leftColumns: 1 }
                });

                $("#projects-container").show();

                // Overview click event
                $(document).off('click', '.overview-btn').on('click', '.overview-btn', function () {
                    const projectId = $(this).data('id');
                    sessionStorage.setItem('project_id', projectId);
                    const role = sessionStorage.getItem('user_role');

                    switch (role) {
                        case 'Admin':
                            window.location.href = `/admin/overview/${projectId}`;
                            break;
                        case 'System Admin':
                            window.location.href = `/systemAdmin/overview/${projectId}`;
                            break;
                        case 'Staff':
                            window.location.href = `/staff/overview/${projectId}`;
                            break;
                        default:
                            alert("Unauthorized: Unknown role.");
                    }
                });
            },
            error: function (xhr) {
                Swal.close();
                console.error("AJAX Error:", xhr.responseText);
                let msg = "An error occurred while fetching project data.";
                if (xhr.status === 404) msg = "No project data found.";
                else if (xhr.status === 500) msg = "Internal Server Error.";
                showError(msg);
            }
        });
    }

    function showError(message) {
        $("#projects-container").hide();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            timer: 10000,
            showConfirmButton: false
        });
    }

    function showNoProjectsTable(msg) {
        if ($.fn.DataTable.isDataTable("#projects")) {
            $('#projects').DataTable().clear().destroy();
        }

        $('#projects').DataTable({
            data: [[msg, '', '', '', '', '', '']],
            columns: [
                { title: "Project Title" },
                { title: "Location" },
                { title: "Status" },
                { title: "Contract Amount" },
                { title: "Contractor" },
                { title: "Duration" },
                { title: "Action", orderable: false }
            ],
            columnDefs: [{
                targets: 0,
                render: function (data) {
                    return `<td colspan="7" style="text-align:center;">${data}</td>`;
                }
            }],
            ordering: false,
            paging: false,
            searching: false,
            info: false
        });

        $("#projects-container").show();
    }
});

// $(document).ready(function () {
//     fetchRecentProjects();
//     function fetchRecentProjects() {
//         $.ajax({
//             url: "/projects/ProjectDetails",
//             type: "GET",
//             dataType: "json",
//             success: function (data) {
//                 if (!data || typeof data !== 'object' || data.status !== "success") {
//                     return Swal.fire({
//                         icon: 'error',
//                         title: 'Data Error',
//                         text: data.message || 'Unexpected response from server.',
//                     });
//                 }

//                 if (Array.isArray(data.projects) && data.projects.length === 0) {
//                     return Swal.fire({
//                         icon: 'info',
//                         title: 'No Projects Found',
//                         text: data.message || 'There are no recently added projects.',
//                         timer: 10000,  // Close after 5 seconds
//                         showConfirmButton: false,  // Remove the OK button
//                     }); 
//                 }

//                 // Re-initialize DataTable if it already exists
//                 if ($.fn.DataTable.isDataTable("#recentProjects")) {
//                     $('#recentProjects').DataTable().clear().destroy();
//                 }

//                 $('#recentProjects').DataTable({
//                     data: data.projects,
//                     columns: [
//                         { data: 'title', title: "Project Title" },
//                         { data: 'location', title: "Location" },
//                         { data: 'status', title: "Status" },
//                         { data: 'amount', title: "Contract Amount" },
//                         { data: 'contractor', title: "Contractor" },
//                         { data: 'duration', title: "Duration" },
//                         { data: 'action', title: "Action", orderable: false }
//                     ],
//                     responsive: true,
//                     scrollX: true,
//                     paging: true,
//                     searching: true,
//                     autoWidth: false,
//                     aLengthMenu: [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
//                     pageLength: 10,
//                     processing: true,
//                     order: [[3, 'desc']],
//                     columnDefs: [{ targets: '_all', orderable: true }],
//                     fixedColumns: { leftColumns: 1 }
//                 });
//             },
//             error: function (xhr, status, error) {
//                 console.error("AJAX Error:", error);
//                 Swal.fire({
//                     icon: 'error',
//                     title: 'Fetch Error',
//                     text: xhr.responseJSON?.message || 'An error occurred while fetching project data.',
//                 });
//             }
//         });
//     }

// });

// $(document).ready(function () {
//     // Initially hide the table
//     $("#projects-container").hide(); 

//     // Load projects and initialize DataTable
//     loadProjects();
//     $('#location_filter, #contractor_filter, #amount_filter, #status_filter').on('input change', function () {
//         filterProjects();
//     });

//     const urlParams = new URLSearchParams(window.location.search);
//     const statusFilter = urlParams.get('page'); // e.g., 'ongoing', 'started', etc.

//     function loadProjects() {
//         const urlParams = new URLSearchParams(window.location.search);
//         const statusFilter = urlParams.get('page'); // Get query parameter (e.g., ?page=started)

//         $.ajax({
//             url: "/projects/ProjectDetails",
//             method: "GET",
//             dataType: "json",
//             success: function (response) {
//                 Swal.close(); // Hide loading when done

//                 if (!response || typeof response !== "object" || !Array.isArray(response.projects)) {
//                     console.error("Invalid API Response Structure:", response);
//                     showError("Failed to fetch project data. Please try again.");
//                     return;
//                 }

//                 if (response.projects.length === 0) {
//                     Swal.fire({
//                         icon: 'info',
//                         title: 'No Projects Found',
//                         text: 'There are no currently added projects. Please add one first.',
//                         timer: 10000,
//                         showConfirmButton: false,
//                     });
//                     return;
//                 }

//                 let filteredProjects = response.projects;

//                 // Apply filtering only if a dashboard card was clicked
//                 if (statusFilter) {
//                     const statusMap = {
//                         tobestarted: 'To Be Started',
//                         ongoing: 'Ongoing',
//                         completed: 'Completed',
//                         discontinued: 'Discontinued',
//                         suspended: 'Suspended'
//                     };
                    
//                     const actualStatus = statusMap[statusFilter?.toLowerCase()];
                    
//                     if (actualStatus) {
//                         filteredProjects = response.projects.filter(p =>
//                             p.status === actualStatus
//                         );
                    

//                         if (filteredProjects.length === 0) {
                            
//                             if ($.fn.DataTable.isDataTable("#projects")) {
//                                 // Update existing DataTable
//                                 var table = $('#projects').DataTable();
//                                 table.clear(); // Clear existing data
//                                 table.rows.add(projects); // Add new data
//                                 table.draw(); // Redraw the table
//                             }

//                             $('#projects').DataTable({
//                                 data: [[`There are no currently ${statusFilter.toLowerCase()} projects.`, '', '', '', '', '', '']],
//                                 columns: [
//                                     { title: "Project Title" },
//                                     { title: "Location" },
//                                     { title: "Status" },
//                                     { title: "Contract Amount" },
//                                     { title: "Contractor" },
//                                     { title: "Duration" },
//                                     { title: "Action", orderable: false }
//                                 ],
//                                 columnDefs: [{
//                                     targets: 0,
//                                     render: function (data) {
//                                         return `<td colspan="7" style="text-align:center;">${data}</td>`;
//                                     }
//                                 }],
//                                 ordering: false,
//                                 paging: false,
//                                 searching: false,
//                                 info: false
//                             });

//                             $("#projects-container").show();
//                             return;
//                         }
//                     }
//                 }

//                 const projects = filteredProjects.map(project => [
//                     project.title || "N/A",
//                     project.location || "N/A",
//                     project.status || "N/A",
//                     `₱${project.amount || "0.00"}`,
//                     project.contractor || "N/A",
//                     project.duration || "N/A",
//                     project.action
//                 ]);

        
//                 $('#projects').DataTable({
//                     data: projects,
//                     columns: [
//                         { title: "Project Title" },
//                         { title: "Location" },
//                         { title: "Status" },
//                         { title: "Contract Amount" },
//                         { title: "Contractor" },
//                         { title: "Duration" },
//                         { title: "Action", orderable: false }
//                     ],
//                     responsive: true,
//                     scrollX: true,
//                     paging: true,
//                     searching: true,
//                     autoWidth: false,
//                     aLengthMenu: [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
//                     pageLength: 10,
//                     order: [[3, 'desc']],
//                     processing: true,
//                     columnDefs: [
//                         { targets: '_all', orderable: true }
//                     ],
//                     fixedColumns: {
//                         leftColumns: 1
//                     }
//                 });

//                 $(document).off('click', '.overview-btn').on('click', '.overview-btn', function () {
//                     const projectId = $(this).data('id');
//                     sessionStorage.setItem('project_id', projectId);

//                     const role = sessionStorage.getItem('user_role');
//                     if (role === 'Admin') {
//                         window.location.href = `/admin/overview/${projectId}`;
//                     } else if (role === 'System Admin') {
//                         window.location.href = `/systemAdmin/overview/${projectId}`;
//                     } else if (role === 'Staff') {
//                         window.location.href = `/staff/overview/${projectId}`;
//                     } else {
//                         alert("Unauthorized: Unknown role.");
//                     }
//                 });

//                 $("#projects-container").show();
//             },
//             error: function (xhr) {
//                 Swal.close();
//                 console.error("AJAX Error:", xhr.responseText);
//                 let errorMessage = "Failed to load project data.";

//                 if (xhr.status === 404) {
//                     errorMessage = "No project data found.";
//                 } else if (xhr.status === 500) {
//                     errorMessage = "Internal Server Error. Please try again later.";
//                 }

//                 showError(errorMessage);
//             }
//         });
//     }

// // Function to show errors
// function showError(message) {
//     function showError(message) {
//         Swal.fire({
//             icon: 'error',
//             title: 'Error',
//             text: message,
//             timer: 10000,  // Close after 5 seconds
//             showConfirmButton: false,  // Remove the OK button
//         });
//     }
    
//     $("#projects-container").hide(); // Ensure table remains hidden if there's an error
// }
// });



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

$(document).ready(function () {
function fetchTrashedProjects() {
    $.ajax({
        url: "/projects/fetch-trash",
        method: "GET",
        dataType: "json",
        success: function(response) {
            Swal.close(); // Close the loading alert

            if ($.fn.DataTable.isDataTable('#trashList')) {
                $('#trashList').DataTable().destroy();
            }

            let table = $('#trashList').DataTable({
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
                },
                data: [],
                columns: [
                    { title: "Title" },
                    { title: "Location" },
                    { title: "Status" },
                    { title: "Amount" },
                    { title: "Contractor" },
                    { title: "Duration" },
                    { title: "Action" }
                ]
            });

            table.clear();

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
            Swal.close();
            Swal.fire("Error!", "Failed to fetch trashed projects. Please try again.", "error");
        }
    });
}


fetchTrashedProjects();
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