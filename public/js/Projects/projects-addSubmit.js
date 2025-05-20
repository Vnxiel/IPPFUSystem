// ================================
    // Form Submission Logic
    // ================================

    $(document).on("submit", "#addProjectForm", function (event) {
        event.preventDefault();

        if (!validateFinancialFields()) {
            return; // Stop if financial fields are invalid
        }

        const form = this;
        let emptyFields = [];

        $(form).find("input, textarea, select").removeClass("empty-field");

        const allElements = form.querySelectorAll("input, textarea, select");
        allElements.forEach(el => {
            if (!el.value.trim()) {
                emptyFields.push(el);
                $(el).addClass("empty-field");
            }
        });

        if (emptyFields.length > 0) {
            Swal.fire({
                title: "Some fields are empty!",
                text: "Please fill out all fields before submitting, or you can choose to submit anyway.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Submit Anyway",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    submitFormAjax();
                } else {
                    return false;
                }
            });
        } else {
            submitFormAjax();
        }

        function submitFormAjax() {
            $(".currency-input").each(function () {
                $(this).val($(this).val().replace(/[₱,]/g, ""));
            });

            var statusValue = $("#projectStatus").val();
            var ongoingInput = $("#ongoingStatus");
            var percentage = ongoingInput.val().trim();
            var date = $("#ongoingDate").val().trim();

            if (statusValue === "Ongoing" && percentage && date) {
                if (!ongoingInput.val().includes(" - ")) {
                    ongoingInput.val(`${percentage} - ${date}`);
                }
            }

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "/projects/addProject",
                method: "POST",
                data: new FormData(form),
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Project Added Successfully!",
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000,
                            didClose: function () {
                                $("#addNewProjectModal").modal("hide");
                                location.reload();
                            }
                        });
                        $('#addNewProjectModal').on('hidden.bs.modal', function () {
                            $("#addProjectForm")[0].reset();
                            loadProjects();
                            $(this).off('hidden.bs.modal');
                        });
                
                    } else if (response.errors) {
                        let errorMessages = "<ul class='text-left'>";
                        $.each(response.errors, function (field, errors) {
                            errorMessages += `<li><strong>${field.replace(/_/g, " ")}:</strong> ${errors.join(", ")}</li>`;
                        });
                        errorMessages += "</ul>";
                
                        Swal.fire({
                            icon: "warning",
                            title: "Validation Error",
                            html: errorMessages,
                            confirmButtonText: "OK"
                        });
                
                    } else if (response.message === 'A project with the same FPP and RC already exists.') {
                        Swal.fire({
                            icon: "error",
                            title: "Duplicate Entry",
                            text: response.message,
                            confirmButtonText: "OK"
                        });
                
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Unexpected Error",
                            text: "Something went wrong while processing your request. Please try again.",
                            confirmButtonText: "OK"
                        });
                    }
                },
                
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error " + xhr.status,
                        text: "An unexpected error occurred. Adding the project failed.",
                        confirmButtonText: "OK"
                    });
                    console.error("Error:", xhr.responseText);
                }
            });
        }
    });

    $(document).on("input change", "input, textarea, select", function () {
        if ($(this).val().trim() !== "") {
            $(this).removeClass("empty-field");
        }
    });
