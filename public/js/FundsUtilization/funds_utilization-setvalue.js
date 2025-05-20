document.addEventListener('DOMContentLoaded', function () {
    const voCountInput = document.getElementById('voCount');
    const voCount = parseInt(voCountInput?.value) || 1;
  
    const allFields = ['appropriation', 'abc', 'contract_amount', 'bid', 'engineering', 'mqc', 'contingency'];
    const pageLoadFields = ['contract_amount', 'engineering', 'mqc', 'contingency'];
  
    // Inputs for balance calculation
    const actualContractAmountInput = document.getElementById("actual_contract_amount");
    const contractAmountInput = document.getElementById("contract_amount");
    const balanceDisplay = document.getElementById("contractBalance");
  
    const inputIds = [
      'amountMobilization',
      'amountPartial1',
      'amountPartial2',
      'amountPartial3',
      'amountPartial4',
      'amountPartial5',
      'amountFinal'
    ];
  
    // Helper to format number as currency with commas and 2 decimals
    function formatNumber(num) {
      return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
  
    // Parse and sanitize input values (remove commas, peso sign, etc)
    function getSanitizedValue(input) {
      if (!input || !input.value) return 0;
      return parseFloat(input.value.replace(/₱|,/g, '').trim()) || 0;
    }
  
    // Update the actual_* fields based on latest VO inputs
    function updateActualField(field, latestVO) {
      const latestVOInput = document.getElementById(`vo_${field}_${latestVO}`);
      const actualInput = document.getElementById(`actual_${field}`);
      if (latestVOInput && actualInput) {
        actualInput.value = latestVOInput.value;
      }
    }
  
    // Set actual_* fields on page load only if voCount === 1
    if (voCount === 1) {
      pageLoadFields.forEach(function (field) {
        const origInput = document.getElementById(`orig_${field}`);
        const actualInput = document.getElementById(`actual_${field}`);
        if (origInput && actualInput) {
          actualInput.value = origInput.value;
        }
      });
    }
  
    // Add event listeners to VO inputs to update actual_* fields on input
    allFields.forEach(function (field) {
      for (let i = 1; i <= voCount; i++) {
        const voInput = document.getElementById(`vo_${field}_${i}`);
        if (voInput) {
          voInput.addEventListener('input', function () {
            updateActualField(field, i);
            calculateBalance();
          });
        }
      }
    });
  
    // Calculate balance based on contract amount and billing fields
    function calculateBalance(triggerInput = null) {
      const contractAmount = getSanitizedValue(actualContractAmountInput);
      let total = 0;
  
      inputIds.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
          total += getSanitizedValue(input);
        }
      });
  
      const balance = contractAmount - total;
  
      // Update balance display
      if (balanceDisplay) {
        balanceDisplay.textContent = formatNumber(balance);
      }
  
      // Update visible contract amount input (formatted)
      if (contractAmountInput) {
        contractAmountInput.value = formatNumber(contractAmount);
      }
  
      // Warn if exceeded allocation
      if (balance < 0 && triggerInput) {
        Swal.fire({
          icon: 'warning',
          title: 'Exceeded Allocation',
          text: 'Total billing exceeds the allocated Contract Amount!',
          confirmButtonText: 'OK'
        }).then(() => {
          triggerInput.value = '';  // Clear the field
          triggerInput.focus();
          calculateBalance(); // Recalculate after clearing
        });
      }
    }
  
    // Add input listeners for billing fields to trigger recalculation and formatting
    inputIds.forEach(id => {
      const input = document.getElementById(id);
      if (input) {
        input.addEventListener('input', () => calculateBalance(input));
        input.addEventListener('blur', function () {
          const val = getSanitizedValue(this);
          this.value = val ? formatNumber(val) : '';
        });
      }
    });
  
    // Add listeners for changes on actual_contract_amount and other actual_* fields to recalc balances
    const actualFields = ['actual_contract_amount', 'actual_engineering', 'actual_mqc'];
    actualFields.forEach(id => {
      const input = document.getElementById(id);
      if (input) {
        input.addEventListener('input', () => {
          calculateBalance();
          if (typeof calculateExpenditureAndSavings === "function") calculateExpenditureAndSavings();
          if (typeof updateEngineeringBalance === "function") updateEngineeringBalance();
          if (typeof updateMqcBalance === "function") updateMqcBalance();
        });
        input.addEventListener('change', () => {
          calculateBalance();
          if (typeof calculateExpenditureAndSavings === "function") calculateExpenditureAndSavings();
          if (typeof updateEngineeringBalance === "function") updateEngineeringBalance();
          if (typeof updateMqcBalance === "function") updateMqcBalance();
        });
      }
    });
  
    // On page load, format the actual_contract_amount and contract_amount fields if they have values
    if (actualContractAmountInput && actualContractAmountInput.value) {
      actualContractAmountInput.value = formatNumber(getSanitizedValue(actualContractAmountInput));
    }
    if (contractAmountInput && contractAmountInput.value) {
      contractAmountInput.value = formatNumber(getSanitizedValue(contractAmountInput));
    }
  
    // Calculate initial balance on page load
    calculateBalance();
  
    // Calculate Mobilization Percentage
    const percentInput = document.getElementById('percentMobi');
    const amountMobilizationInput = document.getElementById('amountMobilization');


  
    function calculateMobilization() {
        let percent = parseFloat(percentInput.value);
        const contractAmount = getSanitizedValue(actualContractAmountInput);

        if (percent > 15) {
            percent = 15;
            percentInput.value = 15;
        }

        const mobilizationAmount = (percent / 100) * contractAmount;

        if (!isNaN(mobilizationAmount)) {
            amountMobilizationInput.value = formatNumber(mobilizationAmount); // Format properly
            amountMobilizationInput.dispatchEvent(new Event('input')); // Trigger balance calculation
            amountMobilizationInput.dispatchEvent(new Event('blur'));  // Trigger formatting (just in case)
        }
        }

  
    percentInput.addEventListener('input', calculateMobilization);
    actualContractAmountInput.addEventListener('input', calculateMobilization);
  
    // Initial call if needed
    calculateMobilization();


    
  });
  function updateBalances() {
    // Calculate sum for Engineering entries
    const engSum = entries
      .filter(e => e.type === 'Engineering')
      .reduce((acc, cur) => acc + parseFloat(cur.amount), 0);
  
    // Calculate sum for MQC entries
    const mqcSum = entries
      .filter(e => e.type === 'MQC')
      .reduce((acc, cur) => acc + parseFloat(cur.amount), 0);
  
    // Update UI
    document.getElementById('engineeringBalance').textContent = engSum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    document.getElementById('mqcBalance').textContent = mqcSum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }
  