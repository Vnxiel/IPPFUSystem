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
  
    function parseCurrency(value) {
      if (!value) return 0;
      return parseFloat(value.replace(/[₱,]/g, '').trim()) || 0;
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
      amountSelectors.forEach(selector => {
        const el = document.querySelector(selector);
        if (el) total += parseCurrency(el.value);
      });
  
      // Set the readonly inputs with formatted peso string
      ["#amountTotal", "#totalExpenditures"].forEach(id => {
        const el = document.querySelector(id);
        if (el) el.value = formatPeso(total);
      });
    }
  
    function calculateSavings() {
      let total = 0;
      balanceSelectors.forEach(selector => {
        const el = document.querySelector(selector);
        if (el) total += parseCurrency(el.textContent);
      });
  
      // Set readonly inputs with formatted peso string
      ["#totalSavings", "#amountSavings"].forEach(id => {
        const el = document.querySelector(id);
        if (el) el.value = formatPeso(total);
      });
    }
  
    function calculateAll() {
      calculateExpenditures();
      calculateSavings();
    }
  
    // Attach event listeners on inputs (except readonly ones)
    amountSelectors.forEach(selector => {
      const el = document.querySelector(selector);
      if (el && !el.hasAttribute("readonly")) {
        el.addEventListener("input", calculateAll);
      }
    });
  
    // Observe balance text changes
    const observer = new MutationObserver(calculateAll);
    balanceSelectors.forEach(selector => {
      const el = document.querySelector(selector);
      if (el) observer.observe(el, { characterData: true, subtree: true, childList: true });
    });
  
    // Initial calculation on page load
    calculateAll();
  });
  