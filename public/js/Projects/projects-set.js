
// Function to allow only numbers and hyphen
function restrictInput(event) {
    const regex = /^[0-9-]*$/;
    const value = event.target.value;
    if (!regex.test(value)) {
        event.target.value = value.replace(/[^0-9-]/g, ''); // Remove invalid characters
    }
}

// Get the input fields
const projectFPP = document.getElementById('projectFPP');
const projectRC = document.getElementById('projectRC');

// Add input event listeners to restrict characters
if (projectFPP) projectFPP.addEventListener('input', restrictInput);
if (projectRC) projectRC.addEventListener('input', restrictInput);

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


const yearSelect = document.getElementById('projectYear');

const dateInputs = [
    'noaIssuedDate', 'noaReceivedDate',
    'ntpIssuedDate', 'ntpReceivedDate',
    'originalStartDate', 'targetCompletion',
    'completionDate', 'revisedCompletionDate'
];

const select = document.getElementById('projectYear');
const startYear = 2015; // Set your desired start year

for (let year = currentYear; year >= startYear; year--) {
    const option = document.createElement('option');
    option.value = year;
    option.textContent = year;
    select.appendChild(option);
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


document.addEventListener("DOMContentLoaded", function () {
    const ongoingStatusInput = document.getElementById('ongoingStatus');

    ongoingStatusInput.addEventListener('blur', function () {
      const value = parseFloat(this.value.trim());

      if (isNaN(value) || value < 1 || value > 100) {
        Swal.fire({
          icon: 'warning',
          title: 'Invalid Percentage',
          text: 'Please enter a value between 1 and 100.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        }).then(() => {
          this.value = '';
          this.focus();
        });
      }
    });

    function parseCurrency(value) {
        return parseFloat((value || '0').replace(/[₱,]/g, '')) || 0;
    }

    function showError(fieldLabel) {
        Swal.fire({
        icon: 'warning',
        title: 'Limit Exceeded',
        text: `${fieldLabel} exceeds the Appropriation!`
        });
    }

    const fieldGroups = [
        { label: 'ABC', ids: ['abc'] },
        { label: 'Contract Amount', ids: ['contractAmount'] },
        { label: 'Engineering', ids: ['engineering'] },
        { label: 'MQC', ids: ['mqc'] },
        { label: 'Contingency', ids: ['contingency'] },
        { label: 'Bid Difference', ids: ['bid'] },
        { label: 'Appropriation', ids: ['appropriation'] } // Note: 'orig_appropriation' is the base limit
    ];

    fieldGroups.forEach(group => {
        group.ids.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('blur', function () {
            const appropriationValue = parseCurrency(document.getElementById('appropriation').value);
            const inputValue = parseCurrency(input.value);

          
            if (inputValue > appropriationValue) {
                console.warn(`✖ ${group.label} [${id}] exceeds appropriation`);
                showError(group.label);
                input.value = '';
            } else {
                console.log(`✔ ${group.label} [${id}] is within limit`);
            }
            });
        }
        });
    });

    
    //For Currency Input restriction and comma
    document.querySelectorAll('.currency-input').forEach(input => {
        input.addEventListener('input', () => {
            let value = input.value;
    
            // Remove all non-digit and non-dot characters
            value = value.replace(/[^0-9.]/g, '');
    
            // If more than one dot, keep only the first
            const firstDot = value.indexOf('.');
            if (firstDot !== -1) {
                const beforeDot = value.substring(0, firstDot);
                const afterDot = value.substring(firstDot + 1).replace(/\./g, '');
                value = beforeDot + '.' + afterDot;
            }
    
            // Split into integer and decimal parts
            let [intPart, decimalPart] = value.split('.');
    
            // Remove leading zeros, unless input is just "0" or "0.x"
            if (intPart.length > 1 && intPart.startsWith('0')) {
                intPart = intPart.replace(/^0+/, '') || '0';
            }
    
            // Format integer part with commas
            intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    
            // Keep up to two decimal digits
            if (decimalPart !== undefined) {
                decimalPart = decimalPart.slice(0, 2);
                input.value = `${intPart}.${decimalPart}`;
            } else {
                input.value = intPart;
            }
        });
    });

    //For Project ID Restriction
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
    

});

