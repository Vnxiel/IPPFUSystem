$(document).ready(function () {
    // ================================
    // DOM Manipulations and Event Listeners
    // ================================
document.addEventListener("DOMContentLoaded", function () {

    
      // ================================
    // Project Location Suggestions
    // ================================
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
    // ================================
    // Contractor 'Others' toggle
    // ================================
        const contractorSelect = document.getElementById("projectContractor");
        const othersContractorDiv = document.getElementById("othersContractorDiv");
        const othersContractorInput = document.getElementById("othersContractor");
    
        if (contractorSelect) {
            contractorSelect.addEventListener("change", function () {
                if (this.value === "Others") {
                    othersContractorDiv.style.display = "block";
                } else {
                    othersContractorDiv.style.display = "none";
                    othersContractorInput.value = "";
                }
            });
        }

        const projectStatusSelect = document.getElementById("projectStatus");
        const ongoingStatusContainer = document.getElementById("ongoingStatusContainer");
    
        if (projectStatusSelect && ongoingStatusContainer) {
            projectStatusSelect.addEventListener("change", function () {
                if (this.value === "Ongoing") {
                    ongoingStatusContainer.style.display = "block";
                } else {
                    ongoingStatusContainer.style.display = "none";
                    
                    const ongoingStatus = document.getElementById("ongoingStatus");
                    const ongoingDate = document.getElementById("ongoingDate");
    
                    if (ongoingStatus) ongoingStatus.value = '';
                    if (ongoingDate) ongoingDate.value = '';
                }
            });
        }

    // Currency Formatting
    const currencyFields = ['abc', 'contractAmount', 'engineering', 'mqc', 'contingency', 'bid', 'appropriation'];
    const limitedFields = ['abc', 'contractAmount', 'engineering', 'mqc', 'contingency'];
    const appropriationInput = document.getElementById('appropriation');

    function parseCurrency(value) {
        return parseFloat(value.replace(/[^0-9.-]+/g, '')) || 0;
    }

    function formatToPeso(value) {
        const number = parseFloat(value.replace(/[^0-9.-]+/g, ''));
        if (isNaN(number)) return '';
        return '₱ ' + number.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function unformatCurrency(value) {
        return value.replace(/[^0-9.-]+/g, '');
    }

    currencyFields.forEach(id => {
        const field = document.getElementById(id);
        if (!field) return;

        field.addEventListener('blur', () => {
            if (field.value.trim() !== '') {
                const value = parseCurrency(field.value);
                if (limitedFields.includes(id)) {
                    const appropriation = parseCurrency(appropriationInput.value);
                    if (value > appropriation) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Exceeds Appropriation',
                            text: `${field.labels[0].innerText} must not exceed Appropriation amount.`
                        });
                        field.value = '';
                        return;
                    }
                }
                field.value = formatToPeso(field.value);
            }
        });

        field.addEventListener('focus', () => {
            field.value = unformatCurrency(field.value);
        });
    });

    const abcInput = document.getElementById('abc');
    const contractAmountInput = document.getElementById('contractAmount');
    const bidInput = document.getElementById('bid');

    function updateBidDifference() {
        const abc = parseCurrency(abcInput.value);
        const contractAmount = parseCurrency(contractAmountInput.value);
        const bid = contractAmount - abc;
        bidInput.value = isNaN(bid) ? '' : bid.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    abcInput.addEventListener('input', updateBidDifference);
    contractAmountInput.addEventListener('input', updateBidDifference);

    function validateDateOrder(earlierId, laterId, message) {
        const earlier = document.getElementById(earlierId);
        const later = document.getElementById(laterId);

        later.addEventListener('blur', () => {
            if (!later.value || !earlier.value) return;

            const earlierDate = new Date(earlier.value);
            const laterDate = new Date(later.value);

            if (laterDate <= earlierDate) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Date Entry',
                    text: message
                });
                later.value = '';
            }
        });
    }

    validateDateOrder('noaIssuedDate', 'noaReceivedDate', 'NOA Received Date must be after Issued Date.');
    validateDateOrder('ntpIssuedDate', 'ntpReceivedDate', 'NTP Received Date must be after Issued Date.');

    document.querySelectorAll('.order-set').forEach(order => {
        const suspension = order.querySelector('input[id^="suspensionOrderNo"]');
        const resumption = order.querySelector('input[id^="resumeOrderNo"]');
        const remarks = order.querySelector('input[name$="Remarks"]');

        if (remarks) remarks.value = '';

        if (suspension && resumption) {
            resumption.addEventListener('change', () => {
                if (!resumption.value) return;
                if (suspension.value && new Date(resumption.value) <= new Date(suspension.value)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid Date Entry',
                        text: 'Resumption date must be after Suspension date.'
                    });
                    resumption.value = '';
                }
            });
        }
    });

    const originalStartDate = document.getElementById('originalStartDate');
    const contractDays = document.getElementById('projectContractDays');
    const targetCompletion = document.getElementById('targetCompletion');

    function updateTargetCompletion() {
        if (originalStartDate.value && contractDays.value) {
            const start = new Date(originalStartDate.value);
            start.setDate(start.getDate() + parseInt(contractDays.value) - 1);
            targetCompletion.value = start.toISOString().split('T')[0];
        }
    }

    originalStartDate.addEventListener('change', updateTargetCompletion);
    contractDays.addEventListener('input', updateTargetCompletion);
});

function validateFinancialFields() {
    const requiredFields = [
        "#appropriation",
        "#contractAmount",
        "#engineering",
        "#abc",
        "#mqc"
    ];

    let allFilled = true;

    // Remove old validation styling
    requiredFields.forEach(selector => {
        $(selector).removeClass("empty-field");
    });

    // Check each required field
    requiredFields.forEach(selector => {
        const value = $(selector).val().trim();
        if (!value) {
            $(selector).addClass("empty-field");
            allFilled = false;
        }
    });

    if (!allFilled) {
        Swal.fire({
            icon: "warning",
            title: "Missing Financial Information",
            text: "Please fill in all required financial fields before submitting.",
            confirmButtonText: "OK"
        });
    }

    return allFilled;
}


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
});
