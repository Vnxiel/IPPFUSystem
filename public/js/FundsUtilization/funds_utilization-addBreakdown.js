
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

  function getOrigFunds(type) {
    const id = type === 'engineering' ? 'orig_engineering' : 'orig_mqc';
    const el = document.getElementById(id);
    return parseAmount(el?.value || '0');
  }
  
  function getActualFunds(type) {
    const id = type === 'engineering' ? 'actual_engineering' : 'actual_mqc';
    const el = document.getElementById(id);
    return parseAmount(el?.value || '0');
  }
  
  function getPendingTotal(type) {
    return entries
      .filter(e => e.type === type)
      .reduce((sum, e) => sum + parseAmount(e.amount), 0);
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
      <td>${entry.date}</td>
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
    const date = document.getElementById("entryDate").value;
    const period = document.getElementById("entryPeriod").value;
    const amountRaw = document.getElementById("entryAmount").value;
    const amount = parseFloat(cleanMoney(amountRaw));
  
    if (!type || !name || !month || !period || !date || isNaN(amount) || amount <= 0) {
      return Swal.fire({ icon: "warning", title: "Please fill in all fields with valid data." });
    }
  
    const orig = getOrigFunds(type);
    const actual = getActualFunds(type);
    const pending = getPendingTotal(type);
    const available = orig - actual - pending;
  
    if (amount > available) {
      return Swal.fire({
        icon: "error",
        title: `Insufficient ${type.toUpperCase()} funds.`,
        text: `You only have ₱${available.toLocaleString(undefined, { minimumFractionDigits: 2 })} remaining.`
      });
    }
  
    const newEntry = { type, name, month, date, period, amount };
  
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
  
    const totalByType = {
      engineering: getPendingTotal('engineering'),
      mqc: getPendingTotal('mqc')
    };
  
    // Validate funds before submitting
    for (const type of ['engineering', 'mqc']) {
      const orig = getOrigFunds(type);
      const actual = getActualFunds(type);
      const pending = totalByType[type];
      if ((actual + pending) > orig) {
        return Swal.fire({
          icon: "error",
          title: `${type.toUpperCase()} limit exceeded.`,
          text: `You only have ₱${(orig - actual).toLocaleString(undefined, { minimumFractionDigits: 2 })} remaining.`
        });
      }
    }
  
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        "Content-Type": "application/json"
      },
      url: `/projects/fund-utilization/${project_id}/details`,
      method: "POST",
      data: JSON.stringify({ entries }),
      success: function (response) {
        if (response.success) {
          Swal.fire({ icon: "success", title: "Entries submitted!" }).then(() => {
            entries.forEach(entry => {
              const tableId = entry.type === "engineering" ? "engineeringSubTable" : "mqcSubTable";
              const tbody = document.querySelector(`#${tableId} tbody`);
              const tr = document.createElement("tr");
              tr.innerHTML = `
                <td>${entry.date}</td>  
                <td>${entry.name} - ${entry.period}</td>
                <td class="text-end" data-amount="${entry.amount}">₱${parseFloat(entry.amount).toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
              `;
              tbody.appendChild(tr);
    
              const actualInputId = entry.type === 'engineering' ? 'actual_engineering' : 'actual_mqc';
              const actualInput = document.getElementById(actualInputId);
              const currentActual = parseAmount(actualInput.value);
              const newActual = currentActual + parseAmount(entry.amount);
              actualInput.value = newActual.toLocaleString(undefined, { minimumFractionDigits: 2 });
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
    const orig = parseAmount(document.getElementById('orig_engineering')?.value);
  
    const actual = parseAmount(document.getElementById('actual_engineering')?.value);

    const balance = orig - actual;
  
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
    
    const origRaw = document.getElementById('orig_mqc')?.value || '0';
    const orig = parseAmount(origRaw); // properly removes commas and parses

    const actualRaw = document.getElementById('actual_mqc')?.value || '0';
    const actual = parseAmount(actualRaw); // properly removes commas and parses

    const balance = orig - actual;
  
    // Optional debug log
    console.log("MQC Balance Debug:", { actual, orig, balance });
  
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
