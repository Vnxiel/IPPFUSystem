function deleteFile(fileName) {
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
            fetch(`/file-delete/${fileName}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        title: "Deleted!",
                        text: data.message,
                        icon: "success",
                        confirmButtonColor: "#3085d6"
                    });

                    // Reload DataTable
                    $('#projectFiles').DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire("Error", data.message || "Something went wrong", "error");
                }
            })
            .catch(err => {
                console.error("Delete error:", err);
                Swal.fire("Error", "Failed to delete file.", "error");
            });
        }
    });
}
