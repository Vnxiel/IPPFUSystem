
document.addEventListener('DOMContentLoaded', function () {

  const voCountInput = document.getElementById('voCount');
  let voCount = parseInt(voCountInput?.value) || 1;

  const allFields = ['appropriation', 'abc', 'contract_amount', 'bid', 'engineering', 'mqc', 'contingency'];
  const pageLoadFields = ['contract_amount', 'engineering', 'mqc', 'contingency'];

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

  function formatNumber(num) {
    return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  function getSanitizedValue(input) {
    if (!input || !input.value) return 0;
    return parseFloat(input.value.replace(/₱|,/g, '').trim()) || 0;
  }

  function updateActualField(field, latestVO) {
    const latestVOInput = document.getElementById(`vo_${field}_${latestVO}`);
    const actualInput = document.getElementById(`actual_${field}`);
    if (latestVOInput && actualInput) {
      actualInput.value = latestVOInput.value;
    }
  }

  // Initial set of actual_* fields on load
  pageLoadFields.forEach(function (field) {
    let latestNonEmptyValue = '';
    for (let i = voCount; i >= 1; i--) {
      const voInput = document.getElementById(`vo_${field}_${i}`);
      if (voInput && voInput.value.trim() !== '') {
        latestNonEmptyValue = voInput.value.trim();
        break;
      }
    }

    const actualInput = document.getElementById(`actual_${field}`);
    if (actualInput) {
      if (latestNonEmptyValue) {
        actualInput.value = latestNonEmptyValue;
      } else {
        const origInput = document.getElementById(`orig_${field}`);
        if (origInput) {
          actualInput.value = origInput.value;
        }
      }
    }
  });

  // 🔄 Attach VO input listeners (initial + reusable)
  function attachVOListeners() {
    voCount = parseInt(voCountInput?.value) || 1; // Refresh in case voCount was updated
    allFields.forEach(function (field) {
      for (let i = 1; i <= voCount; i++) {
        const voInput = document.getElementById(`vo_${field}_${i}`);
        if (voInput && !voInput.dataset.listenerAttached) {
          voInput.addEventListener('input', function () {
            updateActualField(field, i);
            calculateBalance();
          
            // Update amountEng or amountMqc if applicable
            const actualEng = document.getElementById("actual_engineering");
            const amountEng = document.querySelector('input[name="amountEng"]');
            const actualMqc = document.getElementById("actual_mqc");
            const amountMqc = document.querySelector('input[name="amountMqc"]');
          
            if (field === 'engineering' && actualEng && amountEng) {
              amountEng.value = actualEng.value;
            }
          
            if (field === 'mqc' && actualMqc && amountMqc) {
              amountMqc.value = actualMqc.value;
            }
          
            // Make all previous VO inputs for this field readonly if this input has a value
            if (this.value.trim() !== '') {
              for (let j = 1; j < i; j++) {
                const prevInput = document.getElementById(`vo_${field}_${j}`);
                if (prevInput) {
                  prevInput.readOnly = true;
                }
              }
            }
          });
          

          voInput.dataset.listenerAttached = "true";
        }
      }
    });
  }

  attachVOListeners(); // Initial run

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

    if (balanceDisplay) {
      balanceDisplay.textContent = formatNumber(balance);
    }

    if (contractAmountInput) {
      contractAmountInput.value = formatNumber(contractAmount);
    }
  }

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

  const actualFields = ['actual_contract_amount', 'actual_engineering', 'actual_mqc'];
  actualFields.forEach(id => {
    const input = document.getElementById(id);
    if (input) {
      input.addEventListener('input', () => {
        calculateBalance();
        if (typeof calculateExpenditureAndSavings === "function") calculateExpenditureAndSavings();
        const amountEng = document.getElementById('amountEng');
        const amountMqc = document.getElementById('amountMqc');
        
        if (id === 'actual_engineering' && amountEng) {
          amountEng.value = formatNumber(getSanitizedValue(input));
        }
        
        if (id === 'actual_mqc' && amountMqc) {
          amountMqc.value = formatNumber(getSanitizedValue(input));
        }
        
      });
      input.addEventListener('change', () => {
        calculateBalance();
        if (typeof calculateExpenditureAndSavings === "function") calculateExpenditureAndSavings();
        const amountEng = document.getElementById('amountEng');
        const amountMqc = document.getElementById('amountMqc');
        
        if (id === 'actual_engineering' && amountEng) {
          amountEng.value = formatNumber(getSanitizedValue(input));
        }
        
        if (id === 'actual_mqc' && amountMqc) {
          amountMqc.value = formatNumber(getSanitizedValue(input));
        }
        
      });
    }
  });

  if (actualContractAmountInput && actualContractAmountInput.value) {
    actualContractAmountInput.value = formatNumber(getSanitizedValue(actualContractAmountInput));
  }
  if (contractAmountInput && contractAmountInput.value) {
    contractAmountInput.value = formatNumber(getSanitizedValue(contractAmountInput));
  }

  calculateBalance();

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
      amountMobilizationInput.value = formatNumber(mobilizationAmount);
      amountMobilizationInput.dispatchEvent(new Event('input'));
      amountMobilizationInput.dispatchEvent(new Event('blur'));
    }
  }

  percentInput.addEventListener('input', calculateMobilization);
  actualContractAmountInput.addEventListener('input', calculateMobilization);
  calculateMobilization();

  // 🔹 Calculate total of original values (excluding appropriation)
  function calculateOrigTotal() {
    const fieldsToSum = ['contract_amount', 'bid', 'engineering', 'mqc', 'contingency'];
    let total = 0;

    fieldsToSum.forEach(field => {
      const input = document.getElementById(`orig_${field}`);
      if (input) {
        total += getSanitizedValue(input);
      }
    });

    const totalInput = document.getElementById('orig_total');
    if (totalInput) {
      totalInput.value = formatNumber(total);
    }
  }

  calculateOrigTotal();

  ['abc', 'contract_amount', 'bid', 'engineering', 'mqc', 'contingency'].forEach(field => {
    const input = document.getElementById(`orig_${field}`);
    if (input) {
      input.addEventListener('input', calculateOrigTotal);
      input.addEventListener('blur', function () {
        const val = getSanitizedValue(this);
        this.value = val ? formatNumber(val) : '';
        calculateOrigTotal();
      });
    }
  });

  // ✅ Make attachVOListeners globally callable
  window.attachVOListeners = attachVOListeners;

    // 🔁 Auto-attach listeners when new VO fields are added
    const observer = new MutationObserver((mutationsList) => {
      for (const mutation of mutationsList) {
        if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
          attachVOListeners(); // Check for new VO inputs and attach listeners
        }
      }
    });
  
    observer.observe(document.body, {
      childList: true,
      subtree: true
    });

});

// 🔹 Optional helper for Engineering and MQC balances
function updateBalances() {
  const engSum = entries
    .filter(e => e.type === 'Engineering')
    .reduce((acc, cur) => acc + parseFloat(cur.amount), 0);

  const mqcSum = entries
    .filter(e => e.type === 'MQC')
    .reduce((acc, cur) => acc + parseFloat(cur.amount), 0);

  document.getElementById('engineeringBalance').textContent = engSum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  document.getElementById('mqcBalance').textContent = mqcSum.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}
