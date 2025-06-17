document.addEventListener('DOMContentLoaded', function () {
  function parseCurrency(value) {
    return parseFloat((value || '0').replace(/[₱,]/g, '')) || 0;
  }

  function showAlert(message, icon = 'warning') {
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: icon,
      title: message,
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      background: '#f8f9fa',
      color: '#000',
      customClass: {
        popup: 'shadow-sm'
      }
    });
  }

  function showError(fieldLabel) {
    Swal.fire({
      icon: 'error',
      title: 'Limit Exceeded',
      text: `${fieldLabel} exceeds the Original Appropriation!`
    });
  }

  const fieldGroups = [
    { label: 'ABC', ids: ['orig_abc', 'vo_abc_1', 'actual_abc'] },
    { label: 'Contract Amount', ids: ['orig_contract_amount', 'vo_contract_amount_1', 'actual_contract_amount'] },
    { label: 'Engineering', ids: ['orig_engineering', 'vo_engineering_1', 'actual_engineering'] },
    { label: 'MQC', ids: ['orig_mqc', 'vo_mqc_1', 'actual_mqc'] },
    { label: 'Contingency', ids: ['orig_contingency', 'vo_contingency_1', 'actual_contingency'] },
    { label: 'Bid Difference', ids: ['orig_bid', 'vo_bid_1', 'actual_bid'] },
    { label: 'Appropriation', ids: ['vo_appropriation_1', 'actual_appropriation'] }
  ];

  const origAppropriationInput = document.getElementById('orig_appropriation');

  fieldGroups.forEach(group => {
    group.ids.forEach(id => {
      const input = document.getElementById(id);
      if (input) {
        input.addEventListener('blur', function () {
          const appropriationValue = parseCurrency(origAppropriationInput.value);
          let exceeded = false;
          group.ids.forEach(fieldId => {
            const fieldEl = document.getElementById(fieldId);
            if (!fieldEl) return;
            const fieldValue = parseCurrency(fieldEl.value);
            if (fieldValue > appropriationValue) exceeded = true;
          });

          if (exceeded) {
            showError(group.label);
            group.ids.forEach(fieldId => {
              const fieldEl = document.getElementById(fieldId);
              if (!fieldEl) return;
              const fieldValue = parseCurrency(fieldEl.value);
              if (fieldValue > appropriationValue) fieldEl.value = '';
            });
          }
        });
      }
    });
  });

  const amountTotal = document.querySelector('input[name="amountTotal"]');
  const amountSavings = document.querySelector('input[name="amountSavings"]');
  const origAppropriation = document.getElementById('orig_appropriation');

  // Make function available globally
  window.validateExpenditures = function () {
    const appropriation = parseCurrency(origAppropriation.value);
    const total = parseCurrency(amountTotal.value);
    const savings = parseCurrency(amountSavings.value);

    if (total > appropriation) {
      Swal.fire({
        icon: 'error',
        title: 'Expenditure Exceeded',
        text: 'Total Expenditures cannot exceed the Original Appropriation!',
      });
      amountTotal.value = '';
      if (amountSavings) amountSavings.value = ''; // Clear savings too
      return false;
    }
    

    if (savings < 0) {
      Swal.fire({
        icon: 'error',
        title: 'Negative Savings',
        text: 'Total Savings cannot be a negative amount!',
      });
      amountSavings.value = '';
      return false;
    }

    return true;
  };

  const addEntryBtn = document.getElementById('addEntryBtn');
  if (addEntryBtn) {
    addEntryBtn.addEventListener('click', function () {
      const type = document.getElementById('entryType')?.value;
      if (!type) {
        showAlert('Please select entry type.', 'info');
        return;
      }

      if (!window.validateExpenditures()) return;

      // Proceed with entry logic...
    });
  }
});
