
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('ea');
  const dropdown = document.getElementById('projectEngineerDropdown');
  const engineerDataScript = document.getElementById('engineer-data');

  // Parse engineer data (array of strings)
  const engineerData = engineerDataScript ? JSON.parse(engineerDataScript.textContent).map(name => name.trim()) : [];

  let selectedIndex = -1;

  input.addEventListener('input', filterEngineers);
  input.addEventListener('focus', showEngineerDropdown);

  input.addEventListener('blur', () => {
    setTimeout(() => {
      dropdown.style.display = 'none';
      finalizeEngineer();
    }, 150);
  });

  input.addEventListener('keydown', e => {
    const visibleButtons = Array.from(dropdown.querySelectorAll('button')).filter(b => b.style.display !== 'none');

    if ((e.key === 'ArrowDown' || e.key === 'ArrowUp') && dropdown.style.display !== 'block') {
      showEngineerDropdown();
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
        selectEngineer(visibleButtons[selectedIndex].textContent);
      } else {
        finalizeEngineer();
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

  function filterEngineers() {
    const query = input.value.toLowerCase().trim();
    dropdown.innerHTML = '';
    let anyVisible = false;

    const matches = engineerData
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
      btn.addEventListener('click', () => selectEngineer(item.name));
      dropdown.appendChild(btn);
      anyVisible = true;
    });

    dropdown.style.display = anyVisible ? 'block' : 'none';
    selectedIndex = -1;
  }

  function showEngineerDropdown() {
    dropdown.innerHTML = '';
    engineerData.forEach(name => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'list-group-item list-group-item-action';
      btn.textContent = name;
      btn.addEventListener('click', () => selectEngineer(name));
      dropdown.appendChild(btn);
    });
    dropdown.style.display = 'block';
    selectedIndex = -1;
  }

  function finalizeEngineer() {
    const val = input.value.trim();
    if (val === '') return;

    const match = engineerData.find(name => name.toLowerCase() === val.toLowerCase());

    if (match) {
      input.value = match;
    } else {
      input.value = toTitleCase(val);
    }
  }

  function selectEngineer(name) {
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
