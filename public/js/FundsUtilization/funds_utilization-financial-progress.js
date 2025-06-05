
  document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.release-checkbox');

    checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener('change', function () {
        const labelId = this.getAttribute('data-label-id');
        const label = document.getElementById(labelId);

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


    
    function updateCheckboxState(amountInputId, checkboxId, labelId) {
      const amountInput = document.getElementById(amountInputId);
      const checkbox = document.getElementById(checkboxId);
      const label = document.getElementById(labelId);
      if (!amountInput || !checkbox || !label) return;

      const amountValue = parseFloat(amountInput.value) || 0;
      if (amountValue <= 0) {
        checkbox.disabled = true;
        checkbox.checked = false;
        label.textContent = 'Not Released';
        label.classList.remove('text-success');
        label.classList.add('text-muted');
      } else {
        checkbox.disabled = false;
        // Keep checkbox state and label as is
      }
    }

    // Check Mobilization checkbox
    updateCheckboxState('amountMobilization', 'releaseMobilization', 'labelMobi');

    // Check Partial Billing checkboxes
    for (let i = 1; i <= 5; i++) {
      updateCheckboxState(`amountPartial${i}`, `releasePartial${i}`, `labelPartial${i}`);
    }

    // Optional: Add event listeners to dynamically update checkbox state on amount input changes
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

