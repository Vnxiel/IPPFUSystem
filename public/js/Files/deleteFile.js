// Delete File
function deleteFile(fileID) {
    fetch(`/delete/${fileID}`, { 
        method: "DELETE",
        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") }
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        loadFiles(document.getElementById("projectID").value); // Reload files
    })
    .catch(error => console.error("Error deleting file:", error));
}