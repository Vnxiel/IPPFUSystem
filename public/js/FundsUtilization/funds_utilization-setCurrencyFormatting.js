function formatNumber(num) {
    if (!num) return '';
    const parts = num.toString().split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    return parts.join('.');
  }
  
  function cleanNumber(val) {
    // Remove everything except digits and decimal point
    val = val.replace(/[^0-9.]/g, '');
  
    // Allow only one decimal point
    const parts = val.split('.');
    if (parts.length > 2) {
      val = parts[0] + '.' + parts.slice(1).join('');
    }
  
    // Limit decimal places to max 2 digits
    if (parts[1]) {
      val = parts[0] + '.' + parts[1].slice(0, 2);
    }
  
    return val;
  }
  

  // Lightweight formatting while typing (no peso sign, no fixed decimals)
function formatInputLive(input) {
    let val = cleanNumber(input.value);
    if (!val) {
        input.value = '';
        return;
    }
    // Allow partial typing, so don't fix decimals yet
    // Just add commas to integer part
    const parts = val.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    input.value = parts.join('.');
}

  function formatInput(input) {
    const raw = cleanNumber(input.value);
    if (!raw) {
      input.value = '';
      return;
    }
  
    const floatVal = parseFloat(raw);
    if (isNaN(floatVal)) {
      input.value = '';
      return;
    }
  
    input.value = '₱' + formatNumber(floatVal.toFixed(2));
  }
  
  function initAmountInputs() {
    const amountInputs = document.querySelectorAll('.amount-input');
  
    amountInputs.forEach(input => {
      formatInput(input); // Initial formatting on page load
  
      input.addEventListener('input', function () {
        let value = this.value;
  
        // Remove all characters except digits, commas, and periods
        value = value.replace(/[^0-9.,]/g, '');
  
        // Remove commas temporarily for validation, but keep them while typing
        // We'll remove them on blur anyway
        let parts = value.split('.');
  
        // If more than one decimal point, remove extras
        if (parts.length > 2) {
          // Keep the first decimal point only
          value = parts[0] + '.' + parts.slice(1).join('');
        }
  
        // Prevent multiple commas in a row
        value = value.replace(/,+/g, ',');
  
        // Allow any number of commas, no formatting on input event to avoid caret jump
        this.value = value;
      });
  
      input.addEventListener('blur', function () {
        // On blur, clean and format properly
        formatInput(this);
      });
    });
  }
  
  // Run on DOM load
  initAmountInputs();

  document.addEventListener("DOMContentLoaded", function () {
    const amountInputs = document.querySelectorAll(".amount-input");
  
    amountInputs.forEach(input => {
      input.addEventListener("input", function (e) {
        let value = this.value.replace(/[^\d.]/g, "");
        let parts = value.split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        this.value = '₱' + parts.join(".");
      });
  
      input.addEventListener("focus", function () {
        this.value = this.value.replace(/[^\d.]/g, "");
      });
  
      input.addEventListener("blur", function () {
        let value = this.value.replace(/[^\d.]/g, "");
        let parts = value.split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        this.value = value ? '₱' + parts.join(".") : '';
      });
    });
  
    document.getElementById("addFundUtilization").addEventListener("submit", function () {
      amountInputs.forEach(input => {
        input.value = input.value.replace(/[^\d.]/g, "");
      });
    });
  });
  
  
  