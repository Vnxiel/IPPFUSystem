const formatter = new Intl.NumberFormat('en-PH', {
  style: 'currency',
  currency: 'PHP',
  minimumFractionDigits: 2
});

function parseCurrency(value) {
  return parseFloat((value || '0').replace(/[₱,]/g, '')) || 0;
}

function formatCurrency(value) {
  return formatter.format(value);
}

function calculateTotalExpenditures() {
  const final = parseCurrency(document.querySelector('input[name="amountFinal"]')?.value);
  const eng = parseCurrency(document.querySelector('input[name="amountEng"]')?.value);
  const mqc = parseCurrency(document.querySelector('input[name="amountMqc"]')?.value);
  // const mobi = parseCurrency(document.querySelector('input[name="amountMobi"]')?.value);

  let partials = 0;
  document.querySelectorAll('input[name^="amountPart"]').forEach(input => {
    partials += parseCurrency(input.value);
  });

  const total = final + eng + mqc + partials;

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

document.addEventListener('DOMContentLoaded', () => {
  const fieldNames = ['amountFinal', 'amountEng', 'amountMqc', 'amountMobi'];

  fieldNames.forEach(name => {
    const input = document.querySelector(`input[name="${name}"]`);
    if (input) input.addEventListener('input', calculateTotalExpenditures);
  });

  document.querySelectorAll('input[name^="amountPart"]').forEach(input => {
    input.addEventListener('input', calculateTotalExpenditures);
  });

  const billingsTableBody = document.getElementById('billingsTableBody');
  const observer = new MutationObserver(() => {
    document.querySelectorAll('input[name^="amountPart"]').forEach(input => {
      input.removeEventListener('input', calculateTotalExpenditures); // safety
      input.addEventListener('input', calculateTotalExpenditures);
    });
  });
  observer.observe(billingsTableBody, { childList: true });

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
          date: document.querySelector('[name="dateMobi"]').value,
          amount: document.querySelector('[name="amountMobi"]').value,
          remarks: document.querySelector('[name="remMobi"]').value
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


function loadFundUtilization(project_id) {
  fetch(`/fund-utilization/${project_id}`)
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        const fu = data.data || {};
        const vos = data.variationOrders || [];

        document.getElementById('projectTitleFU').value = data.projectTitle ?? '';
        document.getElementById('orig_abc').value = fu.orig_abc ?? '';
        document.getElementById('orig_contract_amount').value = fu.orig_contract_amount ?? '';
        document.getElementById('orig_engineering').value = fu.orig_engineering ?? '';
        document.getElementById('orig_mqc').value = fu.orig_mqc ?? '';
        document.getElementById('orig_bid').value = fu.orig_bid ?? '';
        document.getElementById('orig_contingency').value = fu.orig_contingency ?? '';
        document.getElementById('orig_appropriation').value = fu.orig_appropriation ?? '';

        document.getElementById('actual_abc').value = fu.actual_abc ?? '';
        document.getElementById('actual_contract_amount').value = fu.actual_contract_amount ?? '';
        document.getElementById('actual_engineering').value = fu.actual_engineering ?? '';
        document.getElementById('actual_mqc').value = fu.actual_mqc ?? '';
        document.getElementById('actual_bid').value = fu.actual_bid ?? '';
        document.getElementById('actual_contingency').value = fu.actual_contingency ?? '';
        document.getElementById('actual_appropriation').value = fu.actual_appropriation ?? '';

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
        document.querySelector('[name="dateMobi"]').value = summary.mobilization?.date || '';
        document.querySelector('[name="amountMobi"]').value = summary.mobilization?.amount || '';
        document.querySelector('[name="remMobi"]').value = summary.mobilization?.remarks || '';
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
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${billingCount} Partial Billing </td>
              <td><input type="date" class="form-control amount-input" name="datePart${billingCount}" value="${billing.date ?? ''}"></td>
              <td><input type="text" class="form-control amount-input" name="amountPart${billingCount}" value="${billing.amount ?? ''}" placeholder="₱0.00"></td>
              <td><input type="text" class="form-control amount-input" name="remPart${billingCount}" value="${billing.remarks ?? ''}"></td>
            `;
            billingsBody.appendChild(row);
          });
        }
      }
    });


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

// Utility: convert "₱1,000.00" -> 1000
function parseCurrency(val) {
  return parseFloat((val || '0').replace(/[₱,]/g, '')) || 0;
}

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

// Calculate mobilization as % of contract
function calculateMobilization() {
  const percent = parseFloat(document.getElementById('percentMobi')?.value || '0');
  const contractAmount = parseCurrency(document.getElementById('orig_contract_amount')?.value || '0');
  const mobiAmount = contractAmount * (percent / 100);

  const mobiInput = document.querySelector('input[name="amountMobi"]');
  if (mobiInput) mobiInput.value = formatCurrency(mobiAmount);

  calculateTotalExpenditures(); // Recalculate after updating mobi
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


// Utility function to retrieve existing V.O. indices
function getExistingVOIndices() {
  const headers = document.querySelectorAll('.vo-header');
  return Array.from(headers).map(th => parseInt(th.dataset.voIndex));
}

// Function to determine the next available V.O. index
function getNextVOIndex() {
  const existingIndices = getExistingVOIndices();
  let index = 1;
  while (existingIndices.includes(index)) {
    index++;
  }
  return index;
}

// Function to update the state of Add/Remove buttons
function updateVOButtonsState() {
  const addButton = document.querySelector('.btn-outline-primary[onclick="addVOFields()"]');
  const removeButton = document.querySelector('.btn-outline-danger[onclick="removeSelectedVOFields()"]');
  const voCount = document.querySelectorAll('.vo-header').length;
  if (addButton) addButton.disabled = voCount >= 3;
  if (removeButton) removeButton.disabled = voCount <= 1;
}

// Function to add a new V.O. column
function addVOFields() {
  const voIndex = getNextVOIndex();
  const table = document.querySelector('.table.table-bordered');
  const headerRow = table.querySelector('thead tr');

  // Create new header
  const newHeader = document.createElement('th');
  newHeader.className = "vo-header editable-header";
  newHeader.dataset.voIndex = voIndex;
  const displayLabel = `V.O. ${voIndex}`;
  newHeader.innerHTML = `
    <input type="checkbox" class="vo-select" data-vo-index="${voIndex}">
    <span ondblclick="editHeader(this)">${displayLabel}</span>
  `;
  headerRow.insertBefore(newHeader, headerRow.children[headerRow.children.length - 1]);

  // Add corresponding cells to each row
  const rowNames = ['abc', 'contract_amount', 'engineering', 'mqc', 'contingency', 'bid', 'appropriation'];
  const rows = table.querySelectorAll('tbody tr');
  rowNames.forEach((name, index) => {
    const cell = document.createElement('td');
    cell.innerHTML = `<input type="text" class="form-control amount-input" id="vo_${name}_${voIndex}" name="vo_${name}_${voIndex}" placeholder="₱0.00">`;
    const cells = rows[index].querySelectorAll('td');
    rows[index].insertBefore(cell, cells[cells.length - 1]);
  });

  // Save updated headers to localStorage
  saveVOHeaders();

  updateVOButtonsState();
}

// Function to remove selected V.O. columns
function removeSelectedVOFields() {
  const selectedCheckboxes = document.querySelectorAll('.vo-select:checked');
  if (selectedCheckboxes.length === 0) return;

  const table = document.querySelector('.table.table-bordered');
  const headerRow = table.querySelector('thead tr');
  const rows = table.querySelectorAll('tbody tr');

  selectedCheckboxes.forEach(cb => {
    const index = Array.from(headerRow.children).findIndex(th =>
      th.classList.contains('vo-header') && th.dataset.voIndex === cb.dataset.voIndex
    );
    if (index > -1) {
      headerRow.removeChild(headerRow.children[index]);
      rows.forEach(row => row.removeChild(row.children[index]));
    }
  });

  // Save updated headers to localStorage
  saveVOHeaders();

  updateVOButtonsState();
}

// Function to edit V.O. header text
function editHeader(spanElement) {
  const currentText = spanElement.innerText;
  const input = document.createElement('input');
  input.type = 'text';
  input.value = currentText;

  input.onblur = function () {
    const newText = input.value || currentText;
    spanElement.innerText = newText;
    spanElement.style.display = 'inline';
    spanElement.parentNode.removeChild(input);

    // Save updated headers to localStorage
    saveVOHeaders();
  };

  spanElement.parentNode.insertBefore(input, spanElement);
  spanElement.style.display = 'none';
  input.focus();
}

// Function to save current V.O. headers to localStorage
function saveVOHeaders() {
  const headers = document.querySelectorAll('.vo-header');
  const headersData = Array.from(headers).map(th => ({
    voIndex: th.dataset.voIndex,
    label: th.querySelector('span').innerText
  }));
  localStorage.setItem('voHeaders', JSON.stringify(headersData));
}

// Function to restore V.O. headers from localStorage
function restoreVOHeaders() {
  const savedHeaders = JSON.parse(localStorage.getItem('voHeaders') || '[]');
  savedHeaders.forEach(header => {
    const existingIndices = getExistingVOIndices();
    if (!existingIndices.includes(parseInt(header.voIndex))) {
      const table = document.querySelector('.table.table-bordered');
      const headerRow = table.querySelector('thead tr');

      // Create new header
      const newHeader = document.createElement('th');
      newHeader.className = "vo-header editable-header";
      newHeader.dataset.voIndex = header.voIndex;
      newHeader.innerHTML = `
        <input type="checkbox" class="vo-select" data-vo-index="${header.voIndex}">
        <span ondblclick="editHeader(this)">${header.label}</span>
      `;
      headerRow.insertBefore(newHeader, headerRow.children[headerRow.children.length - 1]);

      // Add corresponding cells to each row
      const rowNames = ['abc', 'contract_amount', 'engineering', 'mqc', 'contingency', 'bid', 'appropriation'];
      const rows = table.querySelectorAll('tbody tr');
      rowNames.forEach((name, index) => {
        const cell = document.createElement('td');
        cell.innerHTML = `<input type="text" class="form-control amount-input" id="vo_${name}_${header.voIndex}" name="vo_${name}_${header.voIndex}" placeholder="₱0.00">`;
        const cells = rows[index].querySelectorAll('td');
        rows[index].insertBefore(cell, cells[cells.length - 1]);
      });
    }
  });
}

// Initialize once the DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
  restoreVOHeaders();
  updateVOButtonsState();
});
