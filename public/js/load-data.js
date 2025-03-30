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
    $('#trashList').DataTable({
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
