$(document).ready(function() {
    $(document).on("submit", "#registerUserForm", function(e) {
        e.preventDefault();

        // Get password and confirmation values
    const password = $('#password').val();
    const passwordConfirmation = $('#password_confirmation').val();

    // Check if passwords match
    if (password !== passwordConfirmation) {
        Swal.fire({
            icon: "warning",
            title: "Password Mismatch",
            text: "Password and Confirm Password do not match. Please try again.",
        });
        return; // Stop the form submission
    }

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "/userRegistration",
            method: "POST",
            data: {
                ofmis_id: $('#ofmis_id').val(),
                fullname: $('#fullname').val(),
                position: $('#position').val(),
                email: $('#email').val(),
                username: $('#username').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
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
                    // Check for duplicate username or OFMIS ID errors
                    const usernameError = response.errors.find(err => 
                        err.toLowerCase().includes('username') && err.toLowerCase().includes('taken')
                    );
                    const ofmisIdError = response.errors.find(err => 
                        err.toLowerCase().includes('ofmis_id') && err.toLowerCase().includes('taken')
                    );
                    
                    if (usernameError) {
                        Swal.fire({
                            icon: "warning",
                            title: "Username Taken",
                            text: "This username is already registered. Please choose a different one.",
                        });
                    } else if (ofmisIdError) {
                        Swal.fire({
                            icon: "warning",
                            title: "OFMIS ID Registered",
                            text: "This OFMIS ID is already registered in the system.",
                        });
                    } else {
                        // Show other validation errors
                        let errorMessage = "Please fix the following:<br><ul>";
                        response.errors.forEach(error => {
                            errorMessage += `<li>${error}</li>`;
                        });
                        errorMessage += "</ul>";
                        
                        Swal.fire({
                            icon: "warning",
                            title: "Validation Errors",
                            html: errorMessage
                        });
                    }
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


// Get references to the elements
const userRoleSelect = document.getElementById('userRole');
const timeFrameSelect = document.getElementById('time_frame');
const timeFrameLabel = document.getElementById('timeFrameLabel');
const time_limitContainer = document.getElementById('time_limitContainer');

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
        time_limitContainer.style.display = 'none';
    }
});

// Event listener for time frame selection
timeFrameSelect.addEventListener('change', function() {
    // Check if "Temporary" is selected
    if (timeFrameSelect.value === 'Temporary') {
        // Show the Temporary Date input field
        time_limitContainer.style.display = 'block';
    } else {
        // Hide the Temporary Date input field
        time_limitContainer.style.display = 'none';
    }
});

    let selectedUserId = null; // Store the user ID globally

    // Open modal & fetch user role details
    $(document).on("click", ".btn-outline-warning", function () {
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
                    $("#time_limit").val(response.user.time_limit ? response.user.time_limit : "");

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
        let time_limitValue = $("#time_limit").val();

        let requestData = {
            id: selectedUserId, // Use the stored user ID
            userRole: $("#userRole").val(),
            time_frame: $("#time_frame").val()
        };

        if (time_limitValue) {
            requestData.time_limit = time_limitValue;
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

    
    // Show/hide password toggle
    $(document).on('click', '.toggle-password', function () {
        const targetInput = $($(this).data('target'));
        const type = targetInput.attr('type') === 'password' ? 'text' : 'password';
        targetInput.attr('type', type);
        $(this).toggleClass('fa-eye fa-eye-slash');
    });
});
