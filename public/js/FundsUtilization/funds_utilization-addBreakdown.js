
document.addEventListener("DOMContentLoaded", function () {
  const entryAmountInput = document.getElementById("entryAmount");
  const entries = [];
  const project_id = sessionStorage.getItem("project_id");

  entryAmountInput.addEventListener("input", function () {
    let value = this.value.replace(/,/g, '').replace(/[^0-9.]/g, '');
    const parts = value.split(".");
    if (parts.length > 2) {
      value = parts[0] + "." + parts.slice(1).join("");
    }
    if (!isNaN(value) && value !== '') {
      const [intPart, decimalPart] = value.split(".");
      let formatted = parseInt(intPart).toLocaleString();
      if (decimalPart !== undefined) {
        formatted += "." + decimalPart.slice(0, 2);
      }
      this.value = formatted;
    } else {
      this.value = '';
    }
  });

  const months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];

  const monthSelect = document.getElementById("entryMonth");
  months.forEach(month => {
    const opt = document.createElement("option");
    opt.value = month;
    opt.textContent = month;
    monthSelect.appendChild(opt);
  });

  monthSelect.value = months[new Date().getMonth()];

  function cleanMoney(value) {
    return value.replace(/[^0-9.]/g, '');
  }

  function parseAmount(value) {
    value = value?.toString().replace(/[₱,]/g, '').trim();
    return parseFloat(value) || 0;
  }
  

  function updateBalances() {
    updateEngineeringBalance();
    updateMqcBalance();
  }

  function renderTable() {
    const tbody = document.getElementById("entryTableBody");
    tbody.innerHTML = '';
    entries.forEach((entry, index) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${entry.type}</td>
        <td>${entry.name}</td>
        <td>${entry.month}</td>
        <td>${entry.period}</td>
        <td>₱${parseFloat(entry.amount).toLocaleString(undefined, {minimumFractionDigits:2})}</td>
        <td><button class="removeEntryBtn btn btn-sm btn-danger" data-index="${index}">Remove</button></td>
      `;
      tbody.appendChild(tr);
    });

    document.querySelectorAll(".removeEntryBtn").forEach(btn => {
      btn.addEventListener("click", function () {
        const idx = parseInt(this.getAttribute("data-index"));
        entries.splice(idx, 1);
        renderTable();
        updateBalances();
      });
    });

    updateBalances();
  }

  function isDuplicate(newEntry) {
    return entries.some(e =>
      e.type === newEntry.type &&
      e.name.toLowerCase() === newEntry.name.toLowerCase() &&
      e.month === newEntry.month &&
      e.period === newEntry.period
    );
  }

  document.getElementById("addEntryBtn").addEventListener("click", function () {
    updateAmountFields();
    const type = document.getElementById("entryType").value;
    const name = document.getElementById("entryName").value.trim();
    const month = document.getElementById("entryMonth").value;
    const period = document.getElementById("entryPeriod").value;
    const amountRaw = document.getElementById("entryAmount").value;
    const amount = parseFloat(cleanMoney(amountRaw));

    if (!type || !name || !month || !period || isNaN(amount) || amount <= 0) {
      return Swal.fire({ icon: "warning", title: "Please fill in all fields with valid data." });
    }

    const newEntry = { type, name, month, period, amount };

    if (isDuplicate(newEntry)) {
      return Swal.fire({ icon: "error", title: "Duplicate entry detected." });
    }

    entries.push(newEntry);
    renderTable();

    document.getElementById("entryName").value = '';
    document.getElementById("entryPeriod").value = '';
    document.getElementById("entryAmount").value = '';
  });

  document.getElementById("submitEntriesBtn").addEventListener("click", function () {
    if (entries.length === 0) {
      return Swal.fire({ icon: "warning", title: "No entries to submit." });
    }

    $.ajax({
      headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
      url: `/projects/fund-utilization/${project_id}/details`,
      method: "POST",
      data: { entries },
      success: function (response) {
        if (response.success) {
          Swal.fire({ icon: "success", title: "Entries submitted!" }).then(() => {
            entries.forEach(entry => {
              const tableId = entry.type === "engineering" ? "engineeringSubTable" : "mqcSubTable";
              const tbody = document.querySelector(`#${tableId} tbody`);
              const tr = document.createElement("tr");
              tr.innerHTML = `
                <td>${entry.name} (${entry.month} - ${entry.period})</td>
                <td data-amount="${entry.amount}">${parseFloat(entry.amount).toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
              `;
              tbody.appendChild(tr);
            });

            entries.length = 0;
            renderTable();
            updateBalances();
            $('#entryModal').modal('hide');
            updateAmountFields();
          });
        }
      },
      error: function (xhr) {
        Swal.fire({ icon: "error", title: "Submission failed", text: xhr.responseText || "An error occurred." });
      }
    });
  });

  function updateAmountFields() {
    const engineeringValue = document.getElementById('actual_engineering')?.value || '';
    const mqcValue = document.getElementById('actual_mqc')?.value || '';
    const contingencyValue = document.getElementById('actual_contingency')?.value || '';

    const amountEngInput = document.querySelector('input[name="amountEng"]');
    if (amountEngInput) amountEngInput.value = engineeringValue;

    const amountMqcInput = document.querySelector('input[name="amountMqc"]');
    if (amountMqcInput) amountMqcInput.value = mqcValue;

    const amountContingencyInput = document.querySelector('input[name="amountContingency"]');
    if (amountContingencyInput) amountContingencyInput.value = contingencyValue;

    updateBalances();
  }

  function updateEngineeringBalance() {
    const actual = parseAmount(document.getElementById('actual_engineering')?.value);
  
    // ✅ Only use the DOM values (already submitted ones)
    let used = 0;
    document.querySelectorAll('#engineeringSubTable tbody tr td[data-amount]').forEach(td => {
      used += parseFloat(td.dataset.amount) || 0;
    });
  
  
    const balance = actual - used;
  
    const balanceEl = document.getElementById('engineeringBalance');
    if (balanceEl) {
      balanceEl.textContent = `₱${balance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
      balanceEl.setAttribute('data-balance', balance);
    }
  
    const balanceForm = document.getElementById('formEngineeringBalance');
    if (balanceForm) {
      balanceForm.setAttribute('data-balance', balance);
      balanceForm.innerText = `₱${balance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
    }
  }
  

  function updateMqcBalance() {
    const actualRaw = document.getElementById('actual_mqc')?.value || '0';
    const actual = parseAmount(actualRaw); // properly removes commas and parses
    
    // Sum of amounts already shown in the DOM
    let used = 0;
    document.querySelectorAll('#mqcSubTable tbody tr td[data-amount]').forEach(td => {
      used += parseFloat(td.dataset.amount) || 0;
    });
  
    // Add pending entries that are not yet submitted
    const usedPending = entries.filter(e => e.type === 'mqc')
      .reduce((sum, e) => sum + parseAmount(e.amount), 0);
  
    const totalUsed = used + usedPending;
    const balance = actual - totalUsed;
  
    // Optional debug log
    console.log("MQC Balance Debug:", { actual, used, usedPending, totalUsed, balance });
  
    const balanceEl = document.getElementById('mqcBalance');
    if (balanceEl) {
      balanceEl.textContent = `₱${balance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
      balanceEl.setAttribute('data-balance', balance);
    }
  
    const balanceForm = document.getElementById('formMqcBalance');
    if (balanceForm) {
      balanceForm.setAttribute('data-balance', balance);
      balanceForm.innerText = `₱${balance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
    }
  }
  
  
  ['actual_engineering', 'actual_mqc'].forEach(id => {
    const input = document.getElementById(id);
    if (input) {
      input.addEventListener('input', () => {
        updateAmountFields();
      });
    }
  });

  updateAmountFields();
});
