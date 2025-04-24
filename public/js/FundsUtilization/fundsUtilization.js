
document.addEventListener('DOMContentLoaded', function () {
  const fundModal = document.getElementById('addProjectFundUtilization');

  fundModal.addEventListener('show.bs.modal', function () {
    const project_id = sessionStorage.getItem("project_id");
    if (project_id) {
      loadFundUtilization(project_id);
    }
  });

  let voCount = parseInt(document.getElementById('voCount').value) || 1;
  let billingCount = 1;

  document.getElementById('submitFundsUtilization').addEventListener('click', function () {
    const project_id = sessionStorage.getItem("project_id");
    if (!project_id) return;

    // Get latest VO count
    voCount = parseInt(document.getElementById('voCount').value) || 1;

    const variation_orders = [];
    for (let i = 1; i <= voCount; i++) {
      variation_orders.push({
        vo_number: i,
        vo_abc: document.getElementById(`vo_abc_${i}`)?.value || '',
        vo_contract_amount: document.getElementById(`vo_contract_amount_${i}`)?.value || '',
        vo_engineering: document.getElementById(`vo_engineering_${i}`)?.value || '',
        vo_mqc: document.getElementById(`vo_mqc_${i}`)?.value || '',
        vo_bid: document.getElementById(`vo_bid_${i}`)?.value || '',
        vo_contingency: document.getElementById(`vo_contingency_${i}`)?.value || '',
        vo_appropriation: document.getElementById(`vo_appropriation_${i}`)?.value || ''
      });
    }

    const formData = {
      project_id,
      orig_abc: document.getElementById('orig_abc').value,
      orig_contract_amount: document.getElementById('orig_contract_amount').value,
      orig_engineering: document.getElementById('orig_engineering').value,
      orig_mqc: document.getElementById('orig_mqc').value,
      orig_bid: document.getElementById('orig_bid').value,
      orig_contingency: document.getElementById('orig_contingency').value,
      orig_appropriation: document.getElementById('orig_appropriation').value,
      variation_orders,
      actual_abc: document.getElementById('actual_abc').value,
      actual_contract_amount: document.getElementById('actual_contract_amount').value,
      actual_engineering: document.getElementById('actual_engineering').value,
      actual_mqc: document.getElementById('actual_mqc').value,
      actual_bid: document.getElementById('actual_bid').value,
      actual_contingency: document.getElementById('actual_contingency').value,
      actual_appropriation: document.getElementById('actual_appropriation').value,
      summary: {
        mobilization: {
          date: document.querySelector('[name="dateMobi"]').value,
          amount: document.querySelector('[name="amountMobi"]').value,
          remarks: document.querySelector('[name="remMobi"]').value
        },
        final: {
          date: document.querySelector('[name="dateFinal"]').value,
          amount: document.querySelector('[name="amountFinal"]').value,
          remarks: document.querySelector('[name="remFinal"]').value
        },
        engineering: {
          date: document.querySelector('[name="dateEng"]').value,
          amount: document.querySelector('[name="amountEng"]').value,
          remarks: document.querySelector('[name="remEng"]').value
        },
        mqc: {
          date: document.querySelector('[name="dateMqc"]').value,
          amount: document.querySelector('[name="amountMqc"]').value,
          remarks: document.querySelector('[name="remMqc"]').value
        },
        totalExpenditures: {
          amount: document.querySelector('[name="amountTotal"]').value,
          remarks: document.querySelector('[name="remTotal"]').value
        },
        totalSavings: {
          amount: document.querySelector('[name="amountSavings"]').value,
          remarks: document.querySelector('[name="remSavings"]').value
        }
      },
      partialBillings: []
    };

    document.querySelectorAll('#billingsTableBody tr').forEach((row, i) => {
      formData.partialBillings.push({
        date: row.querySelector(`[name="datePart${i + 1}"]`)?.value || '',
        amount: row.querySelector(`[name="amountPart${i + 1}"]`)?.value || '',
        remarks: row.querySelector(`[name="remPart${i + 1}"]`)?.value || ''
      });
    });

    fetch('/fund-utilization/store', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(formData)
    })
    .then(res => res.json())
    .then(result => {
      if (result.status === 'success') {
        Swal.fire('Success', 'Fund Utilization saved successfully!', 'success').then(() => location.reload());
      } else {
        Swal.fire('Failed', result.message || 'Failed to save fund utilization.', 'error');
      }
    })
    .catch(error => {
      console.error('Error saving fund utilization:', error);
      Swal.fire('Error', 'An error occurred while saving fund utilization.', 'error');
    });
  });
});

// Add this global so it works outside the event listener
function addVOFields() {
  voCount++;
  document.getElementById('voCount').value = voCount;

  const table = document.querySelector('.table.table-bordered');
  const headerRow = table.querySelector('thead tr');
  const newHeader = document.createElement('th');
  newHeader.textContent = `V.O. ${voCount}`;
  headerRow.insertBefore(newHeader, headerRow.children[headerRow.children.length - 1]);

  const rowNames = [
    'abc', 'contract_amount', 'engineering',
    'mqc', 'contingency', 'bid', 'appropriation'
  ];

  const rows = table.querySelectorAll('tbody tr');

  rowNames.forEach((name, index) => {
    const cell = document.createElement('td');
    cell.innerHTML = `<input type="text" class="form-control amount-input" id="vo_${name}_${voCount}" name="vo_${name}_${voCount}" placeholder="₱0.00">`;
    const cells = rows[index].querySelectorAll('td');
    rows[index].insertBefore(cell, cells[cells.length - 1]);
  });

  
}

document.querySelectorAll('.amount-input').forEach(input => {
  input.addEventListener('input', function () {
    // Allow: numbers, comma, dot, and peso sign
    this.value = this.value.replace(/[^\d.,₱]/g, '');
  });
});

function removeLastVOFields() {
  if (voCount > 1) {
    const table = document.querySelector('.table.table-bordered');
    const headerRow = table.querySelector('thead tr');
    headerRow.removeChild(headerRow.children[headerRow.children.length - 2]);

    const rows = table.querySelectorAll('tbody tr');
    for (let i = 0; i < 7; i++) {
      const cells = rows[i].querySelectorAll('td');
      rows[i].removeChild(cells[cells.length - 2]);
    }

    voCount--;
    document.getElementById('voCount').value = voCount;
  }
}

function loadFundUtilization(project_id) {
  fetch(`/fund-utilization/${project_id}`)
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        const fu = data.data || {};
        const vos = data.variationOrders || [];

        document.getElementById('projectTitleFU').value = data.projectTitle ?? '';
        document.getElementById('orig_abc').value = fu.orig_abc ?? '';
        document.getElementById('orig_contract_amount').value = fu.orig_contract_amount ?? '';
        document.getElementById('orig_engineering').value = fu.orig_engineering ?? '';
        document.getElementById('orig_mqc').value = fu.orig_mqc ?? '';
        document.getElementById('orig_bid').value = fu.orig_bid ?? '';
        document.getElementById('orig_contingency').value = fu.orig_contingency ?? '';
        document.getElementById('orig_appropriation').value = fu.orig_appropriation ?? '';

        document.getElementById('actual_abc').value = fu.actual_abc ?? '';
        document.getElementById('actual_contract_amount').value = fu.actual_contract_amount ?? '';
        document.getElementById('actual_engineering').value = fu.actual_engineering ?? '';
        document.getElementById('actual_mqc').value = fu.actual_mqc ?? '';
        document.getElementById('actual_bid').value = fu.actual_bid ?? '';
        document.getElementById('actual_contingency').value = fu.actual_contingency ?? '';
        document.getElementById('actual_appropriation').value = fu.actual_appropriation ?? '';

        let maxVO = 1;
        vos.forEach(vo => {
          maxVO = Math.max(maxVO, vo.vo_number);
        });

        for (let i = voCount + 1; i <= maxVO; i++) {
          addVOFields();
        }

        voCount = maxVO;
        document.getElementById('voCount').value = voCount;

        vos.forEach(vo => {
          document.getElementById(`vo_abc_${vo.vo_number}`).value = vo.vo_abc ?? '';
          document.getElementById(`vo_contract_amount_${vo.vo_number}`).value = vo.vo_contract_amount ?? '';
          document.getElementById(`vo_engineering_${vo.vo_number}`).value = vo.vo_engineering ?? '';
          document.getElementById(`vo_mqc_${vo.vo_number}`).value = vo.vo_mqc ?? '';
          document.getElementById(`vo_bid_${vo.vo_number}`).value = vo.vo_bid ?? '';
          document.getElementById(`vo_contingency_${vo.vo_number}`).value = vo.vo_contingency ?? '';
          document.getElementById(`vo_appropriation_${vo.vo_number}`).value = vo.vo_appropriation ?? '';
        });

        const summary = fu.summary || {};
        document.querySelector('[name="dateMobi"]').value = summary.mobilization?.date || '';
        document.querySelector('[name="amountMobi"]').value = summary.mobilization?.amount || '';
        document.querySelector('[name="remMobi"]').value = summary.mobilization?.remarks || '';
        document.querySelector('[name="dateFinal"]').value = summary.final?.date || '';
        document.querySelector('[name="amountFinal"]').value = summary.final?.amount || '';
        document.querySelector('[name="remFinal"]').value = summary.final?.remarks || '';
        document.querySelector('[name="dateEng"]').value = summary.engineering?.date || '';
        document.querySelector('[name="amountEng"]').value = summary.engineering?.amount || '';
        document.querySelector('[name="remEng"]').value = summary.engineering?.remarks || '';
        document.querySelector('[name="dateMqc"]').value = summary.mqc?.date || '';
        document.querySelector('[name="amountMqc"]').value = summary.mqc?.amount || '';
        document.querySelector('[name="remMqc"]').value = summary.mqc?.remarks || '';
        document.querySelector('[name="amountTotal"]').value = summary.totalExpenditures?.amount || '';
        document.querySelector('[name="remTotal"]').value = summary.totalExpenditures?.remarks || '';
        document.querySelector('[name="amountSavings"]').value = summary.totalSavings?.amount || '';
        document.querySelector('[name="remSavings"]').value = summary.totalSavings?.remarks || '';

        const billings = fu.partial_billings || [];

        const billingsBody = document.getElementById('billingsTableBody');
        if (billings.length > 0) {
          billingsBody.innerHTML = '';
          billingCount = 0;
          billings.forEach((billing) => {
            billingCount++;
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${billingCount} Partial Billing </td>
              <td><input type="date" class="form-control amount-input" name="datePart${billingCount}" value="${billing.date ?? ''}"></td>
              <td><input type="text" class="form-control amount-input" name="amountPart${billingCount}" value="${billing.amount ?? ''}" placeholder="₱0.00"></td>
              <td><input type="text" class="form-control amount-input" name="remPart${billingCount}" value="${billing.remarks ?? ''}"></td>
            `;
            billingsBody.appendChild(row);
          });
        }
      }
    });
}
