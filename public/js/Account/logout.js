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
        // Call logout route (make sure CSRF token is included if needed)
        fetch('/logout', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
          })
          .then(response => {
            if (!response.ok) throw new Error('Logout failed.');
            return response.json();
          })
          .then(data => {
            Swal.fire({
              icon: "success",
              title: data.message,
              showConfirmButton: false,
              timer: 1000,
            });
            setTimeout(() => {
              sessionStorage.clear();
              window.location.href = '/';  // Redirect manually
            }, 1500);
          })
          .catch(err => {
            Swal.fire({
              icon: 'error',
              title: 'Logout Failed',
              text: err.message,
            });
          });
          
      }
    });
  }
  