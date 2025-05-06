function filterProjects() {
    var table = $('#projects').DataTable();

    const viewAll = $('#view_all_checkbox').is(':checked');

    if (viewAll) {
        // Show all rows unconditionally
        table.rows().every(function () {
            $(this.node()).show();
        });
        return;
    }

    // Get filter values safely
    const location = ($('#location_filter').val() || '').toLowerCase();
    const contractor = ($('#contractor_filter').val() || '').toLowerCase();
    const rawAmount = $('#amount_filter').val();
    const amount = rawAmount ? rawAmount.replace(/[₱,]/g, '') : '';
    const status = ($('#status_filter').val() || '').toLowerCase();

    table.rows().every(function () {
        const data = this.data();
        const rowLocation = (data[1] || '').toLowerCase();
        const rowStatus = (data[2] || '').toLowerCase();
        const rowAmount = parseFloat((data[3] || '').replace(/[₱,]/g, '')) || 0;
        const rowContractor = (data[4] || '').toLowerCase();

        const match =
            (!location || rowLocation.includes(location)) &&
            (!contractor || rowContractor.includes(contractor)) &&
            (!amount || rowAmount <= parseFloat(amount)) &&
            (!status || rowStatus.includes(status));

        $(this.node()).toggle(match);
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

