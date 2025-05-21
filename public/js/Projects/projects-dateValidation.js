document.addEventListener("DOMContentLoaded", function () {

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
    




    const originalStartDate = document.getElementById("originalStartDate");
    const suspensionDate = document.getElementById("suspensionOrderNo1");
    const resumeDate = document.getElementById("resumeOrderNo1");
    const targetCompletion = document.getElementById("targetCompletion");
    const actualCompletion = document.getElementById("completionDate");
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

    function validateAfterStart(field, label) {
        const startDate = new Date(originalStartDate.value);
        const date = new Date(field.value);
        if (field.value && (date <= startDate)) {
            showError(`${label} must be strictly after the Official Starting Date.`, field);
            return false;
        }
        return true;
    }

    function validateOriginalStartVsNTP() {
        const ntpDate = new Date(ntpIssuedDate.value);
        const startDate = new Date(originalStartDate.value);
        if (originalStartDate.value && ntpIssuedDate.value && startDate < ntpDate) {
            showError("Original Starting Date must be on or after the NTP Issued Date.", originalStartDate);
            return false;
        }
        return true;
    }

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

    function applyTimeExtensionIfNoSuspension() {
        const extension = parseInt(extensionField.value || "0");
        if (
            extension > 0 &&
            !suspensionDate.value &&
            !resumeDate.value &&
            targetCompletion.value
        ) {
            extensionField.closest('.row').style.display = "flex";
            revisedTargetField.closest('.row').style.display = "flex";
            revisedCompletionField.closest('.row').style.display = "flex";
    
            const baseTargetDate = new Date(targetCompletion.value);
            const newTargetDate = new Date(baseTargetDate);
            newTargetDate.setDate(newTargetDate.getDate() + extension);
    
            revisedTargetField.valueAsDate = newTargetDate;
    
            if (actualCompletion.value) {
                const baseActualDate = new Date(actualCompletion.value);
                const newActualDate = new Date(baseActualDate);
                newActualDate.setDate(newActualDate.getDate() + extension);
                revisedCompletionField.valueAsDate = newActualDate;
            }
        }
    }
    extensionField.addEventListener("input", () => {
        applyTimeExtensionIfNoSuspension();
    });
        

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

