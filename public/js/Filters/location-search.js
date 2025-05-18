document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('projectLoc');
  const dropdown = document.getElementById('projectLocDropdown');
  const buttons = dropdown.getElementsByTagName('button');
  let selectedIndex = -1;

  // Remove inline event handlers
  input.oninput = null;
  input.onblur = null;
  input.onfocus = null;
  Array.from(buttons).forEach(btn => btn.onclick = null);

  input.addEventListener('input', filterLocations);
  input.addEventListener('focus', showLocDropdown);
  input.addEventListener('blur', () => {
    setTimeout(() => {
      dropdown.style.display = 'none';
      finalizeLocation();
    }, 150);
  });

  Array.from(buttons).forEach(btn => {
    btn.addEventListener('click', () => {
      selectLoc(btn.textContent);
    });
  });

  input.addEventListener('keydown', e => {
    const visibleButtons = Array.from(buttons).filter(b => b.style.display !== 'none');
    if (e.key === 'ArrowDown') {
      e.preventDefault();
      if (selectedIndex < visibleButtons.length - 1) selectedIndex++;
      updateActive(visibleButtons);
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      if (selectedIndex > 0) selectedIndex--;
      updateActive(visibleButtons);
    } else if (e.key === 'Enter') {
      e.preventDefault();
      if (visibleButtons[selectedIndex]) {
        selectLoc(visibleButtons[selectedIndex].textContent);
      } else {
        finalizeLocation(); // treat as custom input
      }
    } else if (e.key === 'Escape') {
      dropdown.style.display = 'none';
    }
  });

  function filterLocations() {
    const filter = input.value.toLowerCase().replace(/,\s*nueva\s*vizcaya\s*$/i, '').trim();
    let anyVisible = false;

    for (let i = 0; i < buttons.length; i++) {
      const text = buttons[i].textContent.toLowerCase();
      if (text.includes(filter)) {
        buttons[i].style.display = '';
        anyVisible = true;
      } else {
        buttons[i].style.display = 'none';
      }
    }

    dropdown.style.display = anyVisible ? 'block' : 'none';
    selectedIndex = -1;
  }

  function finalizeLocation() {
    let val = input.value.trim().replace(/,\s*nueva\s*vizcaya\s*$/i, '');
    if (val === '') return;

    // Check if input matches a button (case-insensitive)
    const matchBtn = Array.from(buttons).find(btn => btn.textContent.toLowerCase() === val.toLowerCase());

    if (matchBtn) {
      input.value = matchBtn.textContent + ', Nueva Vizcaya';
    } else {
      input.value = toTitleCase(val) + ', Nueva Vizcaya';
    }
  }

  function selectLoc(value) {
    input.value = value.trim() + ', Nueva Vizcaya';
    dropdown.style.display = 'none';
  }

  function showLocDropdown() {
    for (let i = 0; i < buttons.length; i++) {
      buttons[i].style.display = '';
    }
    dropdown.style.display = 'block';
    selectedIndex = -1;
  }

  function updateActive(visibleButtons) {
    Array.from(buttons).forEach(b => b.classList.remove('active'));
    if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
      visibleButtons[selectedIndex].classList.add('active');
    }
  }

  function toTitleCase(str) {
    return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
  }
});
