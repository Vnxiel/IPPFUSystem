function validateFinancialFields() {
    const requiredFields = [
        "#appropriation",
        "#contractAmount",
        "#engineering",
        "#abc",
        "#mqc"
    ];

    let allFilled = true;

    requiredFields.forEach(selector => {
        const $field = $(selector);

        // Check if field exists
        if ($field.length === 0) {
            console.warn(`Field not found: ${selector}`);
            allFilled = false;
            return;
        }

        $field.removeClass("empty-field");

        let value = $field.val().trim();

        // Remove currency formatting if present
        let numericValue = parseFloat(value.replace(/[₱,]/g, ""));

        // Check if field is empty OR is 0/0.000
        if (!value || isNaN(numericValue) || numericValue === 0) {
            $field.addClass("empty-field");
            allFilled = false;
        }
    });

    if (!allFilled) {
        Swal.fire({
            icon: "warning",
            title: "Missing or Invalid Financial Information",
            text: "Please provide all required financial fields before submitting.",
            confirmButtonText: "OK"
        });
    }

    return allFilled;
}


$(document).on("submit", "#addProjectForm", function (event) {
    event.preventDefault();

    // Run financial field check first
    if (!validateFinancialFields()) {
        return; // Stop submission if fields are missing
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
            }
        });
    } else {
        submitFormAjax();
    }

    function submitFormAjax() {
        $(".currency-input").each(function () {
            $(this).val($(this).val().replace(/[₱,]/g, ""));
        });

        const statusValue = $("#projectStatus").val();
        const ongoingInput = $("#ongoingStatus");
        const percentage = ongoingInput.val().trim();
        const date = $("#ongoingDate").val().trim();

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
                        timer: 2000
                    });

                    $('#addNewProjectModal').on('hidden.bs.modal', function () {
                        $("#addProjectForm")[0].reset();
                        $(this).off('hidden.bs.modal');
                    });

                    $("#addNewProjectModal").modal("hide");
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

// Real-time removal of red border as users input
$(document).on("input change", "input, textarea, select", function () {
    if ($(this).val().trim() !== "") {
        $(this).removeClass("empty-field");
    }
});
