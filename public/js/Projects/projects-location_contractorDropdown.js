const contractorInput = document.getElementById('projectContractor');
    const dropdown = document.getElementById('projectContractorDropdown');

    // Store contractor names in JavaScript for easier manipulation
    const contractorDataScript = document.getElementById('contractor-data');
    const contractorNames = contractorDataScript ? JSON.parse(contractorDataScript.textContent) : [];
    

    function filterAndReorderContractors() {
        const inputValue = contractorInput.value.toLowerCase();
        const matches = contractorNames
            .map(name => ({
                name,
                score: name.toLowerCase().startsWith(inputValue) ? 0 : 
                       name.toLowerCase().includes(inputValue) ? 1 : 2
            }))
            .filter(item => item.score < 2)
            .sort((a, b) => a.score - b.score || a.name.localeCompare(b.name));

        dropdown.innerHTML = '';
        matches.forEach(item => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'list-group-item list-group-item-action';
            button.textContent = item.name;
            button.onclick = () => selectContractor(item.name);
            dropdown.appendChild(button);
        });

        dropdown.style.display = matches.length ? 'block' : 'none';
    }

    function selectContractor(name) {
        contractorInput.value = name;
        dropdown.style.display = 'none';
    }

    document.addEventListener('click', function(event) {
        if (!contractorInput.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });

    function filterLocations() {
    const input = document.getElementById('projectLoc');
    const dropdown = document.getElementById('projectLocDropdown');
    const buttons = dropdown.getElementsByTagName('button');

    // Remove existing ", Nueva Vizcaya" before filtering
    const filter = input.value.toLowerCase().replace(/,\s*nueva\s*vizcaya\s*$/i, '').trim();

    let anyVisible = false;

    for (let i = 0; i < buttons.length; i++) {
        const txt = buttons[i].textContent || buttons[i].innerText;
        if (txt.toLowerCase().includes(filter)) {

            buttons[i].style.display = '';
            anyVisible = true;
        } else {
            buttons[i].style.display = 'none';
        }
    }

    dropdown.style.display = anyVisible ? 'block' : 'none';
}

function finalizeLocation() {
    const input = document.getElementById('projectLoc');
    let value = input.value.trim();

    // Remove any existing ", Nueva Vizcaya"
    value = value.replace(/,\s*nueva\s*vizcaya\s*$/i, '');

    if (value !== '') {
        input.value = value + ', Nueva Vizcaya';
    }
}

function selectLoc(value) {
    const input = document.getElementById('projectLoc');
    input.value = value + ', Nueva Vizcaya';
    document.getElementById('projectLocDropdown').style.display = 'none';
}

function showLocDropdown() {
    const dropdown = document.getElementById('projectLocDropdown');
    const buttons = dropdown.getElementsByTagName('button');

    for (let i = 0; i < buttons.length; i++) {
        buttons[i].style.display = '';
    }

    dropdown.style.display = 'block';
}

// Optional: hide dropdown if clicked outside
document.addEventListener('click', function (e) {
    const input = document.getElementById('projectLoc');
    const dropdown = document.getElementById('projectLocDropdown');
    if (!input.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});

