function validateYearInput(input) {
    // Remove any non-digit characters
    input.value = input.value.replace(/\D/g, '');

    // Limit to 4 digits
    if (input.value.length > 4) {
        input.value = input.value.slice(0, 4);
    }
}

function selectYear(year) {
    const input = document.getElementById('year_filter_input');
    input.value = year;
    document.getElementById('year_filter_dropdown').style.display = 'none';
}