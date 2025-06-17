document.addEventListener('DOMContentLoaded', function () {

  // ✅ Parse amount safely, removing ₱, commas, %, spaces, etc.
  function parseAmount(value) {
    return parseFloat(value.replace(/[₱,%\s,]/g, '')) || 0;
  }

  // ✅ Update checkbox label and state based on the amount input value
  function updateCheckboxState(amountInputId, checkboxId, labelId) {
    const amountInput = document.getElementById(amountInputId);
    const checkbox = document.getElementById(checkboxId);
    const label = document.getElementById(labelId);
    if (!amountInput || !checkbox || !label) return;

    const amountValue = parseAmount(amountInput.value);

    if (amountValue <= 0) {
      checkbox.disabled = true;
      checkbox.checked = false;
      label.textContent = 'Not Released';
      label.classList.remove('text-success');
      label.classList.add('text-muted');
    } else {
      checkbox.disabled = false;
      // Keep current checked state; update label only on change
    }
  }

  // ✅ Handle checkbox toggle: update release label text and style
  const checkboxes = document.querySelectorAll('.release-checkbox');
  checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      const labelId = this.getAttribute('data-label-id');
      const label = document.getElementById(labelId);
      if (!label) return;

      if (this.checked) {
        label.textContent = 'Released';
        label.classList.remove('text-muted');
        label.classList.add('text-success');
      } else {
        label.textContent = 'Not Released';
        label.classList.remove('text-success');
        label.classList.add('text-muted');
      }
    });
  });

  // ✅ Initialize checkbox states on page load
  updateCheckboxState('amountMobilization', 'releaseMobilization', 'labelMobi');
  for (let i = 1; i <= 5; i++) {
    updateCheckboxState(`amountPartial${i}`, `releasePartial${i}`, `labelPartial${i}`);
  }

  // ✅ Re-check checkbox eligibility when amount fields change
  function addInputListener(amountInputId, checkboxId, labelId) {
    const amountInput = document.getElementById(amountInputId);
    if (!amountInput) return;

    amountInput.addEventListener('input', () => {
      updateCheckboxState(amountInputId, checkboxId, labelId);
    });
  }

  addInputListener('amountMobilization', 'releaseMobilization', 'labelMobi');
  for (let i = 1; i <= 5; i++) {
    addInputListener(`amountPartial${i}`, `releasePartial${i}`, `labelPartial${i}`);
  }

});
