document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('projectContractor');
  const dropdown = document.getElementById('projectContractorDropdown');
  const contractorDataScript = document.getElementById('contractor-data');
  // example array if no backend script tag
  const contractorNames = contractorDataScript ? JSON.parse(contractorDataScript.textContent) : [
    "Archi Building",
    "Acme Builders",
    "Bravo Construction",
    "Crestline Contractors",
    "Delta Developments",
    "Everest Engineering"
  ];

  let selectedIndex = -1;

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
      // User explicitly selected a visible button
      selectContractor(visibleButtons[selectedIndex].textContent);
    } else {
      // No button selected: try to autocomplete from the list
      const val = input.value.trim().toLowerCase();

      // Find first contractor starting with input value
      const match = contractorNames.find(name => name.toLowerCase().startsWith(val));

      if (match) {
        selectContractor(match);
      } else {
        // fallback: keep user input but title case it
        finalizeContractor();
      }
    }

    // Move cursor to next input
    focusNextInput(input);
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
      btn.addEventListener('click', () => {
        selectContractor(item.name);
        focusNextInput(input);
      });
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
      btn.addEventListener('click', () => {
        selectContractor(name);
        focusNextInput(input);
      });
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

  // New helper function to move focus to the next form control
  function focusNextInput(currentInput) {
    const focusableElements = Array.from(document.querySelectorAll('input, select, textarea, button, [tabindex]:not([tabindex="-1"])'))
      .filter(el => !el.disabled && el.offsetParent !== null);
    const index = focusableElements.indexOf(currentInput);
    if (index > -1 && index < focusableElements.length - 1) {
      focusableElements[index + 1].focus();
    }
  }
});
