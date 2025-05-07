 // Handle Add Status button click
 $(document).on("click", "#fundSummaryBtn", function () {
    const project_id = sessionStorage.getItem("project_id");

    if (!project_id) {
        return Swal.fire({ icon: "error", title: "Missing Info", text: "Cannot load project." });
    }

    // Show the Add Status Modal
    $("#viewFundSummaryModal").modal("show");
});
