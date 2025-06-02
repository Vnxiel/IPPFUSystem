
      // ================================
    // Project Location Suggestions
    // ================================
document.addEventListener("DOMContentLoaded", function () {

    const input = document.getElementById("location");
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


