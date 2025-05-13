$(document).ready(function() {
    fetchPasswordRequests();

    function fetchPasswordRequests() {
        $.ajax({
            url: '/password/requests/fetch',
            type: 'GET',
            success: function(data) {
                let container = $(".card-body.p-2.flex-grow-1"); // Sidebar body
                container.empty(); // Clear existing

                if (data.length === 0) {
                    container.append('<div class="text-muted text-center">No pending requests.</div>');
                    return;
                }

                data.forEach(user => {
                    container.append(`
                        <div class="mb-2 border-bottom pb-2">
                            <div><strong>${user.username}</strong></div>
                            <div class="text-muted small">${user.reason || 'No reason provided'}</div>
                            <div class="text-muted small"><i class="fas fa-envelope"></i> ${user.email}</div>
                            <div class="text-end">
                                <span class="badge bg-warning text-dark">Pending</span>
                            </div>
                        </div>
                    `);
                });
            },
            error: function(xhr) {
                console.error("Failed to fetch requests:", xhr.responseText);
            }
        });
    }
});
