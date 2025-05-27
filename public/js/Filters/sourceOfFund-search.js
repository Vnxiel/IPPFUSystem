const fundInput = document.getElementById('sourceOfFunds');
const fundDropdown = document.getElementById('sourceOfFundsDropdown');
const fundItems = fundDropdown.getElementsByTagName('button');
let fundSelectedIndex = -1;

// Filter dropdown based on input value
function filterFunds() {
    const filter = fundInput.value.toLowerCase().trim();
    let anyVisible = false;

    for (let i = 0; i < fundItems.length; i++) {
        const text = fundItems[i].textContent.toLowerCase().trim();
        const match = text.includes(filter);
        fundItems[i].style.display = match ? '' : 'none';
        if (match) anyVisible = true;
    }

    fundDropdown.style.display = (filter.length > 0 && anyVisible) ? 'block' : 'none';
    fundSelectedIndex = -1;
}

// Select a fund and hide dropdown
function selectFund(name) {
    fundInput.value = name.trim();
    hideFundsDropdown();
}

// Show dropdown and reset index
function showFundsDropdown() {
    fundDropdown.style.display = 'block';
    fundSelectedIndex = -1;
}

// Hide dropdown
function hideFundsDropdown() {
    fundDropdown.style.display = 'none';
}

// Hide dropdown with slight delay to allow button click
function hideFundsDropdownDelayed() {
    setTimeout(hideFundsDropdown, 150);
}

// Highlight the currently selected item
function updateFundActive(visibleItems) {
    visibleItems.forEach((item, i) => {
        item.classList.toggle('active', i === fundSelectedIndex);
        if (i === fundSelectedIndex) {
            item.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }
    });
}

// --- Event Listeners ---

// Filter when typing
fundInput.addEventListener('input', filterFunds);

// Show dropdown on focus
fundInput.addEventListener('focus', showFundsDropdown);

// Hide dropdown when input loses focus
fundInput.addEventListener('blur', hideFundsDropdownDelayed);

// Keyboard navigation
fundInput.addEventListener('keydown', function (e) {
    const visibleItems = Array.from(fundItems).filter(item => item.style.display !== 'none');

    // Redisplay dropdown if hidden and using arrow keys
    if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && fundDropdown.style.display !== 'block') {
        showFundsDropdown();
    }

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
        hideFundsDropdown();
    }
});

// Hide dropdown when clicking outside
document.addEventListener('click', function (e) {
    if (!fundInput.contains(e.target) && !fundDropdown.contains(e.target)) {
        hideFundsDropdown();
    }
});

// Click to select from dropdown
Array.from(fundItems).forEach(button => {
    button.addEventListener('click', () => {
        selectFund(button.textContent);
    });
});