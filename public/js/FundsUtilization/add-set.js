   let billingCount = 1; // starts at 1st billing
    const maxBillings = 5;

    function addNewBill() {
        if (billingCount >= maxBillings) {
            alert("You can only add up to 5 Partial Billings.");
            return;
        }

        billingCount++;

        const tableBody = document.querySelector('[accesskey="billsTableBody"]').parentElement;
        const firstRow = document.querySelector('[accesskey="billsTableBody"]');
        const newRow = firstRow.cloneNode(true);

        // Update label
        const suffix = getOrdinalSuffix(billingCount);
        newRow.cells[0].textContent = `${suffix} Partial Billing`;

        // Clear and update input names
        const inputs = newRow.querySelectorAll('input');
        inputs[0].name = `datePart${billingCount}`;
        inputs[0].value = '';

        inputs[1].name = `amountPart${billingCount}`;
        inputs[1].value = '';

        inputs[2].name = `remPart${billingCount}`;
        inputs[2].value = '';

        tableBody.insertBefore(newRow, tableBody.lastElementChild); // insert before button row
    }

    function removeLastBill() {
        const tableBody = document.querySelector('[accesskey="billsTableBody"]').parentElement;
        const rows = tableBody.querySelectorAll('tr');

        if (billingCount > 1) {
            tableBody.removeChild(rows[rows.length - 2]); // last billing row
            billingCount--;
        } else {
            alert("At least one billing row must remain.");
        }
    }

    function getOrdinalSuffix(n) {
        if (n % 10 === 1 && n !== 11) return n + "st";
        if (n % 10 === 2 && n !== 12) return n + "nd";
        if (n % 10 === 3 && n !== 13) return n + "rd";
        return n + "th";
    }