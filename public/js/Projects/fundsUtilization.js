document.addEventListener('DOMContentLoaded', function () {
    const fundModal = document.getElementById('addProjectFundUtilization');

    fundModal.addEventListener('show.bs.modal', function () {
        fetch('/get-project-id')
            .then(response => response.json())
            .then(data => {
                if (data.projectID) {
                    loadFundUtilization(data.projectID);
                } else {
                    console.warn('Project ID not found in session.');
                }
            })
            .catch(error => {
                console.error('Error getting project ID from session:', error);
            });
    });
});

function loadFundUtilization(projectID) {
    fetch(`/fund-utilization/${projectID}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const fu = data.data || {};
                document.getElementById('projectTitleFU').value = data.projectTitle ?? '';

                // Fill original values
                document.getElementById('orig_abc').value = fu.orig_abc ?? '';
                document.getElementById('orig_contractAmount').value = fu.orig_contract_amount ?? '';
                document.getElementById('orig_engineering').value = fu.orig_engineering ?? '';
                document.getElementById('orig_mqc').value = fu.orig_mqc ?? '';
                document.getElementById('orig_bid').value = fu.orig_bid ?? '';
                document.getElementById('completionDate').value = fu.completionDate ?? '';
                document.getElementById('orig_appropriation').value = fu.orig_appropriation ?? '';

                // Fill actual values
                document.getElementById('actual_abc').value = fu.actual_abc ?? '';
                document.getElementById('actual_contractAmount').value = fu.actual_contractAmount ?? '';
                document.getElementById('actual_engineering').value = fu.actual_engineering ?? '';
                document.getElementById('actual_mqc').value = fu.actual_mqc ?? '';
                document.getElementById('actual_bid').value = fu.actual_bid ?? '';
                document.getElementById('actual_completionDate').value = fu.actual_completionDate ?? '';
                document.getElementById('actual_contingency').value = fu.actual_contingency ?? '';
                document.getElementById('actual_appropriation').value = fu.actual_appropriation ?? '';
            }
        })
        .catch(error => {
            console.error('Error loading fund utilization:', error);
        });
}
