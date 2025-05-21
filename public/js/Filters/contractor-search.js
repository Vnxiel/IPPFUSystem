document.addEventListener('DOMContentLoaded', () => {
  const input = document.createElement('input');
  const span = document.getElementById('contractor-span');
  const dropdown = document.createElement('ul');
  dropdown.className = 'list-group position-absolute w-100 mt-1';
  dropdown.style.zIndex = '1000';
  dropdown.style.maxHeight = '200px';
  dropdown.style.overflowY = 'auto';

  const contractors = [
    "Uminga Builders Corp.",
    "ABC Builders",
    "Mega Construction",
    "Skyline Works",
    "Urban Developers",
    "Tech Builders",
    "Others"
  ];

  // Replace the span with an input field
  span.replaceWith(input);

  let selectedIndex = -1;

  input.className = 'form-control';
  input.placeholder = 'Type contractor...';
  input.value = span.textContent.trim(); // Fill with the current value

  const wrapper = document.createElement('div');
  wrapper.style.position = 'relative';
  wrapper.appendChild(input);
  wrapper.appendChild(dropdown);

  // Insert the input field into the DOM
  span.parentElement.appendChild(wrapper);

  // Event listener to handle input change
  input.addEventListener('input', filterContractors);
  input.addEventListener('focus', showContractorDropdown);
  input.addEventListener('blur', () => {
    setTimeout(() => {
      dropdown.style.display = 'none';
      finalizeContractor();
    }, 150);
  });

  // Listen for keyboard events (Arrow keys, Enter)
  input.addEventListener('keydown', e => {
    const visibleButtons = Array.from(dropdown.children);
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
        finalizeContractor(); // treat as custom input
      }
    } else if (e.key === 'Escape') {
      dropdown.style.display = 'none';
    }
  });

  function filterContractors() {
    const filter = input.value.toLowerCase();
    let anyVisible = false;
    dropdown.innerHTML = '';

    contractors.forEach(contractor => {
      if (contractor.toLowerCase().includes(filter)) {
        const li = document.createElement('li');
        li.textContent = contractor;
        li.className = 'list-group-item list-group-item-action';
        li.addEventListener('click', () => {
          selectContractor(contractor);
        });
        dropdown.appendChild(li);
        anyVisible = true;
      }
    });

    dropdown.style.display = anyVisible ? 'block' : 'none';
    selectedIndex = -1;
  }

  function finalizeContractor() {
    let val = input.value.trim();
    if (val === '') return;

    const visibleButtons = Array.from(dropdown.children);

    // If only one visible suggestion, auto-select it
    if (visibleButtons.length === 1) {
      input.value = visibleButtons[0].textContent.trim();
      return;
    }

    // Exact match
    const matchBtn = Array.from(dropdown.children).find(
      btn => btn.textContent.toLowerCase().trim() === val.toLowerCase()
    );

    if (matchBtn) {
      input.value = matchBtn.textContent.trim();
    } else {
      input.value = val; // Treat as custom input
    }
  }

  function selectContractor(value) {
    input.value = value.trim();
    dropdown.style.display = 'none';
  }

  function showContractorDropdown() {
    dropdown.style.display = 'block';
    selectedIndex = -1;
  }

  function updateActive(visibleButtons) {
    Array.from(dropdown.children).forEach(b => b.classList.remove('active'));
    if (selectedIndex >= 0 && visibleButtons[selectedIndex]) {
      visibleButtons[selectedIndex].classList.add('active');
    }
  }
});