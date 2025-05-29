document.addEventListener('DOMContentLoaded', () => {
    const percentInput = document.getElementById('percentMobi');
    const amountInput = document.getElementById('amountMobilization');
  
    if (!percentInput || !amountInput) return;
  
    // When percent is cleared, clear amount
    percentInput.addEventListener('input', () => {
      const val = percentInput.value.trim();
      if (val === '' || isNaN(parseFloat(val))) {
        amountInput.value = '';
      }
    });
  
    // When amount is cleared, clear percent
    amountInput.addEventListener('input', () => {
      const val = amountInput.value.replace(/₱|,/g, '').trim();
      if (val === '' || isNaN(parseFloat(val))) {
        percentInput.value = '';
      }
    });
  
    const formatPeso = (value) => {
      if (!value) return '';
  
      // Strip all non-numeric and extra dots
      value = value.replace(/[^0-9.]/g, '');
  
      // Limit to one decimal point and two decimal places
      const match = value.match(/^(\d{0,})(\.\d{0,2})?/);
      const integer = match[1];
      const decimal = match[2] || '';
  
      // Add comma separators
      const withCommas = integer.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      return '₱' + withCommas + decimal;
    };
  
    const unformatPeso = (value) => value.replace(/[^0-9.]/g, '');
  
    const expenditureInputs = document.querySelectorAll('.expenditure-amount');
  
    expenditureInputs.forEach(input => {
      // Format on page load
      if (input.value.trim() !== '') {
        input.value = formatPeso(input.value);
      }
  
      input.addEventListener('input', function () {
        const unformatted = unformatPeso(input.value);
        input.value = formatPeso(unformatted);
        // Always move caret to the end
        input.setSelectionRange(input.value.length, input.value.length);
      });
    });
  
  });