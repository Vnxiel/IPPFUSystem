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
  const input = document.getElementById('projectContractor');
  const dropdown = document.getElementById('projectContractorDropdown');
  const contractorDataScript = document.getElementById('contractor-data');
  const contractorNames = contractorDataScript ? JSON.parse(contractorDataScript.textContent) : [];

  let selectedIndex = -1;

  input.oninput = null;
  input.onblur = null;
  input.onfocus = null;
  dropdown.innerHTML = ''; // Clear previous static buttons if any

  input.addEventListener('input', filterContractors);
  input.addEventListener('focus', showContractorDropdown);

  input.addEventListener('blur', () => {
    setTimeout(() => {
      dropdown.style.display = 'none';
      finalizeContractor();
    }, 150);
  });

  input.addEventListener('keydown', e => {
    const visibleButtons = Array.from(dropdown.querySelectorAll('button')).filter(b => b.style.display !== 'none');

    if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && dropdown.style.display !== 'block') {
      showContractorDropdown();
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
      if (visibleButtons[selectedIndex]) {
        selectContractor(visibleButtons[selectedIndex].textContent);
      } else {
        finalizeContractor();
      }
    } else if (e.key === 'Escape') {
      dropdown.style.display = 'none';
    }
  });

  document.addEventListener('click', (e) => {
    if (!input.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.style.display = 'none';
    }
  });

  function filterContractors() {
    const query = input.value.toLowerCase().trim();
    dropdown.innerHTML = '';
    let anyVisible = false;

    const matches = contractorNames
      .map(name => ({
        name,
        score: name.toLowerCase().startsWith(query) ? 0 :
               name.toLowerCase().includes(query) ? 1 : 2
      }))
      .filter(item => item.score < 2 || query === item.name.toLowerCase())
      .sort((a, b) => a.score - b.score || a.name.localeCompare(b.name));

    matches.forEach(item => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'list-group-item list-group-item-action';
      btn.textContent = item.name;
      btn.style.display = '';
      btn.addEventListener('click', () => selectContractor(item.name));
      dropdown.appendChild(btn);
      anyVisible = true;
    });

    dropdown.style.display = anyVisible ? 'block' : 'none';
    selectedIndex = -1;
  }

  function showContractorDropdown() {
    dropdown.innerHTML = '';
    contractorNames.forEach(name => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'list-group-item list-group-item-action';
      btn.textContent = name;
      btn.addEventListener('click', () => selectContractor(name));
      dropdown.appendChild(btn);
    });
    dropdown.style.display = 'block';
    selectedIndex = -1;
  }

  function finalizeContractor() {
    const val = input.value.trim();
    if (val === '') return;

    const match = contractorNames.find(name => name.toLowerCase() === val.toLowerCase());

    if (match) {
      input.value = match;
    } else {
      input.value = toTitleCase(val);
    }
  }

  function selectContractor(name) {
    input.value = name;
    dropdown.style.display = 'none';
    selectedIndex = -1;
  }

  function updateActive(visibleButtons) {
    Array.from(dropdown.querySelectorAll('button')).forEach(b => b.classList.remove('active'));
    if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
      visibleButtons[selectedIndex].classList.add('active');
      visibleButtons[selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }
  }

  function toTitleCase(str) {
    return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
  }
});
