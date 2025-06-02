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
              newCell.innerHTML = `
                <input type="text" class="form-control amount-input"
                       id="vo_${key}_${voCount}"
                       name="vo_${key}_${voCount}">
              `;
          
              const cells = rows[index].querySelectorAll('td');
              rows[index].insertBefore(newCell, cells[cells.length - 1]); // Before 'Actual'
          
              const newInput = newCell.querySelector('input');
          
              // Add live formatting while typing
              // Apply full formatting and setup listeners like existing inputs
                formatInput(newInput);

                newInput.addEventListener('input', function () {
                    // Just do lightweight formatting here (commas only, no peso sign or fixed decimals)
                    formatInputLive(this);
                });
                
                newInput.addEventListener('blur', function () {
                    // Full formatting with peso sign and two decimals on blur
                    formatInput(this);
                });
                

            });
          
            // After adding all rows
            updateVOButtonsState();
            initAmountInputs(); // This will re-bind listeners and format all .amount-input fields
                                                            
          }
              
        function updateVOButtonsState() {
          const addButton = document.querySelector('.btn-outline-primary[onclick="addVOFields()"]');
          if (addButton) addButton.disabled = voCount >= 5;
        }
      
        document.addEventListener('DOMContentLoaded', () => {
            initAmountInputs(); // handles initial formatting + events
            updateVOButtonsState();
          });
          
          
          

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
function formatAmount(value) {
  return '₱' + value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}


// Utility: Calculate 10% of the given value
function calculateRetention(value) {
  return parseAmount(value) * 0.10;
}

// Automatically attach retention logic to amount fields
function attachRetentionListeners() {
  // Mobilization
  const mobiAmountInput = document.getElementById('amountMobilization');
  const mobiRetentionField = document.getElementById('retentionMobiAmount');
  if (mobiAmountInput && mobiRetentionField) {
    const updateMobiRetention = () => {
      mobiRetentionField.value = formatAmount(calculateRetention(mobiAmountInput.value));
    };
    mobiAmountInput.addEventListener('input', updateMobiRetention);
    updateMobiRetention();
  }

  // Partial Billings (1 to 5)
  for (let i = 1; i <= 5; i++) {
    const amountInput = document.getElementById(`amountPartial${i}`);
    const retentionField = document.getElementById(`retentionPartialAmount${i}`);

    if (amountInput && retentionField) {
      const updateRetention = () => {
        retentionField.value = formatAmount(calculateRetention(amountInput.value));
      };
      amountInput.addEventListener('input', updateRetention);
      if (amountInput.value.trim() !== '') {
        updateRetention();
      }
    }
  }

  // Final Billing
  const finalAmountInput = document.getElementById('amountFinal');
  const finalRetentionField = document.getElementById('retentionFinalAmount');
  if (finalAmountInput && finalRetentionField) {
    const updateFinalRetention = () => {
      finalRetentionField.value = formatAmount(calculateRetention(finalAmountInput.value));
    };
    finalAmountInput.addEventListener('input', updateFinalRetention);
    updateFinalRetention();
  }
}

// Show next billing row
function addNextBilling() {
  if (currentBilling < 5) {
    currentBilling++;
    const nextRow = document.querySelector(`.billing-${currentBilling}`);
    if (nextRow) {
      nextRow.style.display = 'table-row';
    }
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
  document.getElementById('btnAddBilling').addEventListener('click', addNextBilling);
  document.getElementById('btnRemoveBilling').addEventListener('click', removeLastBilling);

  // Show only rows with amount
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
