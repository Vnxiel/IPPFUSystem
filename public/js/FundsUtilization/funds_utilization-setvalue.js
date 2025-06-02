function getSanitizedValue(input) {
  if (!input || !input.value) return 0;
  return parseFloat(input.value.replace(/[^0-9.,]/g, '').replace(/,/g, '')) || 0;
}


document.addEventListener('DOMContentLoaded', function () {

  //total appropriation display
  const origApproInput = document.getElementById('orig_appropriation');
  const totalApproOutput = document.getElementById('totalAppro');

  if (origApproInput && totalApproOutput) {
    origApproInput.addEventListener('input', function () {
      totalApproOutput.value = origApproInput.value;
    });
  }



  const abcInput = document.getElementById('orig_abc');
  const contractInput = document.getElementById('orig_contract_amount');
  const savingsInput = document.getElementById('orig_bid');

  function parseCurrency(value) {
    if (!value) return 0;
    // Remove peso sign, commas, and whitespace
    return parseFloat(value.replace(/[₱,]/g, '').trim()) || 0;
  }

  function updateBidSavings() {
    const abc = parseCurrency(abcInput.value);
    const contract = parseCurrency(contractInput.value);
    const savings = abc - contract;

    if (savingsInput) {
      savingsInput.value = savings.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
  }

  if (abcInput && contractInput && savingsInput) {
    updateBidSavings(); // On page load

    abcInput.addEventListener('input', updateBidSavings);
    contractInput.addEventListener('input', updateBidSavings);
  }

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
    if (num === null || num === undefined || num === '') return '';
    const str = num.toString().replace(/[^0-9.]/g, '');
    const parts = str.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    return parts.join('.');
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
    } else if (field === 'contract_amount') {
      // Retain orig fallback for contract_amount only
      const origInput = document.getElementById(`orig_${field}`);
      if (origInput) {
        actualInput.value = origInput.value;
      }
    }
  }
});


  // ✅ Initialize amountEng and amountMqc on load using actual_engineering and actual_mqc
  const amountEng = document.getElementById('amountEng');
  const actualEng = document.getElementById('actual_engineering');
  if (amountEng && actualEng) {
    amountEng.value = formatNumber(getSanitizedValue(actualEng));
  }

  const amountMqc = document.getElementById('amountMqc');
  const actualMqc = document.getElementById('actual_mqc');
  if (amountMqc && actualMqc) {
    amountMqc.value = formatNumber(getSanitizedValue(actualMqc));
  }
  

  // Attach VO input listeners (initial + reusable)
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
    let sum = 0;
  
    inputIds.forEach(id => {
      if (id !== 'amountFinal') {
        sum += getSanitizedValue(document.getElementById(id));
      }
    });
  
    const finalInput = document.getElementById('amountFinal');
    const finalAmount = Math.max(0, contractAmount - sum);
    if (finalInput) finalInput.value = formatNumber(finalAmount);
  
    const balance = contractAmount - (sum + finalAmount);
  
    if (balance < 0 && triggerInput) {
      Swal.fire({
        icon: 'error',
        title: 'Contract Balance',
        text: 'The total amount exceeds the contract amount. Please adjust your inputs.',
      }).then(() => {
        triggerInput.value = '';
        triggerInput.focus();
      });
      return;
    }
  
    if (balanceDisplay) balanceDisplay.textContent = formatNumber(Math.max(0, balance));
    if (contractAmountInput) contractAmountInput.value = formatNumber(contractAmount);
  }
  
  inputIds.forEach(id => {
    const input = document.getElementById(id);
    if (!input) return;

    input.addEventListener('input', function () {

      if (id === 'amountFinal') {
        const raw = this.value.replace(/[^0-9.]/g, '');
        let value = parseFloat(raw);
        const contractAmount = getSanitizedValue(actualContractAmountInput);
        let sumBeforeFinal = 0;
    
        inputIds.forEach(otherId => {
          if (otherId !== 'amountFinal') {
            sumBeforeFinal += getSanitizedValue(document.getElementById(otherId));
          }
        });
    
        const maxFinal = contractAmount - sumBeforeFinal;
        if (isNaN(value)) value = 0;
        if (value > maxFinal) value = maxFinal;
    
        this.value = formatNumber(value);
      }
    
      calculateBalance(this); // Pass the triggering input
    });
    
    input.addEventListener('blur', function () {
      this.value = this.value ? formatNumber(getSanitizedValue(this)) : '';
    });
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

function updateBalances() {
  const origEng = document.getElementById('orig_engineering');
  const amountEng = document.getElementById('amountEng');
  const engBalance = document.getElementById('engineeringBalance');

  const origMqc = document.getElementById('orig_mqc');
  const amountMqc = document.getElementById('amountMqc');
  const mqcBalance = document.getElementById('mqcBalance');

  const engDiff = getSanitizedValue(origEng) - getSanitizedValue(amountEng);
  const mqcDiff = getSanitizedValue(origMqc) - getSanitizedValue(amountMqc);

  if (engBalance) engBalance.textContent = formatNumber(engDiff);
  if (mqcBalance) mqcBalance.textContent = formatNumber(mqcDiff);
}

updateBalances(); 

