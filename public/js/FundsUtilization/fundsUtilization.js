
function formatNumber(num) {
  if (!num) return '';
  const parts = num.toString().split('.');
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  return parts.join('.');
}

function cleanNumber(val) {
  val = val.replace(/[^\d.]/g, '');
  const parts = val.split('.');
  if (parts.length > 2) {
      val = parts[0] + '.' + parts.slice(1).join('');
  }
  return parts.length === 2
      ? parts[0] + '.' + parts[1].slice(0, 2)
      : val;
}



function formatInput(input) {
  const raw = cleanNumber(input.value);
  if (!raw) return;
  const floatVal = parseFloat(raw).toFixed(2);
  input.value = '₱' + formatNumber(floatVal);
}

function initAmountInputs() {
  const amountInputs = document.querySelectorAll('.amount-input');

  amountInputs.forEach(input => {
      formatInput(input); // Initial formatting

      input.addEventListener('input', function () {
        // Allow only digits and one decimal point while typing
        let value = this.value.replace(/[^0-9.]/g, '');
      
        const parts = value.split('.');
        if (parts.length > 2) {
          value = parts[0] + '.' + parts[1];  // only first decimal allowed
        }
      
        // Limit to 2 decimals max (do not format commas here)
        if (parts[1]) {
          parts[1] = parts[1].slice(0, 2);
          value = parts[0] + '.' + parts[1];
        } else {
          value = parts[0];
        }
      
        this.value = value;
      });
      
      input.addEventListener('blur', function () {
        if (!this.value) return;
        let floatVal = parseFloat(this.value);
        if (isNaN(floatVal)) {
          this.value = '';
          return;
        }
        this.value = '₱' + floatVal.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      });
      
    

    input.addEventListener('blur', function () {
      formatInput(this);  // formats when user leaves the field
  });
  
  });
}

// Run on DOM load
initAmountInputs();

// Also re-run when the modal is shown (Bootstrap example)
const modal = document.getElementById('addProjectFundUtilization'); // Change to your actual modal ID
if (modal) {
  modal.addEventListener('shown.bs.modal', function () {
      initAmountInputs(); // re-format input when modal is shown
  });
}

// Clean values before form submission
const form = document.getElementById("addFundUtilization");
if (form) {
  form.addEventListener("submit", function () {
      document.querySelectorAll('.amount-input').forEach(input => {
          input.value = cleanNumber(input.value);
      });
  });
}

function parseAmount(val) {
  const parsed = parseFloat(val.replace(/[^0-9.-]+/g, ''));
  return isNaN(parsed) ? null : parsed;
}

function updateOriginalTotal() {
  const contract = parseAmount(document.getElementById("orig_contract_amount").value);
  const engineering = parseAmount(document.getElementById("orig_engineering").value);
  const mqc = parseAmount(document.getElementById("orig_mqc").value);
  const contingency = parseAmount(document.getElementById("orig_contingency").value);
  const bid = parseAmount(document.getElementById("orig_bid").value);

  const values = [contract, engineering, mqc, contingency, bid];

  // If all fields are empty, clear the total
  if (values.every(v => v === null)) {
    document.getElementById("orig_total").value = '';
    return;
  }

  const total = values.reduce((sum, val) => sum + (val || 0), 0);
  document.getElementById("orig_total").value = total.toFixed(2);
}

const fieldsToWatch = [
  "orig_contract_amount", "orig_engineering",
  "orig_mqc", "orig_contingency", "orig_bid"
];

// Attach listeners
fieldsToWatch.forEach(id => {
  const el = document.getElementById(id);
  if (el) {
    el.addEventListener("input", updateOriginalTotal);
  }
});

// Also run check on load
window.addEventListener("DOMContentLoaded", updateOriginalTotal);

function updateDisplayedContractAmount() {
  const actual = document.getElementById("actual_contract_amount").value.trim();
  const vo = document.getElementById("vo_contract_amount_1").value.trim();
  const orig = document.getElementById("orig_contract_amount").value.trim();

  let displayVal = "amount";

  if (actual !== "") {
    displayVal = actual;
  } else if (vo !== "") {
    displayVal = vo;
  } else if (orig !== "") {
    displayVal = orig;
  }

  document.getElementById("actual_contract_amount").innerText = displayVal;
}

["actual_contract_amount", "vo_contract_amount_1", "orig_contract_amount"].forEach(id => {
  const el = document.getElementById(id);
  if (el) {
    el.addEventListener("input", updateDisplayedContractAmount);
  }
});

window.addEventListener("DOMContentLoaded", updateDisplayedContractAmount);



document.addEventListener('DOMContentLoaded', function () {
  function parseCurrency(value) {
    return parseFloat((value || '0').replace(/[₱,]/g, '')) || 0;
  }

  function showError(fieldLabel) {
    Swal.fire({
      icon: 'error',
      title: 'Limit Exceeded',
      text: `${fieldLabel} exceeds the Original Appropriation!`
    });
  }

  const fieldGroups = [
    { label: 'ABC', ids: ['orig_abc', 'vo_abc_1', 'actual_abc'] },
    { label: 'Contract Amount', ids: ['orig_contract_amount', 'vo_contract_amount_1', 'actual_contract_amount'] },
    { label: 'Engineering', ids: ['orig_engineering', 'vo_engineering_1', 'actual_engineering'] },
    { label: 'MQC', ids: ['orig_mqc', 'vo_mqc_1', 'actual_mqc'] },
    { label: 'Contingency', ids: ['orig_contingency', 'vo_contingency_1', 'actual_contingency'] },
    { label: 'Bid Difference', ids: ['orig_bid', 'vo_bid_1', 'actual_bid'] },
    { label: 'Appropriation', ids: ['vo_appropriation_1', 'actual_appropriation'] } // Note: 'orig_appropriation' is the base limit
  ];

  fieldGroups.forEach(group => {
    group.ids.forEach(id => {
      const input = document.getElementById(id);
      if (input) {
        input.addEventListener('blur', function () {
          const appropriationValue = parseCurrency(document.getElementById('orig_appropriation').value);
          const inputValue = parseCurrency(input.value);

       
          if (inputValue > appropriationValue) {
            console.warn(`✖ ${group.label} [${id}] exceeds appropriation`);
            showError(group.label);
            input.value = '';
          } else {
            console.log(`✔ ${group.label} [${id}] is within limit`);
          }
        });
      }
    });
  });


  const actualEng = document.getElementById("actual_engineering");
  const amountEng = document.querySelector('input[name="amountEng"]');

  const actualMqc = document.getElementById("actual_mqc");
  const summaryMqc = document.querySelector('input[name="amountMqc"]');


  // Sync engineering and mqc values
  if (actualEng && amountEng) {
    actualEng.addEventListener("input", () => {
      amountEng.value = actualEng.value;
    });
  }
 

  if (actualMqc && summaryMqc) {
    actualMqc.addEventListener("input", () => {
      summaryMqc.value = actualMqc.value;
    });
  }

  // Format number to ₱ and comma format
  function formatWithPeso(value) {
    const num = value.replace(/[^\d.]/g, ''); // keep digits and dot only
    if (!num) return '';
    const [intPart, decimalPart] = num.split('.');
    const withComma = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return `₱${withComma}${decimalPart ? '.' + decimalPart.slice(0, 2) : ''}`;
  }


  const amountTotal = document.querySelector('input[name="amountTotal"]');
  const amountSavings = document.querySelector('input[name="amountSavings"]');
  const origAppropriation = document.getElementById('orig_appropriation');

  const validateExpenditures = () => {
    const appropriation = parseCurrency(origAppropriation.value);
    const total = parseCurrency(amountTotal.value);
    const savings = parseCurrency(amountSavings.value);

    if (total > appropriation) {
      Swal.fire({
        icon: 'error',
        title: 'Expenditure Exceeded',
        text: 'Total Expenditures cannot exceed the Original Appropriation!',
      });
      amountTotal.value = '';
      return false;
    }

    if (savings < 0) {
      Swal.fire({
        icon: 'error',
        title: 'Negative Savings',
        text: 'Total Savings cannot be a negative amount!',
      });
      amountSavings.value = '';
      return false;
    }

    return true;
  };

  let voCount = 1;
  let billingCount = 1;

  document.getElementById('submitFundsUtilization').addEventListener('click', function () {
        
        const project_id = sessionStorage.getItem("project_id");
        if (!project_id) return;

        // Get latest VO count
        voCount = parseInt(document.getElementById('voCount').value) || 1;

        const variation_orders = [];
        for (let i = 1; i <= voCount; i++) {
          variation_orders.push({
            vo_number: i,
            vo_abc: document.getElementById(`vo_abc_${i}`)?.value || '',
            vo_contract_amount: document.getElementById(`vo_contract_amount_${i}`)?.value || '',
            vo_engineering: document.getElementById(`vo_engineering_${i}`)?.value || '',
            vo_mqc: document.getElementById(`vo_mqc_${i}`)?.value || '',
            vo_bid: document.getElementById(`vo_bid_${i}`)?.value || '',
            vo_contingency: document.getElementById(`vo_contingency_${i}`)?.value || '',
            vo_appropriation: document.getElementById(`vo_appropriation_${i}`)?.value || ''
          });
        }

        const formData = {
          project_id,
          orig_abc: document.getElementById('orig_abc').value,
          orig_contract_amount: document.getElementById('orig_contract_amount').value,
          orig_engineering: document.getElementById('orig_engineering').value,
          orig_mqc: document.getElementById('orig_mqc').value,
          orig_bid: document.getElementById('orig_bid').value,
          orig_contingency: document.getElementById('orig_contingency').value,
          orig_appropriation: document.getElementById('orig_appropriation').value,
          variation_orders,
          actual_abc: document.getElementById('actual_abc').value,
          actual_contract_amount: document.getElementById('actual_contract_amount').value,
          actual_engineering: document.getElementById('actual_engineering').value,
          actual_mqc: document.getElementById('actual_mqc').value,
          actual_bid: document.getElementById('actual_bid').value,
          actual_contingency: document.getElementById('actual_contingency').value,
          actual_appropriation: document.getElementById('actual_appropriation').value,
          summary: {
              mobilization: {
                date: document.querySelector('[name="dateMobilization"]')?.value || '',
                amount: document.querySelector('[name="amountMobilization"]')?.value || '',
                remarks: document.querySelector('[name="remMobilization"]')?.value || '',
                remaining: {
                  date: document.querySelector('[name="dateMobilization2"]')?.value || '',
                  amount: document.querySelector('[name="amountMobilization2"]')?.value || '',
                  remarks: document.querySelector('[name="remMobilization2"]')?.value || ''
                }
              },
              final: {
                date: document.querySelector('[name="dateFinal"]')?.value || '',
                amount: document.querySelector('[name="amountFinal"]')?.value || '',
                remarks: document.querySelector('[name="remFinal"]')?.value || ''
              },
              engineering: {
                date: document.querySelector('[name="dateEng"]')?.value || '',
                amount: document.querySelector('[name="amountEng"]')?.value || '',
                remarks: document.querySelector('[name="remEng"]')?.value || ''
              },
              mqc: {
                date: document.querySelector('[name="dateMqc"]')?.value || '',
                amount: document.querySelector('[name="amountMqc"]')?.value || '',
                remarks: document.querySelector('[name="remMqc"]')?.value || ''
              },
              totalExpenditures: {
                amount: document.querySelector('[name="amountTotal"]')?.value || ''
              },
              totalSavings: {
                amount: document.querySelector('[name="amountSavings"]')?.value || ''
              }
            },
          partialBillings: []
        };

        document.querySelectorAll('.partial-billing').forEach((row, i) => {
          const dateInput = row.querySelector(`[name="partialBillings[${i + 1}][date]"]`);
          const amountInput = row.querySelector(`[name="partialBillings[${i + 1}][amount]"]`);
          const remarksInput = row.querySelector(`[name="partialBillings[${i + 1}][remarks]"]`);
        
          formData.partialBillings.push({
            date: dateInput?.value || '',
            amount: amountInput?.value || '',
            remarks: remarksInput?.value || ''
          });
        });
        
        

        fetch('/fund-utilization/store', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(formData)
        })
          .then(res => res.json())
          .then(result => {
            if (result.status === 'success') {
              Swal.fire('Success', 'Fund Utilization saved successfully!', 'success').then(() => location.reload());
            } else {
              Swal.fire('Failed', result.message || 'Failed to save fund utilization.', 'error');
            }
          })
          .catch(error => {
            console.error('Error saving fund utilization:', error);
            Swal.fire('Error', 'An error occurred while saving fund utilization.', 'error');
          });
      });

      
});

 
 
   