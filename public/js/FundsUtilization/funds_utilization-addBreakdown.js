document.addEventListener("DOMContentLoaded", function () {
  const entries = [];
  const project_id = sessionStorage.getItem("project_id");

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
    value = value?.toString().replace(/,/g, '').trim();
    return parseFloat(value) || 0;
  }

  function updateBalances() {
    // Parse total allocated amounts
    const amountEng = parseAmount(document.getElementById("amountEng").value);
    const amountMqc = parseAmount(document.getElementById("amountMqc").value);
  
    // Sum up entry amounts for engineering and mqc separately
    const totalEng = entries
      .filter(entry => entry.type === "engineering")
      .reduce((sum, entry) => sum + parseAmount(entry.amount), 0);
  
    const totalMqc = entries
      .filter(entry => entry.type === "mqc")
      .reduce((sum, entry) => sum + parseAmount(entry.amount), 0);
  
    // Calculate balances
    const engBalance = amountEng - totalEng;
    const mqcBalance = amountMqc - totalMqc;
  
    // Display balances in the DOM
    document.getElementById("engineeringBalance").textContent = engBalance.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    document.getElementById("mqcBalance").textContent = mqcBalance.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
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
        <td>₱${parseFloat(entry.amount).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2})}</td>
        <td><button class="removeEntryBtn" data-index="${index}">Remove</button></td>
      `;
      tbody.appendChild(tr);
    });

    document.querySelectorAll(".removeEntryBtn").forEach(btn => {
      btn.addEventListener("click", function () {
        const idx = parseInt(this.getAttribute("data-index"));
        entries.splice(idx, 1);
        renderTable();
        updateBalances(); // ← Add this line after rendering the table
        updateEngineeringBalance();
        updateMqcBalance();
      });
    });

    updateEngineeringBalance();
    updateMqcBalance();
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
            entries.length = 0;
            renderTable(); // refresh entry table
            updateBalances(); // refresh balances
          
            // Reload DataTables
            if ($.fn.DataTable.isDataTable('#engineeringSubTable')) {
              $('#engineeringSubTable').DataTable().ajax.reload(null, false); // reload from server (if server-side), false = keep paging
            } else {
              $('#engineeringSubTable').DataTable().draw(); // fallback
            }
          
            if ($.fn.DataTable.isDataTable('#mqcSubTable')) {
              $('#mqcSubTable').DataTable().ajax.reload(null, false);
            } else {
              $('#mqcSubTable').DataTable().draw();
            }
          
            $('#entryModal').modal('hide');
            updateAmountFields();
          });    
        }      

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

    updateEngineeringBalance();
    updateMqcBalance();
  }
  function updateEngineeringBalance() {
    function parseAmount(value) {
      value = value?.toString().replace(/[₱,]/g, '').trim();
      return parseFloat(value) || 0;
    }
    const allotted = parseAmount(document.querySelector('input[name="amountEng"]')?.value);

    // Sum up all visible engineering amounts rendered in the DOM table
    let used = 0;
    document.querySelectorAll('#engineeringSubTable tbody tr td[data-amount]').forEach(td => {
      used += parseFloat(td.dataset.amount) || 0;
    });

  
    const balance = allotted - used;
  
    console.log(`actual_engineering value: ${allotted}`);
    console.log(`Engineering used from DOM table: ${used}`);
    console.log(`Engineering Balance Calculation -> Allotted: ${allotted}, Used: ${used}, Balance: ${balance}`);
  
    const balanceEl = document.getElementById('engineeringBalance');
    if (balanceEl) {
      balanceEl.textContent = `Balance: ₱${balance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
    }
  }
  
  function updateMqcBalance() {
    function parseAmount(value) {
      value = value?.toString().replace(/[₱,]/g, '').trim();
      return parseFloat(value) || 0;
    }
    const allotted = parseAmount(document.querySelector('input[name="amountMqc"]')?.value);

    // Sum up all visible engineering amounts rendered in the DOM table
    let used = 0;
    document.querySelectorAll('#mqcSubTable tbody tr td[data-amount]').forEach(td => {
      used += parseFloat(td.dataset.amount) || 0;
    });

  
    const balance = allotted - used;
  
    console.log(`actual_engineering value: ${allotted}`);
    console.log(`Engineering used from DOM table: ${used}`);
    console.log(`Engineering Balance Calculation -> Allotted: ${allotted}, Used: ${used}, Balance: ${balance}`);
  
    const balanceEl = document.getElementById('mqcBalance');
    if (balanceEl) {
      balanceEl.textContent = `Balance: ₱${balance.toLocaleString(undefined, { minimumFractionDigits: 2 })}`;
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

  function initializeSubTables() {
    if ($('#engineeringSubTable').length && !$.fn.DataTable.isDataTable('#engineeringSubTable')) {
      $('#engineeringSubTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        order: [[0, 'asc']]
      });
    }

    if ($('#mqcSubTable').length && !$.fn.DataTable.isDataTable('#mqcSubTable')) {
      $('#mqcSubTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        order: [[0, 'asc']]
      });
    }
  }

  initializeSubTables();

  $('#engDetails').on('shown.bs.collapse', function () {
    if ($.fn.DataTable.isDataTable('#engineeringSubTable')) {
      $('#engineeringSubTable').DataTable().columns.adjust().draw();
      updateEngineeringBalance();
    }
  });

  $('#mqcDetails').on('shown.bs.collapse', function () {
    if ($.fn.DataTable.isDataTable('#mqcSubTable')) {
      $('#mqcSubTable').DataTable().columns.adjust().draw();
      updateMqcBalance();
    }
  });
});
