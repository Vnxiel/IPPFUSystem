

function addOrderFields() {
    if (orderCount >= 3) {
        Swal.fire({
            icon: "info",
            title: "Limit Reached",
            text: "You can only add up to 3 order sets.",
        });
        return;
    }

    orderCount++;
    const container = document.getElementById('orderContainer');

    const newSet = document.createElement('div');
    newSet.classList.add('row', 'mt-2', 'mb-2', 'order-set');
    newSet.id = `orderSet${orderCount}`;
    newSet.innerHTML = `
        <div class="row mb-2">
            <div class="col-3 text-end">
                <label for="suspensionOrderNo${orderCount}" class="form-label">
                    Suspension Order No. ${orderCount}
                </label>
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="suspensionOrderNo${orderCount}" name="suspensionOrderNo${orderCount}">
            </div>
            <div class="col-3 text-end">
                <label for="suspensionOrderNo${orderCount}Remarks" class="form-label">
                    Remarks
                </label>
            </div>
            <div class="col-3">
                <input type="text" class="form-control" id="suspensionOrderNo${orderCount}Remarks" name="suspensionOrderNo${orderCount}Remarks">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-3 text-end">
                <label for="resumeOrderNo${orderCount}" class="form-label">
                    Resumption Order No. ${orderCount}
                </label>
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="resumeOrderNo${orderCount}" name="resumeOrderNo${orderCount}">
            </div>
            <div class="col-3 text-end">
                <label for="resumeOrderNo${orderCount}Remarks" class="form-label">
                    Remarks
                </label>
            </div>
            <div class="col-3">
                <input type="text" class="form-control" id="resumeOrderNo${orderCount}Remarks" name="resumeOrderNo${orderCount}Remarks">
            </div>
        </div>
    `;

    container.appendChild(newSet);
}



    /*  V.O. fields
        This script allows the user to add or remove V.O. fields dynamically
        V.O. stands for Variation Order*/

    let voCount = 1; // Initialize V.O. count

    function addVOFields() {
        voCount++;
        const container = document.getElementById('voContainer');

        const newSet = document.createElement('div');
        newSet.classList.add('row', 'mb-3', 'vo-set');
        newSet.id = `voSet${voCount}`;
        newSet.innerHTML = `
                            <div class="row text-center">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">V.O.${voCount}</h6>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="vo_abc${voCount}" class="form-label">ABC</label>
                                    <input type="text" class="form-control currency-input" id="vo_abc${voCount}" name="vo_abc${voCount}">
                                </div>
                                <div class="mb-1">
                                    <label for="vo_contractAmount${voCount}" class="form-label">Contract Amount</label>
                                    <input type="text" class="form-control currency-input" id="vo_contractAmount${voCount}" name="vo_contractAmount${voCount}">
                                </div>
                                <div class="mb-1">
                                    <label for="vo_engineering${voCount}" class="form-label">Engineering</label>
                                    <input type="text" class="form-control currency-input" id="vo_engineering${voCount}" name="vo_engineering${voCount}">
                                </div>
                                <div class="mb-1">
                                    <label for="vo_mqc${voCount}" class="form-label">MQC</label>
                                    <input type="text" class="form-control currency-input" id="vo_mqc${voCount}" name="vo_mqc${voCount}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="vo_contingency${voCount}" class="form-label">Contingency</label>
                                    <input type="text" class="form-control currency-input" id="vo_contingency${voCount}" name="vo_contingency${voCount}">
                                </div>
                                <div class="mb-1">
                                    <label for="vo_bid${voCount}" class="form-label">Bid Difference</label>
                                    <input type="text" class="form-control currency-input" id="vo_bid${voCount}" name="vo_bid${voCount}">
                                </div>
                                <div class="mb-1">
                                    <label for="vo_appropriation${voCount}" class="form-label">Appropriation</label>
                                    <input type="text" class="form-control currency-input" id="vo_appropriation${voCount}" name="vo_appropriation${voCount}">
                                </div>
                            </div>
                        `;
        container.appendChild(newSet);
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