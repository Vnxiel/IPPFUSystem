
let extensionCounter = 1;
const existingFieldsets = document.querySelectorAll('#timeExtensionContainer fieldset');
extensionCounter = existingFieldsets.length || 1;
let orderCounter = 1;

document.addEventListener('DOMContentLoaded', () => {
    extensionCounter = document.querySelectorAll('#timeExtensionContainer fieldset').length || 1;
    orderCounter = document.querySelectorAll('#orderContainer fieldset').length || 1;

    document.getElementById('target_completion_date').addEventListener('change', calculateRevisedCompletionDate);
    document.getElementById('official_starting_date').addEventListener('change', calculateRevisedCompletionDate);

    for (let i = 1; i <= extensionCounter; i++) {
        const input = document.getElementById(`timeExtension${i}`);
        if (input) input.addEventListener('input', calculateRevisedCompletionDate);
    }

    for (let i = 1; i <= orderCounter; i++) {
        const susp = document.getElementById(`suspensionOrderNo${i}`);
        const resume = document.getElementById(`resumeOrderNo${i}`);
        if (susp) susp.addEventListener('change', () => {
            validateSuspensionDate(i);
            calculateRevisedCompletionDate();
        });
        if (resume) resume.addEventListener('change', calculateRevisedCompletionDate);
    }

    calculateRevisedCompletionDate();
});

function addTimeExtension() {
    extensionCounter++;
    const container = document.getElementById('timeExtensionContainer');

    const fieldset = document.createElement('fieldset');
    fieldset.className = 'border p-2 mb-2';
    fieldset.id = `extensionFieldset${extensionCounter}`;

    fieldset.innerHTML = `
        <legend class="float-none w-auto px-2 small">Time Extension ${extensionCounter}</legend>
        <div class="row" id="extensionRow${extensionCounter}">
            <div class="col-3">
                <label for="timeExtension${extensionCounter}" class="form-label">No. of Days of Extension</label>
            </div>
            <div class="col-3">
                <input type="number" class="form-control" id="timeExtension${extensionCounter}" name="timeExtension${extensionCounter}" onchange="calculateRevisedCompletionDate()">
            </div>
            <div class="col-3">
                <label for="extensionReason${extensionCounter}" class="form-label">Reason for Extension</label>
            </div>
            <div class="col-3">
                <input type="text" class="form-control" id="extensionReason${extensionCounter}" name="extensionReason${extensionCounter}">
            </div>
            <div class="col-3 mt-2">
                <label for="revisedExpiry${extensionCounter}" class="form-label">Revised Expiry Date</label>
            </div>
            <div class="col-3 mt-2">
                <input type="date" class="form-control" id="revisedExpiry${extensionCounter}" name="revisedExpiry${extensionCounter}" readonly>
            </div>
           
        </div>
    `;

    container.appendChild(fieldset);
    calculateRevisedCompletionDate();
}

function removeLastTimeExtension() {
    if (extensionCounter <= 1) return;

    const lastFieldset = document.getElementById(`extensionFieldset${extensionCounter}`);
    if (lastFieldset) lastFieldset.remove();

    extensionCounter--;

    const allFieldsets = document.querySelectorAll('#timeExtensionContainer fieldset');
    allFieldsets.forEach((fs, index) => {
        const newIndex = index + 1;
        fs.id = `extensionFieldset${newIndex}`;
        fs.querySelector('legend').innerText = `Time Extension ${newIndex}`;

        const inputs = fs.querySelectorAll('input, label');
        inputs.forEach(input => {
            if (input.htmlFor) input.htmlFor = input.htmlFor.replace(/\d+$/, newIndex);
            if (input.id) input.id = input.id.replace(/\d+$/, newIndex);
            if (input.name) input.name = input.name.replace(/\d+$/, newIndex);
            if (input.getAttribute('onchange')) {
                input.setAttribute('onchange', `calculateRevisedCompletionDate()`);
            }
        });
    });

    calculateRevisedCompletionDate();
}

function calculateRevisedCompletionDate() {
    const baseInput = document.getElementById('target_completion_date');
    const startInput = document.getElementById('official_starting_date');
    const newTargetField = document.getElementById('revised_target_date');

    if (!baseInput || !startInput || !newTargetField || !baseInput.value || !startInput.value) return;

    const baseDate = new Date(baseInput.value);
    const startDate = new Date(startInput.value);
    if (isNaN(baseDate) || isNaN(startDate)) return;

    let totalSuspensionDays = 0;
    let totalExtensionDays = 0;

    // Calculate suspension days
    for (let i = 1; ; i++) {
        const susp = document.getElementById(`suspensionOrderNo${i}`);
        const resume = document.getElementById(`resumeOrderNo${i}`);
        if (!susp || !resume) break;

        const suspDate = new Date(susp.value);
        const resumeDate = new Date(resume.value);

        if (!isNaN(suspDate) && !isNaN(resumeDate) && resumeDate >= suspDate) {
            const effectiveStart = Math.max(suspDate.getTime(), startDate.getTime());
            const effectiveEnd = Math.min(resumeDate.getTime(), baseDate.getTime());

            if (effectiveEnd >= effectiveStart) {
                const days = Math.floor((effectiveEnd - effectiveStart) / (1000 * 60 * 60 * 24)) + 1;
                totalSuspensionDays += days;
            }
        }
    }

    // Recalculate each extension and final revised date
    for (let i = 1; i <= extensionCounter; i++) {
        const extInput = document.getElementById(`timeExtension${i}`);
        const revisedInput = document.getElementById(`revisedExpiry${i}`);

        if (extInput) {
            const extDays = parseInt(extInput.value);
            if (!isNaN(extDays)) {
                totalExtensionDays += extDays;
                const revisedDate = new Date(baseDate);
                revisedDate.setDate(revisedDate.getDate() + totalSuspensionDays + totalExtensionDays);
                if (revisedInput) revisedInput.value = revisedDate.toISOString().split('T')[0];
            } else if (revisedInput) {
                revisedInput.value = '';
            }
        }
    }

    const finalDate = new Date(baseDate);
    finalDate.setDate(finalDate.getDate() + totalSuspensionDays + totalExtensionDays);

    newTargetField.value = finalDate.toISOString().split('T')[0];
    document.getElementById('newDatesSection').style.display = 'flex';
}

function validateSuspensionDate(currentIndex) {
    const currentSusp = document.getElementById(`suspensionOrderNo${currentIndex}`);
    const startInput = document.getElementById('official_starting_date');

    if (!currentSusp || !startInput || !currentSusp.value) return;

    const currDate = new Date(currentSusp.value);
    const startDate = new Date(startInput.value);

    let referenceDate = startDate;
    let hasValidResumption = false;

    if (currentIndex > 1) {
        const prevResume = document.getElementById(`resumeOrderNo${currentIndex - 1}`);
        if (prevResume && prevResume.value) {
            const prevDate = new Date(prevResume.value);
            if (!isNaN(prevDate.getTime())) {
                referenceDate = prevDate;
                hasValidResumption = true;
            }
        }
    }

    if (currDate <= referenceDate) {
        const label = hasValidResumption
            ? `Resumption Order No.${currentIndex - 1}`
            : 'the Official Starting Date';

        Swal.fire({
            icon: 'error',
            title: 'Invalid Suspension Date',
            text: `Suspension Order No.${currentIndex} must be after ${label}.`,
            confirmButtonColor: '#d33',
        });
        currentSusp.value = '';
    }
}
