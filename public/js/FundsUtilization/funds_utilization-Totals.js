document.addEventListener("DOMContentLoaded", function () {
  const amountSelectors = [
    "#amountMobilization",
    "#amountPartial1",
    "#amountPartial2",
    "#amountPartial3",
    "#amountPartial4",
    "#amountPartial5",
    "#amountFinal",
    "#amountEng",
    "#amountMqc"
  ];

  const balanceSelectors = [
    "#contractBalance",
    "#engineeringBalance",
    "#mqcBalance"
  ];

  const expenditureOutputs = ["#amountTotal", "#totalExpenditures"];
  const savingsOutputs = ["#totalSavings", "#amountSavings"];

  // --- Parses anything that looks like a number out of a string ---
  function parseCurrency(value) {
    if (!value) return 0;
    const cleaned = value.toString().replace(/[^0-9.-]+/g, '');
    return parseFloat(cleaned) || 0;
  }

  // --- Formats a number as PHP currency ---
  function formatPeso(amount) {
    return new Intl.NumberFormat('en-PH', {
      style: 'currency',
      currency: 'PHP',
      minimumFractionDigits: 2
    }).format(amount);
  }

  // ─── Sum all amountSelectors, including readonly ones ──────────────
  function calculateExpenditures() {
    let total = 0;
    amountSelectors.forEach(sel => {
      const el = document.querySelector(sel);
      if (el) {
        total += parseCurrency(el.value);
      }
    });
    expenditureOutputs.forEach(sel => {
      const out = document.querySelector(sel);
      if (out) out.value = formatPeso(total);
    });
  }

  // ─── Sum contract + eng + mqc balances ─────────────────────────────
  function calculateSavings() {
    const appropriationEl = document.querySelector("#orig_appropriation");
    const appropriation = appropriationEl ? parseCurrency(appropriationEl.value || appropriationEl.textContent) : 0;

    let expenditures = 0;
    amountSelectors.forEach(sel => {
      const el = document.querySelector(sel);
      if (el) {
        expenditures += parseCurrency(el.value);
      }
    });

    const savings = appropriation - expenditures;

    savingsOutputs.forEach(sel => {
      const out = document.querySelector(sel);
      if (out) out.value = formatPeso(savings);
    });
  }

  // ─── Run both expenditure and savings calculations ────────────────
  function calculateAll() {
    calculateExpenditures();
    calculateSavings();
  }

  // ─── Safe parse float utility ─────────────────────────────────────
  function parseFloatSafe(val) {
    if (!val) return 0;
    let num = parseFloat(val.toString().replace(/[₱,]/g, '').trim());
    return isNaN(num) ? 0 : num;
  }

  // ─── Actual Total Calculation ─────────────────────────────────────
  function calculateActualTotal() {
    const fields = ['contract_amount', 'engineering', 'mqc', 'contingency'];
    let total = 0;

    fields.forEach(key => {
      const input = document.getElementById('actual_' + key);
      if (input) {
        const parsed = parseFloatSafe(input.value);
        // For debugging, can remove console.log if not needed:
        // console.log(`actual_${key}: ${input.value} → ${parsed}`);
        total += parsed;
      }
    });

    const output = document.getElementById('actual_total');
    if (output) {
      output.value = total.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }
  }

  // ─── Original Total Calculation ────────────────────────────────────
  function calculateOrigTotal() {
    const fields = ['contract_amount', 'engineering', 'mqc', 'contingency', 'bid'];
    let total = 0;

    fields.forEach(key => {
      const input = document.getElementById('orig_' + key);
      if (input) {
        total += parseFloatSafe(input.value);
      }
    });

    const output = document.getElementById('orig_total');
    if (output) {
      output.value = total.toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }
  }

  // ─── Attach VO Input Listeners ─────────────────────────────────────
  function attachVOListeners() {
    const voInputs = document.querySelectorAll('[id^="vo_contract_amount_"]');
  
    voInputs.forEach(input => {
      if (!input.dataset.listenerAttached) {
        // Handle typing and real-time updates
        input.addEventListener('input', function () {
          const actualInput = document.getElementById('actual_contract_amount');
          if (actualInput) {
            actualInput.value = parseFloatSafe(this.value).toFixed(2);
            calculateActualTotal();
            actualInput.dispatchEvent(new Event('input'));
          }
        });
  
        // Handle blur formatting and fallback update
        input.addEventListener('blur', function () {
          const actualInput = document.getElementById('actual_contract_amount');
          if (actualInput) {
            const raw = parseFloatSafe(this.value);
            this.value = raw ? formatPeso(raw) : ''; // format this input
            actualInput.value = raw.toFixed(2);
            calculateActualTotal();
          }
        });
  
        // Optional: change event for safety
        input.addEventListener('change', function () {
          const actualInput = document.getElementById('actual_contract_amount');
          if (actualInput) {
            actualInput.value = parseFloatSafe(this.value).toFixed(2);
            calculateActualTotal();
          }
        });
  
        input.dataset.listenerAttached = 'true';
      }
    });
  }
  
  // ─── Attach input listeners to actual fields ──────────────────────
  function attachActualListeners() {
    const actualFields = ['contract_amount', 'engineering', 'mqc', 'contingency'];
    actualFields.forEach(key => {
      const input = document.getElementById('actual_' + key);
      if (input) {
        input.addEventListener('input', calculateActualTotal);
        input.addEventListener('change', calculateActualTotal);
        input.addEventListener('blur', () => {
          // Format on blur to PHP Peso format
          const val = parseFloatSafe(input.value);
          input.value = val ? formatPeso(val) : '';
          calculateActualTotal();
        });
      }
    });
  }

  // ─── Attach input listeners to original fields ────────────────────
  function attachOrigListeners() {
    const origFields = ['contract_amount', 'engineering', 'mqc', 'contingency', 'bid'];
    origFields.forEach(key => {
      const input = document.getElementById('orig_' + key);
      if (input) {
        input.addEventListener('input', calculateOrigTotal);
        input.addEventListener('change', calculateOrigTotal);
        input.addEventListener('blur', () => {
          const val = parseFloatSafe(input.value);
          input.value = val ? formatPeso(val) : '';
          calculateOrigTotal();
        });
      }
    });
  }

  // ─── Initializations on DOMContentLoaded ──────────────────────────
  attachVOListeners();
  attachActualListeners();
  attachOrigListeners();

  // Optional: Attach input event listeners to other amountSelectors for full recalculation
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

  // Observe balance changes (optional, if balances update dynamically)
  const observer = new MutationObserver(calculateAll);
  balanceSelectors.forEach(sel => {
    const el = document.querySelector(sel);
    if (el) {
      observer.observe(el, { characterData: true, childList: true, subtree: true });
    }
  });

  // Initial calculations on page load
  calculateAll();
  calculateActualTotal();
  calculateOrigTotal();

   // Make actual contract amount readonly
   const actualContractInput = document.getElementById('actual_contract_amount');
   if (actualContractInput) {
     actualContractInput.readOnly = true;
   }
 
   // When user tabs from the last VO input, move focus to actual contract amount
   const voInputs = document.querySelectorAll('[id^="vo_contract_amount_"]');
   if (voInputs.length && actualContractInput) {
     const lastVOInput = voInputs[voInputs.length - 1];
 
     lastVOInput.addEventListener('keydown', function(e) {
       if (e.key === 'Tab' && !e.shiftKey) {
         e.preventDefault();
         actualContractInput.focus();
       }
     });
 
     // Optional: if you want Shift+Tab from actual contract to go back to last VO input
     actualContractInput.addEventListener('keydown', function(e) {
       if (e.key === 'Tab' && e.shiftKey) {
         e.preventDefault();
         lastVOInput.focus();
       }
     });
   }
   // Move focus on Enter key from VO inputs
voInputs.forEach((input, index) => {
  input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter') {
      e.preventDefault(); // prevent form submission or default

      // If not the last VO input, focus next VO input
      if (index + 1 < voInputs.length) {
        voInputs[index + 1].focus();
      } else {
        // If last VO input, move focus to actual contract amount
        if (actualContractInput) actualContractInput.focus();
      }
    }
  });
});

});
