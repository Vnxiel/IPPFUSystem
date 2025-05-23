 // Handle "Ongoing Status" Selection Toggle
 function toggleOngoingStatus() {
    let statusSelect = document.getElementById("projectStatus");
    let ongoingContainer = document.getElementById("ongoingStatusContainer");
    let ongoingDate = document.getElementById("ongoingDate");

    if (statusSelect.value === "Ongoing") {
        ongoingContainer.style.display = "block";

        // Set the ongoingDate to today's date
        let today = new Date().toISOString().split('T')[0];
        ongoingDate.value = today;
    } else {
        ongoingContainer.style.display = "none";
        ongoingDate.value = ""; // Clear the date when status is not "Ongoing"
    }
}
// ========= INIT on Page Load ========= //
document.addEventListener('DOMContentLoaded', function () {
toggleOngoingStatus();
});