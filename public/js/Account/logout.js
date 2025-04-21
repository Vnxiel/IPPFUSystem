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
             // Clear sessionStorage
             sessionStorage.clear();

            Swal.fire({
                icon: "success",
                title: "Successfully logged out!",
                showConfirmButton: false,
                timer: 1000,
            })
            setTimeout(function () {
                window.location = "/";
            }, 2000);
        }
    });
}
