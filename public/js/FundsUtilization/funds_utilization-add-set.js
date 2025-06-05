    /*  V.O. fields
        This script allows the user to add or remove V.O. fields dynamically
        V.O. stands for Variation Order*/
        let voCount = parseInt(document.getElementById('voCount').value) || 1;
      
        function addVOFields() {
          if (voCount >= 5) return; // Max limit
      
          voCount++;
          document.getElementById('voCount').value = voCount;
      
          const table = document.getElementById('editableFundTable');
          const headerRow = table.querySelector('thead tr');
      
          // Add new V.O. header before 'Actual'
          const newHeader = document.createElement('th');
          newHeader.textContent = `V.O. ${voCount}`;
          headerRow.insertBefore(newHeader, headerRow.lastElementChild);
      
          const rowKeys = [
              'appropriation', 'abc', 'contract_amount', 'bid',
              'engineering', 'mqc', 'contingency'
          ];
      
          const rows = table.querySelectorAll('tbody tr:not(.fw-bold)');
      
          rowKeys.forEach((key, index) => {
              const newCell = document.createElement('td');
              const isContractAmount = key === 'contract_amount';
      
              newCell.innerHTML = `
                  <input type="text" class="form-control amount-input text-end"
                         id="vo_${key}_${voCount}"
                         name="vo_${key}_${voCount}"
                         ${isContractAmount ? '' : 'disabled'}>
              `;
      
              const cells = rows[index].querySelectorAll('td');
              rows[index].insertBefore(newCell, cells[cells.length - 1]);
      
              const newInput = newCell.querySelector('input');
      
              if (isContractAmount) {
                  formatInput(newInput);
      
                  newInput.addEventListener('input', function () {
                      formatInputLive(this);
                  });
      
                  newInput.addEventListener('blur', function () {
                      formatInput(this);
                  });
              }
          });
      
          // Add new blank <td> to "Total" row before the Actual Total column
          const totalRow = table.querySelector('tbody tr.fw-bold.table-warning');
          const totalCells = totalRow.querySelectorAll('td');
          const newTotalCell = document.createElement('td');
          totalRow.insertBefore(newTotalCell, totalCells[totalCells.length - 1]);
      
          updateVOButtonsState();
          initAmountInputs();
      }
      
          

    function removeLastVOFields() {
        if (voCount > 1) {
            const lastSet = document.getElementById(`voSet${voCount}`);
            lastSet.remove();
            voCount--;
        } else {
            Swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "You must keep at least one V.O. set. If none, leave it blank.",
            });
        }
    }


let currentBilling = 1;

// Utility: Parse amount string with ₱ and commas
function parseAmount(value) {
  return parseFloat(value.replace(/[₱,]/g, '')) || 0;
}

// Utility: Format as currency
// Utility: Parse amount string with ₱ and commas
function parseAmount(value) {
  return parseFloat(value.replace(/[₱,%\s,]/g, '')) || 0;
}

// Utility: Format as currency
function formatAmount(value) {
  return '₱' + value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Utility: Calculate retention from amount and percent
function calculateRetention(value, percent) {
  return parseAmount(value) * (parseFloat(percent) / 100);
}

// Update mobilization retention and total
function updateMobilizationCalculation() {
  const mobiAmountInput = document.getElementById('amountMobilization');
  const mobiPercentInput = document.getElementById('retentionMobiPercent');
  const mobiRetentionField = document.getElementById('retentionMobiAmount');
  const mobiTotalField = document.getElementById('mobilizationTotal');

  const amount = parseAmount(mobiAmountInput?.value || '0');
  const percent = parseAmount(mobiPercentInput?.value || '10'); // fallback to 10%

  const retention = amount * (percent / 100);
  const total = amount - retention;

  if (mobiRetentionField) mobiRetentionField.value = formatAmount(retention);
  if (mobiTotalField) mobiTotalField.value = formatAmount(total);
}

function attachRetentionListeners() {
  const mobiAmountInput = document.getElementById('amountMobilization');
  const mobiPercentInput = document.getElementById('retentionMobiPercent');
  const mobiRetentionField = document.getElementById('retentionMobiAmount');
  const mobiTotalField = document.getElementById('mobilizationTotal');

  const finalAmountInput = document.getElementById('amountFinal');
  const finalRetentionField = document.getElementById('retentionFinalAmount');
  const finalTotalField = document.getElementById('finalAmountTotal');

  // Define final billing update once
  function updateFinalBilling() {
    const amount = parseAmount(finalAmountInput.value);
    const retention = calculateRetention(finalAmountInput.value, 10);
    const total = amount - retention;

    finalRetentionField.value = formatAmount(retention);
    finalTotalField.value = formatAmount(total);
  }

  // Mobilization update + trigger final update
  if (mobiAmountInput && mobiPercentInput && mobiRetentionField && mobiTotalField) {
    function updateMobilizationCalculation() {
      const amount = parseAmount(mobiAmountInput.value);
      const percent = parseAmount(mobiPercentInput.value) || 10;
      const retention = amount * (percent / 100);
      const total = amount - retention;

      mobiRetentionField.value = formatAmount(retention);
      mobiTotalField.value = formatAmount(total);

      // Trigger final billing update as well
      updateFinalBilling();
    }

    mobiAmountInput.addEventListener('input', updateMobilizationCalculation);
    mobiPercentInput.addEventListener('input', updateMobilizationCalculation);
    updateMobilizationCalculation();

    window.setMobilizationAmount = (newValue) => {
      mobiAmountInput.value = newValue;
      updateMobilizationCalculation();
    };
    window.setMobilizationPercent = (newPercent) => {
      mobiPercentInput.value = newPercent;
      updateMobilizationCalculation();
    };
  }

  // Partial Billings update + trigger final update
  for (let i = 1; i <= 5; i++) {
    const amountInput = document.getElementById(`amountPartial${i}`);
    const retentionField = document.getElementById(`retentionPartialAmount${i}`);
    const totalField = document.getElementById(`totalPartial${i}`);

    if (amountInput && retentionField && totalField) {
      function updatePartialBilling() {
        const amount = parseAmount(amountInput.value);
        const retention = calculateRetention(amountInput.value, 10);
        const total = amount - retention;

        retentionField.value = formatAmount(retention);
        totalField.value = formatAmount(total);

        // Trigger final billing update as well
        updateFinalBilling();
      }

      amountInput.addEventListener('input', updatePartialBilling);
      if (amountInput.value.trim() !== '') updatePartialBilling();

      window[`setPartialAmount${i}`] = (newValue) => {
        amountInput.value = newValue;
        updatePartialBilling();
      };
    }
  }

  // Final billing inputs only update their own fields
  if (finalAmountInput && finalRetentionField && finalTotalField) {
    finalAmountInput.addEventListener('input', updateFinalBilling);
    if (finalAmountInput.value.trim() !== '') updateFinalBilling();

    window.setFinalAmount = (newValue) => {
      finalAmountInput.value = newValue;
      updateFinalBilling();
    };
  }
}

// Show next billing row
function addNextBilling() {
  if (currentBilling < 5) {
    currentBilling++;
    const nextRow = document.querySelector(`.billing-${currentBilling}`);
    if (nextRow) nextRow.style.display = 'table-row';
  }
}

// Hide last billing row
function removeLastBilling() {
  if (currentBilling > 1) {
    const rowToHide = document.querySelector(`.billing-${currentBilling}`);
    if (rowToHide) {
      rowToHide.style.display = 'none';
      rowToHide.querySelectorAll('input').forEach(input => input.value = '');
    }
    currentBilling--;
  }
}

// On DOM ready
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('btnAddBilling')?.addEventListener('click', addNextBilling);
  document.getElementById('btnRemoveBilling')?.addEventListener('click', removeLastBilling);

  // Show only billing rows with values
  for (let i = 2; i <= 5; i++) {
    const amountInput = document.getElementById(`amountPartial${i}`);
    const row = document.querySelector(`.billing-${i}`);
    if (amountInput && amountInput.value.trim() !== '') {
      row.style.display = 'table-row';
      currentBilling = i;
    } else {
      row.style.display = 'none';
    }
  }

  attachRetentionListeners();
});


