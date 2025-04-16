document.addEventListener('DOMContentLoaded', function () { 
    const fundModal = document.getElementById('addProjectFundUtilization');

    fundModal.addEventListener('show.bs.modal', function () {
        const project_id = sessionStorage.getItem("project_id");

        if (project_id) {
            loadFundUtilization(project_id);
        } else {
            console.warn('Project ID not found in sessionStorage.');
        }
    });

    document.getElementById('submitFundsUtilization').addEventListener('click', function () {
        const project_id = sessionStorage.getItem("project_id");
        if (!project_id) {
            console.warn('Project ID not found in sessionStorage.');
            return;
        }

        const formData = {
            project_id: project_id,
            orig_abc: document.getElementById('orig_abc').value,
            orig_contract_amount: document.getElementById('orig_contract_amount').value,
            orig_engineering: document.getElementById('orig_engineering').value,
            orig_mqc: document.getElementById('orig_mqc').value,
            orig_bid: document.getElementById('orig_bid').value,
            orig_contingency: document.getElementById('orig_contingency').value,
            orig_appropriation: document.getElementById('orig_appropriation').value,
            orig_completion_date: document.getElementById('orig_completion_date').value,

            actual_abc: document.getElementById('actual_abc').value,
            actual_contract_amount: document.getElementById('actual_contract_amount').value,
            actual_engineering: document.getElementById('actual_engineering').value,
            actual_mqc: document.getElementById('actual_mqc').value,
            actual_bid: document.getElementById('actual_bid').value,
            actual_contingency: document.getElementById('actual_contingency').value,
            actual_appropriation: document.getElementById('actual_appropriation').value,
            actual_completion_date: document.getElementById('actual_completion_date').value,


            vo_abc: document.getElementById('vo_abc').value,
            vo_contract_amount: document.getElementById('vo_contract_amount').value,
            vo_engineering: document.getElementById('vo_engineering').value,
            vo_mqc: document.getElementById('vo_mqc').value,
            vo_bid: document.getElementById('vo_bid').value,
            vo_contingency: document.getElementById('vo_contingency').value,
            vo_appropriation: document.getElementById('vo_appropriation').value,
            vo_completion_date: document.getElementById('vo_completion_date').value,

            // Include variation orders if needed in future
            // variation_orders: [...]
        };


        fetch('/fund-utilization/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                Swal.fire('Success', 'Fund Utilization saved successfully!', 'success');
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

function loadFundUtilization(project_id) {
    fetch(`/fund-utilization/${project_id}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const fu = data.data || {};
                document.getElementById('projectTitleFU').value = data.projectTitle ?? '';

                // Fill original values
                document.getElementById('orig_abc').value = fu.orig_abc ?? '';
                document.getElementById('orig_contract_amount').value = fu.orig_contract_amount ?? '';
                document.getElementById('orig_engineering').value = fu.orig_engineering ?? '';
                document.getElementById('orig_mqc').value = fu.orig_mqc ?? '';
                document.getElementById('orig_bid').value = fu.orig_bid ?? '';
                document.getElementById('orig_completion_date').value = fu.orig_completion_date ?? '';
                document.getElementById('orig_appropriation').value = fu.orig_appropriation ?? '';

                // Fill actual values
                document.getElementById('actual_abc').value = fu.actual_abc ?? '';
                document.getElementById('actual_contract_amount').value = fu.actual_contract_amount ?? '';
                document.getElementById('actual_engineering').value = fu.actual_engineering ?? '';
                document.getElementById('actual_mqc').value = fu.actual_mqc ?? '';
                document.getElementById('actual_bid').value = fu.actual_bid ?? '';
                document.getElementById('actual_completion_date').value = fu.actual_completion_date ?? '';
                document.getElementById('actual_contingency').value = fu.actual_contingency ?? '';
                document.getElementById('actual_appropriation').value = fu.actual_appropriation ?? '';
            }
        })
        .catch(error => {
            console.error('Error loading fund utilization:', error);
        });
}
