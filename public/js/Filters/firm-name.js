document.addEventListener('DOMContentLoaded', () => {
  setupFirmDropdown('firm_name', 'firmDropdown');

  function setupFirmDropdown(inputId, dropdownId) {
    const input = document.getElementById(inputId);
    const dropdown = document.getElementById(dropdownId);
    const buttons = dropdown.querySelectorAll('button');
    let selectedIndex = -1;

    input.addEventListener('input', filterFirmNames);
    input.addEventListener('focus', showDropdown);
    input.addEventListener('blur', () => {
      setTimeout(() => {
        dropdown.style.display = 'none';
        finalizeFirm();
      }, 150);
    });

    input.addEventListener('keydown', (e) => {
      const visibleButtons = Array.from(buttons).filter(b => b.style.display !== 'none');

      if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && dropdown.style.display !== 'block') {
        showDropdown();
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
          selectFirm(visibleButtons[selectedIndex].textContent);
        } else {
          finalizeFirm();
        }
      } else if (e.key === 'Escape') {
        dropdown.style.display = 'none';
      }
    });

    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        selectFirm(btn.textContent);
      });
    });

    function filterFirmNames() {
      const filter = input.value.toLowerCase().trim();
      let anyVisible = false;

      buttons.forEach(btn => {
        const text = btn.textContent.toLowerCase().trim();
        btn.style.display = text.includes(filter) ? '' : 'none';
        if (btn.style.display !== 'none') anyVisible = true;
      });

      dropdown.style.display = anyVisible ? 'block' : 'none';
      selectedIndex = -1;
    }

    function finalizeFirm() {
      let val = input.value.trim();
      if (val === '') return;

      const matchBtn = Array.from(buttons).find(
        btn => btn.textContent.toLowerCase().trim() === val.toLowerCase()
      );

      if (matchBtn) {
        input.value = matchBtn.textContent.trim();
      } else {
        // Do not convert to title case — preserve user input
        input.value = val;
      }
    }

    function selectFirm(value) {
      input.value = value.trim();
      dropdown.style.display = 'none';
    }

    function showDropdown() {
      buttons.forEach(btn => btn.style.display = '');
      dropdown.style.display = 'block';
      selectedIndex = -1;
    }

    function updateActive(visibleButtons) {
      buttons.forEach(b => b.classList.remove('active'));
      if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
        visibleButtons[selectedIndex].classList.add('active');
        visibleButtons[selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
      }
    }
  }
});
