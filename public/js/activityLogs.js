document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch and display all activity logs and initialize DataTable
    function fetchLogs() {
        $.ajax({
            url: '/activity-logs',
            method: 'GET',
            dataType: 'json',
            success: function(logs) {
                const tableBody = $('#activityLogs tbody');
                tableBody.empty(); // Clear existing rows
                logs.forEach(log => {
                    tableBody.append(`
                        <tr>
                            <td>${log.id}</td>
                            <td>${log.performedBy}</td>
                            <td>${log.role}</td>
                            <td>${log.action}</td>
                            <td>${log.created_at}</td>
                        </tr>
                    `); 
                });

                // Initialize DataTable
                $('#activityLogs').DataTable();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching logs:', error);
                alert('Failed to fetch activity logs. Please try again later.');
            }
        });
    }

    // Initial fetch of logs
    fetchLogs();
});
