function deleteFile(fileID) {
    fetch(`/delete/${fileID}`, {  // Assuming the route is /delete/{fileID}
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
        }
    })
    .then(response => response.json())
    .then(data => {
        // Notify user
        Swal.fire({
            icon: data.status === "success" ? "success" : "error",
            title: data.status === "success" ? "Success" : "Error",
            text: data.message,
            confirmButtonColor: "#d33"
        });

        // Reload the DataTable after successful deletion
        $('#projectFiles').DataTable().ajax.reload(); // This will reload the table's data via its AJAX source
    })
    .catch(error => {
        console.error("Error deleting file:", error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Error deleting file. Please try again.",
            confirmButtonColor: "#d33"
        });
    });
}
