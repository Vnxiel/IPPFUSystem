document.addEventListener('DOMContentLoaded', () => {

  const finalAmountTotalInput = document.getElementById('finalAmountTotal');
  const mobilizationTotalInput = document.getElementById('mobilizationTotal');
  const totalAmountOutput = document.getElementById('totalAmount');

  const mqcAmountInput = document.getElementById('TotalMqc');
  const engAmountInput = document.getElementById('TotalEng');

  const partialTotals = Array.from(document.querySelectorAll('input[id^="totalPartial"]'));

  function parseInputValue(input) {
    if (!input) return 0;
    return parseFloat(input.value.replace(/[₱,]/g, '')) || 0;
  }

  function updateTotal() {
    const finalAmountTotal = parseInputValue(finalAmountTotalInput);
    const mobilizationTotal = parseInputValue(mobilizationTotalInput);
    const mqcAmount = parseInputValue(mqcAmountInput);
    const engAmount = parseInputValue(engAmountInput);
    const totalPartial = partialTotals.reduce((sum, input) => sum + parseInputValue(input), 0);

    const total = mqcAmount + engAmount + finalAmountTotal + totalPartial + mobilizationTotal;

    totalAmountOutput.value = total.toLocaleString(undefined, {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    });
  }

  const allInputs = [
    finalAmountTotalInput,
    mobilizationTotalInput,
    mqcAmountInput,
    engAmountInput,
    ...partialTotals
  ];

  allInputs.forEach(input => {
    if (input) {
      ['input', 'change', 'blur'].forEach(evt =>
        input.addEventListener(evt, updateTotal)
      );
    }
  });

  // Initial calculation on load
  updateTotal();
});
