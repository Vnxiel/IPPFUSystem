function filterProjects() {
    var table = $('#projects').DataTable();

    // Get filter values
    const location = $('#location_filter').val().toLowerCase();
    const contractor = $('#contractor_filter').val().toLowerCase();
    const amount = $('#amount_filter').val().replace(/[₱,]/g, '');
    const status = $('#status_filter').val().toLowerCase();

    // Use DataTables built-in filtering
    table.rows().every(function () {
        const data = this.data();
        const rowLocation = (data[1] || '').toLowerCase();    // Location column
        const rowStatus = (data[2] || '').toLowerCase();      // Status column
        const rowAmount = parseFloat((data[3] || '').replace(/[₱,]/g, '')) || 0;
        const rowContractor = (data[4] || '').toLowerCase();  // Contractor column

        const match =
            (!location || rowLocation.includes(location)) &&
            (!contractor || rowContractor.includes(contractor)) &&
            (!amount || rowAmount <= parseFloat(amount)) &&
            (!status || rowStatus.includes(status));

        if (match) {
            $(this.node()).show(); 
        } else {
            $(this.node()).hide();
        }
    });
}

$(document).ready(function () {
    $('#amount_filter').on('input', function () {
        let input = $(this).val().replace(/[^0-9.]/g, ''); // Remove non-numeric characters
        if (input) {
            let parts = input.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ','); // Add commas
            $(this).val(parts.join('.'));
        }
    });
});

