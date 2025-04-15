$(document).ready(function() {
    $(document).on("submit", "#uploadForm", function(event) {
        event.preventDefault();

        // Fetch projectID from sessionStorage
        let project_id = sessionStorage.getItem("project_id");

        if (!project_id) {
            Swal.fire({
                title: "Error",
                text: "No project ID found in session. Please select a project first.",
                icon: "error",
                confirmButtonText: "OK"
            });
            return;
        }

        console.log("Retrieved Project ID:", project_id);

        let fileInput = $("#file")[0];
        if (!fileInput.files.length) {
            Swal.fire({
                title: "Warning",
                text: "Please select a file to upload.",
                icon: "warning",
                confirmButtonText: "OK"
            });
            return;
        }

        let formData = new FormData();
        formData.append("project_id", project_id);
        formData.append("file", fileInput.files[0]);

        console.log("Uploading file:", fileInput.files[0].name);

        // Upload file via AJAX
        $.ajax({
            url: `/upload-file/${project_id}`,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(data) {
                console.log("Upload Response:", data);

                if (data.status === "error" && data.message === "File already exists") {
                    Swal.fire({
                        title: "Duplicate File",
                        text: "A file with the same name already exists for this project. Please rename your file or choose a different one.",
                        icon: "warning",
                        confirmButtonText: "OK"
                    });
                    return;
                }

                if (data.status === "success") {
                    Swal.fire({
                        title: "Success!",
                        text: "File uploaded successfully.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); // Reload the page after clicking "OK"
                    });
                } else {
                    Swal.fire({
                        title: "Upload Failed",
                        text: data.message || "Something went wrong!",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function(xhr) {
                console.error("Upload Error:", xhr.responseText);
                Swal.fire({
                    title: "Error",
                    text: "Failed to upload file. File already exists.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    });
});

// Show Image Preview Before Upload
function setupUploadModal() {
    document.getElementById("file").addEventListener("change", function (event) {
        let file = event.target.files[0];
        let previewContainer = document.getElementById("imagePreviewContainer");
        let previewImage = document.getElementById("imagePreview");

        if (file && file.type.startsWith("image/")) {
            let reader = new FileReader();
            reader.onload = function (e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = "block";
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = "none";
        }
    });
}
