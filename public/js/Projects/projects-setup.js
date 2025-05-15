// ========= Helper Functions ========= //
function parseCurrency(value) {
    return parseFloat(value.replace(/[^0-9.]/g, '')) || 0;
}

function formatCurrency(value) {
    return value.toLocaleString('en-PH', {
        style: 'currency',
        currency: 'PHP',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

// ========= Location Dropdown ========= //
function showLocDropdown() {
    const dropdown = document.getElementById('projectLocDropdown');
    if (dropdown) dropdown.style.display = 'block';
}

function selectLoc(value) {
    document.getElementById('projectLoc').value = value + ', Nueva Vizcaya';
    document.getElementById('projectLocDropdown').style.display = 'none';
}

function appendNuevaVizcaya() {
    const input = document.getElementById('projectLoc');
    let value = input.value;

    // Remove ', Nueva Vizcaya' if already present
    value = value.replace(/,\s*Nueva Vizcaya\s*$/i, '');

    // Re-append it
    if (value.trim() !== '') {
        input.value = value.trim() + ', Nueva Vizcaya';
    }
}

document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('projectLocDropdown');
    const input = document.getElementById('projectLoc');
    if (dropdown && !dropdown.contains(event.target) && event.target !== input) {
        dropdown.style.display = 'none';
    }
});

// ========= Year Dropdown ========= //
document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('projectYear');
    if (select) {
        const currentYear = new Date().getFullYear();
        for (let year = currentYear; year >= 2015; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            select.appendChild(option);
        }
    }
});

// ========= Currency Formatting ========= //
function setupCurrencyInputs() {
    const inputs = document.querySelectorAll('.currency-input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.value = parseCurrency(input.value) || '';
        });

        input.addEventListener('blur', () => {
            if (input.id !== 'bid') {
                const val = parseCurrency(input.value);
                input.value = val ? formatCurrency(val) : '';
            }
            updateBidDifference();
        });

        input.addEventListener('input', () => {
            let value = input.value.replace(/[^0-9.]/g, '');
            let parts = value.split('.');
            let intPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            let decimalPart = parts[1] ? '.' + parts[1].slice(0, 2) : '';
            input.value = intPart + decimalPart;
        });

        if (input.value.trim() !== '') input.dispatchEvent(new Event('blur'));
    });

    document.querySelector('form')?.addEventListener('submit', () => {
        inputs.forEach(input => input.value = parseCurrency(input.value));
    });
}

// ========= Input Restriction ========= //
document.getElementById('projectID')?.addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/[^0-9-]/g, '');
});

// ========= Bid Difference ========= //
function updateBidDifference() {
    const abc = parseCurrency(document.getElementById('abc')?.value);
    const contract = parseCurrency(document.getElementById('contractAmount')?.value);
    const bidInput = document.getElementById('bid');
    if (!isNaN(abc) && !isNaN(contract)) {
        bidInput.value = formatCurrency(abc - contract);
    }
}


// ========= Date Validations ========= //
function validateDatePairs(id1, id2, label) {
    const date1 = document.getElementById(id1);
    const date2 = document.getElementById(id2);

    function validate() {
        if (new Date(date2.value) <= new Date(date1.value) && date2.value) {
            Swal.fire({ icon: 'error', title: `${label} Error`, text: 'Received date must be after issued date.' });
            date2.value = '';
        }
    }

    date1.addEventListener('change', validate);
    date2.addEventListener('change', validate);
}

// ========= Contract Duration Calculation ========= //
function calculateCompletionDate() {
    const days = parseInt(document.getElementById('projectContractDays').value);
    const startDate = document.getElementById('originalStartDate').value;
    const targetField = document.getElementById('targetCompletion');

    if (startDate && days > 0) {
        const result = new Date(startDate);
        result.setDate(result.getDate() + days - 1);
        targetField.value = result.toISOString().split('T')[0];
    }
}

// ========= Revised Date Calculation ========= //
function updateRevisedDates() {
    const target = document.getElementById('targetCompletion').value;
    const extension = parseInt(document.getElementById('timeExtension').value);
    const revised = document.getElementById('revisedTargetCompletion');
    const actual = document.getElementById('completionDate');

    if (target && extension > 0) {
        const newDate = new Date(target);
        newDate.setDate(newDate.getDate() + extension);
        const formatted = newDate.toISOString().split('T')[0];
        revised.value = actual.value = formatted;
        revised.readOnly = actual.readOnly = true;
    } else {
        revised.readOnly = actual.readOnly = false;
    }
}

// ========= Dynamic Orders ========= //
let orderCount = 1;
function addOrderFields() {
    orderCount++;
    const container = document.getElementById('orderContainer');

    const newSet = document.createElement('div');
    newSet.classList.add('row', 'order-set');
    newSet.id = `orderSet${orderCount}`;
    newSet.innerHTML = `
        <div class="col-md-6 mb-1">
            <label for="suspensionOrderNo${orderCount}" class="form-label">Suspension Order No. ${orderCount}</label>
            <input type="date" class="form-control" id="suspensionOrderNo${orderCount}" name="suspensionOrderNo${orderCount}">
        </div>
        <div class="col-md-6 mb-1">
            <label for="resumeOrderNo${orderCount}" class="form-label">Resumption Order No. ${orderCount}</label>
            <input type="date" class="form-control" id="resumeOrderNo${orderCount}" name="resumeOrderNo${orderCount}">
        </div>`;
    container.appendChild(newSet);

    document.getElementById(`suspensionOrderNo${orderCount}`).addEventListener('change', () => validateOrderDates(orderCount));
    document.getElementById(`resumeOrderNo${orderCount}`).addEventListener('change', () => validateOrderDates(orderCount));
}

function removeLastOrderFields() {
    if (orderCount > 1) {
        document.getElementById(`orderSet${orderCount}`).remove();
        orderCount--;
    } else {
        Swal.fire({ icon: 'warning', title: 'Oops...', text: 'At least one order pair is required. Leave it blank if unused.' });
    }
}

function validateOrderDates(index) {
    const suspend = new Date(document.getElementById(`suspensionOrderNo${index}`).value);
    const resume = new Date(document.getElementById(`resumeOrderNo${index}`).value);
    if (resume <= suspend && resume) {
        Swal.fire({ icon: 'error', title: 'Invalid Date', text: 'Resumption must be later than suspension.' });
        document.getElementById(`resumeOrderNo${index}`).value = '';
    }
}

// ========= Autocomplete (Contractors & Municipalities) ========= //
const contractors = ['Kristine Joy Briones', 'Janessa Guillermo', 'CJenalyn Jumawan', 'Arjay Ordinario'];
const municipalities = ['Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi', 'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano', 'Villaverde', 'Ambaguio', 'Santa Fe', 'Lamut'];

function showSuggestions(query, source) {
    const suggestionsBox = document.getElementById('suggestionsBox');
    suggestionsBox.innerHTML = '';

    if (query.length > 0) {
        const filtered = source.filter(item => item.toLowerCase().includes(query.toLowerCase()));
        if (filtered.length > 0) {
            suggestionsBox.style.display = 'block';
            filtered.forEach(item => {
                const a = document.createElement('a');
                a.href = '#';
                a.className = 'list-group-item list-group-item-action';
                a.textContent = item;
                a.onclick = () => {
                    document.getElementById('projectLoc').value = item + ', Nueva Vizcaya';
                    suggestionsBox.style.display = 'none';
                };
                suggestionsBox.appendChild(a);
            });
        } else {
            suggestionsBox.style.display = 'none';
        }
    } else {
        suggestionsBox.style.display = 'none';
    }
}

function showLocationDropdown() {
    const input = $('#location_filter').val().toLowerCase();
    $('#location_filter_dropdown').show();

    $('#location_filter_dropdown .list-group-item').each(function () {
        const itemText = $(this).text().toLowerCase();
        if (!input || itemText.includes(input)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

function selectLocation(location) {
    $('#location_filter').val(location);
    $('#location_filter_dropdown').hide();
    $('#location_filter').trigger('input'); // Trigger DataTable filter
}

$(document).on('click', function (e) {
    if (!$(e.target).closest('#location_filter, #location_filter_dropdown').length) {

        $('#location_filter_dropdown').hide();
    }
});


// Function to allow a dropdown for contractors
const contractorInput = document.getElementById('projectContractor');
const dropdown = document.getElementById('projectContractorDropdown');

// Use the global variable defined in the Blade template
const contractorNames = window.contractorNames || [];

function filterAndReorderContractors() {
    const inputValue = contractorInput.value.toLowerCase();
    const matches = contractorNames
        .map(name => ({
            name,
            score: name.toLowerCase().startsWith(inputValue) ? 0 :
                   name.toLowerCase().includes(inputValue) ? 1 : 2
        }))
        .filter(item => item.score < 2)
        .sort((a, b) => a.score - b.score || a.name.localeCompare(b.name));

    dropdown.innerHTML = '';
    matches.forEach(item => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'list-group-item list-group-item-action';
        button.textContent = item.name;
        button.onclick = () => selectContractor(item.name);
        dropdown.appendChild(button);
    });

    dropdown.style.display = matches.length ? 'block' : 'none';
}

function selectContractor(name) {
    contractorInput.value = name;
    dropdown.style.display = 'none';
}

// Hide dropdown on outside click
document.addEventListener('click', function(event) {
    if (!contractorInput.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});

// Trigger dropdown filtering on input and focus
contractorInput.addEventListener('input', filterAndReorderContractors);
contractorInput.addEventListener('focus', filterAndReorderContractors);

        // Handle "Ongoing Status" Selection Toggle
        function toggleOngoingStatus() {
            let statusSelect = document.getElementById("projectStatus");
            let ongoingContainer = document.getElementById("ongoingStatusContainer");
            let ongoingDate = document.getElementById("ongoingDate");

            if (statusSelect.value === "Ongoing") {
                ongoingContainer.style.display = "block";

                // Set the ongoingDate to today's date
                let today = new Date().toISOString().split('T')[0];
                ongoingDate.value = today;
            } else {
                ongoingContainer.style.display = "none";
                ongoingDate.value = ""; // Clear the date when status is not "Ongoing"
            }
        }
// ========= INIT on Page Load ========= //
document.addEventListener('DOMContentLoaded', function () {
    toggleOngoingStatus();
    setupCurrencyInputs();
    validateDatePairs('noaIssuedDate', 'noaReceivedDate', 'Notice of Award');
    validateDatePairs('ntpIssuedDate', 'ntpReceivedDate', 'Notice to Proceed');
    document.getElementById('projectContractDays')?.addEventListener('input', calculateCompletionDate);
    document.getElementById('originalStartDate')?.addEventListener('change', calculateCompletionDate);
    document.getElementById('targetCompletion')?.addEventListener('change', updateRevisedDates);
    document.getElementById('timeExtension')?.addEventListener('input', updateRevisedDates);
    validateOrderDates(1); // first pair
});

