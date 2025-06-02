const timeExtensionInput = document.getElementById('timeExtension1');
const suspensionOrderInput = document.getElementById('suspensionOrderNo1');

const actualCompletionDate = document.getElementById('actual_completion_date');
const actualLengthLabel = document.querySelector('.actual-length-label');
const actualLengthInput = document.querySelector('.actual-length-input');

function checkActualLengthVisibility() {
    if (actualCompletionDate && actualLengthLabel && actualLengthInput) {
        const hasValue = actualCompletionDate.value.trim() !== '';
        actualLengthLabel.style.display = hasValue ? 'block' : 'none';
        actualLengthInput.style.display = hasValue ? 'block' : 'none';
    }
}

// If needed, hide/show the section entirely based on conditions
function toggleCompletionSection() {
    const section = document.getElementById('completionSection');
    const hasTimeExtension = timeExtensionInput && timeExtensionInput.value.trim() !== "";
    const hasSuspension = suspensionOrderInput && suspensionOrderInput.value.trim() !== "";

    // Optional: Show/hide based on these conditions
    section.style.display = (hasTimeExtension || hasSuspension) ? 'flex' : 'flex'; // or 'none' to hide
    checkActualLengthVisibility();
}

// Event listeners
if (actualCompletionDate) {
    actualCompletionDate.addEventListener('input', checkActualLengthVisibility);
    actualCompletionDate.addEventListener('change', checkActualLengthVisibility);
}
if (timeExtensionInput) {
    timeExtensionInput.addEventListener('input', toggleCompletionSection);
    timeExtensionInput.addEventListener('change', toggleCompletionSection);
}
if (suspensionOrderInput) {
    suspensionOrderInput.addEventListener('input', toggleCompletionSection);
    suspensionOrderInput.addEventListener('change', toggleCompletionSection);
}

// On load
toggleCompletionSection();
checkActualLengthVisibility();
