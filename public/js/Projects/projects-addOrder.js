
orderCount = document.querySelectorAll('#orderContainer fieldset').length || 1;

function orderSuspensionChangeHandler(i) {
    return function() {
        validateSuspensionDate(i);
        calculateRevisedCompletionDate();
    };
}

function attachOrderListeners() {
    
    orderCount = document.querySelectorAll('#orderContainer fieldset').length || 1;

    for (let i = 1; i <= orderCount; i++) {
        const susp = document.getElementById(`suspensionOrderNo${i}`);
        const resume = document.getElementById(`resumeOrderNo${i}`);

        if (susp) {
            // Remove previous listener if attached - needs the same function ref so we'll skip removal here
            susp.onchange = orderSuspensionChangeHandler(i); // replace listener directly
        }
        if (resume) {
            resume.onchange = calculateRevisedCompletionDate; // replace listener directly
        }
    }
}

function addOrderFields() {
    if (orderCount >= 5) {
        Swal.fire({
            icon: "info",
            title: "Limit Reached",
            text: "You can only add up to 5 suspension/resumption orders.",
        });
        return;
    }

    orderCount++;
    const container = document.getElementById('orderContainer');

    const suspensionKey = `suspensionOrderNo${orderCount}`;
    const resumeKey = `resumeOrderNo${orderCount}`;

    const fieldset = document.createElement('fieldset');
    fieldset.className = 'border p-2 mb-3 order-set';
    fieldset.id = `orderFieldset${orderCount}`;

    fieldset.innerHTML = `
        <div class="row mb-2">
            <div class="col-3">
                <label for="${suspensionKey}" class="form-label">Suspension Order No.${orderCount}</label>
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="${suspensionKey}" name="${suspensionKey}">
            </div>
            <div class="col-3">
                <label for="${resumeKey}" class="form-label">Resumption Order No.${orderCount}</label>
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="${resumeKey}" name="${resumeKey}">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-3">
                <label for="${suspensionKey}Remarks" class="form-label">Reason for Suspension</label>
            </div>
            <div class="col-9">
                <textarea class="form-control" id="${suspensionKey}Remarks" name="${suspensionKey}Remarks" rows="2"></textarea>
            </div>
        </div>
    `;

    container.appendChild(fieldset);

    // Attach listeners to the new inputs immediately
    attachOrderListeners();
}

function removeLastOrderFields() {
    if (orderCount > 1) {
        const lastFieldset = document.getElementById(`orderFieldset${orderCount}`);
        if (lastFieldset) lastFieldset.remove();
        orderCount--;
    } else {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "You must keep at least one order pair. If none, leave it blank.",
        });
    }
    // Reattach listeners just in case
    attachOrderListeners();
}

// Attach listeners on initial page load
document.addEventListener('DOMContentLoaded', attachOrderListeners);
