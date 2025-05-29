const fundInput = document.getElementById('sourceOfFunds');
const fundDropdown = document.getElementById('sourceOfFundsDropdown');
const fundItems = fundDropdown.getElementsByTagName('button');
let fundSelectedIndex = -1;

// Helper: Get next focusable element after the current one
function getNextFocusableElement(current) {
    const focusableSelectors = 'input, select, textarea, button, a[href], [tabindex]:not([tabindex="-1"])';
    const focusables = Array.from(document.querySelectorAll(focusableSelectors))
        .filter(el => !el.disabled && el.offsetParent !== null); // visible and enabled only

    const currentIndex = focusables.indexOf(current);
    if (currentIndex === -1 || currentIndex === focusables.length - 1) {
        return null; // no next focusable
    }
    return focusables[currentIndex + 1];
}

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
    fundSelectedIndex = -1; // Reset selection every time you filter
}

// Select a fund and hide dropdown + focus next element
function selectFund(name) {
    fundInput.value = name.trim();
    hideFundsDropdown();

    // Move focus to next input after a slight delay to avoid conflicts
    setTimeout(() => {
        const nextInput = getNextFocusableElement(fundInput);
        if (nextInput) nextInput.focus();
    }, 100);
}

// Show dropdown and reset index
function showFundsDropdown() {
    filterFunds(); // Always filter before showing dropdown
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

fundInput.addEventListener('input', filterFunds);

fundInput.addEventListener('focus', showFundsDropdown);

fundInput.addEventListener('blur', hideFundsDropdownDelayed);

fundInput.addEventListener('keydown', function (e) {
    const visibleItems = Array.from(fundItems).filter(item => item.style.display !== 'none');

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
        if (visibleItems.length === 0) {
            hideFundsDropdown();
            return;
        }

        if (fundSelectedIndex >= 0 && visibleItems[fundSelectedIndex]) {
            selectFund(visibleItems[fundSelectedIndex].textContent);
        } else {
            selectFund(visibleItems[0].textContent);
        }
    } else if (e.key === 'Escape') {
        hideFundsDropdown();
    }
});

document.addEventListener('click', function (e) {
    if (!fundInput.contains(e.target) && !fundDropdown.contains(e.target)) {
        hideFundsDropdown();
    }
});

Array.from(fundItems).forEach(button => {
    button.addEventListener('click', () => {
        selectFund(button.textContent);
    });
});
