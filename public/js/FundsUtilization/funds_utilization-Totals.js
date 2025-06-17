document.addEventListener("DOMContentLoaded", function () {
  const amountSelectors = [
    "#amountMobilization", "#amountPartial1", "#amountPartial2", "#amountPartial3",
    "#amountPartial4", "#amountPartial5", "#amountFinal", "#amountEng", "#amountMqc"
  ];

  const balanceSelectors = ["#contractBalance", "#engineeringBalance", "#mqcBalance"];
  const expenditureOutputs = ["#amountTotal", "#totalExpenditures"];
  const savingsOutputs = ["#totalSavings", "#amountSavings"];

  function parseCurrency(value) {
    if (!value) return 0;
    return parseFloat(value.toString().replace(/[^0-9.-]+/g, '')) || 0;
  }

  function formatPeso(amount) {
    return new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP',
      minimumFractionDigits: 2
    }).format(amount);
  }

  function calculateExpenditures() {
    let total = 0;
    amountSelectors.forEach(sel => {
      const el = document.querySelector(sel);
      if (el) total += parseCurrency(el.value);
    });
    expenditureOutputs.forEach(sel => {
      const out = document.querySelector(sel);
      if (out) out.value = formatPeso(total);
    });
  }

  function calculateSavings() {
    const appropriationEl = document.querySelector("#orig_appropriation");
    const appropriation = appropriationEl ? parseCurrency(appropriationEl.value || appropriationEl.textContent) : 0;
    let expenditures = 0;
    amountSelectors.forEach(sel => {
      const el = document.querySelector(sel);
      if (el) expenditures += parseCurrency(el.value);
    });

    const savings = appropriation - expenditures;
    savingsOutputs.forEach(sel => {
      const out = document.querySelector(sel);
      if (out) out.value = formatPeso(savings);
    });
  }

  function calculateAll() {
    calculateExpenditures();
    calculateSavings();
    if (typeof window.validateExpenditures === 'function') {
      window.validateExpenditures(); // ← Trigger validation after calculation
    }
  }

  function parseFloatSafe(val) {
    if (!val) return 0;
    let num = parseFloat(val.toString().replace(/[₱,]/g, '').trim());
    return isNaN(num) ? 0 : num;
  }

  function calculateActualTotal() {
    const fields = ['contract_amount', 'engineering', 'mqc', 'contingency'];
    let total = 0;
    fields.forEach(key => {
      const input = document.getElementById('actual_' + key);
      if (input) total += parseFloatSafe(input.value);
    });
    const output = document.getElementById('actual_total');
    if (output) {
      output.value = total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
  }

  function calculateOrigTotal() {
    const fields = ['contract_amount', 'engineering', 'mqc', 'contingency', 'bid'];
    let total = 0;
    fields.forEach(key => {
      const input = document.getElementById('orig_' + key);
      if (input) total += parseFloatSafe(input.value);
    });
    const output = document.getElementById('orig_total');
    if (output) {
      output.value = total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
  }

  function attachVOListeners() {
    const voInputs = document.querySelectorAll('[id^="vo_contract_amount_"]');
    voInputs.forEach(input => {
      if (!input.dataset.listenerAttached) {
        input.addEventListener('input', function () {
          const actualInput = document.getElementById('actual_contract_amount');
          if (actualInput) {
            actualInput.value = parseFloatSafe(this.value).toFixed(2);
            calculateActualTotal();
            actualInput.dispatchEvent(new Event('input'));
          }
        });

        input.addEventListener('blur', function () {
          const actualInput = document.getElementById('actual_contract_amount');
          if (actualInput) {
            const raw = parseFloatSafe(this.value);
            this.value = raw ? formatPeso(raw) : '';
            actualInput.value = raw.toFixed(2);
            calculateActualTotal();
          }
        });

        input.dataset.listenerAttached = 'true';
      }
    });
  }

  function attachActualListeners() {
    const fields = ['contract_amount', 'engineering', 'mqc', 'contingency'];
    fields.forEach(key => {
      const input = document.getElementById('actual_' + key);
      if (input) {
        input.addEventListener('input', calculateActualTotal);
        input.addEventListener('blur', () => {
          const val = parseFloatSafe(input.value);
          input.value = val ? formatPeso(val) : '';
          calculateActualTotal();
        });
      }
    });
  }

  function attachOrigListeners() {
    const fields = ['contract_amount', 'engineering', 'mqc', 'contingency', 'bid'];
    fields.forEach(key => {
      const input = document.getElementById('orig_' + key);
      if (input) {
        input.addEventListener('input', calculateOrigTotal);
        input.addEventListener('blur', () => {
          const val = parseFloatSafe(input.value);
          input.value = val ? formatPeso(val) : '';
          calculateOrigTotal();
        });
      }
    });
  }

  attachVOListeners();
  attachActualListeners();
  attachOrigListeners();

  amountSelectors.forEach(sel => {
    const el = document.querySelector(sel);
    if (el) {
      el.addEventListener("input", calculateAll);
      el.addEventListener("blur", () => {
        const val = parseCurrency(el.value);
        el.value = val ? formatPeso(val) : "";
        calculateAll();
      });
    }
  });

  balanceSelectors.forEach(sel => {
    const el = document.querySelector(sel);
    if (el) {
      new MutationObserver(calculateAll).observe(el, { childList: true, subtree: true });
    }
  });

  calculateAll();
  calculateActualTotal();
  calculateOrigTotal();

  const actualContractInput = document.getElementById('actual_contract_amount');
  if (actualContractInput) actualContractInput.readOnly = true;
});
