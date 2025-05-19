
document.addEventListener('DOMContentLoaded', function () {
    function parseCurrency(value) {
      return parseFloat((value || '0').replace(/[₱,]/g, '')) || 0;
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
      { label: 'Appropriation', ids: ['vo_appropriation_1', 'actual_appropriation'] } // Note: 'orig_appropriation' is the base limit
    ];
  
    fieldGroups.forEach(group => {
      group.ids.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
          input.addEventListener('blur', function () {
            const appropriationValue = parseCurrency(document.getElementById('orig_appropriation').value);
            const inputValue = parseCurrency(input.value);
  
         
            if (inputValue > appropriationValue) {
              console.warn(`✖ ${group.label} [${id}] exceeds appropriation`);
              showError(group.label);
              input.value = '';
            } else {
              console.log(`✔ ${group.label} [${id}] is within limit`);
            }
          });
        }
      });
    });

    
  const actualEng = document.getElementById("actual_engineering");
  const amountEng = document.querySelector('input[name="amountEng"]');

  const actualMqc = document.getElementById("actual_mqc");
  const summaryMqc = document.querySelector('input[name="amountMqc"]');


  // Sync engineering and mqc values
  if (actualEng && amountEng) {
    actualEng.addEventListener("input", () => {
      amountEng.value = actualEng.value;
    });
  }
 

  if (actualMqc && summaryMqc) {
    actualMqc.addEventListener("input", () => {
      summaryMqc.value = actualMqc.value;
    });
  }

  const amountTotal = document.querySelector('input[name="amountTotal"]');
  const amountSavings = document.querySelector('input[name="amountSavings"]');
  const origAppropriation = document.getElementById('orig_appropriation');

    const validateExpenditures = () => {
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
});