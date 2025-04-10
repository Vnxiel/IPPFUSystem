$(document).ready(function() {
    var table = $('#projects').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("projects.getData") }}',  // Your route to the controller
            data: function(d) {
                d.status = $('#status_filter').val();  // Get value from Status filter
                d.contractor = $('#contractor_filter').val();  // Get value from Contractor filter
            },
            error: function(xhr, error, thrown) {
                console.error("DataTables Error:", xhr.responseText);  // Log the error response to console
            }
        },
        columns: [
            { data: 'title', name: 'title' },
            { data: 'location', name: 'location' },
            { data: 'status', name: 'status' },
            { data: 'contract_amount', name: 'contract_amount' },
            { data: 'contractor', name: 'contractor' },
            { data: 'duration', name: 'duration' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Trigger table redraw when filters change
    $('#status_filter, #contractor_filter').change(function () {
        table.draw();  // Redraw the table with updated filter values
    });
});
$(document).ready(function() {
    var table = $('#projects').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("projects.getData") }}',
            method: 'GET',  // You can use POST if needed
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')  // Add CSRF token to request
            },
            data: function(d) {
                d.status = $('#status_filter').val(); 
                d.contractor = $('#contractor_filter').val(); 
            },
            error: function(xhr, error, thrown) {
                console.error("DataTables Error:", xhr.responseText);
            }
        },
        columns: [ ... ]
    });
});
