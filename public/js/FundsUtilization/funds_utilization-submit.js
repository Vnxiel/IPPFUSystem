document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('submitFundsUtilization').addEventListener('click', function (e) {
    e.preventDefault();

    const project_id = sessionStorage.getItem("project_id");
    if (!project_id) return;

    const existingDateInput = document.getElementById('existingFinancialCompletionDate');
    const existingDateValue = existingDateInput ? existingDateInput.value.trim() : '';

    // Check if any release checkbox is checked
    const anyChecked = Array.from(document.querySelectorAll('.release-checkbox')).some(cb => cb.checked);

    const proceedToSave = (financial_completion_date = '') => {
      const voCount = parseInt(document.getElementById('voCount').value) || 1;
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
            date: document.querySelector('[name="dateMobilization"]')?.value || '',
            amount: document.querySelector('[name="amountMobilization"]')?.value || '',
            remarks: 'Not Released'
          },
          final: {
            date: document.querySelector('[name="dateFinal"]')?.value || '',
            amount: document.querySelector('[name="amountFinal"]')?.value || '',
            remarks: 'Not Released'
          },
          engineering: {
            date: document.querySelector('[name="dateEng"]')?.value || '',
            amount: document.querySelector('[name="amountEng"]')?.value || '',
            remarks: document.querySelector('[name="remEng"]')?.value || ''
          },
          mqc: {
            date: document.querySelector('[name="dateMqc"]')?.value || '',
            amount: document.querySelector('[name="amountMqc"]')?.value || '',
            remarks: document.querySelector('[name="remMqc"]')?.value || ''
          },
          totalExpenditures: {
            amount: document.querySelector('[name="amountTotal"]')?.value || ''
          },
          totalSavings: {
            amount: document.querySelector('[name="amountSavings"]')?.value || ''
          },
        },
        financial_completion_date: financial_completion_date,
        partialBillings: []
      };

      const mobiCheckbox = document.getElementById('releaseMobilization');
      const finalCheckbox = document.getElementById('releaseFinal');

      formData.summary.mobilization.remarks = mobiCheckbox?.checked ? 'Release' : 'Not Released';
      formData.summary.final.remarks = finalCheckbox?.checked ? 'Release' : 'Not Released';

      let allPartialsReleased = true;
      const partialRows = document.querySelectorAll('.partial-billing');
      partialRows.forEach((row, idx) => {
        if (row.offsetParent === null) return;

        const dateInput = row.querySelector(`[name="partialBillings[${idx + 1}][amount]"]`);
        const releaseCheckbox = row.querySelector('.release-partial');
        const released = releaseCheckbox?.checked ?? false;

        if (!released) allPartialsReleased = false;

        formData.partialBillings.push({
          date: row.querySelector(`[name="partialBillings[${idx + 1}][date]"]`)?.value || '',
          amount: dateInput?.value || '',
          remarks: released ? 'Release' : 'Not Released'
        });
      });

      const allReleased = (mobiCheckbox?.checked) && (finalCheckbox?.checked) && allPartialsReleased;

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
          Swal.fire('Success', 'Fund Utilization saved successfully!', 'success')
            .then(() => location.reload());
        } else {
          Swal.fire('Failed', result.message || 'Failed to save fund utilization.', 'error');
        }
      })
      .catch(error => {
        console.error('Error saving fund utilization:', error);
        Swal.fire('Error', 'An error occurred while saving fund utilization.', 'error');
      });
    };

    // 🛑 Check if amountTotal or amountSavings is empty
    const amountTotalVal = document.querySelector('[name="amountTotal"]')?.value.trim();
    const amountSavingsVal = document.querySelector('[name="amountSavings"]')?.value.trim();
    if (!amountTotalVal || !amountSavingsVal) {
      Swal.fire({
        icon: 'error',
        title: 'Missing Required Fields',
        text: 'Total Expenditures and Total Savings must not be empty before submitting.'
      });
      return;
    }

    // 🟡 No checkboxes checked warning
    if (!anyChecked) {
      Swal.fire({
        icon: 'warning',
        title: 'No release status set',
        text: 'You haven’t marked any billing as "Released". Do you still want to save the data?',
        showCancelButton: true,
        confirmButtonText: 'Yes, save it',
        cancelButtonText: 'Cancel'
      }).then(result => {
        if (result.isConfirmed) {
          proceedToSave(existingDateValue);
        }
      });
      return;
    }

    const mobiCheckbox = document.getElementById('releaseMobilization');
    const finalCheckbox = document.getElementById('releaseFinal');
    const partialRows = document.querySelectorAll('.partial-billing');
    let allPartialsReleased = true;
    partialRows.forEach(row => {
      if (row.offsetParent === null) return;
      const releaseCheckbox = row.querySelector('.release-partial');
      if (!(releaseCheckbox?.checked ?? false)) allPartialsReleased = false;
    });
    const allReleased = (mobiCheckbox?.checked) && (finalCheckbox?.checked) && allPartialsReleased;

    // 🟢 If any release is checked but no financial date, prompt for it
    if (anyChecked && !existingDateValue) {
      Swal.fire({
        title: 'Set Financial Completion Date',
        input: 'date',
        inputLabel: 'Financial Completion Date',
        inputPlaceholder: 'Select the financial completion date',
        inputAttributes: {
          max: new Date().toISOString().split("T")[0]
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        preConfirm: (dateValue) => {
          if (!dateValue) {
            Swal.showValidationMessage('Completion date is required');
          }
          return dateValue;
        }
      }).then(result => {
        if (result.isConfirmed) {
          proceedToSave(result.value);
        }
      });
    } else {
      proceedToSave(existingDateValue);
    }
  });
});
