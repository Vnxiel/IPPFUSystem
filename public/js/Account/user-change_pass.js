document.addEventListener("DOMContentLoaded", function () {
    const otpBtn = document.getElementById("getOtpBtn");
    const usernameInput = document.getElementById("otp-username");
    const otpInput = document.getElementById("otp");
  
    // Real-time monitoring (debugging only)
    usernameInput.addEventListener("input", function () {
        console.log("Current username input:", this.value);
    });
  
    // Restrict OTP input to 6 numeric digits only
    otpInput.addEventListener("input", function () {
        this.value = this.value.replace(/\D/g, "").slice(0, 6);
    });
  
    otpBtn.addEventListener("click", function () {
        const username = usernameInput.value.trim();
  
        if (!username) {
            Swal.fire({
                icon: "warning",
                title: "Username Required",
                text: "Please enter your username to request an OTP.",
                confirmButtonColor: "#3085d6"
            });
            return;
        }
  
        otpBtn.disabled = true;
        otpBtn.textContent = "Sending...";
  
        fetch("/password/send-otp", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ username: username })
        })
        .then(response => response.json())
        .then(data => {
            otpBtn.disabled = false;
            otpBtn.textContent = "Get OTP";
  
            Swal.fire({
                icon: data.success ? "success" : "error",
                title: data.success ? "OTP Sent" : "Error",
                text: data.message,
                confirmButtonColor: "#3085d6"
            });
        })
        .catch(err => {
            otpBtn.disabled = false;
            otpBtn.textContent = "Get OTP";
  
            Swal.fire({
                icon: "error",
                title: "Request Failed",
                text: "Unable to send OTP. Please try again.",
                confirmButtonColor: "#d33"
            });
        });
    });
  
    // Password visibility toggle
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', function () {
            const target = document.querySelector(this.getAttribute('data-target'));
            if (target.type === "password") {
                target.type = "text";
                this.classList.add("fa-eye-slash");
                this.classList.remove("fa-eye");
            } else {
                target.type = "password";
                this.classList.remove("fa-eye-slash");
                this.classList.add("fa-eye");
            }
        });
    });
  
    // Password change form submission
    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault();
  
        const username = $('#otp-username').val().trim();
        const otp = $('#otp').val().trim();
        const newPassword = $('#newPassword').val().trim();
        const confirmPassword = $('#confirmPassword').val().trim();
  
        if (!username || !otp || !newPassword || !confirmPassword) {
            Swal.fire({
                icon: "warning",
                title: "Missing Fields",
                text: "Please fill in all required fields.",
                confirmButtonColor: "#f39c12"
            });
            return;
        }
  
        if (newPassword !== confirmPassword) {
            Swal.fire({
                icon: "error",
                title: "Password Mismatch",
                text: "New password and confirm password do not match.",
                confirmButtonColor: "#e74c3c"
            });
            return;
        }
  
        $.ajax({
            url: '/password/change-password',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                username: username,
                otp: otp,
                new_password: newPassword,
                confirm_password: confirmPassword
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: res.message,
                        confirmButtonColor: "#2ecc71"
                    });
                    $('#changePassword-LoginModal').modal('hide');
                    $('#changePasswordForm')[0].reset();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message,
                        confirmButtonColor: "#e74c3c"
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Server Error",
                    text: "Something went wrong. Please try again.",
                    confirmButtonColor: "#e74c3c"
                });
            }
        });
    });
  });
  