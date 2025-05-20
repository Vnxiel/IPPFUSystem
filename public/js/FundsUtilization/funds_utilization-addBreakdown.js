document.addEventListener("DOMContentLoaded", function () {
    const entries = [];
    const project_id = sessionStorage.getItem("project_id");
  
    const months = [
      "January", "February", "March", "April", "May", "June",
      "July", "August", "September", "October", "November", "December"
    ];
  
    // Populate month dropdowns
    const monthSelect = document.getElementById("entryMonth");
    months.forEach(month => {
      const opt = document.createElement("option");
      opt.value = month;
      opt.textContent = month;
      monthSelect.appendChild(opt);
    });
  
    // Set default to current month
    monthSelect.value = months[new Date().getMonth()];
  
    function cleanMoney(value) {
      return value.replace(/[^0-9.]/g, '');
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
  
      // Attach remove event listeners
      document.querySelectorAll(".removeEntryBtn").forEach(btn => {
        btn.addEventListener("click", function () {
          const idx = parseInt(this.getAttribute("data-index"));
          entries.splice(idx, 1);
          renderTable();
          updateEngineeringBalance();
          updateMqcBalance();
        });
      });
    }
  
    function isDuplicate(newEntry) {
      return entries.some(e =>
        e.type === newEntry.type &&
        e.name.toLowerCase() === newEntry.name.toLowerCase() &&
        e.month === newEntry.month &&
        e.period === newEntry.period
      );
    }
  
    // Add Entry to Array
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
  
      // Get the allotted amount for Engineering or MQC
      const allowedEngineering = parseFloat(cleanMoney(document.getElementById("engineeringBalance")?.value || "0"));
      const allowedMQC = parseFloat(cleanMoney(document.getElementById("mqcBalance")?.value || "0"));
  
      const engSum = entries
        .filter(e => e.type === 'Engineering')
        .reduce((acc, cur) => acc + parseFloat(cur.amount), 0);
  
      const mqcSum = entries
        .filter(e => e.type === 'MQC')
        .reduce((acc, cur) => acc + parseFloat(cur.amount), 0);
  
      if (type === "Engineering" && (engSum + amount) > allowedEngineering) {
        return Swal.fire({
          icon: "warning",
          title: "Engineering Funds Consumed",
          text: "You cannot add more Engineering entries. Allotted funds have been consumed."
        });
      }
  
      if (type === "MQC" && (mqcSum + amount) > allowedMQC) {
        return Swal.fire({
          icon: "warning",
          title: "MQC Funds Consumed",
          text: "You cannot add more MQC entries. Allotted funds have been consumed."
        });
      }
  
      // Passed all checks
      entries.push(newEntry);
      renderTable();
  
      updateEngineeringBalance();
      updateMqcBalance();
  
      // Clear inputs
      document.getElementById("entryName").value = '';
      document.getElementById("entryPeriod").value = '';
      document.getElementById("entryAmount").value = '';
    });
  
    // Submit All
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
              renderTable();
              $('#entryModal').modal('hide');
              updateEngineeringBalance();
              updateMqcBalance();
  
              // Redraw DataTables if initialized
              if ($.fn.DataTable.isDataTable('#engineeringSubTable')) {
                $('#engineeringSubTable').DataTable().clear().draw();
              }
              if ($.fn.DataTable.isDataTable('#mqcSubTable')) {
                $('#mqcSubTable').DataTable().clear().draw();
              }
            });
          } else {
            Swal.fire({ icon: "error", title: response.message || "Submission failed." });
          }
        }
      });
    });
  
    // Initialize DataTables on page load
    initializeSubTables();
  
    // Redraw or reinitialize DataTable when breakdown is shown for Engineering
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
  
    function parseAmount(value) {
      value = value?.toString().replace(/,/g, '').trim(); // Remove commas
      return parseFloat(value) || 0;
    }
  
    // Update amountEng, amountMqc, amountContingency from actual_* inputs
    const updateAmountFields = () => {
      const engineeringValue = document.getElementById('actual_engineering')?.value || '';
      const mqcValue = document.getElementById('actual_mqc')?.value || '';
      const contingencyValue = document.getElementById('actual_contingency')?.value || '';
  
      const amountEngInput = document.querySelector('input[name="amountEng"]');
      if (amountEngInput) amountEngInput.value = engineeringValue;
  
      const amountMqcInput = document.querySelector('input[name="amountMqc"]');
      if (amountMqcInput) amountMqcInput.value = mqcValue;
  
      const amountContingencyInput = document.querySelector('input[name="amountContingency"]');
      if (amountContingencyInput) amountContingencyInput.value = contingencyValue;
  
    };
  
    ['actual_engineering', 'actual_mqc', 'actual_contingency'].forEach(id => {
      const el = document.getElementById(id);
      if (el) {
        el.addEventListener('input', updateAmountFields);
      }
    });
  
    updateAmountFields();
  
    function updateEngineeringBalance() {
      const allotted = parseAmount(document.getElementById('amountEng')?.value);
      const used = entries
        .filter(e => e.type === 'Engineering')
        .reduce((acc, e) => acc + parseAmount(e.amount), 0);
  
      const balance = allotted - used;
      const balanceEl = document.getElementById('engineeringBalance');
      if (balanceEl) balanceEl.textContent = `Balance: ₱${balance.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
    }
  
    function updateMqcBalance() {
      const allotted = parseAmount(document.getElementById('amountMqc')?.value);
      const used = entries
        .filter(e => e.type === 'MQC')
        .reduce((acc, e) => acc + parseAmount(e.amount), 0);
  
      const balance = allotted - used;
      const balanceEl = document.getElementById('mqcBalance');
      if (balanceEl) balanceEl.textContent = `Balance: ₱${balance.toLocaleString(undefined, {minimumFractionDigits: 2})}`;
    }
  
    function initializeSubTables() {
      // Initialize Engineering sub table if it exists and not yet initialized
      if ($('#engineeringSubTable').length && !$.fn.DataTable.isDataTable('#engineeringSubTable')) {
        $('#engineeringSubTable').DataTable({
          paging: true,
          searching: true,
          ordering: true,
          order: [[0, 'asc']]
        });
      }
  
      // Initialize MQC sub table if it exists and not yet initialized
      if ($('#mqcSubTable').length && !$.fn.DataTable.isDataTable('#mqcSubTable')) {
        $('#mqcSubTable').DataTable({
          paging: true,
          searching: true,
          ordering: true,
          order: [[0, 'asc']]
        });
      }
    }
  
  });
  