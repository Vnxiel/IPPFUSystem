$(document).ready(function() {
    $(document).on("submit", "#addProjectForm", function(event) {
        event.preventDefault();

        // Remove peso sign and commas before submission
        $(".currency-input").each(function() {
            $(this).val($(this).val().replace(/[₱,]/g, ""));
        });

        var statusValue = $("#projectStatus").val();
        var ongoingInput = $("#ongoingStatus");
        var percentage = ongoingInput.val().trim();
        var date = $("#ongoingDate").val().trim();

        // Handle "Ongoing" status properly
        if (statusValue === "Ongoing" && percentage && date) {
            // Ensure it is not already formatted correctly
            if (!ongoingInput.val().includes(" - ")) {
                ongoingInput.val(`${percentage} - ${date}`);
            }
        }

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/projects/addProject", // Matches Laravel route
            method: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Project Added Successfully!",
                        text: response.message,
                        showConfirmButton: false,
                        timer: 2000,
                        didClose: function () {
                            $("#addNewProjectModal").modal("hide");
                            $("#ProjectForm")[0].reset();
                            loadProjects(); // ✅ Reload projects here
                        }
                    });
                }
                
                 else if (response.errors) {
                    let errorMessages = "<ul class='text-left'>";
                    $.each(response.errors, function(field, errors) {
                        errorMessages += `<li><strong>${field.replace(/_/g, " ")}:</strong> ${errors.join(", ")}</li>`;
                    });
                    errorMessages += "</ul>";

                    Swal.fire({
                        icon: "warning",
                        title: "Validation Error",
                        html: errorMessages,
                        confirmButtonText: "OK"
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Unexpected Error",
                        text: "Something went wrong while processing your request. Please try again. Some fields may have invalid input.",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = "An unexpected error occurred. Adding the project failed.";
                Swal.fire({
                    icon: "error",
                    title: "Error " + xhr.status,
                    text: errorMessage,
                    confirmButtonText: "OK"
                });

                console.error("Error:", xhr.responseText);
            }
        });
    });
});
