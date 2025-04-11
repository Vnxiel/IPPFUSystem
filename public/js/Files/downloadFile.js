function downloadFile(filePath) {
    console.log("Original filePath:", filePath);

    if (!filePath) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "File path is missing. Cannot download.",
            confirmButtonColor: "#d33"
        });
        return;
    }

    // Decode the path for accurate fetch and file name
    let decodedPath = decodeURIComponent(filePath);
    let cleanedFilename = decodedPath.split("/").pop(); // Get the clean filename
    let fileUrl = `/download-file/${cleanedFilename}`; // The URL to trigger the file download
    console.log("File URL for fetch:", fileUrl);

    // Send a GET request to download the file from the server
    fetch(fileUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error("File not found or inaccessible.");
            }
            return response.blob();
        })
        .then(blob => {
            let a = document.createElement("a");
            a.href = URL.createObjectURL(blob);
            a.download = cleanedFilename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        })
        .catch(error => {
            console.error("Download Error:", error);
            Swal.fire({
                icon: "error",
                title: "Download Failed",
                text: "File not found or inaccessible. Please contact support.",
                confirmButtonColor: "#d33"
            });
        });
}
