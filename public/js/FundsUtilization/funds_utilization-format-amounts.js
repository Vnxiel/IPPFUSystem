// Utility to parse a string amount (removing commas, spaces, etc.)
function parseAmount(value) {
    return parseFloat(value.replace(/[^0-9.]/g, '')) || 0;
}

// Format number with comma separators and two decimals
function formatWithCommasAndTwoDecimals(value) {
    return parseAmount(value).toLocaleString('en-US', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

// Format input field with full formatting on blur
function formatInput(input) {
    input.value = formatWithCommasAndTwoDecimals(input.value);
}

// Lightweight formatting while typing (removes invalid chars and updates commas)
function formatInputLive(input) {
    let raw = input.value.replace(/[^0-9.]/g, '');

    // Allow only one decimal point
    const firstDotIndex = raw.indexOf('.');
    raw = raw.replace(/\./g, (match, offset) => offset === firstDotIndex ? '.' : '');

    let parts = raw.split('.');
    let integerPart = parts[0].replace(/^0+(?=\d)/, ''); // Remove leading zeros
    let decimalPart = parts[1] !== undefined ? parts[1] : null;

    // Add commas
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

    input.value = decimalPart !== null ? `${integerPart}.${decimalPart}` : integerPart;

    // If user types just "." or ends with ".", preserve it
    if (raw.endsWith('.') && decimalPart === null) {
        input.value += '.';
    }
}


// Initialize all .amount-input fields with event listeners
function initAmountInputs() {
    const amountInputs = document.querySelectorAll('.amount-input');
    amountInputs.forEach(input => {
        // Format on initial load
        if (input.value.trim() !== '') {
            formatInput(input);
        }

        // Live formatting
        input.addEventListener('input', function () {
            formatInputLive(this);
        });

        // Final formatting on blur
        input.addEventListener('blur', function () {
            formatInput(this);
        });
    });
}

// Initialize formatting once DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    initAmountInputs();
});
