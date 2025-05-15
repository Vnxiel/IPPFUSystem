function filterProjects(dataTable) {
    const viewAll = $('#view_all_checkbox').is(':checked');

    if (viewAll) {
        dataTable.search('').draw(); // Reset any search
        $('#view_all_checkbox').prop('checked', false); // Uncheck the checkbox
        return;
    }
    

    const location = ($('#location_filter').val() || '').toLowerCase();
    const contractor = ($('#contractor_filter').val() || '').toLowerCase();
    const rawAmount = $('#amount_filter').val();
    const amount = rawAmount ? rawAmount.replace(/[₱,]/g, '') : '';
    const status = ($('#status_filter').val() || '').toLowerCase();

    // Filtering data in the DataTable based on the input values
    dataTable.rows().every(function () {
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

        // Show or hide the row based on the match
        if (match) {
            $(this.node()).show();
        } else {
            $(this.node()).hide();
        }
    });

    dataTable.draw(); // Redraw DataTable after filtering
}
