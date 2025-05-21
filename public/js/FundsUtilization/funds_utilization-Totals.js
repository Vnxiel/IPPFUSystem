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
    let sum = 0;
    balanceSelectors.forEach(sel => {
      const el = document.querySelector(sel);
      if (el) {
        sum += parseCurrency(el.textContent);
      }
    });
    savingsOutputs.forEach(sel => {
      const out = document.querySelector(sel);
      if (out) out.value = formatPeso(sum);
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
