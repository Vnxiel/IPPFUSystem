$(document).ready(function() {
    $(document).on("submit", "#addProjectForm", function(event) {
        event.preventDefault();

        // Remove peso sign before submission
        $(".currency-input").each(function () {
            $(this).val($(this).val().replace(/[₱,]/g, ""));
        });

        var statusValue = $("#projectStatus").val();
        var ongoingInput = $("#ongoingStatus");

        if (statusValue === "Ongoing") {
            var percentage = ongoingInput.val().trim();
            var date = $("#ongoingDate").val();

            if (percentage && date) {
                // Prevent duplicate concatenation
                if (!ongoingInput.val().includes(" - ")) {
                    ongoingInput.val(percentage + " - " + date);
                }
            }
        }

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/projects/add-project", // Matches Laravel route
            method: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Project Added Successfully!",
                        showConfirmButton: false,
                        timer: 2000,
                    }).then(function() {
                        $("#addNewProjectModal").modal("hide");
                        $("#addProjectForm")[0].reset();
                        loadProjects(); // Reload projects without refreshing
                    });
                } else if (response.errors) {
                    var errorMessages = Object.values(response.errors).join("<br>");
                    Swal.fire({
                        icon: "error",
                        title: "Validation Failed!",
                        html: errorMessages,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Something went wrong!",
                        text: "Please try again later.",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            },
            error: function(xhr) {
                console.error("Error:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Server Error!",
                    text: "An unexpected error occurred.",
                    showConfirmButton: false,
                    timer: 3000,
                });
            }
        });
    });
}); 