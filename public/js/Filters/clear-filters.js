function clearFilters() {
    // Get filter inputs safely
    const locationFilter = document.getElementById('location_filter');
    const contractorFilter = document.getElementById('contractor_filter');
    const amountFilter = document.getElementById('amount_filter');
    const statusFilter = document.getElementById('status_filter');
    const viewAllCheckbox = document.getElementById('view_all_checkbox');
    const locationDropdown = document.getElementById('locationDropdown');

    // Clear input values if they exist
    if (locationFilter) locationFilter.value = '';
    if (contractorFilter) contractorFilter.value = '';
    if (amountFilter) amountFilter.value = '';
    if (statusFilter) statusFilter.value = '';
    if (viewAllCheckbox) viewAllCheckbox.checked = false;


    // Hide the dropdown if it exists
    if (locationDropdown) locationDropdown.style.display = 'none';

    // Re-run filtering logic if defined
    if (typeof filterProjects === 'function') {
        filterProjects();
    } else {
        console.warn('filterProjects() is not defined.');
    }
}
