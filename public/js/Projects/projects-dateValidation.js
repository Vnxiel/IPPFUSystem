document.addEventListener("DOMContentLoaded", function () {
    // ================================
    // 1. Populate Year Options
    // ================================
        const selectYear = document.getElementById("projectYear");
        if (!selectYear) return;
    
        const currentYear = new Date().getFullYear();
        const numberOfYears = 15;
    
        for (let i = 0; i < numberOfYears; i++) {
            const year = currentYear - i;
            const option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            selectYear.appendChild(option);
        }
    
        // Optional: Save the selected value in real time
        selectYear.addEventListener("change", function () {
            const selectedYear = this.value;
        });
    


    // ================================
    // 2. Initialize Fields
    // ================================

    const originalStartDate = document.getElementById("originalStartDate");
    const suspensionDate = document.getElementById("suspensionOrderNo1");
    const resumeDate = document.getElementById("resumeOrderNo1");
    const targetCompletion = document.getElementById("targetCompletion");
    const actualCompletion = document.getElementById("revisedCompletionDate");
    const revisedTargetField = document.getElementById("revisedTargetDate");
    const revisedCompletionField = document.getElementById("revisedCompletionDate");
    const extensionField = document.getElementById("timeExtension");

    const ntpIssuedDate = document.getElementById("ntpIssuedDate");
    const ntpReceivedDate = document.getElementById("ntpReceivedDate");

    // // Hide optional rows initially
    // extensionField.closest('.row').style.display = "none";
    // revisedTargetField.closest('.row').style.display = "none";
    // revisedCompletionField.closest('.row').style.display = "none";

    const contractDays = document.getElementById("projectContractDays");

    function updateTargetCompletion() {
        if (originalStartDate.value && contractDays.value) {
            const start = new Date(originalStartDate.value);
            const days = parseInt(contractDays.value);
            if (!isNaN(days)) {
                start.setDate(start.getDate() + days - 1); // subtract 1 to include the start day
                targetCompletion.value = start.toISOString().split('T')[0];

                // Optional: reset dependent fields
                actualCompletion.value = '';
                revisedTargetField.value = '';
                revisedCompletionField.value = '';
            }
        }
    }

    originalStartDate.addEventListener("change", updateTargetCompletion);
    contractDays.addEventListener("input", updateTargetCompletion);

    function showError(message, field) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Date',
            text: message
        }).then(() => {
            if (field) {
                field.value = '';
                field.focus();
            }
        });
    }

     // ================================
    // 5. Set Minimum Allowed Dates
    // ================================
    function setMinDates() {
        const start = originalStartDate.value;
        if (start) {
            const nextDay = new Date(start);
            nextDay.setDate(nextDay.getDate() + 1);
            const minDate = nextDay.toISOString().split("T")[0];

            suspensionDate.min = minDate;
            resumeDate.min = minDate;
            targetCompletion.min = minDate;
            actualCompletion.min = minDate;
            revisedTargetField.min = minDate;
            revisedCompletionField.min = minDate;
        }
    }

     // ================================
    // 6. Validate if Date is After Start Date
    // ================================
    function validateAfterStart(field, label) {
        const startDate = new Date(originalStartDate.value);
        const date = new Date(field.value);
        if (field.value && (date <= startDate)) {
            showError(`${label} must be strictly after the Official Starting Date.`, field);
            return false;
        }
        return true;
    }

    // ================================
    // 7. Validate NTP Issued Date vs Start Date
    // ================================
    function validateOriginalStartVsNTP() {
        const ntpDate = new Date(ntpIssuedDate.value);
        const startDate = new Date(originalStartDate.value);
        if (originalStartDate.value && ntpIssuedDate.value && startDate < ntpDate) {
            showError("Original Starting Date must be on or after the NTP Issued Date.", originalStartDate);
            return false;
        }
        return true;
    }

     // ================================
    // 8. Validate Suspension & Resumption Dates
    // ================================
    function validateSuspensionAndResumption() {
        const suspend = new Date(suspensionDate.value);
        const resume = new Date(resumeDate.value);

        if (suspensionDate.value && !validateAfterStart(suspensionDate, "Suspension Date")) return;
        if (resumeDate.value && !validateAfterStart(resumeDate, "Resumption Date")) return;

        if (suspensionDate.value && resumeDate.value && resume <= suspend) {
            showError("Resumption Date must be after Suspension Date.", resumeDate);
            return;
        }

        if (suspensionDate.value && resumeDate.value) {
            const extensionDays = Math.max(0, Math.floor((resume - suspend) / (1000 * 60 * 60 * 24)) - 1);

            extensionField.closest('.row').style.display = "flex";
            revisedTargetField.closest('.row').style.display = "flex";
            revisedCompletionField.closest('.row').style.display = "flex";
            extensionField.value = extensionDays;

            if (targetCompletion.value) {
                let newTarget = new Date(targetCompletion.value);
                newTarget.setDate(newTarget.getDate() + extensionDays);
                revisedTargetField.valueAsDate = newTarget;
            }

            if (actualCompletion.value) {
                let newActual = new Date(actualCompletion.value);
                newActual.setDate(newActual.getDate() + extensionDays);
                revisedCompletionField.valueAsDate = newActual;
            }
        }
    }

    
    extensionField.addEventListener("input", () => {
        updateRevisedTargetCompletion();
    });
    
       // ================================
    // 9. Calculate Total Suspension Days
    // ================================   
    function calculateTotalSuspensionExtension() {
        const orderContainer = document.getElementById('orderContainer');
        const suspensionInputs = orderContainer.querySelectorAll('input[id^="suspensionOrderNo"]');
        const resumptionInputs = orderContainer.querySelectorAll('input[id^="resumeOrderNo"]');
    
        let totalExtensionDays = 0;
    
        suspensionInputs.forEach((suspensionInput, idx) => {
            const suspensionValue = suspensionInput.value;
            const resumeInput = resumptionInputs[idx];
            const resumeValue = resumeInput ? resumeInput.value : null;
    
            if (suspensionValue && resumeValue) {
                const suspendDate = new Date(suspensionValue);
                const resumeDate = new Date(resumeValue);
    
                if (resumeDate > suspendDate) {
                    // Calculate difference in days (excluding the first day)
                    const diffTime = resumeDate - suspendDate;
                    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) - 1; 
                    totalExtensionDays += Math.max(0, diffDays);
                }
            }
        });
    
        return totalExtensionDays;
    }
    
    function calculateTotalSuspensionExtension() {
        const orderContainer = document.getElementById('orderContainer');
        const suspensionInputs = orderContainer.querySelectorAll('input[id^="suspensionOrderNo"]');
        const resumptionInputs = orderContainer.querySelectorAll('input[id^="resumeOrderNo"]');
    
        let totalSuspensionDays = 0;
    
        suspensionInputs.forEach((suspensionInput, idx) => {
            const suspensionValue = suspensionInput.value;
            const resumeInput = resumptionInputs[idx];
            const resumeValue = resumeInput ? resumeInput.value : null;
    
            if (suspensionValue && resumeValue) {
                const suspendDate = new Date(suspensionValue);
                const resumeDate = new Date(resumeValue);
    
                if (resumeDate > suspendDate) {
                    const diffTime = resumeDate - suspendDate;
                    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                    totalSuspensionDays += diffDays;
                }
            }
        });
    
        return totalSuspensionDays;
    }
    
    function updateRevisedTargetCompletion() {
        const targetDate = targetCompletion.value ? new Date(targetCompletion.value) : null;
        const actualDate = actualCompletion && actualCompletion.value
            ? new Date(actualCompletion.value)
            : null;

        const extension = parseInt(extensionField.value || "0");
        const suspensionDays = calculateTotalSuspensionExtension();
    
        if (!targetDate) return;
    
        const totalDaysToAdd = suspensionDays + extension;
    
        const revisedTargetDate = new Date(targetDate);
        revisedTargetDate.setDate(revisedTargetDate.getDate() + totalDaysToAdd);
    
        // Display revised fields
        extensionField.closest('.row').style.display = "flex";
        revisedTargetField.closest('.row').style.display = "flex";
        revisedCompletionField.closest('.row').style.display = "flex";
    
        revisedTargetField.valueAsDate = revisedTargetDate;
    
        if (actualDate) {
            const revisedActualDate = new Date(actualDate);
            revisedActualDate.setDate(revisedActualDate.getDate() + totalDaysToAdd);
            revisedCompletionField.valueAsDate = revisedActualDate;
        }
    }
    
    // Example: Call updateExtensionFields on any input change of suspension/resumption date fields
    document.getElementById('orderContainer').addEventListener('input', e => {
        if (e.target.matches('input[id^="suspensionOrderNo"], input[id^="resumeOrderNo"]')) {
            updateRevisedTargetCompletion();
        }
    });

    const orderContainer = document.getElementById('orderContainer');

orderContainer.addEventListener('input', function (e) {
    if (e.target.matches('input[id^="suspensionOrderNo"]') || e.target.matches('input[id^="resumeOrderNo"]')) {
        validateSuspensionOrderSequence();
        updateRevisedTargetCompletion();
    }
});

function validateSuspensionOrderSequence() {
    const suspensionInputs = orderContainer.querySelectorAll('input[id^="suspensionOrderNo"]');
    const resumptionInputs = orderContainer.querySelectorAll('input[id^="resumeOrderNo"]');

    let latestResumptionDate = null;

    for (let i = 0; i < suspensionInputs.length; i++) {
        const suspensionInput = suspensionInputs[i];
        const resumptionInput = resumptionInputs[i];

        const suspensionDate = suspensionInput.value ? new Date(suspensionInput.value) : null;
        const resumptionDate = resumptionInput.value ? new Date(resumptionInput.value) : null;

        // Validate that the suspension date of the current order is not before the latest resumption date
        if (suspensionDate && latestResumptionDate && suspensionDate <= latestResumptionDate) {
            showError(
                `Suspension Date for Order No.${i + 1} must be after the latest Resumption Date of the previous orders.`,
                suspensionInput
            );
            return;
        }

        // Update latestResumptionDate if the current resumption date is valid
        if (resumptionDate && (!latestResumptionDate || resumptionDate > latestResumptionDate)) {
            latestResumptionDate = resumptionDate;
        }

        // Validate suspension < resumption within the same order
        if (suspensionDate && resumptionDate && resumptionDate <= suspensionDate) {
            showError(`Resumption Date must be after Suspension Date in Order No.${i + 1}.`, resumptionInput);
            return;
        }
    }
}

    
    

    // Trigger validation and restrictions only on blur
    originalStartDate.addEventListener("blur", () => {
        if (!validateOriginalStartVsNTP()) return;
        setMinDates();
        suspensionDate.value = '';
        resumeDate.value = '';
        actualCompletion.value = '';
        revisedTargetField.value = '';
        revisedCompletionField.value = '';
    });


    ntpIssuedDate.addEventListener("change", () => {
        validateOriginalStartVsNTP();
    });

    suspensionDate.addEventListener("change", () => {
        validateSuspensionAndResumption();
    });

    resumeDate.addEventListener("change", () => {
        validateSuspensionAndResumption();
    });

    targetCompletion.addEventListener("change", () => {
        validateAfterStart(targetCompletion, "Target Completion Date");
    });

    actualCompletion.addEventListener("change", () => {
        validateAfterStart(actualCompletion, "Actual Completion Date");
    });

    revisedTargetField.addEventListener("change", () => {
        validateAfterStart(revisedTargetField, "Revised Target Date");
    });

    revisedCompletionField.addEventListener("change", () => {
        validateAfterStart(revisedCompletionField, "Revised Completion Date");
    });
});

function restrictDateOrderAllowSame(issuedId, receivedId) {
    const issued = document.getElementById(issuedId);
    const received = document.getElementById(receivedId);

    if (!issued || !received) return;

    // Update the min date of received field to match issued date (same day allowed)
    issued.addEventListener('change', () => {
        if (issued.value) {
            const minDate = new Date(issued.value);
            received.min = minDate.toISOString().split("T")[0];
            if (received.value && new Date(received.value) < minDate) {
                received.value = ''; // clear if invalid
            }
        } else {
            received.removeAttribute('min');
        }
    });

    // Validate on blur (optional if min is set)
    received.addEventListener('blur', () => {
        if (!issued.value || !received.value) return;

        const issuedDate = new Date(issued.value);
        const receivedDate = new Date(received.value);

        if (receivedDate < issuedDate) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Date Entry',
                text: `${receivedId.toUpperCase().replace(/([A-Z])/g, ' $1')} must be the same as or after ${issuedId.toUpperCase().replace(/([A-Z])/g, ' $1')}.`
            });
            received.value = '';
        }
    });
}

// Apply for NOA and NTP
restrictDateOrderAllowSame('noaIssuedDate', 'noaReceivedDate');
restrictDateOrderAllowSame('ntpIssuedDate', 'ntpReceivedDate');

function restrictNTPAfterNOAReceived(noaReceivedId, ntpIssuedId) {
    const noaReceived = document.getElementById(noaReceivedId);
    const ntpIssued = document.getElementById(ntpIssuedId);

    if (!noaReceived || !ntpIssued) return;

    noaReceived.addEventListener('change', () => {
        if (noaReceived.value) {
            const minDate = new Date(noaReceived.value);
            ntpIssued.min = minDate.toISOString().split("T")[0];

            if (ntpIssued.value && new Date(ntpIssued.value) < minDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Date Entry',
                    text: 'NTP Issued Date must be the same as or after NOA Received Date.'
                });
                ntpIssued.value = '';
            }
        } else {
            ntpIssued.removeAttribute('min');
        }
    });

    ntpIssued.addEventListener('blur', () => {
        if (!noaReceived.value || !ntpIssued.value) return;

        const noaDate = new Date(noaReceived.value);
        const ntpDate = new Date(ntpIssued.value);

        if (ntpDate < noaDate) {
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Date Entry',
                text: 'NTP Issued Date must be the same as or after NOA Received Date.'
            });
            ntpIssued.value = '';
        }
    });
}

// Apply the restriction
restrictNTPAfterNOAReceived('noaReceivedDate', 'ntpIssuedDate');

document.querySelectorAll('.order-set').forEach(order => {
    const suspension = order.querySelector('input[id^="suspensionOrderNo"]');
    const resumption = order.querySelector('input[id^="resumeOrderNo"]');
    const remarks = order.querySelector('input[name$="Remarks"]');

    if (remarks) remarks.value = '';

    if (suspension && resumption) {
        resumption.addEventListener('change', () => {
            if (!resumption.value) return;
            if (suspension.value && new Date(resumption.value) <= new Date(suspension.value)) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Date Entry',
                    text: 'Resumption date must be after Suspension date.'
                });
                resumption.value = '';
            }
        });
    }
});

const originalStartDate = document.getElementById('originalStartDate');
const contractDays = document.getElementById('projectContractDays');
const targetCompletion = document.getElementById('targetCompletion');

function updateTargetCompletion() {
    if (originalStartDate.value && contractDays.value) {
        const start = new Date(originalStartDate.value);
        start.setDate(start.getDate() + parseInt(contractDays.value) - 1);
        targetCompletion.value = start.toISOString().split('T')[0];
    }
}
// Update logic on change/input (calculate targetCompletion etc.)
originalStartDate.addEventListener("change", updateTargetCompletion);
originalStartDate.addEventListener("input", updateTargetCompletion);
contractDays.addEventListener('input', updateTargetCompletion);

function checkOrderInputs() {
    const suspensionInput = document.querySelector('input[name^="suspensionOrderNo"]');
    const extensionInput = document.getElementById('timeExtension');

    const hasSuspension = suspensionInput && suspensionInput.value.trim() !== '';
    const hasExtension = extensionInput && extensionInput.value.trim() !== '';

    const newDates = document.getElementById('newDatesSection');
    const actualDate = document.getElementById('actualCompletionSection');

    if (hasSuspension || hasExtension) {
        newDates.style.display = 'flex';
        actualDate.style.display = 'none';
    } else {
        newDates.style.display = 'none';
        actualDate.style.display = 'flex';
    }
}

// Trigger check on load and on input
window.addEventListener('DOMContentLoaded', checkOrderInputs);
document.getElementById('timeExtension').addEventListener('input', checkOrderInputs);
document.querySelector('input[name^="suspensionOrderNo"]').addEventListener('input', checkOrderInputs);


function enforceSuspensionDateConstraints() {
    const orderContainer = document.getElementById("orderContainer");
    const suspensionInputs = orderContainer.querySelectorAll('input[id^="suspensionOrderNo"]');
    const resumptionInputs = orderContainer.querySelectorAll('input[id^="resumeOrderNo"]');

    let lastAllowedDate = originalStartDate.value ? new Date(originalStartDate.value) : null;

    suspensionInputs.forEach((suspInput, index) => {
        const resumeInput = resumptionInputs[index];

        if (suspInput) {
            if (lastAllowedDate) {
                const nextDay = new Date(lastAllowedDate);
                nextDay.setDate(nextDay.getDate() + 1);
                const minDate = nextDay.toISOString().split('T')[0];
                suspInput.min = minDate;
                resumeInput.min = minDate;
            }

            // Add validation listener
            suspInput.addEventListener("change", () => {
                const suspDate = new Date(suspInput.value);
                if (lastAllowedDate && suspDate <= lastAllowedDate) {
                    showError(`Suspension Date No.${index + 1} must be after the previous resumption date or the original start date.`, suspInput);
                }
            });

            resumeInput.addEventListener("change", () => {
                const resumeDate = new Date(resumeInput.value);
                const suspDate = new Date(suspInput.value);

                if (resumeDate <= suspDate) {
                    showError(`Resumption Date No.${index + 1} must be after Suspension Date No.${index + 1}.`, resumeInput);
                } else if (lastAllowedDate && resumeDate <= lastAllowedDate) {
                    showError(`Resumption Date No.${index + 1} must be after the previous resumption date or the original start date.`, resumeInput);
                } else {
                    // Update lastAllowedDate for next round
                    lastAllowedDate = resumeDate;
                }
            });

            // If already filled, update lastAllowedDate
            if (resumeInput.value) {
                const resumeDate = new Date(resumeInput.value);
                if (resumeDate > lastAllowedDate) {
                    lastAllowedDate = resumeDate;
                }
            }
        }
    });
}

// Call this AFTER originalStartDate is set
originalStartDate.addEventListener("change", () => {
    setMinDates();
    enforceSuspensionDateConstraints();
});

suspensionDate.addEventListener("change", () => {
    validateSuspensionAndResumption();
    enforceSuspensionDateConstraints();
});

resumeDate.addEventListener("change", () => {
    validateSuspensionAndResumption();
    enforceSuspensionDateConstraints();
});
