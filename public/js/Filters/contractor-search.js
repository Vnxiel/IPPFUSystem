function setupDropdownHandlers(inputId, dropdownId, toggleBtnId = null) {
  const input = document.getElementById(inputId);
  const dropdown = document.getElementById(dropdownId);
  const toggleBtn = toggleBtnId ? document.getElementById(toggleBtnId) : null;
  const buttons = Array.from(dropdown.querySelectorAll('button'));
  const data = buttons.map(btn => btn.textContent.trim());
  let selectedIndex = -1;

  if (!input || !dropdown) return;

  function toTitleCase(str) {
    return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
  }

  function updateActive(visibleButtons) {
    buttons.forEach(b => b.classList.remove('active'));
    if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
      visibleButtons[selectedIndex].classList.add('active');
      visibleButtons[selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }
  }

  function selectValue(value) {
    input.value = value;
    dropdown.style.display = 'none';
    selectedIndex = -1;
    input.dispatchEvent(new Event('input', { bubbles: true }));
  }

  function finalizeValue() {
    const val = input.value.trim();
    if (!val) return;
    const match = data.find(d => d.toLowerCase() === val.toLowerCase());
    input.value = match ? match : toTitleCase(val);
  }

  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      selectValue(btn.textContent.trim());
      const allInputs = Array.from(document.querySelectorAll('input, select, textarea'));
      const currentIndex = allInputs.indexOf(input);
      if (currentIndex >= 0 && currentIndex + 1 < allInputs.length) {
        allInputs[currentIndex + 1].focus();
      }
    });
  });

  input.addEventListener('focus', () => {
    dropdown.style.display = 'block';
  });

  input.addEventListener('input', () => {
    const query = input.value.toLowerCase().trim();
    selectedIndex = -1;

    let hasVisible = false;

    buttons.forEach(btn => {
      const text = btn.textContent.toLowerCase();
      const match = text.includes(query);
      btn.style.display = match ? '' : 'none';
      if (match) hasVisible = true;
    });

    dropdown.style.display = hasVisible ? 'block' : 'none';
  });

  input.addEventListener('blur', () => {
    setTimeout(() => {
      dropdown.style.display = 'none';
      finalizeValue();
    }, 150);
  });

  input.addEventListener('keydown', e => {
    const visibleButtons = buttons.filter(b => b.style.display !== 'none');

    if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && dropdown.style.display !== 'block') {
      dropdown.style.display = 'block';
    }

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
      if (visibleButtons.length === 1) {
        selectValue(visibleButtons[0].textContent.trim());
      } else if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
        selectValue(visibleButtons[selectedIndex].textContent.trim());
      } else {
        finalizeValue();
      }

      const allInputs = Array.from(document.querySelectorAll('input, select, textarea'));
      const currentIndex = allInputs.indexOf(input);
      if (currentIndex >= 0 && currentIndex + 1 < allInputs.length) {
        allInputs[currentIndex + 1].focus();
      }
    } else if (e.key === 'Escape') {
      dropdown.style.display = 'none';
    }
  });

  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
        selectedIndex = -1;
      } else {
        input.focus();
      }
    });
  }

  document.addEventListener('click', (event) => {
    if (!input.contains(event.target) && !dropdown.contains(event.target)) {
      dropdown.style.display = 'none';
      selectedIndex = -1;
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  setupDropdownHandlers('contractor_filter', 'contractorDropdown', 'contractorToggleBtn');
});



document.addEventListener('DOMContentLoaded', () => {
  setupDropdown('firm_name', 'firmDropdown');
  setupDropdown('contractor_name', 'contractorNameDropdown');
  setupDropdown('contractor_address', 'contractor_addressDropdown');
});

function setupDropdown(inputId, dropdownId) {
  const input = document.getElementById(inputId);
  const dropdown = document.getElementById(dropdownId);
  const buttons = dropdown.getElementsByTagName('button');
  let selectedIndex = -1;

  input.addEventListener('input', () => filterOptions());
  input.addEventListener('focus', () => showAllOptions());

  input.addEventListener('blur', () => {
    setTimeout(() => {
      dropdown.style.display = 'none';
      finalizeSelection();
    }, 150);
  });

  Array.from(buttons).forEach(btn => {
    btn.addEventListener('click', () => {
      selectValue(btn.textContent);
    });
  });

  input.addEventListener('keydown', e => {
    const visible = Array.from(buttons).filter(btn => btn.style.display !== 'none');
  
    if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && dropdown.style.display !== 'block') {
      showAllOptions();
    }
  
    if (e.key === 'ArrowDown') {
      e.preventDefault();
      if (selectedIndex < visible.length - 1) selectedIndex++;
      updateActive(visible);
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      if (selectedIndex > 0) selectedIndex--;
      updateActive(visible);
    } else if (e.key === 'Enter') {
      e.preventDefault();
      if (visible[selectedIndex]) {
        selectValue(visible[selectedIndex].textContent);
      } else {
        finalizeSelection();
      }
    } else if (e.key === 'Tab') {
      if (dropdown.style.display === 'block') {
        if (visible[selectedIndex]) {
          selectValue(visible[selectedIndex].textContent);
        } else {
          finalizeSelection();
        }
        dropdown.style.display = 'none';
      }
    } else if (e.key === 'Escape') {
      dropdown.style.display = 'none';
    }
  });
  
  function filterOptions() {
    const filter = input.value.toLowerCase().trim();
    let anyVisible = false;

    for (let i = 0; i < buttons.length; i++) {
      const text = buttons[i].textContent.toLowerCase().trim();
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

  function showAllOptions() {
    Array.from(buttons).forEach(btn => btn.style.display = '');
    dropdown.style.display = 'block';
    selectedIndex = -1;
  }

  function finalizeSelection() {
    const val = input.value.trim();
    if (val === '') return;

    const match = Array.from(buttons).find(
      btn => btn.textContent.toLowerCase().trim() === val.toLowerCase()
    );

    input.value = match ? match.textContent.trim() : toTitleCase(val);
  }

  function selectValue(value) {
    input.value = value.trim();
    dropdown.style.display = 'none';
  }

  function updateActive(visibleButtons) {
    Array.from(buttons).forEach(b => b.classList.remove('active'));
    if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
      visibleButtons[selectedIndex].classList.add('active');
      visibleButtons[selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }
  }

  function toTitleCase(str) {
    return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
  }
}