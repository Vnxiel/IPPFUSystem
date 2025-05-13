    function showLocDropdown() {
        const dropdown = document.getElementById('projectLocDropdown');
        if (dropdown) {
            dropdown.style.display = 'block';
        }
    }

    function selectLoc(value) {
        document.getElementById('projectLoc').value = value + ', Nueva Vizcaya';
        document.getElementById('projectLocDropdown').style.display = 'none';
    }

    const select = document.getElementById('projectYear');
    const currentYear = new Date().getFullYear();
    const startYear = 2015; // Set your desired start year

    for (let year = currentYear; year >= startYear; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        select.appendChild(option);
    }

    // Hide when clicking outside
    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('projectLocDropdown');
        const input = document.getElementById('projectLoc');

        if (!dropdown.contains(event.target) && event.target !== input) {
            dropdown.style.display = 'none';
        }
    });

    document.querySelectorAll('.currency-input').forEach(input => {
    input.addEventListener('input', () => {
        let value = input.value.replace(/[^0-9.]/g, '');
        let parts = value.split('.');
        let intPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        let decimalPart = parts[1] ? '.' + parts[1].slice(0, 2) : '';
        input.value = intPart + decimalPart;
    });
});

document.querySelector('form').addEventListener('submit', () => {
    document.querySelectorAll('.currency-input').forEach(input => {
        input.value = input.value.replace(/[^0-9.]/g, '');
    });
});

document.getElementById('projectID').addEventListener('input', function(event) {
        // Replace anything that is not a number or hyphen
        event.target.value = event.target.value.replace(/[^0-9-]/g, '');
    });

document.querySelectorAll('.currency-input').forEach(input => {
    input.addEventListener('blur', () => {
        let value = parseFloat(input.value.replace(/[^0-9.]/g, ''));
        input.value = isNaN(value) ? '' : value.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    });
});
