let orderCount = 1;
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