function filterProjects(dataTable) {
    const viewAll = $('#view_all_checkbox').is(':checked');

    if (viewAll) {
        dataTable.search('').draw(); // Reset any search
        $('#view_all_checkbox').prop('checked', false); // Uncheck the checkbox
        return;
    }
    

    const location = ($('#location_filter').val() || '').toLowerCase();
    const contractor = ($('#contractor_filter').val() || '').toLowerCase();
    const rawAmount = $('#amount_filter').val();
    const amount = rawAmount ? rawAmount.replace(/[₱,]/g, '') : '';
    const status = ($('#status_filter').val() || '').toLowerCase();

    // Filtering data in the DataTable based on the input values
    dataTable.rows().every(function () {
        const data = this.data();
        const rowLocation = (data[1] || '').toLowerCase();
        const rowStatus = (data[2] || '').toLowerCase();
        const rowAmount = parseFloat((data[3] || '').replace(/[₱,]/g, '')) || 0;
        const rowContractor = (data[4] || '').toLowerCase();

        const match =
            (!location || rowLocation.includes(location)) &&
            (!contractor || rowContractor.includes(contractor)) &&
            (!amount || rowAmount <= parseFloat(amount)) &&
            (!status || rowStatus.includes(status));

        // Show or hide the row based on the match
        if (match) {
            $(this.node()).show();
        } else {
            $(this.node()).hide();
        }
    });

    dataTable.draw(); // Redraw DataTable after filtering
}


//Location filter
document.addEventListener('DOMContentLoaded', () => {
  const locationInput = document.getElementById('location_filter');
  const locationDropdown = document.getElementById('location_filter_dropdown');

  if (!locationInput || !locationDropdown) return;

  const locationButtons = Array.from(locationDropdown.querySelectorAll('button'));
  const locationData = locationButtons.map(btn => btn.textContent.trim());

  let selectedIndex = -1;

  locationInput.addEventListener('input', () => {
    const query = locationInput.value.toLowerCase().trim();
    selectedIndex = -1;

    let hasVisible = false;

    locationButtons.forEach(btn => {
      const text = btn.textContent.toLowerCase();
      const match = text.includes(query);
      btn.style.display = match ? '' : 'none';
      if (match) hasVisible = true;
    });

    locationDropdown.style.display = hasVisible ? 'block' : 'none';
  });

  locationInput.addEventListener('focus', () => {
    locationDropdown.style.display = 'block';
  });

  locationInput.addEventListener('blur', () => {
    setTimeout(() => {
      locationDropdown.style.display = 'none';
      finalizeLocation();
    }, 150);
  });

  locationInput.addEventListener('keydown', e => {
    const visibleButtons = locationButtons.filter(b => b.style.display !== 'none');

    if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && locationDropdown.style.display !== 'block') {
      locationDropdown.style.display = 'block';
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
        selectLocation(visibleButtons[0].textContent);
      } else if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
        selectLocation(visibleButtons[selectedIndex].textContent);
      } else {
        finalizeLocation();
      }

      // Move to next field
      const allInputs = Array.from(document.querySelectorAll('input, select, textarea'));
      const currentIndex = allInputs.indexOf(locationInput);
      if (currentIndex >= 0 && currentIndex + 1 < allInputs.length) {
        allInputs[currentIndex + 1].focus();
      }
    } else if (e.key === 'Escape') {
      locationDropdown.style.display = 'none';
    }
  });

  document.addEventListener('click', (e) => {
    if (!locationInput.contains(e.target) && !locationDropdown.contains(e.target)) {
      locationDropdown.style.display = 'none';
    }
  });

  function updateActive(visibleButtons) {
    locationButtons.forEach(b => b.classList.remove('active'));
    if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
      visibleButtons[selectedIndex].classList.add('active');
      visibleButtons[selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
    }
  }

  function selectLocation(name) {
    locationInput.value = name;
    locationDropdown.style.display = 'none';
    selectedIndex = -1;
  }

  function finalizeLocation() {
    const val = locationInput.value.trim();
    if (val === '') return;

    const match = locationData.find(loc => loc.toLowerCase() === val.toLowerCase());
    locationInput.value = match ? match : toTitleCase(val);
  }

  function toTitleCase(str) {
    return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
  }

  // Make sure buttons still work if clicked manually
  locationButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      selectLocation(btn.textContent);
      // Move focus
      const allInputs = Array.from(document.querySelectorAll('input, select, textarea'));
      const currentIndex = allInputs.indexOf(locationInput);
      if (currentIndex >= 0 && currentIndex + 1 < allInputs.length) {
        allInputs[currentIndex + 1].focus();
      }
    });
  });
});


//contractor filter
function initComboBox(inputId, dropdownId) {
    const input = document.getElementById(inputId);
    const dropdown = document.getElementById(dropdownId);

    if (!input || !dropdown) return;

    const buttons = Array.from(dropdown.querySelectorAll('button'));
    const values = buttons.map(btn => btn.textContent.trim());
    let selectedIndex = -1;

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

    input.addEventListener('focus', () => {
        dropdown.style.display = 'block';
    });

    input.addEventListener('blur', () => {
        setTimeout(() => {
            dropdown.style.display = 'none';
            finalizeInput();
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
                select(visibleButtons[0].textContent);
            } else if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
                select(visibleButtons[selectedIndex].textContent);
            } else {
                finalizeInput();
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

    document.addEventListener('click', (e) => {
        if (!input.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    function updateActive(visibleButtons) {
        buttons.forEach(b => b.classList.remove('active'));
        if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
            visibleButtons[selectedIndex].classList.add('active');
            visibleButtons[selectedIndex].scrollIntoView({ block: 'nearest', behavior: 'smooth' });
        }
    }

    function select(value) {
        input.value = value;
        dropdown.style.display = 'none';
        selectedIndex = -1;
    }

    function finalizeInput() {
        const val = input.value.trim();
        if (val === '') return;

        const match = values.find(v => v.toLowerCase() === val.toLowerCase());
        input.value = match ? match : toTitleCase(val);
    }

    function toTitleCase(str) {
        return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
    }

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            select(btn.textContent);
            const allInputs = Array.from(document.querySelectorAll('input, select, textarea'));
            const currentIndex = allInputs.indexOf(input);
            if (currentIndex >= 0 && currentIndex + 1 < allInputs.length) {
                allInputs[currentIndex + 1].focus();
            }
        });
    });
}

// Initialize combo boxes
document.addEventListener('DOMContentLoaded', () => {
    initComboBox('location_filter', 'location_filter_dropdown');
    initComboBox('contractor_filter', 'contractorDropdown');
});