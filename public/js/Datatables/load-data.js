
$(document).ready(function () {
    // Hide the table container initially (optional, based on your UI preference)
    $("#projects-container").hide();

    // Show the table after DOM is ready (and data is already populated server-side)
    $("#projects-container").show();
    const hasData = $('#projects tbody tr').length > 0 &&
                    !$('#projects tbody tr td').first().attr('colspan');

    if (hasData) {
        $('#projects').DataTable({
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
    }
    // Overview button click handler
    $(document).on('click', '.overview-btn', function () {
        const projectId = $(this).data('id');
        sessionStorage.setItem('project_id', projectId);

        const role = sessionStorage.getItem('user_role');
        if (role === 'Admin') {
            window.location.href = `/admin/overview/${projectId}`;
        } else if (role === 'System Admin') {
            window.location.href = `/systemAdmin/overview/${projectId}`;
        } else if (role === 'Staff') {
            window.location.href = `/staff/overview/${projectId}`;
        } else {
            alert("Unauthorized: Unknown role.");
        }
    });

    // Filters
    $('#location_filter, #contractor_filter, #amount_filter, #status_filter').on('input change', function () {
        filterProjects();
    });

    // If filtering by status from URL query (e.g., ?page=ongoing)
    const urlParams = new URLSearchParams(window.location.search);
    const statusFilter = urlParams.get('page');

    if (statusFilter) {
        const statusMap = {
            tobestarted: 'Not Started',
            ongoing: 'Ongoing',
            completed: 'Completed',
            discontinued: 'Discontinued',
            suspended: 'Suspended'
        };

        const actualStatus = statusMap[statusFilter.toLowerCase()];
        if (actualStatus) {
            $('#projects tbody tr').each(function () {
                const statusText = $(this).find('td:eq(2)').text().trim();
                $(this).toggle(statusText === actualStatus);
            });

            // Show a message if no matching rows are found
            if ($('#projects tbody tr:visible').length === 0) {
                $('#projects tbody').html(`
                    <tr>
                        <td colspan="7" class="text-center">There are no currently ${statusFilter.toLowerCase()} projects.</td>
                    </tr>
                `);
            }
        }
    }

// Function to show errors
function showError(message) {
    function showError(message) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
            timer: 10000,  // Close after 5 seconds
            showConfirmButton: false,  // Remove the OK button
        });
    }
    
    $("#projects-container").hide(); // Ensure table remains hidden if there's an error
}
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
    "order": [[0, 'desc']],  // Sorting based on the first column (date and time)
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
                                <i class="fa fa-search"></i>
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