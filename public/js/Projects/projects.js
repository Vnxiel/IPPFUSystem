// Kapag ang buong page ay na-load na, awtomatikong kukunin ang mga detalye ng proyekto
document.addEventListener("DOMContentLoaded", function () {  
    fetchProjectDetails(); // Kunin ang mga detalye ng proyekto kapag nag-load ang page

    let currencyDivs = document.querySelectorAll(".currency-input"); // Hanapin ang lahat ng currency input fields

    currencyDivs.forEach(div => {
        div.setAttribute("contenteditable", "true"); // Ginagawang editable ang div para ma-typean ng user

        // Pinipigilan ang pagpasok ng hindi tamang characters (e.g. letters)
        div.addEventListener("keydown", function (event) {
            if (!isValidKey(event)) {
                event.preventDefault(); // Hindi papayagan ang hindi tamang key press
            }
        });

        // Inaayos ang format ng currency habang nagta-type ang user
        div.addEventListener("input", function () {
            formatCurrencyInput(this);
        });

        // Kapag inalis ng user ang focus sa input, maaayos ulit ang format ng currency
        div.addEventListener("blur", function () {
            formatCurrencyOnBlur(this);
        });

        // Kapag nag-focus ang user sa input, ibabalik sa numerong halaga para madaling i-edit
        div.addEventListener("focus", function () {
            restoreNumericValue(this);
        });

        // Sisiguraduhin na may default value ang currency input kahit walang laman
        if (div.textContent.trim() === "" || div.textContent.trim() === "Loading...") {
            div.textContent = "₱ 0.00";
        }
    });
});

// Function para i-format ang currency habang nagta-type ang user
function formatCurrencyInput(element) {
    let value = element.textContent.replace(/[^\d.]/g, ''); // Tatanggalin ang hindi numerong characters
    let formattedValue = parseFloat(value).toLocaleString('en-PH', { minimumFractionDigits: 2 });

    if (!isNaN(formattedValue)) {
        element.textContent = "₱ " + formattedValue;
    } else {
        element.textContent = "₱ 0.00"; // Kapag walang valid na input, default na ₱ 0.00
    }
}

// Function para i-format ang currency kapag nawala ang focus sa input
function formatCurrencyOnBlur(element) {
    let value = element.textContent.replace(/[^\d.]/g, ''); // Tatanggalin ang hindi numerong characters
    
    if (value === "" || isNaN(parseFloat(value))) {
        element.textContent = "₱ 0.00"; // Kapag walang valid na input, ibabalik sa ₱ 0.00
    } else {
        element.textContent = "₱ " + parseFloat(value).toLocaleString('en-PH', { minimumFractionDigits: 2 });
    }
}

// Function para ipakita ang raw numeric value kapag nag-focus sa input field
function restoreNumericValue(element) {
    let value = element.textContent.replace(/[^\d.]/g, ''); // Tatanggalin ang hindi numerong characters
    element.textContent = value; // Ipapakita lang ang numero para madaling i-edit
}

// Function na nagpapahintulot lang ng tamang key inputs (mga numero, decimal, at control keys)
function isValidKey(event) {
    const allowedKeys = ["Backspace", "ArrowLeft", "ArrowRight", "Delete", "Tab"];
    const isNumber = /^[0-9.]$/.test(event.key); // Titignan kung numero o decimal ang pinindot

    return isNumber || allowedKeys.includes(event.key); // Papayagan lang kung valid key
}

// Function para i-format ang petsa sa tamang format (YYYY-MM-DD)
function formatDate(dateString) {
    if (!dateString) return ""; // Kung walang petsa, ibalik bilang empty string
    let parts = dateString.split("-");
    if (parts.length === 3) {
        return `${parts[0]}-${parts[1]}-${parts[2]}`; // Siguraduhing tama ang format
    }
    return dateString; // Kung hindi valid, ibalik lang ang original string
}

// Function para i-format ang currency value bilang ₱ 1,234.56
function formatCurrency(value) {
    let number = parseFloat(value);
    return isNaN(number) ? "₱ 0.00" : `₱ ${number.toLocaleString('en-PH', { minimumFractionDigits: 2 })}`;
}

// Kapag pinindot ang "Edit Project" button, ipapakita ang modal para sa pag-edit
document.getElementById("editProjectBtn").addEventListener("click", function () {
    let projectModal = new bootstrap.Modal(document.getElementById("projectModal"));
    projectModal.show();
});

// Kapag binago ang project status, magpapakita o magtatago ng "Ongoing Status" field gamit ang animation
$(document).ready(function () {
    $('#editStatus').on('change', function () {
        $(this).val() === 'Ongoing' ? $('#ongoingStatusContainer').slideDown() : $('#ongoingStatusContainer').slideUp();
    });
});

// Kapag isinara ang modal, mare-reload ang page para makita ang mga pagbabago
document.addEventListener("DOMContentLoaded", function () {
    let projectModal = document.getElementById("projectModal");

    projectModal.addEventListener("hidden.bs.modal", function () {
        location.reload(); // Awtomatikong iri-reload ang page kapag na-close ang modal
    });
});


document.addEventListener("DOMContentLoaded", function () {
    const targetCompletionInput = document.getElementById("targetCompletion");
    const timeExtensionInput = document.getElementById("timeExtension");
    const revisedTargetInput = document.getElementById("revisedTargetCompletion");
    const completionDateInput = document.getElementById("completionDate");

    function updateDates() {
      const targetDateValue = targetCompletionInput.value;
      const timeExtension = parseInt(timeExtensionInput.value);

      if (targetDateValue && !isNaN(timeExtension) && timeExtension > 0) {
        const targetDate = new Date(targetDateValue);
        const revisedDate = new Date(targetDate);
        revisedDate.setDate(targetDate.getDate() + timeExtension);

        const formatted = revisedDate.toISOString().split('T')[0];

        revisedTargetInput.value = formatted;
        completionDateInput.value = formatted;

        revisedTargetInput.readOnly = true;
        completionDateInput.readOnly = true;
      } else {
        revisedTargetInput.readOnly = false;
        completionDateInput.readOnly = false;
      }
    }

    targetCompletionInput.addEventListener("change", updateDates);
    timeExtensionInput.addEventListener("input", updateDates);
  });

  document.addEventListener("DOMContentLoaded", function () {
    const contractDaysInput = document.getElementById("projectContractDays");
    const startDateInput = document.getElementById("officialStart");
    const completionDateInput = document.getElementById("targetCompletion");

    function calculateCompletionDate() {
      const startDateValue = startDateInput.value;
      const contractDays = parseInt(contractDaysInput.value);

      if (startDateValue && contractDays > 0) {
        const startDate = new Date(startDateValue);
        const completionDate = new Date(startDate);
        completionDate.setDate(startDate.getDate() + contractDays - 1); // minus 1 here
        const formatted = completionDate.toISOString().split('T')[0];
        completionDateInput.value = formatted;
      }
    }

    contractDaysInput.addEventListener("input", calculateCompletionDate);
    startDateInput.addEventListener("change", calculateCompletionDate);
  });

  document.addEventListener("DOMContentLoaded", function () {
    function validateDates(issuedId, receivedId, label) {
      const issued = document.getElementById(issuedId);
      const received = document.getElementById(receivedId);

      function checkDate() {
        const issuedDate = new Date(issued.value);
        const receivedDate = new Date(received.value);

        if (issued.value && received.value && receivedDate <= issuedDate) {
          Swal.fire({
            icon: 'error',
            title: `${label} Error`,
            text: 'Received date must be after the issued date.',
            confirmButtonColor: '#3085d6',
          });
          received.value = ""; // Clear invalid input
        }
      }

      issued.addEventListener("change", checkDate);
      received.addEventListener("change", checkDate);
    }

    validateDates("noaIssuedDate", "noaReceivedDate", "Notice of Award");
    validateDates("ntpIssuedDate", "ntpReceivedDate", "Notice to Proceed");
  });
