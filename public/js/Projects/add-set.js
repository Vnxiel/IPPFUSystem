
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
        
        let voCount = parseInt(document.getElementById('voCount').value) || 1;
      
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
      
          // Row IDs by order in tbody (appropriation, abc, contract_amount, etc.)
          const rowKeys = [
            'appropriation', 'abc', 'contract_amount', 'bid',
            'engineering', 'mqc', 'contingency'
          ];
      
          // Match these rows by index
          const rows = table.querySelectorAll('tbody tr:not(.fw-bold)'); // exclude total row
      
          rowKeys.forEach((key, index) => {
            const newCell = document.createElement('td');
            newCell.innerHTML = `
              <input type="text" class="form-control amount-input"
                     id="vo_${key}_${voCount}"
                     name="vo_${key}_${voCount}">
            `;
      
            const cells = rows[index].querySelectorAll('td');
            rows[index].insertBefore(newCell, cells[cells.length - 1]); // Before 'Actual'
          });
      
          // Optionally disable button if max reached
          updateVOButtonsState();
        }
      
        function updateVOButtonsState() {
          const addButton = document.querySelector('.btn-outline-primary[onclick="addVOFields()"]');
          if (addButton) addButton.disabled = voCount >= 3;
        }
      
        document.addEventListener('DOMContentLoaded', updateVOButtonsState);
      

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