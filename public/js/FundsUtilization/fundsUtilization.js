function formatNumber(num) {
  if (!num) return '';
  const parts = num.toString().split('.');
  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
  return parts.join('.');
}

function cleanNumber(val) {
  return val.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
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
          const raw = cleanNumber(this.value);
          const [intPart, decimalPart] = raw.split('.');
          let formatted = formatNumber(intPart || '');
          if (decimalPart !== undefined) {
              formatted += '.' + decimalPart.slice(0, 2);
          }
          this.value = '₱' + formatted;
      });

      input.addEventListener('blur', function () {
          formatInput(this);
      });

      input.addEventListener('focus', function () {
          this.value = cleanNumber(this.value);
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

const formatter = new Intl.NumberFormat('en-PH', {
  style: 'currency',
  currency: 'PHP',
  minimumFractionDigits: 2
});


function parseCurrency(value) {
  if (!value) return 0;
  return parseFloat(value.replace(/[₱,]/g, '').trim()) || 0;
}


function formatCurrency(value) {
  return formatter.format(value);
}

function calculateTotalExpenditures() {
  const final = parseCurrency(document.querySelector('input[name="amountFinal"]')?.value);
  const eng = parseCurrency(document.querySelector('input[name="amountEng"]')?.value);
  const mqc = parseCurrency(document.querySelector('input[name="amountMqc"]')?.value);
  const mobi = parseCurrency(document.querySelector('input[name="amountMobi"]')?.value);

  let partials = 0;
  document.querySelectorAll('input[name^="amountPart"]').forEach(input => {
    partials += parseCurrency(input.value);
  });

  const total = final + eng + mqc + mobi + partials;

  const totalField = document.querySelector('input[name="amountTotal"]');
  if (totalField) totalField.value = formatCurrency(total);

  calculateSavings(total);
}

function calculateSavings(total) {
  const appropriation = parseCurrency(document.getElementById('orig_appropriation')?.value);
  const savings = appropriation - total;

  const savingsField = document.querySelector('input[name="amountSavings"]');
  if (savingsField) savingsField.value = formatCurrency(savings);
}

function calculateMobilization() {
  const percent = parseFloat(document.getElementById("percentMobi")?.value) || 0;
  const contract = parseCurrency(document.getElementById("orig_contract_amount")?.value);
  const mobiAmount = (percent / 100) * contract;

  const mobiField = document.querySelector('input[name="amountMobi"]');
  if (mobiField) {
    mobiField.value = formatCurrency(mobiAmount);
    calculateTotalExpenditures(); // recalc after update
  }
}

function attachInputListeners() {
  const fieldNames = ['amountFinal', 'amountEng', 'amountMqc', 'amountMobi'];

  fieldNames.forEach(name => {
    const input = document.querySelector(`input[name="${name}"]`);
    if (input) input.addEventListener('input', calculateTotalExpenditures);
  });

  document.querySelectorAll('input[name^="amountPart"]').forEach(input => {
    input.addEventListener('input', calculateTotalExpenditures);
  });
}

document.addEventListener('DOMContentLoaded', () => {
  attachInputListeners();

  const billingObserver = new MutationObserver(() => {
    attachInputListeners();
  });

  billingObserver.observe(document.getElementById('billingsTableBody'), {
    childList: true,
    subtree: true
  });

  document.getElementById('orig_appropriation')?.addEventListener('input', calculateTotalExpenditures);

  document.getElementById('percentMobi')?.addEventListener('input', calculateMobilization);
  document.getElementById('orig_contract_amount')?.addEventListener('input', calculateMobilization);

  // Initial calculation on load
  calculateTotalExpenditures();
});

document.addEventListener('DOMContentLoaded', function () {
  const fundModal = document.getElementById('addProjectFundUtilization');

  fundModal.addEventListener('show.bs.modal', function () {
    const project_id = sessionStorage.getItem("project_id");
    if (project_id) {
      loadFundUtilization(project_id);
      fetchPreviousAppropriationData(project_id)
    }
  });

  let voCount = parseInt(document.getElementById('voCount').value) || 1;
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
          percent: document.getElementById('percentMobi')?.value || '',
          date: document.querySelector('[name="dateMobi"]')?.value || '',
          amount: document.querySelector('[name="amountMobi"]')?.value || '',
          remarks: document.querySelector('[name="remMobi"]')?.value || '',
          remaining: {
            date: document.querySelector('[name="dateMobi2"]')?.value || '',
            amount: document.querySelector('[name="amountMobi2"]')?.value || '',
            remarks: document.querySelector('[name="remMobi2"]')?.value || ''
          }
        },      
        final: {
          date: document.querySelector('[name="dateFinal"]').value,
          amount: document.querySelector('[name="amountFinal"]').value,
          remarks: document.querySelector('[name="remFinal"]').value
        },
        engineering: {
          date: document.querySelector('[name="dateEng"]').value,
          amount: document.querySelector('[name="amountEng"]').value,
          remarks: document.querySelector('[name="remEng"]').value
        },
        mqc: {
          date: document.querySelector('[name="dateMqc"]').value,
          amount: document.querySelector('[name="amountMqc"]').value,
          remarks: document.querySelector('[name="remMqc"]').value
        },
        totalExpenditures: {
          amount: document.querySelector('[name="amountTotal"]').value,
          remarks: document.querySelector('[name="remTotal"]').value
        },
        totalSavings: {
          amount: document.querySelector('[name="amountSavings"]').value,
          remarks: document.querySelector('[name="remSavings"]').value
        }
      },
      partialBillings: []
    };

    document.querySelectorAll('#billingsTableBody tr').forEach((row, i) => {
      formData.partialBillings.push({
        date: row.querySelector(`[name="datePart${i + 1}"]`)?.value || '',
        amount: row.querySelector(`[name="amountPart${i + 1}"]`)?.value || '',
        remarks: row.querySelector(`[name="remPart${i + 1}"]`)?.value || ''
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

// Add this global so it works outside the event listener
function addVOFields() {
  if (voCount >= 3) return; // Limit to 3 VOs

  voCount++;
  document.getElementById('voCount').value = voCount;

  const table = document.querySelector('.table.table-bordered');
  const headerRow = table.querySelector('thead tr');
  const newHeader = document.createElement('th');
  newHeader.textContent = `V.O. ${voCount}`;
  headerRow.insertBefore(newHeader, headerRow.children[headerRow.children.length - 1]);

  const rowNames = [
    'abc', 'contract_amount', 'engineering',
    'mqc', 'contingency', 'bid', 'appropriation'
  ];

  const rows = table.querySelectorAll('tbody tr');

  rowNames.forEach((name, index) => {
    const cell = document.createElement('td');
    cell.innerHTML = `<input type="text" class="form-control amount-input" id="vo_${name}_${voCount}" name="vo_${name}_${voCount}" >`;
    const cells = rows[index].querySelectorAll('td');
    rows[index].insertBefore(cell, cells[cells.length - 1]);
  });

  updateVOButtonsState();
}

function removeLastVOFields() {
  if (voCount > 1) {
    const table = document.querySelector('.table.table-bordered');
    const headerRow = table.querySelector('thead tr');
    headerRow.removeChild(headerRow.children[headerRow.children.length - 2]);

    const rows = table.querySelectorAll('tbody tr');
    for (let i = 0; i < 7; i++) {
      const cells = rows[i].querySelectorAll('td');
      rows[i].removeChild(cells[cells.length - 2]);
    }

    voCount--;
    document.getElementById('voCount').value = voCount;
  }

  updateVOButtonsState();
}

function updateVOButtonsState() {
  const addButton = document.querySelector('.btn-outline-primary[onclick="addVOFields()"]');
  const removeButton = document.querySelector('.btn-outline-danger[onclick="removeLastVOFields()"]');

  if (addButton) addButton.disabled = voCount >= 3;
  if (removeButton) removeButton.disabled = voCount <= 1;
}

// Call updateVOButtonsState initially to set the correct state
document.addEventListener('DOMContentLoaded', updateVOButtonsState);

function fetchPreviousAppropriationData(project_id) {
  if (!project_id) return;

  fetch(`/fund-utilization/${project_id}`)
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        const previousData = data.previousData || [];

        const origList = document.getElementById('orig_appropriation_list');
        const voList = document.getElementById('vo_appropriation_list');
        const actualList = document.getElementById('actual_appropriation_list');

        origList.innerHTML = '';
        voList.innerHTML = '';
        actualList.innerHTML = '';

        const formatter = new Intl.NumberFormat('en-PH', {
          style: 'currency',
          currency: 'PHP',
          minimumFractionDigits: 2
        });

        // Use Set to ensure unique values
        const origValues = new Set();
        const voValues = new Set();
        const actualValues = new Set();

        previousData.forEach(entry => {
          if (entry.orig_appropriation && !origValues.has(entry.orig_appropriation)) {
            origValues.add(entry.orig_appropriation);
            origList.innerHTML += `<option value="${formatter.format(entry.orig_appropriation)}">`;
          }
          if (entry.vo_appropriation && !voValues.has(entry.vo_appropriation)) {
            voValues.add(entry.vo_appropriation);
            voList.innerHTML += `<option value="${formatter.format(entry.vo_appropriation)}">`;
          }
          if (entry.actual_appropriation && !actualValues.has(entry.actual_appropriation)) {
            actualValues.add(entry.actual_appropriation);
            actualList.innerHTML += `<option value="${formatter.format(entry.actual_appropriation)}">`;
          }
        });
      }
    })
    .catch(err => console.error('Failed to fetch previous appropriations:', err));
}
 
function loadFundUtilization(project_id) {
  fetch(`/fund-utilization/${project_id}`)
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        const fu = data.data || {};
        const vos = data.variationOrders || [];

        document.getElementById('projectTitleFU').value = data.projectTitle ?? '';
        document.getElementById('orig_abc').value = formatCurrency(fu.orig_abc);
        document.getElementById('orig_contract_amount').value = formatCurrency(fu.orig_contract_amount);
        document.getElementById('orig_engineering').value = formatCurrency(fu.orig_engineering);
        document.getElementById('orig_mqc').value = formatCurrency(fu.orig_mqc);
        document.getElementById('orig_bid').value = formatCurrency(fu.orig_bid);
        document.getElementById('orig_contingency').value = formatCurrency(fu.orig_contingency);
        document.getElementById('orig_appropriation').value = formatCurrency(fu.orig_appropriation);

        document.getElementById('actual_abc').value = formatCurrency(fu.actual_abc);
        document.getElementById('actual_contract_amount').value = formatCurrency(fu.actual_contract_amount);
        document.getElementById('actual_engineering').value = formatCurrency(fu.actual_engineering);
        document.getElementById('actual_mqc').value = formatCurrency(fu.actual_mqc);
        document.getElementById('actual_bid').value = formatCurrency(fu.actual_bid);
        document.getElementById('actual_contingency').value = formatCurrency(fu.actual_contingency);
        document.getElementById('actual_appropriation').value = formatCurrency(fu.actual_appropriation);

        let maxVO = 1;
        vos.forEach(vo => {
          maxVO = Math.max(maxVO, vo.vo_number);
        });

        for (let i = voCount + 1; i <= maxVO; i++) {
          addVOFields();
        }

        voCount = maxVO;
        document.getElementById('voCount').value = voCount;

        vos.forEach(vo => {
          document.getElementById(`vo_abc_${vo.vo_number}`).value = vo.vo_abc ?? '';
          document.getElementById(`vo_contract_amount_${vo.vo_number}`).value = vo.vo_contract_amount ?? '';
          document.getElementById(`vo_engineering_${vo.vo_number}`).value = vo.vo_engineering ?? '';
          document.getElementById(`vo_mqc_${vo.vo_number}`).value = vo.vo_mqc ?? '';
          document.getElementById(`vo_bid_${vo.vo_number}`).value = vo.vo_bid ?? '';
          document.getElementById(`vo_contingency_${vo.vo_number}`).value = vo.vo_contingency ?? '';
          document.getElementById(`vo_appropriation_${vo.vo_number}`).value = vo.vo_appropriation ?? '';
        });

        const summary = fu.summary || {};
        
        const mobi = summary.mobilization || {};
        const mobiPercent = mobi.percent || '';
        document.getElementById('percentMobi').value = mobiPercent;
        renderMobilizationRows(mobiPercent, mobi);  // ✅ This ensures inputs exist
        
        // ✅ Now safe to set values because inputs have been rendered
        
        document.getElementById('percentMobi').dispatchEvent(new Event('input'));          
        document.querySelector('[name="dateFinal"]').value = summary.final?.date || '';
        document.querySelector('[name="amountFinal"]').value = summary.final?.amount || '';
        document.querySelector('[name="remFinal"]').value = summary.final?.remarks || '';
        document.querySelector('[name="dateEng"]').value = summary.engineering?.date || '';
        document.querySelector('[name="amountEng"]').value = summary.engineering?.amount || '';
        document.querySelector('[name="remEng"]').value = summary.engineering?.remarks || '';
        document.querySelector('[name="dateMqc"]').value = summary.mqc?.date || '';
        document.querySelector('[name="amountMqc"]').value = summary.mqc?.amount || '';
        document.querySelector('[name="remMqc"]').value = summary.mqc?.remarks || '';
        document.querySelector('[name="amountTotal"]').value = summary.totalExpenditures?.amount || '';
        document.querySelector('[name="remTotal"]').value = summary.totalExpenditures?.remarks || '';
        document.querySelector('[name="amountSavings"]').value = summary.totalSavings?.amount || '';
        document.querySelector('[name="remSavings"]').value = summary.totalSavings?.remarks || '';
          
        const billings = fu.partial_billings || [];

        const billingsBody = document.getElementById('billingsTableBody');
        if (billings.length > 0) {
          billingsBody.innerHTML = '';
          billingCount = 0;
          billings.forEach((billing) => {
            billingCount++;
            const formattedAmount = formatCurrency(parseCurrency(billing.amount ?? '0'));
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${billingCount}st Partial Billing </td>
              <td><input type="date" class="form-control amount-input" name="datePart${billingCount}" value="${billing.date ?? ''}"></td>
              <td><input type="text" class="form-control amount-input" name="amountPart${billingCount}" value="${formattedAmount}" ></td>
              <td><input type="text" class="form-control amount-input" name="remPart${billingCount}" value="${billing.remarks ?? ''}"></td>
            `;
            billingsBody.appendChild(row);
          });
        }
        
      }
    });
    
    const percentInput = document.getElementById('percentMobi');
    const mobiTableBody = document.getElementById('mobilizationRows');
    const maxPercent = 15;
    const contractAmount = 1000000; // Example contract amount (set this to the actual contract amount)
    
    percentInput.setAttribute('max', maxPercent);
    
    function renderMobilizationRows(percentValue, existing = {}) {
      let percent = parseFloat(percentValue) || maxPercent;
    
      if (percent > maxPercent) {
        percent = maxPercent;
      }
    
      mobiTableBody.innerHTML = '';
    
      const firstPercent = Math.min(percent, maxPercent);
      const remainingPercent = Math.max(0, maxPercent - firstPercent);
    
      // Calculate the mobilization amounts
      const mobilizationAmount = (firstPercent / 100) * contractAmount;
      const remainingMobilizationAmount = (remainingPercent / 100) * contractAmount;
    
      // First mobilization row
      const row1 = document.createElement('tr');
      row1.innerHTML = `
        <td>${firstPercent}% Mobilization</td>
        <td><input type="date" class="form-control" name="dateMobi" value="${existing.date || ''}"></td>
        <td><input type="text" class="form-control amount-input" name="amountMobi" value="${mobilizationAmount || ''}" ></td>
        <td><input type="text" class="form-control" name="remMobi" value="${existing.remarks || ''}"></td>
      `;
      mobiTableBody.appendChild(row1);
    
      // Remaining mobilization row
      if (remainingPercent > 0) {
        const rem = existing.remaining || {};
        const row2 = document.createElement('tr');
        row2.innerHTML = `
          <td>${remainingPercent}% Remaining Mobilization</td>
          <td><input type="date" class="form-control" name="dateMobi2" value="${rem.date || ''}"></td>
          <td><input type="text" class="form-control amount-input" name="amountMobi2" value="${remainingMobilizationAmount || ''}" ></td>
          <td><input type="text" class="form-control" name="remMobi2" value="${rem.remarks || ''}"></td>
        `;
        mobiTableBody.appendChild(row2);
      }
    }
    
    // Re-render on percent input change
    percentInput.addEventListener('input', function () {
      if (this.value > maxPercent) {
        this.value = maxPercent;
      }
      renderMobilizationRows(this.value);
    });
    
    // Initial render with blank values
    renderMobilizationRows(percentInput.value);
    
    
  //input event for mobilization amount. as per client ask to add to put input text box for mobilization
  document.getElementById('percentMobi').addEventListener('input', function () {
    const percent = parseFloat(this.value) || 0;

    const contractInput = document.getElementById('orig_contract_amount');
    const rawContract = (contractInput.value || '0').replace(/[₱,]/g, '');
    const contractAmount = parseFloat(rawContract) || 0;

    const result = contractAmount * (percent / 100);

    // Format result as ₱ currency
    const formatted = `₱${result.toLocaleString('en-PH', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2
    })}`;

    document.querySelector('[name="amountMobi"]').value = formatted;
  });


 // Formatter for PHP currency
const formatter = new Intl.NumberFormat('en-PH', {
  style: 'currency',
  currency: 'PHP',
  minimumFractionDigits: 2,
});

// Utility: convert number -> "₱1,000.00"
function formatCurrency(val) {
  return formatter.format(val);
}

// Get sum of all partial billing fields
function getPartialBillingTotal() {
  let total = 0;
  const partials = document.querySelectorAll('input[name^="amountPart"]');
  partials.forEach(input => {
    total += parseCurrency(input.value);
  });
  return total;
}

// Compute total expenditures and inject into DOM
function calculateTotalExpenditures() {
  const final = parseCurrency(document.querySelector('input[name="amountFinal"]')?.value || '0');
  const eng = parseCurrency(document.querySelector('input[name="amountEng"]')?.value || '0');
  const mqc = parseCurrency(document.querySelector('input[name="amountMqc"]')?.value || '0');
  const mobi = parseCurrency(document.querySelector('input[name="amountMobi"]')?.value || '0');
  const partialTotal = getPartialBillingTotal();

  const total = final + eng + mqc + mobi + partialTotal;

  const totalInput = document.querySelector('input[name="amountTotal"]');
  if (totalInput) {
    totalInput.value = formatCurrency(total);
    totalInput.dispatchEvent(new Event('input')); // Trigger input event for savings calculation
  }

  calculateSavings(total); // pass total expenditures
}

// Compute savings = appropriation - expenditures
function calculateSavings(totalExpenditures) {
  const appropriation = parseCurrency(document.getElementById("orig_appropriation")?.value || '0');
  const savings = appropriation - totalExpenditures;

  const savingsInput = document.querySelector('input[name="amountSavings"]');
  if (savingsInput) savingsInput.value = formatCurrency(savings);
}

// Setup all event listeners after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  const fieldNames = ['amountFinal', 'amountEng', 'amountMqc', 'amountMobi'];

  // Attach input listeners to main fields
  fieldNames.forEach(name => {
    const input = document.querySelector(`input[name="${name}"]`);
    if (input) {
      input.addEventListener('input', calculateTotalExpenditures);
    }
  });

  // Attach to existing partial billing inputs
  document.querySelectorAll('input[name^="amountPart"]').forEach(input => {
    input.addEventListener('input', calculateTotalExpenditures);
  });

  // Recalculate when dynamic rows are added
  const billingsTableBody = document.getElementById('billingsTableBody');
  const observer = new MutationObserver(() => {
    document.querySelectorAll('input[name^="amountPart"]').forEach(input => {
      input.removeEventListener('input', calculateTotalExpenditures); // optional safety
      input.addEventListener('input', calculateTotalExpenditures);
    });
  });
  observer.observe(billingsTableBody, { childList: true });

  // Orig appropriation change
  const appropriationInput = document.getElementById('orig_appropriation');
  if (appropriationInput) {
    appropriationInput.addEventListener('input', calculateTotalExpenditures);
  }

  // Mobilization fields
  const percentMobi = document.getElementById('percentMobi');
  const origContract = document.getElementById('orig_contract_amount');

  percentMobi?.addEventListener('input', calculateMobilization);
  origContract?.addEventListener('input', calculateMobilization);
});


}