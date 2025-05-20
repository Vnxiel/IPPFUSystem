// ========== Currency Utilities ==========
function parseCurrency(value) {
    return parseFloat(String(value || '0').replace(/[₱,]/g, '')) || 0;
}


function formatCurrency(value) {
    return value.toLocaleString("en-PH", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function formatToPeso(value) {
    const number = parseCurrency(value);
    return isNaN(number) ? '' : `₱ ${formatCurrency(number)}`;
}

function unformatCurrency(value) {
    return value.replace(/[^0-9.-]+/g, '');
}

// ========== Currency Formatting Setup ==========
// Max digits before decimal for your orig_abc decimal(15, 2) is 13
const MAX_INT_DIGITS = 13;
const MAX_DECIMAL_DIGITS = 2;

function setupCurrencyInputs() {
    const inputs = document.querySelectorAll('.currency-input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.value = unformatCurrency(input.value) || '';
        });

        input.addEventListener('blur', () => {
            if (input.value.trim() !== '') {
                input.value = formatToPeso(input.value);
            }
        });

        input.addEventListener('input', () => {
            let value = input.value.replace(/[^0-9.]/g, '');

            const firstDot = value.indexOf('.');
            if (firstDot !== -1) {
                let beforeDot = value.substring(0, firstDot);
                let afterDot = value.substring(firstDot + 1).replace(/\./g, '');

                // Enforce max digits before decimal
                if (beforeDot.length > MAX_INT_DIGITS) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limit Exceeded',
                        text: `Maximum allowed digits before decimal is ${MAX_INT_DIGITS}.`
                    });
                    beforeDot = beforeDot.slice(0, MAX_INT_DIGITS);
                }

                // Enforce max digits after decimal
                if (afterDot.length > MAX_DECIMAL_DIGITS) {
                    afterDot = afterDot.slice(0, MAX_DECIMAL_DIGITS);
                }

                value = beforeDot + '.' + afterDot;
            } else {
                // No decimal point — enforce max digits
                if (value.length > MAX_INT_DIGITS) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Limit Exceeded',
                        text: `Maximum allowed digits is ${MAX_INT_DIGITS}.`
                    });
                    value = value.slice(0, MAX_INT_DIGITS);
                }
            }

            // Remove leading zeros but keep one zero if all are zeros
            let [intPart, decimalPart] = value.split('.');
            intPart = intPart.replace(/^0+/, '') || '0';

            // Format integer with commas
            intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            input.value = decimalPart !== undefined
                ? `${intPart}.${decimalPart}`
                : intPart;
        });

        // Initial blur to apply formatting if needed
        if (input.value.trim() !== '') input.dispatchEvent(new Event('blur'));
    });

    // On form submit: unformat all values
    document.querySelector('form')?.addEventListener('submit', () => {
        inputs.forEach(input => input.value = parseCurrency(input.value));
    });
}


// Optional: Appropriation validation on blur
function setupAppropriationValidation(limitedFields = [], appropriationId = 'appropriation') {
    const appropriationInput = document.getElementById(appropriationId);
    if (!appropriationInput) return;

    limitedFields.forEach(id => {
        const field = document.getElementById(id);
        if (!field) return;

        field.addEventListener('blur', () => {
            const appropriation = parseCurrency(appropriationInput.value);
            const value = parseCurrency(field.value);

            if (value > appropriation) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Exceeds Appropriation',
                    text: `${field.labels[0]?.innerText || id} must not exceed Appropriation amount.`,
                    confirmButtonColor: '#dc3545'
                });
                field.value = '';
                field.focus();
            }
        });
    });
}

// On DOM ready
document.addEventListener('DOMContentLoaded', () => {
    setupCurrencyInputs();
    setupAppropriationValidation(
        ['abc', 'contractAmount', 'engineering', 'mqc', 'contingency']
    );

    // === Bind updateBidDifference to input blur events ===
    document.getElementById('abc')?.addEventListener('blur', updateBidDifference);
    document.getElementById('contractAmount')?.addEventListener('blur', updateBidDifference);

});
