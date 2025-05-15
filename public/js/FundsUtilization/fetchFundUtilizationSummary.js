$(document).ready(function () {
  const project_id = sessionStorage.getItem("project_id");

  if (project_id) {
    loadFundSummary(project_id);
  } else {
    console.warn("No project_id found. Skipping fund summary.");
  }
});

function loadFundSummary(project_id) {
  fetch(`/fund-utilization/${project_id}`)
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        const fu = data.data || {};
        const vos = (data.variationOrders || []).sort((a, b) => a.vo_number - b.vo_number); // 🔁 Sort VO columns
        const summary = fu.summary || {};
        const funds = fu || {};

        const fields = ['abc', 'contract_amount', 'engineering', 'mqc', 'bid', 'contingency', 'appropriation'];

        // === Original and Actual Values ===
        fields.forEach(field => {
          document.getElementById(`orig_${field}_view`).textContent = numberFormat(funds[`orig_${field}`]);
          document.getElementById(`actual_${field}_view`).textContent = numberFormat(funds[`actual_${field}`]);
        });

        // === Replace VO Placeholder Cell with First TH ===
        const headerRow = document.querySelector('#costBreakdownTable thead tr');
        const voPlaceholder = document.getElementById("voHeadersPlaceholder");
        const actualTh = voPlaceholder.nextSibling;
        voPlaceholder.remove();

        vos.sort((a, b) => a.vo_number - b.vo_number); // Ensure correct order

        // Insert each VO header in order before the 'Actual' column
        vos.forEach(vo => {
          const th = document.createElement("th");
          th.textContent = `V.O. ${vo.vo_number}`;
          headerRow.insertBefore(th, actualTh);
        });

        // Insert VO data cells row-by-row in correct order
        fields.forEach(field => {
          const placeholderCell = document.querySelector(`.vo_cells_row[data-field="${field}"]`);
          const row = placeholderCell.parentNode;
          const actualCell = placeholderCell.nextSibling;
          placeholderCell.remove();

          vos.forEach(vo => {
            const td = document.createElement("td");
            td.textContent = numberFormat(vo[`vo_${field}`]);
            row.insertBefore(td, actualCell);
          });
        });


        // === Mobilization Section ===
        document.getElementById('percentMobi_view').textContent = `${summary.mobilization?.percent ?? '0.00'}%`;
        document.getElementById('dateMobi_view').textContent = summary.mobilization?.date || '-';
        document.getElementById('amountMobi_view').textContent = numberFormat(summary.mobilization?.amount);
        document.getElementById('remMobi_view').textContent = summary.mobilization?.remarks || '-';

        // === Partial Billings ===
        const billings = fu.partial_billings || [];
        const billingContainer = document.getElementById('partialBillingsRows');
        billingContainer.innerHTML = '';
        billings.forEach((billing, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>${index + 1}${getOrdinal(index + 1)} Partial Billing</td>
            <td>${billing.date || '-'}</td>
            <td>${numberFormat(billing.amount)}</td>
            <td>${billing.remarks || '-'}</td>
          `;
          billingContainer.appendChild(row);
        });

        // === Final Billing ===
        document.getElementById('dateFinal_view').textContent = summary.final?.date || '-';
        document.getElementById('amountFinal_view').textContent = numberFormat(summary.final?.amount);
        document.getElementById('remFinal_view').textContent = summary.final?.remarks || '-';

        // === Engineering ===
        document.getElementById('dateEng_view').textContent = summary.engineering?.date || '-';
        document.getElementById('amountEng_view').textContent = numberFormat(summary.engineering?.amount);
        document.getElementById('remEng_view').textContent = summary.engineering?.remarks || '-';

        // === MQC ===
        document.getElementById('dateMqc_view').textContent = summary.mqc?.date || '-';
        document.getElementById('amountMqc_view').textContent = numberFormat(summary.mqc?.amount);
        document.getElementById('remMqc_view').textContent = summary.mqc?.remarks || '-';

        // === Totals ===
        document.getElementById('amountTotal_view').textContent = numberFormat(summary.totalExpenditures?.amount);
        document.getElementById('remTotal_view').textContent = summary.totalExpenditures?.remarks || '-';

        document.getElementById('amountSavings_view').textContent = numberFormat(summary.totalSavings?.amount);
        document.getElementById('remSavings_view').textContent = summary.totalSavings?.remarks || '-';

      } else {
        console.warn("Fund summary not found.");
      }
    })
    .catch(error => {
      console.error('Error loading fund summary:', error);
    });
}

function numberFormat(value) {
  const num = parseFloat(value);
  return isNaN(num) ? '-' : num.toLocaleString('en-PH', {
    style: 'currency',
    currency: 'PHP',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  });
}

function getOrdinal(n) {
  const s = ["th", "st", "nd", "rd"],
        v = n % 100;
  return s[(v - 20) % 10] || s[v] || s[0];
}
