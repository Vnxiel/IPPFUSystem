$(document).ready(function() {
    $(document).on("submit", "#addProjectForm", function(e) {
        e.preventDefault();

        var statusValue = $("#projectStatus").val();
        var ongoingInput = $("#ongoingStatus");

        if (statusValue === "Ongoing") {
            var percentage = ongoingInput.val().trim();
            var date = $("#ongoingDate").val();

            if (percentage && date) {
                if (!ongoingInput.val().includes(" - ")) {
                    ongoingInput.val(percentage + " - " + date);
                }
            }
        }

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/add-project",
            method: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response === "1") {
                    Swal.fire({
                        icon: "success",
                        title: "Project Added!",
                        text: "Project added succesfully.",
                        timer: 1000, 
                        showConfirmButton: false,                   
                    }).then(() => {
                        $("#addNewProjectModal").modal("hide");
                        $("#addProjectForm")[0].reset();
                        loadProjects();
                    });
                } else if (response == 2) {
                    Swal.fire({
                        icon: "warning",
                        title: "Missing Information!",
                        text: "Please fill out all required fields before submitting.",
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Oops! Something went wrong.",
                        text: "We couldn't save your project. Please try again later.",
                    });
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "Server Error!",
                    text: "Something went wrong. Please try again later."
                });
            }
        });
    });
});
