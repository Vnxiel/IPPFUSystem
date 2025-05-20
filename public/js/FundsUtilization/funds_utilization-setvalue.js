document.addEventListener('DOMContentLoaded', function () {

  const voCountInput = document.getElementById('voCount');
  const voCount = parseInt(voCountInput?.value) || 1;

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

  // Set actual_* fields based on VO values if available, fallback to orig_* on page load
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

    if (balance < 0 && triggerInput) {
      Swal.fire({
        icon: 'warning',
        title: 'Exceeded Allocation',
        text: 'Total billing exceeds the allocated Contract Amount!',
        confirmButtonText: 'OK'
      }).then(() => {
        triggerInput.value = '';
        triggerInput.focus();
        calculateBalance();
      });
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

  // 🔹 Call once on load and re-calculate when original fields change
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

});

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
