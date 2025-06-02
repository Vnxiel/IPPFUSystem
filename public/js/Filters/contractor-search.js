function setupDropdownHandlers(inputId, dropdownId, toggleBtnId = null) {
  const input = document.getElementById(inputId);
  const dropdown = document.getElementById(dropdownId);
  const toggleBtn = toggleBtnId ? document.getElementById(toggleBtnId) : null;
  let selectedIndex = -1;
  if (!input || !dropdown) {
    console.warn(`Missing input or dropdown element: ${inputId}, ${dropdownId}`);
    return;
  }

  function attachClickHandlers() {
      const buttons = dropdown.querySelectorAll('button');
      buttons.forEach(button => {
          button.onmousedown = () => {
              const value = button.textContent.trim();

              // Reset input value
              if (value.toLowerCase() === 'all contractors') {
                  input.value = '';
              } else {
                  input.value = value;
              }

              input.dispatchEvent(new Event('input', { bubbles: true }));
              dropdown.style.display = 'none';
              selectedIndex = -1;
          };
      });
  }

  function showDropdown(showAll = false) {
      const buttons = dropdown.querySelectorAll('button');
      buttons.forEach(button => button.style.display = showAll ? '' : button.style.display);
      dropdown.style.display = 'block';
      attachClickHandlers();
      selectedIndex = -1;
  }

  function hideDropdown() {
      setTimeout(() => {
          dropdown.style.display = 'none';
          selectedIndex = -1;
      }, 200);
  }

  function filterDropdown() {
      const filter = input.value.toLowerCase();
      const buttons = dropdown.querySelectorAll('button');
      buttons.forEach(button => {
          const text = button.textContent.toLowerCase();
          button.style.display = text.includes(filter) ? '' : 'none';
      });
      selectedIndex = -1;
      updateActiveButton();
  }

  function updateActiveButton() {
      const visibleButtons = Array.from(dropdown.querySelectorAll('button')).filter(btn => btn.style.display !== 'none');
      dropdown.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
      if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
          visibleButtons[selectedIndex].classList.add('active');
          visibleButtons[selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
      }
  }

  input.addEventListener('focus', () => {
      // Always show all buttons when refocusing
      showDropdown(true);
  });

  input.addEventListener('input', () => {
      dropdown.style.display = 'block';
      filterDropdown();
  });

  input.addEventListener('blur', hideDropdown);

  input.addEventListener('keydown', (e) => {
      const isArrowKey = e.key === 'ArrowDown' || e.key === 'ArrowUp';

      if (isArrowKey && dropdown.style.display !== 'block') {
          showDropdown(true); // Show all options on arrow key when hidden
      }

      const visibleButtons = Array.from(dropdown.querySelectorAll('button')).filter(btn => btn.style.display !== 'none');

      if (e.key === 'ArrowDown') {
          e.preventDefault();
          if (selectedIndex < visibleButtons.length - 1) selectedIndex++;
          updateActiveButton();
      } else if (e.key === 'ArrowUp') {
          e.preventDefault();
          if (selectedIndex > 0) selectedIndex--;
          updateActiveButton();
      } else if (e.key === 'Enter') {
          e.preventDefault();
          if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
              visibleButtons[selectedIndex].click();
          }
      } else if (e.key === 'Escape') {
          dropdown.style.display = 'none';
          selectedIndex = -1;
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

  // Close dropdown when clicking outside
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
