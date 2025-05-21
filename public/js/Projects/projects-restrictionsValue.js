// ========== Input Restriction Functions ==========
function restrictToNumbersAndHyphen(event) {
    const regex = /^[0-9-]*$/;
    const value = event.target.value;
    if (!regex.test(value)) {
        event.target.value = value.replace(/[^0-9-]/g, '');
    }
}

// ========== Apply Restrictions ==========
document.addEventListener('DOMContentLoaded', () => {
    // Restrict for specific fields
    ['projectFPP', 'projectRC', 'projectID'].forEach(id => {
        const field = document.getElementById(id);
        if (field) {
            field.addEventListener('input', restrictToNumbersAndHyphen);
        }
    });

   // ========== Avoid contract amount higher than abc ==========
        const abcInput = document.getElementById("abc");
        const contractInput = document.getElementById("contractAmount");
    
        if (!abcInput || !contractInput) return;
    
        function parseCurrency(value) {
            if (!value) return 0;
            return parseFloat(value.replace(/[₱,]/g, "").trim()) || 0;
        }
    
        function validateContractAmount() {
            const abcValue = parseCurrency(abcInput.value);
            const contractValue = parseCurrency(contractInput.value);
    
            // Only validate if BOTH fields have a value > 0
            if (abcValue > 0 && contractValue > 0) {
                if (contractValue > abcValue) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Input',
                        text: 'Contract Amount cannot exceed ABC value.',
                        confirmButtonColor: '#dc3545'
                    }).then(() => {
                        contractInput.value = '';
                        contractInput.focus();
                    });
                }
            }
        }
    
        // Validate on blur and input events on Contract Amount
        contractInput.addEventListener('blur', validateContractAmount);
        contractInput.addEventListener('input', () => {
            // Optional: live check only after both have values
            if (abcInput.value.trim() !== '' && contractInput.value.trim() !== '') {
                validateContractAmount();
            }
        });
    
        // Also, when ABC changes, re-validate contract amount if any
        abcInput.addEventListener('input', () => {
            if (abcInput.value.trim() !== '' && contractInput.value.trim() !== '') {
                validateContractAmount();
            }
        });

        
});


