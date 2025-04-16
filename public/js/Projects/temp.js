
document.addEventListener("DOMContentLoaded", function () {
    const currencyInputs = document.querySelectorAll(".currency-input");

    currencyInputs.forEach(input => {
        // On focus: strip formatting for easier editing
        input.addEventListener("focus", function () {
            const raw = parseCurrency(input.value);
            input.value = raw ? raw : ''; // Keep blank if zero
        });

        // On blur: format unless it's empty
        input.addEventListener("blur", function () {
            if (input.id !== 'bid') {
                const raw = parseCurrency(input.value);
                input.value = raw ? formatCurrency(raw) : '';
            }
            updateBidDifference();
        });

        // Format pre-filled values
        if (input.value.trim() !== "") {
            input.dispatchEvent(new Event("blur"));
        }
    });

    function parseCurrency(value) {
        return parseFloat(value.replace(/[^0-9.]/g, "")) || 0;
    }

    function formatCurrency(value) {
        return value.toLocaleString("en-PH", {
            style: "currency",
            currency: "PHP",
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function updateBidDifference() {
        const abcInput = document.getElementById('abc');
        const contractInput = document.getElementById('contractAmount');
        const bidInput = document.getElementById('bid');

        const abc = parseCurrency(abcInput.value);
        const contractAmount = parseCurrency(contractInput.value);

        // Only calculate if both fields are filled
        if (abcInput.value.trim() !== '' && contractInput.value.trim() !== '') {
            const bidDifference = abc - contractAmount;
            bidInput.value = bidDifference !== 0 ? formatCurrency(bidDifference) : formatCurrency(0);
        } else {
            bidInput.value = '';
        }
    }

    // Trigger calculation while typing
    document.getElementById('abc').addEventListener('input', updateBidDifference);
    document.getElementById('contractAmount').addEventListener('input', updateBidDifference);
});


// Handle "Other Fund" Selection Toggle
function toggleOtherFund() {
    var sourceOfFunds = document.getElementById("sourceOfFunds").value;
    var otherFundContainer = document.getElementById("otherFundContainer");

    if (sourceOfFunds === "Others") {
        otherFundContainer.style.display = "block";
    } else {
        otherFundContainer.style.display = "none";
    }
}

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


// Add Event Listener for Project Status Dropdown
document.getElementById("projectStatus").addEventListener("change", function () {
    toggleOngoingStatus();
});


// Handle "Other Fund" Dropdown Change
$('#sourceOfFunds').on('change', function () {
    if ($(this).val() === 'Others') {
        $('#otherFundContainer').slideDown(); // Show input with animation
    } else {
        $('#otherFundContainer').slideUp(); // Hide input with animation
    }
});



let orderCount = 1;

// Function to add order fields dynamically
function addOrderFields() {
    orderCount++;
    const container = document.getElementById('orderContainer');

    const newSet = document.createElement('div');
    newSet.classList.add('row', 'order-set');
    newSet.id = `orderSet${orderCount}`;
    newSet.innerHTML = `
    <div class="col-md-6">
        <div class="mb-1">
            <label for="suspensionOrderNo${orderCount}" class="form-label">Suspension Order No. ${orderCount}</label>
            <input type="date" class="form-control" id="suspensionOrderNo${orderCount}" name="suspensionOrderNo${orderCount}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-1">
            <label for="resumeOrderNo${orderCount}" class="form-label">Resumption Order No. ${orderCount}</label>
            <input type="date" class="form-control" id="resumeOrderNo${orderCount}" name="resumeOrderNo${orderCount}">
        </div>
    </div>
`;

    container.appendChild(newSet);

    // Attach event listeners to the new input fields
    const suspensionOrderNo = document.getElementById(`suspensionOrderNo${orderCount}`);
    const resumeOrderNo = document.getElementById(`resumeOrderNo${orderCount}`);

    suspensionOrderNo.addEventListener('change', function () {
        validateOrderDates(orderCount);
    });

    resumeOrderNo.addEventListener('change', function () {
        validateOrderDates(orderCount);
    });
}

// Function to remove last order fields dynamically
function removeLastOrderFields() {
    if (orderCount > 1) {
        const lastSet = document.getElementById(`orderSet${orderCount}`);
        lastSet.remove();
        orderCount--;
    } else {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "You must keep at least one order pair. If none leave it blank.",
        });
    }
}

// Function to validate that resumeOrderNo is not earlier than or equal to suspensionOrderNo
function validateOrderDates(orderId) {
    const suspensionOrderNo = document.getElementById(`suspensionOrderNo${orderId}`);
    const resumeOrderNo = document.getElementById(`resumeOrderNo${orderId}`);

    const suspensionDate = new Date(suspensionOrderNo.value);
    const resumeDate = new Date(resumeOrderNo.value);

    if (resumeDate <= suspensionDate && resumeOrderNo.value !== '') {
        Swal.fire({
            icon: "error",
            title: "Invalid Date",
            text: "The resumption order date must be later than the suspension order date.",
        });
        resumeOrderNo.value = ''; // Clear the resume order field
    }
}

// Initial validation for the first order pair when the page loads
document.addEventListener("DOMContentLoaded", function () {
    const firstSuspensionOrderNo = document.getElementById('suspensionOrderNo1');
    const firstResumeOrderNo = document.getElementById('resumeOrderNo1');

    firstSuspensionOrderNo.addEventListener('change', function () {
        validateOrderDates(1);
    });

    firstResumeOrderNo.addEventListener('change', function () {
        validateOrderDates(1);
    });
});

@endsection

document.addEventListener("DOMContentLoaded", function () {
const currencyInputs = document.querySelectorAll(".currency-input");

currencyInputs.forEach(input => {
    // On focus: strip formatting for easier editing
    input.addEventListener("focus", function () {
        const raw = parseCurrency(input.value);
        input.value = raw ? raw : ''; // Keep blank if zero
    });

    // On blur: format unless it's empty
    input.addEventListener("blur", function () {
        if (input.id !== 'bid') {
            const raw = parseCurrency(input.value);
            input.value = raw ? formatCurrency(raw) : '';
        }
        updateBidDifference();
    });

    // Format pre-filled values
    if (input.value.trim() !== "") {
        input.dispatchEvent(new Event("blur"));
    }
});

function parseCurrency(value) {
    return parseFloat(value.replace(/[^0-9.]/g, "")) || 0;
}

function formatCurrency(value) {
    return value.toLocaleString("en-PH", {
        style: "currency",
        currency: "PHP",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function updateBidDifference() {
    const abcInput = document.getElementById('abc');
    const contractInput = document.getElementById('contractAmount');
    const bidInput = document.getElementById('bid');

    const abc = parseCurrency(abcInput.value);
    const contractAmount = parseCurrency(contractInput.value);

    // Only calculate if both fields are filled
    if (abcInput.value.trim() !== '' && contractInput.value.trim() !== '') {
        const bidDifference = abc - contractAmount;
        bidInput.value = bidDifference !== 0 ? formatCurrency(bidDifference) : formatCurrency(0);
    } else {
        bidInput.value = '';
    }
}

// Trigger calculation while typing
document.getElementById('abc').addEventListener('input', updateBidDifference);
document.getElementById('contractAmount').addEventListener('input', updateBidDifference);
});


// Handle "Other Fund" Selection Toggle
function toggleOtherFund() {
var sourceOfFunds = document.getElementById("sourceOfFunds").value;
var otherFundContainer = document.getElementById("otherFundContainer");

if (sourceOfFunds === "Others") {
    otherFundContainer.style.display = "block";
} else {
    otherFundContainer.style.display = "none";
}
}

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


// Add Event Listener for Project Status Dropdown
document.getElementById("projectStatus").addEventListener("change", function () {
toggleOngoingStatus();
});


// Handle "Other Fund" Dropdown Change
$('#sourceOfFunds').on('change', function () {
if ($(this).val() === 'Others') {
    $('#otherFundContainer').slideDown(); // Show input with animation
} else {
    $('#otherFundContainer').slideUp(); // Hide input with animation
}
});



let orderCount = 1;

// Function to add order fields dynamically
function addOrderFields() {
orderCount++;
const container = document.getElementById('orderContainer');

const newSet = document.createElement('div');
newSet.classList.add('row', 'order-set');
newSet.id = `orderSet${orderCount}`;
newSet.innerHTML = `
<div class="col-md-6">
    <div class="mb-1">
        <label for="suspensionOrderNo${orderCount}" class="form-label">Suspension Order No. ${orderCount}</label>
        <input type="date" class="form-control" id="suspensionOrderNo${orderCount}" name="suspensionOrderNo${orderCount}">
    </div>
</div>
<div class="col-md-6">
    <div class="mb-1">
        <label for="resumeOrderNo${orderCount}" class="form-label">Resumption Order No. ${orderCount}</label>
        <input type="date" class="form-control" id="resumeOrderNo${orderCount}" name="resumeOrderNo${orderCount}">
    </div>
</div>
`;

container.appendChild(newSet);

// Attach event listeners to the new input fields
const suspensionOrderNo = document.getElementById(`suspensionOrderNo${orderCount}`);
const resumeOrderNo = document.getElementById(`resumeOrderNo${orderCount}`);

suspensionOrderNo.addEventListener('change', function () {
    validateOrderDates(orderCount);
});

resumeOrderNo.addEventListener('change', function () {
    validateOrderDates(orderCount);
});
}

// Function to remove last order fields dynamically
function removeLastOrderFields() {
if (orderCount > 1) {
    const lastSet = document.getElementById(`orderSet${orderCount}`);
    lastSet.remove();
    orderCount--;
} else {
    Swal.fire({
        icon: "warning",
        title: "Oops...",
        text: "You must keep at least one order pair. If none leave it blank.",
    });
}
}

// Function to validate that resumeOrderNo is not earlier than or equal to suspensionOrderNo
function validateOrderDates(orderId) {
const suspensionOrderNo = document.getElementById(`suspensionOrderNo${orderId}`);
const resumeOrderNo = document.getElementById(`resumeOrderNo${orderId}`);

const suspensionDate = new Date(suspensionOrderNo.value);
const resumeDate = new Date(resumeOrderNo.value);

if (resumeDate <= suspensionDate && resumeOrderNo.value !== '') {
    Swal.fire({
        icon: "error",
        title: "Invalid Date",
        text: "The resumption order date must be later than the suspension order date.",
    });
    resumeOrderNo.value = ''; // Clear the resume order field
}
}

// Initial validation for the first order pair when the page loads
document.addEventListener("DOMContentLoaded", function () {
const firstSuspensionOrderNo = document.getElementById('suspensionOrderNo1');
const firstResumeOrderNo = document.getElementById('resumeOrderNo1');

firstSuspensionOrderNo.addEventListener('change', function () {
    validateOrderDates(1);
});

firstResumeOrderNo.addEventListener('change', function () {
    validateOrderDates(1);
});
});




//load the contractors name this is example only
const contractors = ['Kristine Joy Briones', 'Janessa Guillermo', 'CJenalyn Jumawan', 'Arjay Ordinario'];

function showSuggestions(query) {
const suggestionsBox = document.getElementById('suggestionsBox');
suggestionsBox.innerHTML = ''; // Clear previous suggestions

if (query.length > 0) {
    const filteredContractors = contractors.filter(contractor => contractor.toLowerCase().includes(query.toLowerCase()));

    if (filteredContractors.length > 0) {
        suggestionsBox.style.display = 'block';
        filteredContractors.forEach(contractor => {
            const item = document.createElement('a');
            item.href = '#';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = contractor;
            suggestionsBox.appendChild(item);
        });
    } else {
        suggestionsBox.style.display = 'none';
    }
} else {
    suggestionsBox.style.display = 'none';
}
}


// Predefined list of municipalities in Nueva Vizcaya
const municipalities = [
'Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi',
'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano',
'Villaverde', 'Ambaguio', 'Santa Fe', 'Lamut'
];

function showMunicipalitySuggestions(query) {
const suggestionsBox = document.getElementById('suggestionsBox');
suggestionsBox.innerHTML = ''; // Clear previous suggestions

if (query.length > 0) {
    // Filter the municipalities based on the user input
    const filteredMunicipalities = municipalities.filter(municipality => municipality.toLowerCase().includes(query.toLowerCase()));

    if (filteredMunicipalities.length > 0) {
        suggestionsBox.style.display = 'block';
        filteredMunicipalities.forEach(municipality => {
            const item = document.createElement('a');
            item.href = '#';
            item.className = 'list-group-item list-group-item-action';
            item.textContent = municipality;
            item.onclick = function () {
                document.getElementById('projectLoc').value = municipality + ', Nueva Vizcaya'; // Auto-format the location
                suggestionsBox.style.display = 'none'; // Hide suggestions after selection
            };
            suggestionsBox.appendChild(item);
        });
    } else {
        suggestionsBox.style.display = 'none';
    }
} else {
    suggestionsBox.style.display = 'none';
}
}

document.addEventListener("DOMContentLoaded", function () {
const contractorSelect = document.getElementById("projectContractor");
const othersContractorDiv = document.getElementById("othersContractorDiv");
const othersContractorInput = document.getElementById("othersContractor");

contractorSelect.addEventListener("change", function () {
    if (this.value === "Others") {
        // Show the "Specify New Contractor" text box
        othersContractorDiv.style.display = "block";
    } else {
        // Hide the "Specify New Contractor" text box if anything else is selected
        othersContractorDiv.style.display = "none";
        othersContractorInput.value = ""; // Clear input if not "Others"
    }
});
});



document.addEventListener("DOMContentLoaded", function () {
function validateDates(issuedId, receivedId, label) {
    const issued = document.getElementById(issuedId);
    const received = document.getElementById(receivedId);

    function checkDate() {
        if (issued.value && received.value) {
            const issuedDate = new Date(issued.value);
            const receivedDate = new Date(received.value);

            // Only validate if both dates are valid
            if (!isNaN(issuedDate) && !isNaN(receivedDate)) {
                if (receivedDate <= issuedDate) {
                    Swal.fire({
                        icon: 'error',
                        title: `${label} Error`,
                        text: 'Received date must be after the issued date.',
                        confirmButtonColor: '#3085d6',
                    });
                    received.value = ""; // Clear invalid input
                }
            }
        }
    }

    // Use blur instead of change so it fires after typing and moving away
    issued.addEventListener("blur", checkDate);
    received.addEventListener("blur", checkDate);
}

validateDates("noaIssuedDate", "noaReceivedDate", "Notice of Award");
validateDates("ntpIssuedDate", "ntpReceivedDate", "Notice to Proceed");
});




document.addEventListener("DOMContentLoaded", function () {
const contractDaysInput = document.getElementById("projectContractDays");
const startDateInput = document.getElementById("officialStart");
const completionDateInput = document.getElementById("targetCompletion");

function calculateCompletionDate() {
    const startDateValue = startDateInput.value;
    const contractDays = parseInt(contractDaysInput.value);

    if (startDateValue && contractDays > 0) {
        const startDate = new Date(startDateValue);
        const completionDate = new Date(startDate);
        completionDate.setDate(startDate.getDate() + contractDays - 1); // minus 1 here
        const formatted = completionDate.toISOString().split('T')[0];
        completionDateInput.value = formatted;
    }
}

contractDaysInput.addEventListener("input", calculateCompletionDate);
startDateInput.addEventListener("change", calculateCompletionDate);
});

document.addEventListener("DOMContentLoaded", function () {
const targetCompletionInput = document.getElementById("targetCompletion");
const timeExtensionInput = document.getElementById("timeExtension");
const revisedTargetInput = document.getElementById("revisedTargetCompletion");
const completionDateInput = document.getElementById("completionDate");

function updateDates() {
    const targetDateValue = targetCompletionInput.value;
    const timeExtension = parseInt(timeExtensionInput.value);

    if (targetDateValue && !isNaN(timeExtension) && timeExtension > 0) {
        const targetDate = new Date(targetDateValue);
        const revisedDate = new Date(targetDate);
        revisedDate.setDate(targetDate.getDate() + timeExtension);

        const formatted = revisedDate.toISOString().split('T')[0];

        revisedTargetInput.value = formatted;
        completionDateInput.value = formatted;

        revisedTargetInput.readOnly = true;
        completionDateInput.readOnly = true;
    } else {
        revisedTargetInput.readOnly = false;
        completionDateInput.readOnly = false;
    }
}

targetCompletionInput.addEventListener("change", updateDates);
timeExtensionInput.addEventListener("input", updateDates);
});