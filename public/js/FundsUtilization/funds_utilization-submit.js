document.addEventListener('DOMContentLoaded', function () {  
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
                date: document.querySelector('[name="dateMobilization"]')?.value || '',
                amount: document.querySelector('[name="amountMobilization"]')?.value || '',
                remarks: document.querySelector('[name="remMobilization"]')?.value || '',
              },
              final: {
                date: document.querySelector('[name="dateFinal"]')?.value || '',
                amount: document.querySelector('[name="amountFinal"]')?.value || '',
                remarks: document.querySelector('[name="remFinal"]')?.value || ''
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
              }
            },
          partialBillings: []
        };

        document.querySelectorAll('.partial-billing').forEach((row, i) => {
          const dateInput = row.querySelector(`[name="partialBillings[${i + 1}][date]"]`);
          const amountInput = row.querySelector(`[name="partialBillings[${i + 1}][amount]"]`);
          const remarksInput = row.querySelector(`[name="partialBillings[${i + 1}][remarks]"]`);
        
          formData.partialBillings.push({
            date: dateInput?.value || '',
            amount: amountInput?.value || '',
            remarks: remarksInput?.value || ''
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

 
 
   