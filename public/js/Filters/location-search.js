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
    buttons.forEach((button, index) => {
      button.onclick = () => {
        const value = button.textContent.trim();
        input.value = value;

  
        input.dispatchEvent(new Event('input', { bubbles: true }));
        dropdown.style.display = 'none';
        selectedIndex = -1;
      };
    });
  }

  function showDropdown() {
    const buttons = dropdown.querySelectorAll('button');
    buttons.forEach(button => button.style.display = '');
    dropdown.style.display = 'block';
    attachClickHandlers();
    selectedIndex = -1;
  }

  function hideDropdown() {
    // Only hide after slight delay to allow button click
    setTimeout(() => {
      dropdown.style.display = 'none';
      selectedIndex = -1;
    }, 150);
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
      visibleButtons[selectedIndex].scrollIntoView({ block: 'nearest' });
    }
  }

  input.addEventListener('focus', () => {
    showDropdown();
    filterDropdown();
  });

  input.addEventListener('input', () => {
    showDropdown();
    filterDropdown();
  });

  input.addEventListener('blur', () => {
    // Delay hiding only if user isn't clicking on a dropdown button
    setTimeout(() => {
      if (!dropdown.contains(document.activeElement)) {
        dropdown.style.display = 'none';
        selectedIndex = -1;
      }
    }, 150);
  });
  

  input.addEventListener('keydown', (e) => {
    const allButtons = Array.from(dropdown.querySelectorAll('button'));
  
    // Tab key allows normal behavior
    if (e.key === 'Tab') {
      dropdown.style.display = 'none';
      selectedIndex = -1;
      return;
    }
  
    if (e.key === 'ArrowDown') {
      e.preventDefault();
      if (dropdown.style.display !== 'block') {
        showDropdown(); // show all
      } else {
        allButtons.forEach(button => button.style.display = '');
      }
      const visibleButtons = allButtons.filter(btn => btn.style.display !== 'none');
      if (selectedIndex < visibleButtons.length - 1) selectedIndex++;
      updateActiveButton();
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      if (dropdown.style.display !== 'block') {
        showDropdown(); // show all
      } else {
        allButtons.forEach(button => button.style.display = '');
      }
      const visibleButtons = allButtons.filter(btn => btn.style.display !== 'none');
      if (selectedIndex > 0) selectedIndex--;
      updateActiveButton();
    } else if (e.key === 'Enter') {
      e.preventDefault();
      const visibleButtons = allButtons.filter(btn => btn.style.display !== 'none');
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

  // Hide when clicking outside
  document.addEventListener('click', (event) => {
    if (!input.contains(event.target) && !dropdown.contains(event.target)) {
      dropdown.style.display = 'none';
      selectedIndex = -1;
    }
  });
}

// Example setup
document.addEventListener('DOMContentLoaded', () => {
  setupDropdownHandlers('contractor_filter', 'contractorDropdown');
  setupDropdownHandlers('location_filter', 'location_filter_dropdown');
  setupDropdownHandlers('year_filter_input', 'year_filter_dropdown');
});





document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('location');
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

    // Show all options if user navigates with keyboard
    if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && dropdown.style.display !== 'block') {
      showLocDropdown();
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
        selectLoc(visibleButtons[selectedIndex].textContent);
      } else {
        finalizeLocation();
      }
    } else if (e.key === 'Escape') {
      dropdown.style.display = 'none';
    }
  });

  function filterLocations() {
    const filter = input.value.toLowerCase().replace(/,\s*nueva\s*vizcaya\s*$/i, '').trim();
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

  function finalizeLocation() {
    let val = input.value.trim().replace(/,\s*nueva\s*vizcaya\s*$/i, '');
    if (val === '') return;

    const visibleButtons = Array.from(buttons).filter(btn => btn.style.display !== 'none');

    if (visibleButtons.length === 1) {
      input.value = visibleButtons[0].textContent.trim() + ', Nueva Vizcaya';
      return;
    }

    const matchBtn = Array.from(buttons).find(
      btn => btn.textContent.toLowerCase().trim() === val.toLowerCase()
    );

    if (matchBtn) {
      input.value = matchBtn.textContent.trim() + ', Nueva Vizcaya';
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
      visibleButtons[selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }
  }

  function toTitleCase(str) {
    return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
  }
});


// document.addEventListener('DOMContentLoaded', () => {
//   const focusableElements = Array.from(document.querySelectorAll('input, textarea'));

//   focusableElements.forEach((el, idx) => {
//     el.addEventListener('keydown', (e) => {
//       if (e.key === 'Enter') {
//         // Skip if inside a textarea — allow new line
//         if (el.tagName.toLowerCase() === 'textarea') {
//           return; // Just let Enter do its normal thing
//         }

//         e.preventDefault();

//         let nextEl = null;
//         for (let i = idx + 1; i < focusableElements.length; i++) {
//           const next = focusableElements[i];
//           if (!next.disabled && next.offsetParent !== null) {
//             nextEl = next;
//             break;
//           }
//         }

//         if (nextEl) {
//           nextEl.focus();
//           if (nextEl.select) nextEl.select();
//         }
//       }
//     });
//   });
// });
