document.addEventListener("DOMContentLoaded", function () {
  const amountSelectors    = [
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
  const balanceSelectors   = [
    "#contractBalance",
    "#engineeringBalance",
    "#mqcBalance"
  ];
  const expenditureOutputs = ["#amountTotal", "#totalExpenditures"];
  const savingsOutputs     = ["#totalSavings", "#amountSavings"];

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

  // ─── Sum all amountSelectors, including readonly ones ─────────────────
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
  

  // ─── Run both ───────────────────────────────────────────────────────
  function calculateAll() {
    calculateExpenditures();
    calculateSavings();
  }

  // ─── Recalculate on any billing input change ────────────────────────
  amountSelectors.forEach(sel => {
    const el = document.querySelector(sel);
    if (el) {
      el.addEventListener("input", calculateAll);
      el.addEventListener("blur", () => {
        el.value = parseCurrency(el.value)
          ? formatPeso(parseCurrency(el.value))
          : "";
        calculateAll();
      });
    }
  });

  // ─── Watch for programmatic updates to the balance cells ───────────
  const observer = new MutationObserver(calculateAll);
  balanceSelectors.forEach(sel => {
    const el = document.querySelector(sel);
    if (el) {
      observer.observe(el, { characterData: true, childList: true, subtree: true });
    }
  });

  // ─── Initial calculation on page load ──────────────────────────────
  calculateAll();
});



  // ─── Total actual ──────────────────────────────
function parseFloatSafe(val) {
  let num = parseFloat(val.replace(/,/g, ''));
  return isNaN(num) ? 0 : num;
}

function calculateActualTotal() {
  const fields = ['contract_amount', 'engineering', 'mqc', 'contingency'];
  let total = 0;

  fields.forEach(key => {
    const input = document.getElementById('actual_' + key);
    if (input) {
      total += parseFloatSafe(input.value);
    }
  });

  // Format as currency
  document.getElementById('actual_total').value = total.toLocaleString(undefined, {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}

// Recalculate total whenever any actual field is changed
document.addEventListener('DOMContentLoaded', () => {
  const fields = ['contract_amount', 'engineering', 'mqc', 'contingency'];
  fields.forEach(key => {
    const input = document.getElementById('actual_' + key);
    if (input) {
      input.addEventListener('input', calculateActualTotal);
    }
  });

  // Initial calculation on page load
  calculateActualTotal();
});