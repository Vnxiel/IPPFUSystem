
document.addEventListener('DOMContentLoaded', function () {
  const suspensionDate = document.getElementById('suspensionOrderNo1');
  const resumptionDate = document.getElementById('resumeOrderNo1');
  const remarks = document.getElementById('suspensionOrderNo1Remarks');

  function checkRemarksRequired() {
    const hasSuspension = suspensionDate.value.trim() !== '';
    const hasResumption = resumptionDate.value.trim() !== '';

    if (hasSuspension || hasResumption) {
      remarks.setAttribute('required', 'required');
      remarks.classList.add('is-invalid'); // Optionally highlight empty required field
    } else {
      remarks.removeAttribute('required');
      remarks.classList.remove('is-invalid');
    }
  }

  // Check on input
  suspensionDate.addEventListener('input', checkRemarksRequired);
  resumptionDate.addEventListener('input', checkRemarksRequired);

  // Optional: Check again before form submission
  document.querySelector('form').addEventListener('submit', function (e) {
    checkRemarksRequired();
    if ((suspensionDate.value || resumptionDate.value) && remarks.value.trim() === '') {
      e.preventDefault();
      remarks.classList.add('is-invalid');
      remarks.focus();
    }
  });
});



// for edit

document.addEventListener('DOMContentLoaded', function () {
  // Helper: parse the index number out of an ID like "suspensionOrderNo3Remarks"
  function extractIndexFromRemarksId(remarksId) {
    const m = remarksId.match(/\d+/);
    return m ? m[0] : null;
  }

  // For a given index, check if suspensionDate or resumptionDate has a value.
  // If so, mark the textarea as required; otherwise, remove required.
  function updateRemarksRequirement(index) {
    const suspensionDate = document.getElementById(`suspensionOrderNo${index}`);
    const resumptionDate  = document.getElementById(`resumeOrderNo${index}`);
    const remarksTextarea = document.getElementById(`suspensionOrderNo${index}Remarks`);

    if (!remarksTextarea) return;

    const needsRemark = (suspensionDate?.value || '').trim() !== '' ||
                        (resumptionDate?.value  || '').trim() !== '';

    if (needsRemark) {
      // user entered a date → remark must be filled
      remarksTextarea.setAttribute('required', 'required');
    } else {
      // neither date is present → remark not required
      remarksTextarea.removeAttribute('required');
      remarksTextarea.classList.remove('is-invalid');
    }
  }

  // When any date‐field changes or when form is submitted, check requirements
  function attachListenersForIndex(index) {
    const suspensionDate = document.getElementById(`suspensionOrderNo${index}`);
    const resumptionDate = document.getElementById(`resumeOrderNo${index}`);
    const remarksTextarea = document.getElementById(`suspensionOrderNo${index}Remarks`);

    if (suspensionDate) {
      suspensionDate.addEventListener('change', () => {
        updateRemarksRequirement(index);
      });
      suspensionDate.addEventListener('input', () => {
        updateRemarksRequirement(index);
      });
    }

    if (resumptionDate) {
      resumptionDate.addEventListener('change', () => {
        updateRemarksRequirement(index);
      });
      resumptionDate.addEventListener('input', () => {
        updateRemarksRequirement(index);
      });
    }

    // As soon as the user types into the textarea, remove "is-invalid" if present.
    if (remarksTextarea) {
      remarksTextarea.addEventListener('input', () => {
        if (remarksTextarea.classList.contains('is-invalid') && remarksTextarea.value.trim() !== '') {
          remarksTextarea.classList.remove('is-invalid');
        }
      });
    }
  }

  // 1) Find all textarea IDs that end in "...Remarks"
  const allRemarks = Array.from(document.querySelectorAll('textarea[id$="Remarks"]'));
  const indices = allRemarks
    .map(t => extractIndexFromRemarksId(t.id))
    .filter(i => i !== null);

  // 2) Attach listeners for each index
  indices.forEach(i => {
    updateRemarksRequirement(i);   // run once on load
    attachListenersForIndex(i);
  });

  // 3) On form submit, re-validate all required‐when‐dates fields
  const theForm = document.querySelector('form');
  if (theForm) {
    theForm.addEventListener('submit', function (e) {
      let anyInvalid = false;

      indices.forEach(i => {
        const suspensionDate = document.getElementById(`suspensionOrderNo${i}`);
        const resumptionDate  = document.getElementById(`resumeOrderNo${i}`);
        const remarksTextarea = document.getElementById(`suspensionOrderNo${i}Remarks`);

        const needsRemark = (suspensionDate?.value || '').trim() !== '' ||
                            (resumptionDate?.value || '').trim() !== '';
        const hasRemark = (remarksTextarea?.value || '').trim() !== '';

        if (needsRemark && !hasRemark) {
          // block submission and mark textarea invalid
          anyInvalid = true;
          remarksTextarea.classList.add('is-invalid');
        }
      });

      if (anyInvalid) {
        e.preventDefault();
        // Focus the first missing‐remark field
        const firstInvalid = document.querySelector('textarea.is-invalid');
        firstInvalid?.focus();
      }
    });
  }
});
