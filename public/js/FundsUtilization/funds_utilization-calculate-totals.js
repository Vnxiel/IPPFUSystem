document.addEventListener('DOMContentLoaded', () => {
    const categories = ['appropriation', 'abc', 'contract_amount', 'bid', 'engineering', 'mqc', 'contingency'];
    const voCount = parseInt(document.getElementById('voCount')?.value || 1);

    const parseAmount = (val) => {
        if (!val) return 0;
        return parseFloat(val.toString().replace(/,/g, '').trim()) || 0;
    };

    const calculateOriginalTotal = () => {
        let total = 0;
        document.querySelectorAll('.orig-cell').forEach(cell => {
            total += parseAmount(cell.dataset.value);

        });

        const origTotal = document.getElementById('orig_total');
        if (origTotal) {
            origTotal.textContent = total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });


        }
    };

    const calculateActuals = () => {
        categories.forEach((key) => {
            let total = 0;
            for (let i = 1; i <= voCount; i++) {
                const input = document.getElementById(`vo_${key}_${i}`);
                if (input) {
                    total += parseAmount(input.value);
                }
            }

            const actualInput = document.getElementById(`actual_${key}`);
            if (actualInput) {
                actualInput.value = total.toFixed(2);
            }
        });
    };

    const updateAll = () => {
        calculateActuals();
        calculateOriginalTotal();
    };

    // Attach input event listeners
    document.querySelectorAll('.amount-input').forEach(input => {
        input.addEventListener('input', updateAll);
    });

    // Trigger once on load
    updateAll();
});
