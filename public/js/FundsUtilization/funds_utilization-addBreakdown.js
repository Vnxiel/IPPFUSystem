function updateEngineeringTotalFromTable() {
  let total = 0;
  document.querySelectorAll('#engineeringSubTable tbody td[data-amount]').forEach(td => {
    const rawAmount = td.getAttribute('data-amount')?.replace(/,/g, '');
    const parsed = parseFloat(rawAmount);
    total += isNaN(parsed) ? 0 : parsed;
  });

  const totalEngInput = document.querySelector('input[name="TotalEng"]');
  if (totalEngInput) {
    totalEngInput.value = total.toLocaleString('en-US', { style: 'currency', currency: 'PHP' });
  }
}

function updateMqcTotalFromTable() {
  let total = 0;
  document.querySelectorAll('#mqcSubTable tbody td[data-amount]').forEach(td => {
    const rawAmount = td.getAttribute('data-amount')?.replace(/,/g, '');
    const parsed = parseFloat(rawAmount);
    total += isNaN(parsed) ? 0 : parsed;
  });

  const totalMqcInput = document.querySelector('input[name="TotalMqc"]');
  if (totalMqcInput) {
    totalMqcInput.value = total.toLocaleString('en-US', { style: 'currency', currency: 'PHP' });
  }
}

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
        <td>${entry.date_from} to ${entry.date_to}</td>
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
      e.date_from === newEntry.date_from &&
      e.date_to === newEntry.date_to
    );
  }

  document.getElementById("addEntryBtn").addEventListener("click", function () {
    updateAmountFields();
    const type = document.getElementById("entryType").value;
    const name = document.getElementById("entryName").value.trim();
    const month = document.getElementById("entryMonth").value;
    const date_from = document.getElementById("entryDateFrom").value;
    const date_to = document.getElementById("entryDateTo").value;
    const amountRaw = document.getElementById("entryAmount").value;
    const amount = parseFloat(cleanMoney(amountRaw));
    const period = `${date_from} - ${date_to}`;
    
    // Debug log for missing/invalid fields
    console.log({
      typeMissing: !type,
      nameMissing: !name,
      monthMissing: !month,
      dateFromMissing: !date_from,
      dateToMissing: !date_to,
      amountInvalid: isNaN(amount) || amount <= 0
    });
    
    if (!type || !name || !month || !date_from || !date_to || isNaN(amount) || amount <= 0) {
      return Swal.fire({ icon: "warning", title: "Please fill in all fields with valid data." });
    }
    
    const orig = getOrigFunds(type);
    const actual = getActualFunds(type);
    const pending = getPendingTotal(type);
    const available = orig - actual - pending;


    const newEntry = { type, name, month, date_from, date_to, period, amount };

    if (isDuplicate(newEntry)) {
      return Swal.fire({ icon: "error", title: "Duplicate entry detected." });
    }

    entries.push(newEntry);
    renderTable();

    document.getElementById("entryName").value = '';
    document.getElementById("entryDateFrom").value = '';
    document.getElementById("entryDateTo").value = '';
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

    // for (const type of ['engineering', 'mqc']) {
    //   const orig = getOrigFunds(type);
    //   const actual = getActualFunds(type);
    //   const pending = totalByType[type];
    //   if ((actual + pending) > orig) {
    //     return Swal.fire({
    //       icon: "error",
    //       title: `${type.toUpperCase()} limit exceeded.`,
    //       text: `You only have ₱${(orig - actual).toLocaleString(undefined, { minimumFractionDigits: 2 })} remaining.`
    //     });
    //   }
    // }

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
                <td>${entry.date_from} to ${entry.date_to}</td>  
                <td>${entry.name} - ${entry.month}</td>
                <td class="text-end" data-amount="${entry.amount}">₱${parseFloat(entry.amount).toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
              `;
              tbody.appendChild(tr);

              const actualInputId = entry.type === 'engineering' ? 'actual_engineering' : 'actual_mqc';
              const actualInput = document.getElementById(actualInputId);
              const currentActual = parseAmount(actualInput.value);
              const newActual = currentActual + parseAmount(entry.amount);
              actualInput.value = newActual.toLocaleString(undefined, { minimumFractionDigits: 2 });
            });

              updateEngineeringTotalFromTable();
              updateMqcTotalFromTable();

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
    const engineeringValue = parseAmount(document.getElementById('actual_engineering')?.value || '0');
    const mqcValue = parseAmount(document.getElementById('actual_mqc')?.value || '0');
    const contingencyValue = parseAmount(document.getElementById('actual_contingency')?.value || '0');
  
    const amountEngInput = document.querySelector('input[name="amountEng"]');
    if (amountEngInput) {
      amountEngInput.value = engineeringValue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
  
    const amountMqcInput = document.querySelector('input[name="amountMqc"]');
    if (amountMqcInput) {
      amountMqcInput.value = mqcValue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
  
    const amountContingencyInput = document.querySelector('input[name="amountContingency"]');
    if (amountContingencyInput) {
      amountContingencyInput.value = contingencyValue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
  
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
    const origRaw = document.getElementById('orig_mqc')?.value || '0.00';
    const orig = parseAmount(origRaw);
    const actualRaw = document.getElementById('actual_mqc')?.value || '0.00';
    const actual = parseAmount(actualRaw);
    const balance = orig - actual;

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
