

// Add a new billing set to the form dynamically
// This script allows the user to add or remove billing sets dynamically
    let billingCount = 1;

    function addNextBilling() {
        billingCount++;
        const container = document.getElementById('billingsContainer');

        const ordinalSuffix = (n) => {
            const s = ["th", "st", "nd", "rd"],
                v = n % 100;
            return n + (s[(v - 20) % 10] || s[v] || s[0]);
        };

        const newBillingSet = document.createElement('div');
        newBillingSet.classList.add('row', 'billing-set');
        newBillingSet.id = `billingSet${billingCount}`;
        newBillingSet.innerHTML = `
            <div class="row">
                <h6 class="m-1 fw-bold">${ordinalSuffix(billingCount)} Partial Billing</h6>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-1">
                        <label for="datePart${billingCount}" class="form-label">Date</label>
                        <input type="date" class="form-control" id="datePart${billingCount}" name="datePart${billingCount}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-1">
                        <label for="amountPart${billingCount}" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amountPart${billingCount}" name="amountPart${billingCount}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-1">
                        <label for="remPart${billingCount}" class="form-label">Remarks</label>
                        <input type="text" class="form-control" id="remPart${billingCount}" name="remPart${billingCount}">
                    </div>
                </div>
            </div>
        `;
        container.appendChild(newBillingSet);
    }

    function removeLastBilling() {
        if (billingCount > 1) {
            const lastBillingSet = document.getElementById(`billingSet${billingCount}`);
            lastBillingSet.remove();
            billingCount--;
        } else {
            Swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "You must keep at least one billing set. If none, leave it blank.",
            });
        }
    }


    /*  Order fields
        This script allows the user to add or remove order fields dynamically  */
    let orderCount = 1;

    function addOrderFields() {
        orderCount++;
        const container = document.getElementById('orderContainer');

        const newSet = document.createElement('div');
        newSet.classList.add('row', 'order-set');
        newSet.id = `orderSet${orderCount}`;
        newSet.innerHTML = `
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="suspensionOrderNo${orderCount}" class="form-label">Suspension Order No. ${orderCount}</label>
                                    <input type="date" class="form-control" id="suspensionOrderNo${orderCount}" name="suspensionOrderNo${orderCount}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-1">
                                    <label for="resumeOrderNo${orderCount}" class="form-label">Resumption Order No. ${orderCount}</label>
                                    <input type="date" class="form-control" id="resumeOrderNo${orderCount}" name="resumeOrderNo${orderCount}">
                                </div>
                            </div>
                        `;
        container.appendChild(newSet);
    }

    function removeLastOrderFields() {
        if (orderCount > 1) {
            const lastSet = document.getElementById(`orderSet${orderCount}`);
            lastSet.remove();
            orderCount--;
        } else {
            Swal.fire({
                icon: "warning",
                title: "Oops...",
                text: "You must keep at least one order pair. If none leave it blank.",
            });
        }
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