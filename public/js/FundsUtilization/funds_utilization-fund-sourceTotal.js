function parseAmount(value) {
    if (!value) return 0;
    // Remove commas and anything that's not digits or dot
    const cleaned = value.replace(/,/g, '').trim();
    const num = parseFloat(cleaned);
    return isNaN(num) ? 0 : num;
  }
  
  function formatWithCommas(value) {
    return value.toLocaleString('en-US', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
  }
  
  function calculateTotals() {
    let origTotal = 0;
    let actualTotal = 0;
  
    // Sum all fields starting with orig_
    document.querySelectorAll('input[id^="orig_"]').forEach(input => {
      const val = parseAmount(input.value);
      origTotal += val;
    });
  
    // Sum all fields starting with actual_
    document.querySelectorAll('input[id^="actual_"]').forEach(input => {
      const val = parseAmount(input.value);
      actualTotal += val;
    });
  
    // Set totals in the fields (or elements)
    const origTotalField = document.getElementById('orig_total');
    const actualTotalField = document.getElementById('actual_total');
  
    if (origTotalField) origTotalField.value = formatWithCommas(origTotal);
    if (actualTotalField) actualTotalField.value = formatWithCommas(actualTotal);
  }
  
  function bindTotalListeners() {
    // Listen on all orig_, actual_ and vo_ fields to recalc totals on input
    const inputs = document.querySelectorAll(
      'input[id^="orig_"], input[id^="actual_"], input[id^="vo_"]'
    );
  
    inputs.forEach(input => {
      input.removeEventListener('input', calculateTotals);
      input.addEventListener('input', calculateTotals);
    });
  }
  
  document.addEventListener('DOMContentLoaded', () => {
    bindTotalListeners();
    calculateTotals();
  });
  