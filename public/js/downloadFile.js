function downloadFile(filePath, timestampedFilename) {
    console.log("Downloading File:", filePath, "Saved as:", timestampedFilename); // Debugging

    if (!filePath) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "File path is missing. Cannot download.",
            confirmButtonColor: "#d33"
        });
        return;
    }

    let fileUrl = `/storage/app/public/project_files/${filePath}`; // Ensure correct URL for storage access

    // Ensure filename is defined and replace %20 with spaces
    if (timestampedFilename) {
        timestampedFilename = timestampedFilename.replace(/%20/g, ' ');
    }

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
            a.download = timestampedFilename; // Use cleaned filename
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
