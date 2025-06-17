function deleteFile(file_name) {
    const userRole = sessionStorage.getItem('user_role') || window.currentUserRole;
  
    if (userRole === 'Admin') {
      Swal.fire({
        icon: 'warning',
        title: 'Access Denied',
        text: 'Only System Admins are allowed to delete uploaded files.',
        confirmButtonColor: '#3085d6',
      });
      return;
    }
  
    Swal.fire({
      title: "Are you sure?",
      text: "This file will be permanently deleted!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Deleting...',
          allowOutsideClick: false,
          didOpen: () => Swal.showLoading()
        });
  
        fetch(`/file-delete/${file_name}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
          }
        })
          .then(res => res.json())
          .then(data => {
            Swal.close();
  
            if (data.status === 'success') {
              Swal.fire({
                title: "Deleted!",
                text: data.message,
                icon: "success",
                confirmButtonColor: "#3085d6"
              });
  
              // Reload DataTable or UI
              $('#projectFiles').DataTable().ajax.reload(null, false);
            } else {
              Swal.fire("Error", data.message || "Something went wrong", "error");
            }
          })
          .catch(err => {
            Swal.close();
            console.error("Delete error:", err);
            Swal.fire("Error", "Failed to delete file.", "error");
          });
      }
    });
  }
  