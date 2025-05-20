
      // ================================
    // Project Location Suggestions
    // ================================
document.addEventListener("DOMContentLoaded", function () {

    const input = document.getElementById("projectLoc");
    const suggestionsBox = document.getElementById("suggestionsBoxs");
    
    if (suggestionsBox) {
        const suggestionItems = suggestionsBox.querySelectorAll(".suggestion-items");
    
        input.addEventListener("keyup", function () {
            const query = input.value.toLowerCase().trim();
            if (query === "") {
                suggestionsBox.style.display = "none";
                return;
            }
    
            let hasMatch = false;
            suggestionItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) ? "block" : "none";
                if (text.includes(query)) hasMatch = true;
            });
    
            suggestionsBox.style.display = hasMatch ? "block" : "none";
        });
    
        suggestionItems.forEach(item => {
            item.addEventListener("click", function () {
                input.value = this.textContent.trim();
                suggestionsBox.style.display = "none";
            });
        });
    
        document.addEventListener("click", function (e) {
            if (!suggestionsBox.contains(e.target) && e.target !== input) {
                suggestionsBox.style.display = "none";
            }
        });
    
    
    input.addEventListener("keyup", function () {
        const query = input.value.toLowerCase().trim();
        if (query === "") {
            suggestionsBox.style.display = "none";
            return;
        }

        let hasMatch = false;
        suggestionItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(query) ? "block" : "none";
            if (text.includes(query)) hasMatch = true;
        });

        suggestionsBox.style.display = hasMatch ? "block" : "none";
    });

    suggestionItems.forEach(item => {
        item.addEventListener("click", function () {
            input.value = this.textContent.trim();
            suggestionsBox.style.display = "none";
        });
    });


    document.addEventListener("click", function (e) {
        if (!suggestionsBox.contains(e.target) && e.target !== input) {
            suggestionsBox.style.display = "none";
        }
    });
    }
});

function filterFunds() {
    const input = document.getElementById("sourceOfFunds");
    const filter = input.value.toLowerCase();
    const dropdown = document.getElementById("sourceOfFundsDropdown");
    const items = dropdown.querySelectorAll("button");

    let hasVisible = false;

    items.forEach(item => {
        const text = item.textContent.toLowerCase();
        if (text.includes(filter)) {
            item.style.display = "block";
            hasVisible = true;
        } else {
            item.style.display = "none";
        }
    });

    dropdown.style.display = hasVisible ? "block" : "none";
}

function selectFund(value) {
    const input = document.getElementById("sourceOfFunds");
    input.value = value;
    hideFundsDropdown();
}

function showFundsDropdown() {
    const dropdown = document.getElementById("sourceOfFundsDropdown");
    if (dropdown) {
        dropdown.style.display = "block";
    }
}

function hideFundsDropdown() {
    const dropdown = document.getElementById("sourceOfFundsDropdown");
    if (dropdown) {
        dropdown.style.display = "none";
    }
}

function hideFundsDropdownDelayed() {
    setTimeout(hideFundsDropdown, 150);
}
