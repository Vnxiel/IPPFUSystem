// ========= Bid Difference ========= //
function updateBidDifference() {
    const abc = parseCurrency(document.getElementById('abc')?.value);
    const contract = parseCurrency(document.getElementById('contractAmount')?.value);
    const bidInput = document.getElementById('bid');

    if (!isNaN(abc) && !isNaN(contract) && bidInput) {
        const difference = abc - contract;

        // Ensure bid difference is not negative
        bidInput.value = difference >= 0 ? formatToPeso(difference) : '₱ 0.00';
    } else if (bidInput) {
        bidInput.value = '';
    }
}
