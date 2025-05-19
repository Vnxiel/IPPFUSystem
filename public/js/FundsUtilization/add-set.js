
function addOrderFields() {
    orderCount++;
    const container = document.getElementById('orderContainer');

    const suspensionKey = `suspensionOrderNo${orderCount}`;
    const resumeKey = `resumeOrderNo${orderCount}`;

    const newSet = document.createElement('div');
    newSet.classList.add('row', 'mb-2', 'order-set');
    newSet.id = `orderSet${orderCount}`;
    newSet.innerHTML = `
        <div class="row">
            <div class="col-3 text-end">
                <label for="${suspensionKey}" class="form-label">Suspension Order No. ${orderCount}
                <span class="text-danger">*</span></label>
            </div>   
            <div class="col-md-3 mb-2">
               <input type="date" class="form-control" id="${suspensionKey}" name="${suspensionKey}">
            </div>
            <div class="col-3 text-end">
                <label for="${resumeKey}" class="form-label">Resume Order No. ${orderCount}
                <span class="text-danger">*</span></label>
            </div>   
            <div class="col-md-3 mb-2">
                <input type="date" class="form-control" id="${resumeKey}" name="${resumeKey}">
            </div>
           
        </div>
        <div class="row mt-1 mb-2">
            <div class="col-md-3 mb-3 text-end">
                <label for="${suspensionKey}Remarks" class="form-label">Suspension
                    Remarks</label>
            </div>
            <div class="col-9">
                <textarea class="form-control" id="${suspensionKey}Remarks"
                name="${suspensionKey}Remarks" rows="2"></textarea>
            </div>
        </div>
    `;
    container.appendChild(newSet);
}


function removeLastOrderFields() {
    if (orderCount > 1) {
        const lastSet = document.getElementById(`orderSet${orderCount}`);
        if (lastSet) lastSet.remove();
        orderCount--;
    } else {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "You must keep at least one order pair. If none, leave it blank.",
        });
    }
}

    /*  V.O. fields
        This script allows the user to add or remove V.O. fields dynamically
        V.O. stands for Variation Order*/
        
        function addVOFields() {
            if (voCount >= 3) return; // Max limit
          
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
          if (addButton) addButton.disabled = voCount >= 3;
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
  
    // Hide last billing row if needed
    function removeLastBilling() {
      if (currentBilling > 1) {
        const rowToHide = document.querySelector(`.billing-${currentBilling}`);
        if (rowToHide) {
          rowToHide.style.display = 'none';
          // Optional: clear the inputs
          rowToHide.querySelectorAll('input').forEach(input => input.value = '');
        }
        currentBilling--;
      }
    }
  
    // On page load, auto-show rows that have any value
    document.addEventListener('DOMContentLoaded', () => {

        document.getElementById('btnAddBilling').addEventListener('click', addNextBilling);
        document.getElementById('btnRemoveBilling').addEventListener('click', removeLastBilling);
      for (let i = 2; i <= 5; i++) {
        const row = document.querySelector(`.billing-${i}`);
        const hasValue = Array.from(row.querySelectorAll('input')).some(input => input.value.trim() !== '');
  
        if (hasValue) {
          row.style.display = 'table-row';
          currentBilling = i; // Update currentBilling to the highest visible row
        } else {
          row.style.display = 'none'; // Ensure it's hidden if empty
        }
      }
    });
  
   