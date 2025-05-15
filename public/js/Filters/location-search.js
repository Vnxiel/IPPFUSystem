const input = document.getElementById('projectLoc');
const dropdown = document.getElementById('projectLocDropdown');
const items = dropdown.getElementsByTagName('button');
let selectedIndex = -1;

function showLocDropdown() {
    const filter = input.value.toLowerCase().trim();
    let anyVisible = false;

    for (let i = 0; i < items.length; i++) {
        const text = items[i].textContent.toLowerCase().trim();
        const match = text.startsWith(filter);
        items[i].style.display = match ? '' : 'none';
        if (match) anyVisible = true;
    }

    dropdown.style.display = (filter.length > 0 && anyVisible) ? 'block' : 'none';
    selectedIndex = -1;
}

function selectLoc(value) {
    input.value = value.trim();
    dropdown.style.display = 'none';
}

input.addEventListener('keydown', function (e) {
    const visibleItems = Array.from(items).filter(item => item.style.display !== 'none');

    if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (selectedIndex < visibleItems.length - 1) selectedIndex++;
        updateActive(visibleItems);
    } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (selectedIndex > 0) selectedIndex--;
        updateActive(visibleItems);
    } else if (e.key === 'Enter') {
        e.preventDefault();
        if (visibleItems[selectedIndex]) {
            selectLoc(visibleItems[selectedIndex].textContent);
        } else if (visibleItems.length === 1) {
            // Auto-select if only one option
            selectLoc(visibleItems[0].textContent);
        }
    } else if (e.key === 'Escape') {
        dropdown.style.display = 'none';
    }
});

function updateActive(visibleItems) {
    visibleItems.forEach((item, i) => {
        item.classList.toggle('active', i === selectedIndex);
    });
}

document.addEventListener('click', function (e) {
    if (!input.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});
