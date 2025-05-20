const eaInput = document.getElementById('ea');
const eaDropdown = document.getElementById('eaDropdown');
const eaItems = eaDropdown.getElementsByTagName('button');
let eaSelectedIndex = -1;

function showEaDropdown() {
    const filter = eaInput.value.toLowerCase().trim();
    let anyVisible = false;

    for (let i = 0; i < eaItems.length; i++) {
        const text = eaItems[i].textContent.toLowerCase().trim();
        const match = text.startsWith(filter);
        eaItems[i].style.display = match ? '' : 'none';
        if (match) anyVisible = true;
    }

    eaDropdown.style.display = (filter.length > 0 && anyVisible) ? 'block' : 'none';
    eaSelectedIndex = -1;
}

function selectEa(name) {
    eaInput.value = name.trim();
    eaDropdown.style.display = 'none';
}

eaInput.addEventListener('keydown', function (e) {
    const visibleItems = Array.from(eaItems).filter(item => item.style.display !== 'none');

    if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (eaSelectedIndex < visibleItems.length - 1) eaSelectedIndex++;
        updateEaActive(visibleItems);
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (eaSelectedIndex > 0) eaSelectedIndex--;
        updateEaActive(visibleItems);
    } else if (e.key === 'Enter') {
        e.preventDefault();
        const visibleCount = visibleItems.length;
        if (visibleCount === 1) {
            selectEa(visibleItems[0].textContent);
        } else if (visibleCount > 1 && eaSelectedIndex >= 0) {
            selectEa(visibleItems[eaSelectedIndex].textContent);
        }
    } else if (e.key === 'Escape') {
        eaDropdown.style.display = 'none';
    }
});


function updateEaActive(visibleItems) {
    visibleItems.forEach((item, i) => {
        item.classList.toggle('active', i === eaSelectedIndex);
    });
}

document.addEventListener('click', function (e) {
    if (!eaInput.contains(e.target) && !eaDropdown.contains(e.target)) {
        eaDropdown.style.display = 'none';
    }
});

