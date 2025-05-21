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
  
    // --- Better parsing of any text that contains a number ---
    function parseCurrency(value) {
      if (!value) return 0;
      const cleaned = value.toString().replace(/[^0-9.-]+/g, '');
      return parseFloat(cleaned) || 0;
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
        if (el && !el.hasAttribute("readonly")) {
          total += parseCurrency(el.value);
        }
      });
      expenditureOutputs.forEach(sel => {
        const out = document.querySelector(sel);
        if (out) out.value = formatPeso(total);
      });
    }
  
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
  
    function calculateAll() {
      calculateExpenditures();
      calculateSavings();
    }
  
    // Recalc whenever any billing input changes
    amountSelectors.forEach(sel => {
      const el = document.querySelector(sel);
      if (el && !el.hasAttribute("readonly")) {
        el.addEventListener("input", calculateAll);
        el.addEventListener("blur", () => {
          el.value = parseCurrency(el.value)
            ? formatPeso(parseCurrency(el.value))
            : "";
          calculateAll();
        });
      }
    });
  
    // Watch for any programmatic change in your balance cells
    const observer = new MutationObserver(calculateAll);
    balanceSelectors.forEach(sel => {
      const el = document.querySelector(sel);
      if (el) {
        observer.observe(el, { characterData: true, childList: true, subtree: true });
      }
    });
  
    // Initial calculation on page load
    calculateAll();
  });
  