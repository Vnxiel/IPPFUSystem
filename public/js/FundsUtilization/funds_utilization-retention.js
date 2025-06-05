function formatToDecimal(value) {
    return parseFloat(value).toFixed(2);
  }
  
  function calculateMobilizationFields() {
    const amountInput = document.getElementById('amountMobilization');
    const retentionPercentInput = document.getElementById('retentionMobiPercent');
    const retentionAmountInput = document.getElementById('retentionMobiAmount');
    const totalOutput = document.getElementById('mobilizationTotal');
  
    let amount = parseFloat((amountInput.value || '0').replace(/,/g, ''));
    let percent = parseFloat((retentionPercentInput.value || '0').replace('%', ''));
  
    if (isNaN(amount)) amount = 0;
    if (isNaN(percent)) percent = 0;
  
    const retention = amount * (percent / 100);
    const total = amount - retention;
  
    retentionAmountInput.value = formatToDecimal(retention);
    totalOutput.value = formatToDecimal(total);
  }
  
  // Attach listeners
  document.getElementById('amountMobilization')?.addEventListener('input', calculateMobilizationFields);
  document.getElementById('retentionMobiPercent')?.addEventListener('input', calculateMobilizationFields);
  
  // Trigger once on load
  window.addEventListener('DOMContentLoaded', calculateMobilizationFields);
  