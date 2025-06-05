
  document.addEventListener('DOMContentLoaded', () => {
    const percentInput = document.getElementById('percentMobi');
    const amountInput = document.getElementById('amountMobilization');
    const retentionAmountField = document.getElementById('retentionMobiAmount');
    const totalField = document.getElementById('mobilizationTotal');

    if (!percentInput || !amountInput) return;

    // When percent is cleared, clear amount
    percentInput.addEventListener('input', () => {
      const val = percentInput.value.trim();
      if (val === '' || isNaN(parseFloat(val))) {
        amountInput.value = '';
        retentionAmountField.value = '';
        totalField.value = '';
      }
    });

    // When amount is cleared, clear percent and totals
    amountInput.addEventListener('input', () => {
      const val = unformatPeso(amountInput.value).trim();
      if (val === '' || isNaN(parseFloat(val))) {
        percentInput.value = '';
        retentionAmountField.value = '';
        totalField.value = '';
      } else {
        calculateMobilizationAmounts();
      }
    });

    const formatPeso = (value) => {
      if (!value) return '';
      value = value.replace(/[^0-9.]/g, '');
      const match = value.match(/^(\d{0,})(\.\d{0,2})?/);
      const integer = match[1];
      const decimal = match[2] || '';
      const withCommas = integer.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      return '₱' + withCommas + decimal;
    };

    const unformatPeso = (value) => value.replace(/[^0-9.]/g, '');

    function calculateMobilizationAmounts() {
      const amount = parseFloat(unformatPeso(amountInput.value));
      const percentMatch = percentInput.value.match(/(\d+)%?/);
      const percent = percentMatch ? parseFloat(percentMatch[1]) : 0;

      if (!isNaN(amount)) {
        const retention = (amount * percent) / 100;
        const total = amount - retention;
        retentionAmountField.value = retention.toFixed(2);
        totalField.value = total.toFixed(2);
      } else {
        retentionAmountField.value = '';
        totalField.value = '';
      }
    }

    const expenditureInputs = document.querySelectorAll('.expenditure-amount');
    expenditureInputs.forEach(input => {
      if (input.value.trim() !== '') {
        input.value = formatPeso(input.value);
      }

      input.addEventListener('input', function () {
        const unformatted = unformatPeso(input.value);
        input.value = formatPeso(unformatted);
        input.setSelectionRange(input.value.length, input.value.length);
      });
    });
  });
