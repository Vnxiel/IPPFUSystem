    const fundInput = document.getElementById('sourceOfFunds');
    const fundDropdown = document.getElementById('sourceOfFundsDropdown');
    const fundItems = fundDropdown.getElementsByTagName('button');
    let fundSelectedIndex = -1;

    function showFundDropdown() {
        const filter = fundInput.value.toLowerCase().trim();
        let anyVisible = false;

        for (let i = 0; i < fundItems.length; i++) {
            const text = fundItems[i].textContent.toLowerCase().trim();
            const match = text.startsWith(filter);
            fundItems[i].style.display = match ? '' : 'none';
            if (match) anyVisible = true;
        }

        fundDropdown.style.display = (filter.length > 0 && anyVisible) ? 'block' : 'none';
        fundSelectedIndex = -1;
    }

    function selectFund(name) {
        fundInput.value = name.trim();
        fundDropdown.style.display = 'none';
    }

    fundInput.addEventListener('keydown', function (e) {
        const visibleItems = Array.from(fundItems).filter(item => item.style.display !== 'none');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (fundSelectedIndex < visibleItems.length - 1) fundSelectedIndex++;
            updateFundActive(visibleItems);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (fundSelectedIndex > 0) fundSelectedIndex--;
            updateFundActive(visibleItems);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (visibleItems[fundSelectedIndex]) {
                selectFund(visibleItems[fundSelectedIndex].textContent);
            }
        } else if (e.key === 'Escape') {
            fundDropdown.style.display = 'none';
        }
    });

    function updateFundActive(visibleItems) {
        visibleItems.forEach((item, i) => {
            item.classList.toggle('active', i === fundSelectedIndex);
        });
    }

    document.addEventListener('click', function (e) {
        if (!fundInput.contains(e.target) && !fundDropdown.contains(e.target)) {
            fundDropdown.style.display = 'none';
        }
    });