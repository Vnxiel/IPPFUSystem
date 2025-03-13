$(document).ready(function() {
    $('#recentProjects').DataTable({
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
    $('#projects').DataTable({
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

$(document).ready(function() {
    $('#projectFiles').DataTable({
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