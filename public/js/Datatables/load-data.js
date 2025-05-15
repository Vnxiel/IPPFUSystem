// ✅ Global scope
var dataTable = null;

$(document).ready(function () {
    $("#projects-container").hide();

    const hasData = $('#projects tbody tr').length > 0 &&
        !$('#projects tbody tr td').first().attr('colspan');


    if (hasData) {
        // Initialize DataTable first
        dataTable = $('#projects').DataTable({
            responsive: true,
            scrollX: true,
            paging: true,
            searching: true,
            autoWidth: false,
            aLengthMenu: [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
            pageLength: 10,
            order: [[0, 'desc']],
            processing: true,
            columnDefs: [{ targets: '_all', orderable: true }],
            fixedColumns: { leftColumns: 1 }
        });

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
                $('#status_filter').val(actualStatus); // Set value
             
                setTimeout(() => {
                
                    dataTable.draw();
        
                    const filteredRows = dataTable.rows({ filter: 'applied' }).data().length;
                   
        
                    if (filteredRows === 0) {
                        dataTable.clear().draw();
                        $('#projects tbody').html(`
                            <tr>
                                <td colspan="8" class="text-center">There are no currently ${actualStatus.toLowerCase()} projects.</td>
                            </tr>
                        `);
                    } else {
                        console.log('[FILTER WORKED] Filtered projects shown.');
                    }
                }, 500); // Slight delay to ensure DOM settles
            } else {
                console.warn('[STATUS MAP FAIL] No match for:', statusFilter);
            }
        }
        

        // AFTER dataTable is initialized
        $('#clear_filters_btn').on('click', function () {
            clearFilters();
        });

        // Restore and highlight previously selected project
        const highlightedId = localStorage.getItem('highlighted_project_id');
        const savedPage = localStorage.getItem('highlighted_project_page');

        if (highlightedId && savedPage !== null && savedPage !== 'preserve') {
            $('#projects').on('draw.dt', function highlightRow() {
                $('#projects').off('draw.dt', highlightRow);

                const newRow = $('#projects tbody tr').filter((_, el) => $(el).data('id') == highlightedId);
                if (newRow.length) {
                    newRow.addClass('table-success focus-highlight');
                    $('html, body').animate({ scrollTop: newRow.offset().top - 100 }, 500);
                }
            });

            dataTable.page(parseInt(savedPage)).draw('page');
        }

        $("#projects-container").show();
    }
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (!dataTable) return true;
    
        const viewAll = $('#view_all_checkbox').is(':checked');
        if (viewAll) return true;
    
        // Normalizer removes accents and diacritics like ñ, é, ü, etc.
        function normalize(str) {
            return (str || '')
                .normalize("NFD")                         // Separate accent marks
                .replace(/[\u0300-\u036f]/g, "")          // Remove accents
                .toLowerCase()
                .trim();
        }
    
        const location = normalize($('#location_filter').val());
        const contractor = normalize($('#contractor_filter').val());
        const amountInput = $('#amount_filter').val().replace(/[₱,]/g, '');
        const maxAmount = parseFloat(amountInput) || null;
        const status = normalize($('#status_filter').val());
    
        // Extract just the town before the comma
        const rowLocation = normalize((data[2] || '').split(',')[0]);
        const rowStatus = normalize(data[3]);
        const rowAmount = parseFloat((data[4] || '').replace(/[₱,]/g, '')) || 0;
        const rowContractor = normalize(data[5]);
    
        
    
        return (!location || rowLocation === location) &&
               (!contractor || rowContractor.includes(contractor)) &&
               (!maxAmount || rowAmount <= maxAmount) &&
               (!status || rowStatus.includes(status));
    });
    
    

    // Debounced filter triggers
    if (dataTable) {
        let filterTimer;
        $('#location_filter, #contractor_filter, #amount_filter, #status_filter, #view_all_checkbox').on('input change', function () {
            clearTimeout(filterTimer);
            filterTimer = setTimeout(() => {
                dataTable.draw();
            }, 150);
        });
    }

    // Highlight clicked row
    $(document).on('click', '#projects tbody tr', function (event) {
        // Avoid triggering when clicking on the button inside the row
        if ($(event.target).closest('button').length) return;

        $('#projects tbody tr').removeClass('focus-highlight');
        $(this).addClass('focus-highlight');

        const projectId = $(this).data('id');
        const pageNumber = dataTable ? dataTable.page() : 0;

        sessionStorage.setItem('project_id', projectId);
        localStorage.setItem('highlighted_project_id', projectId);
        localStorage.setItem('highlighted_project_page', pageNumber);

        const role = localStorage.getItem('user_role') || sessionStorage.getItem('user_role');
        const urlMap = {
            'Admin': `/admin/overview/${projectId}`,
            'System Admin': `/systemAdmin/overview/${projectId}`,
            'Staff': `/staff/overview/${projectId}`
        };

        if (urlMap[role]) {
            window.location.href = urlMap[role];
        } else {
            alert("Unauthorized: Unknown role.");
        }
    });


    // Overview button click
    $(document).on('click', '.overview-btn', function () {
        const projectId = $(this).data('id');
        const pageNumber = dataTable ? dataTable.page() : 0;

        sessionStorage.setItem('project_id', projectId);
        localStorage.setItem('highlighted_project_id', projectId);
        localStorage.setItem('highlighted_project_page', pageNumber);

        const role = localStorage.getItem('user_role') || sessionStorage.getItem('user_role');
        const urlMap = {
            'Admin': `/admin/overview/${projectId}`,
            'System Admin': `/systemAdmin/overview/${projectId}`,
            'Staff': `/staff/overview/${projectId}`
        };

        if (urlMap[role]) {
            window.location.href = urlMap[role];
        } else {
            alert("Unauthorized: Unknown role.");
        }
    });

    // Format amount input with commas
    $('#amount_filter').on('input', function () {
        let input = $(this).val().replace(/[^0-9.]/g, '');
        if (input) {
            let parts = input.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            $(this).val(parts.join('.'));
        }
    });
});

// Add highlight CSS to head
$('<style>')
    .prop('type', 'text/css')
    .html(`
        .focus-highlight {
            background-color: #d1e7dd !important;
            transition: background-color 0.3s ease;
            box-shadow: 0 0 10px #198754;
        }
    `)
    .appendTo('head');


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
    const hasData = $('#trashList tbody tr').length > 0 &&
                    $('#trashList tbody tr td').first().attr('colspan') !== '7';

    if (hasData) {
        $('#trashList').DataTable({
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