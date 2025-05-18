    const contractorInput = document.getElementById('projectContractor');
    const contractorDropdown = document.getElementById('projectContractorDropdown');
    const contractorItems = contractorDropdown.getElementsByTagName('button');
    const othersContractorDiv = document.getElementById('othersContractorDiv');
    let contractorSelectedIndex = -1;

    function showContractorDropdown() {
        const filter = contractorInput.value.toLowerCase().trim();
        let anyVisible = false;

        for (let i = 0; i < contractorItems.length; i++) {
            const text = contractorItems[i].textContent.toLowerCase().trim();
            const match = text.startsWith(filter);
            contractorItems[i].style.display = match ? '' : 'none';
            if (match) anyVisible = true;
        }

        contractorDropdown.style.display = (filter.length > 0 && anyVisible) ? 'block' : 'none';
        contractorSelectedIndex = -1;
        othersContractorDiv.style.display = 'none';
    }

    function selectContractor(name) {
        contractorInput.value = name.trim();
        contractorDropdown.style.display = 'none';
        contractorSelectedIndex = -1;

        if (name === 'Others') {
            othersContractorDiv.style.display = 'block';
            document.getElementById('othersContractor').focus();
        } else {
            othersContractorDiv.style.display = 'none';
        }
    }

    contractorInput.addEventListener('keydown', function (e) {
        const visibleItems = Array.from(contractorItems).filter(item => item.style.display !== 'none');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (contractorSelectedIndex < visibleItems.length - 1) contractorSelectedIndex++;
            updateContractorActive(visibleItems);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (contractorSelectedIndex > 0) contractorSelectedIndex--;
            updateContractorActive(visibleItems);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            const visibleCount = visibleItems.length;
            if (visibleCount === 1) {
                selectContractor(visibleItems[0].textContent);
            } else if (visibleCount > 1 && contractorSelectedIndex >= 0) {
                selectContractor(visibleItems[contractorSelectedIndex].textContent);
            }
        } else if (e.key === 'Escape') {
            contractorDropdown.style.display = 'none';
        }
    });

    function updateContractorActive(visibleItems) {
        visibleItems.forEach((item, i) => {
            item.classList.toggle('active', i === contractorSelectedIndex);
        });
    }

    document.addEventListener('click', function (e) {
        if (!contractorInput.contains(e.target) && !contractorDropdown.contains(e.target)) {
            contractorDropdown.style.display = 'none';
        }
    });