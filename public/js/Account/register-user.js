$(document).ready(function() {
    $(document).on("submit", "#registerUserForm", function(e) {
        e.preventDefault();

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/userRegistration",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if (response.status == 1) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.message + " registered successfully.",
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        $("#registerUserForm")[0].reset(); // Clear textboxes
                        window.location.href = '/systemAdmin/userManagement'; // Redirect to user management


                    });
                } else if (response.status == 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "Warning!",
                        text: "Please try again."
                    });
                } else if (response.status == 2) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: "An error occurred while saving your data."
                    });
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText); // Debugging
                Swal.fire({
                    icon: "error",
                    title: "Server Error!",
                    text: "Something went wrong. Please try again later."
                });
            }
        });
    });
});

// Get references to the elements
const userRoleSelect = document.getElementById('userRole');
const timeFrameSelect = document.getElementById('time_frame');
const timeFrameLabel = document.getElementById('timeFrameLabel');
const timeLimitContainer = document.getElementById('timeLimitContainer');

// Event listener for user role selection
userRoleSelect.addEventListener('change', function() {
    // Check if "Admin" or "systemAdmin" is selected
    if (userRoleSelect.value === 'System Admin' || userRoleSelect.value === 'Admin' || userRoleSelect.value === 'systemAdmin') {
        // Show Time Frame Select
        timeFrameLabel.style.display = 'block';
        timeFrameSelect.style.display = 'block';
    } else {
        // Hide Time Frame Select and Temporary Date input
        timeFrameLabel.style.display = 'none';
        timeFrameSelect.style.display = 'none';
        timeLimitContainer.style.display = 'none';
    }
});

// Event listener for time frame selection
timeFrameSelect.addEventListener('change', function() {
    // Check if "Temporary" is selected
    if (timeFrameSelect.value === 'Temporary') {
        // Show the Temporary Date input field
        timeLimitContainer.style.display = 'block';
    } else {
        // Hide the Temporary Date input field
        timeLimitContainer.style.display = 'none';
    }
});

$(document).ready(function () {
    let selectedUserId = null; // Store the user ID globally

    // Open modal & fetch user role details
    $(document).on("click", ".btn-warning", function () {
        selectedUserId = $(this).data("id"); // Get user ID from button

        $.ajax({
            url: "/getUserRole",
            method: "GET",
            data: { id: selectedUserId },
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            success: function (response) {
                if (response.success === 1) {
                    $("#userRole").val(response.user.role);
                    $("#time_frame").val(response.user.time_frame);
                    $("#timeLimit").val(response.user.timeLimit ? response.user.timeLimit : "");

                    $("#roleModal").modal("show"); // Show modal
                } else {
                    Swal.fire({                     
                        icon: "error",                     
                        title: "Error!",                     
                        text: "User not found!" 
                    });
                }
            },
            error: function () {
                Swal.fire({ 
                    icon: "error", 
                    title: "Server Error!", 
                    text: "Something went wrong." 
                });
            }
        });
    });

    // Submit role change
    $(document).on("submit", "#userRoleForm", function (e) {
        e.preventDefault();
        let timeLimitValue = $("#timeLimit").val();

        let requestData = {
            id: selectedUserId, // Use the stored user ID
            userRole: $("#userRole").val(),
            time_frame: $("#time_frame").val()
        };

        if (timeLimitValue) {
            requestData.timeLimit = timeLimitValue;
        }

        $.ajax({
            url: "/changeRole",
            method: "POST",
            data: requestData,
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
            success: function (response) {
                if (response === 1) {
                    Swal.fire({ 
                        icon: "success", 
                        title: "Success!", 
                        text: "Role updated successfully!" 
                    }).then(() => {
                        $("#roleModal").modal("hide");
                        // Refresh the user list
                        window.location.href = '/systemAdmin/userManagement'; // Redirect to user management
                    });
                } else {
                    Swal.fire({ 
                        icon: "error", 
                        title: "Error!", 
                        text: "Update failed." 
                    });
                }
            },
            error: function () {
                Swal.fire({ 
                    icon: "error", 
                    title: "Error!", 
                    text: "Something went wrong. Please try again." 
                });
            }
        });
    });
});
