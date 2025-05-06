

let currentFocus = -1;

function showLocDropdown() {
    const input = document.getElementById("projectLoc");
    const dropdown = document.getElementById("projectLocDropdown");

    dropdown.style.display = input.value ? "block" : "none";

    // Optional: filter items based on input
    const items = dropdown.querySelectorAll("button");
    let visibleCount = 0;
    items.forEach((item, index) => {
        if (item.textContent.toLowerCase().includes(input.value.toLowerCase())) {
            item.style.display = "";
            visibleCount++;
        } else {
            item.style.display = "none";
        }
    });

    if (visibleCount === 0) dropdown.style.display = "none";
    currentFocus = -1;
}

document.getElementById("projectLoc").addEventListener("keydown", function(e) {
    const dropdown = document.getElementById("projectLocDropdown");
    let items = dropdown.querySelectorAll("button");
    items = Array.from(items).filter(item => item.style.display !== "none");

    if (e.key === "ArrowDown") {
        e.preventDefault();
        currentFocus = (currentFocus + 1) % items.length;
        setActive(items);
    } else if (e.key === "ArrowUp") {
        e.preventDefault();
        currentFocus = (currentFocus - 1 + items.length) % items.length;
        setActive(items);
    } else if (e.key === "Enter") {
        e.preventDefault();
        if (currentFocus > -1 && items[currentFocus]) {
            items[currentFocus].click();
        }
    }
});

function setActive(items) {
    items.forEach(item => item.classList.remove("active"));
    if (currentFocus >= 0 && items[currentFocus]) {
        items[currentFocus].classList.add("active");
        items[currentFocus].scrollIntoView({ block: "nearest" });
    }
}

function selectLoc(name) {
    document.getElementById("projectLoc").value = name;
    document.getElementById("projectLocDropdown").style.display = "none";
    currentFocus = -1;
}
