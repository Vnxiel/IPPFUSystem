function clearFilters() {
    $('#location_filter').val('');
    $('#contractor_filter').val('');
    $('#amount_filter').val('');
    $('#status_filter').val('');
    $('#view_all_checkbox').prop('checked', false); // Set to false instead of true
    $('#locationDropdown').hide();

    if (typeof dataTable !== 'undefined' && dataTable !== null) {
        dataTable.draw(); // Triggers your custom filtering logic
    } else {
        console.warn('DataTable is not available.');
    }
}
