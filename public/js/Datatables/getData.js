function loadUsers() {
    $.ajax({
        url: "/getUsers",
        method: "GET",
        success: function(response) {
            if (response.status == 1 && Array.isArray(response.users)) { // Ensure users exist
                let userTable = $("#userList tbody");
                userTable.empty(); // Clear existing rows

                $.each(response.users, function(index, user) { // Ensure jQuery is loaded
                    let row = `
                            <tr>
                                <td>${user.id}</td>
                                <td>${user.fullname}</td>
                                <td>${user.username}</td>
                                <td>${user.position}</td>
                                <td>${user.role}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#roleModal" data-id="${user.id}">
                                        <span class="fa-solid fa-address-card"></span>
                                    </button>
                                </td>
                            </tr>
                        `;

                    userTable.append(row);
                });
            } else {
                console.log("Invalid user data:", response);
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

loadUsers();

//ACTIVITY LOGS
$(document).ready(function() {
function loadActivityLogs() {
    $.ajax({
        url: "/getActivityLogs",
        method: "GET",
        success: function(response) {
            if (response.status == 1 && Array.isArray(response.users)) { // Ensure users exist
                let userTable = $("#userList tbody");
                userTable.empty(); // Clear existing rows

                $.each(response.users, function(index, user) { // Ensure jQuery is loaded
                    let row = `
                        <tr>
                            <td>${log.id}</td>
                            <td>${log.performedBy}</td>
                            <td>${log.role}</td>
                            <td>${log.action}</td>
                            <td>${new Date(log.created_at).toLocaleString()}</td>
                        </tr>
                    `;
                    userTable.append(row);
                });
            } else {
                console.log("Invalid user data:", response);
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

loadActivityLogs();
});

