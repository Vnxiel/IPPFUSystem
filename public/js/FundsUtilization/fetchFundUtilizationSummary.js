 // Handle Add Status button click
 $(document).on("click", "#fundSummaryBtn", function () {
    const project_id = sessionStorage.getItem("project_id");

    if (!project_id) {
        return Swal.fire({ icon: "error", title: "Missing Info", text: "Cannot load project." });
    }

    // Show the Add Status Modal
    $("#viewFundSummaryModal").modal("show");
});

// Handle Fund Summary button click
$(document).on("click", "#fundSummaryBtn", function () {
    const project_id = sessionStorage.getItem("project_id");
  
    if (!project_id) {
      return Swal.fire({
        icon: "error",
        title: "Missing Info",
        text: "Cannot load project."
      });
    }
  
    // Load data into modal and show it
    loadFundSummary(project_id);
    $("#viewFundSummaryModal").modal("show");
  });
  
  function loadFundSummary(project_id) {
    fetch(`/fund-utilization/${project_id}`)
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          const fu = data.data || {};
          const vos = data.variationOrders || [];
          const summary = fu.summary || {};
          const funds = fu || {};
  
          const fields = ['abc', 'contract_amount', 'engineering', 'mqc', 'bid', 'contingency', 'appropriation'];
          fields.forEach(field => {
            document.getElementById(`orig_${field}_view`).textContent = numberFormat(funds[`orig_${field}`]);
            document.getElementById(`actual_${field}_view`).textContent = numberFormat(funds[`actual_${field}`]);
          });
  
          const vo = vos.find(v => v.vo_number === 1) || {};
          fields.forEach(field => {
            document.getElementById(`vo_${field}_view`).textContent = numberFormat(vo[`vo_${field}`]);
          });
  
          document.getElementById('percentMobi_view').textContent = `${summary.percentMobi ?? '0.00'}%`;
          document.getElementById('dateMobi_view').textContent = summary.mobilization?.date || '-';
          document.getElementById('amountMobi_view').textContent = numberFormat(summary.mobilization?.amount);
          document.getElementById('remMobi_view').textContent = summary.mobilization?.remarks || '-';
  
          // Insert partial billings dynamically
          const billings = fu.partial_billings || [];
          const billingContainer = document.getElementById('partialBillingsRows');
          billingContainer.innerHTML = ''; // clear previous
  
          billings.forEach((billing, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${index + 1}st Partial Billing</td>
              <td>${billing.date || '-'}</td>
              <td>${numberFormat(billing.amount)}</td>
              <td>${billing.remarks || '-'}</td>
            `;
            billingContainer.appendChild(row);
          });
  
          document.getElementById('dateFinal_view').textContent = summary.final?.date || '-';
          document.getElementById('amountFinal_view').textContent = numberFormat(summary.final?.amount);
          document.getElementById('remFinal_view').textContent = summary.final?.remarks || '-';
  
          document.getElementById('dateEng_view').textContent = summary.engineering?.date || '-';
          document.getElementById('amountEng_view').textContent = numberFormat(summary.engineering?.amount);
          document.getElementById('remEng_view').textContent = summary.engineering?.remarks || '-';
  
          document.getElementById('dateMqc_view').textContent = summary.mqc?.date || '-';
          document.getElementById('amountMqc_view').textContent = numberFormat(summary.mqc?.amount);
          document.getElementById('remMqc_view').textContent = summary.mqc?.remarks || '-';
  
          document.getElementById('amountTotal_view').textContent = numberFormat(summary.totalExpenditures?.amount);
          document.getElementById('remTotal_view').textContent = summary.totalExpenditures?.remarks || '-';
  
          document.getElementById('amountSavings_view').textContent = numberFormat(summary.totalSavings?.amount);
          document.getElementById('remSavings_view').textContent = summary.totalSavings?.remarks || '-';
        }
      })
      .catch(error => console.error('Error loading fund summary:', error));
  }
    
  function numberFormat(value) {
    const num = parseFloat(value);
    return isNaN(num) ? '0.00' : num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }
  
