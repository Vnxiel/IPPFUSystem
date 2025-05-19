document.addEventListener('DOMContentLoaded', function () {
    // Utility function to toggle input form visibility
    window.toggleForm = function (formId) {
      const form = document.getElementById(formId);
      form.classList.toggle('d-none');
    };
  
    /**
     * Add Mobilization Entry
     */
    document.getElementById('btnAddMobilization').addEventListener('click', function () {
      const date = document.getElementById('mobiDate').value;
      const percent = document.getElementById('mobiPercent').value;
      const amount = document.getElementById('mobiAmount').value;
      const remarks = document.getElementById('mobiRemarks').value;
  
      if (!date || !percent || !amount) {
        alert('Please fill in all required Mobilization fields.');
        return;
      }
  
      const row = `
        <tr>
          <td>Mobilization (${percent}%)</td>
          <td>${date}<input type="hidden" name="mobilizations[][date]" value="${date}"></td>
          <td>${parseFloat(amount).toLocaleString()}<input type="hidden" name="mobilizations[][amount]" value="${amount}"><input type="hidden" name="mobilizations[][percentage]" value="${percent}"></td>
          <td>${remarks}<input type="hidden" name="mobilizations[][remarks]" value="${remarks}"></td>
        </tr>`;
      
      document.getElementById('mobilizationRows').insertAdjacentHTML('beforeend', row);
      document.getElementById('mobilizationInputForm').classList.add('d-none');
    });
  
    /**
     * Add Engineering Entry
     */
    document.getElementById('btnAddEngineering').addEventListener('click', function () {
      const name = document.getElementById('engName').value;
      const month = document.getElementById('engMonth').value;
      const period = document.getElementById('engPeriod').value;
      const amount = document.getElementById('engAmount').value;
      const remarks = document.getElementById('engRemarks').value;
  
      if (!name || !month || !period || !amount) {
        alert('Please complete all Engineering fields.');
        return;
      }
  
      const row = `
        <tr>
          <td>Engineering - ${name}</td>
          <td>${month}<input type="hidden" name="engineerings[][month]" value="${month}"></td>
          <td>${period}<input type="hidden" name="engineerings[][payment_periods]" value="${period}"></td>
          <td>${parseFloat(amount).toLocaleString()}<input type="hidden" name="engineerings[][amount]" value="${amount}"></td>
          <td>${remarks}<input type="hidden" name="engineerings[][remarks]" value="${remarks}"><input type="hidden" name="engineerings[][name]" value="${name}"></td>
        </tr>`;
      
      document.getElementById('engineeringRows').insertAdjacentHTML('beforeend', row);
      document.getElementById('engineerInputForm').classList.add('d-none');
    });
  
    /**
     * Add MQC Entry
     */
    document.getElementById('btnAddMQC').addEventListener('click', function () {
      const name = document.getElementById('mqcName').value;
      const month = document.getElementById('mqcMonth').value;
      const period = document.getElementById('mqcPeriod').value;
      const amount = document.getElementById('mqcAmount').value;
      const remarks = document.getElementById('mqcRemarks').value;
  
      if (!name || !month || !period || !amount) {
        alert('Please complete all MQC fields.');
        return;
      }
  
      const row = `
        <tr>
          <td>MQC - ${name}</td>
          <td>${month}<input type="hidden" name="mqcs[][month]" value="${month}"></td>
          <td>${period}<input type="hidden" name="mqcs[][payment_periods]" value="${period}"></td>
          <td>${parseFloat(amount).toLocaleString()}<input type="hidden" name="mqcs[][amount]" value="${amount}"></td>
          <td>${remarks}<input type="hidden" name="mqcs[][remarks]" value="${remarks}"><input type="hidden" name="mqcs[][name]" value="${name}"></td>
        </tr>`;
      
      document.getElementById('mqcRows').insertAdjacentHTML('beforeend', row);
      document.getElementById('mqcInputForm').classList.add('d-none');
    });
  
    /**
     * Add Contingency Entry
     */
    document.getElementById('btnAddContingency').addEventListener('click', function () {
      const name = document.getElementById('contName').value;
      const month = document.getElementById('contMonth').value;
      const period = document.getElementById('contPeriod').value;
      const amount = document.getElementById('contAmount').value;
      const remarks = document.getElementById('contRemarks').value;
  
      if (!name || !month || !period || !amount) {
        alert('Please complete all Contingency fields.');
        return;
      }
  
      const row = `
        <tr>
          <td>Contingency - ${name}</td>
          <td>${month}<input type="hidden" name="contingencies[][month]" value="${month}"></td>
          <td>${period}<input type="hidden" name="contingencies[][payment_periods]" value="${period}"></td>
          <td>${parseFloat(amount).toLocaleString()}<input type="hidden" name="contingencies[][amount]" value="${amount}"></td>
          <td>${remarks}<input type="hidden" name="contingencies[][remarks]" value="${remarks}"><input type="hidden" name="contingencies[][name]" value="${name}"></td>
        </tr>`;
      
      document.getElementById('contingencyRows').insertAdjacentHTML('beforeend', row);
      document.getElementById('contingencyInputForm').classList.add('d-none');
    });
  
    /**
     * Add Partial Billing Entry
     */
    document.getElementById('btnAddBilling').addEventListener('click', function () {
      const number = document.getElementById('billingNumber').value;
      const amount = document.getElementById('billingAmount').value;
      const date = document.getElementById('billingDate').value;
      const remarks = document.getElementById('billingRemarks').value;
  
      if (!number || !amount || !date) {
        alert('Please complete all Partial Billing fields.');
        return;
      }
  
      const row = `
        <tr>
          <td>Partial Billing #${number}</td>
          <td>${date}<input type="hidden" name="partial_billings[][date]" value="${date}"></td>
          <td>${parseFloat(amount).toLocaleString()}<input type="hidden" name="partial_billings[][amount]" value="${amount}"></td>
          <td>${remarks}<input type="hidden" name="partial_billings[][remarks]" value="${remarks}"><input type="hidden" name="partial_billings[][number_of_billing]" value="${number}"></td>
        </tr>`;
      
      document.getElementById('partialBillingRows').insertAdjacentHTML('beforeend', row);
      document.getElementById('partialBillingInputForm').classList.add('d-none');
    });
  });
  

  document.getElementById('submitFundsUtilization').addEventListener('click', function () {
    const form = document.getElementById('addFundUtilization');
    const formData = new FormData(form);
  
    // Show confirmation before sending
    Swal.fire({
      title: 'Submit Fund Utilization?',
      text: 'Please confirm all fields are correct before submission.',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Submit',
      cancelButtonText: 'Cancel',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(form.getAttribute('action') || '/fund-utilization/store', {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
          },
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.status === 'success') {
            Swal.fire({
              title: 'Success!',
              text: data.message || 'Fund Utilization saved successfully.',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then(() => {
              location.reload(); // or redirect if needed
            });
          } else {
            Swal.fire({
              title: 'Submission Failed',
              text: data.message || 'An error occurred while saving.',
              icon: 'error'
            });
          }
        })
        .catch(error => {
          console.error('Submission error:', error);
          Swal.fire({
            title: 'Server Error',
            text: 'Unable to submit. Please try again later.',
            icon: 'error'
          });
        });
      }
    });
  });
  