function logout() {
    Swal.fire({
        title: 'Logging Out...',
        text: 'You will be logged out of the system.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, log out!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Ensure CSRF token is present
            const token = document.querySelector('meta[name="csrf-token"]');
            if (!token) {
                Swal.fire({
                    icon: "error",
                    title: "Security error",
                    text: "CSRF token not found. Logout aborted!",
                    confirmButtonText: "OK"
                });
                return;
            }

            Swal.fire({
                icon: "success",
                title: "Successfully logged out!",
                showConfirmButton: false,
                timer: 1000,
            });

            setTimeout(function () {
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token.getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).then(res => {
                    if (res.redirected) {
                        window.location = res.url;
                    } 
                }).catch(() => {
                    Swal.fire({
                        icon: "error",
                        title: "Logout failed",
                        text: "Something went wrong. Please try again.",
                        confirmButtonText: "OK"
                    });
                });
            }, 1000);
        }
    });
}
