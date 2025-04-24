$(document).ready(function () {
  // Preview selected files
  $("#file").on("change", function () {
    const previewContainer = $("#imagePreviewContainer");
    previewContainer.empty(); // Clear previous previews

    const files = this.files;
    if (!files.length) {
      previewContainer.hide();
      return;
    }

    Array.from(files).forEach(file => {
      if (file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function (e) {
          const img = $('<img class="img-thumbnail me-2 mb-2" style="max-width: 100px;">');
          img.attr("src", e.target.result);
          previewContainer.append(img);
        };
        reader.readAsDataURL(file);
      } else {
        const icon = $(`<div class="text-start mb-1"><i class="bi bi-file-earmark me-1"></i> ${file.name}</div>`);
        previewContainer.append(icon);
      }
    });

    previewContainer.show();
  });

  // Handle form submission
  $(document).on("submit", "#uploadForm", function (event) {
    event.preventDefault();

    let project_id = sessionStorage.getItem("project_id");
    if (!project_id) {
      Swal.fire("Error", "No project ID found in session.", "error");
      return;
    }

    let files = $("#file")[0].files;
    if (!files.length) {
      Swal.fire("Warning", "Please select file(s) to upload.", "warning");
      return;
    }

    let formData = new FormData();
    formData.append("project_id", project_id);
    Array.from(files).forEach(file => {
      formData.append("files[]", file); // Note the array syntax
    });

    $.ajax({
      url: `/upload-file/${project_id}`, // Controller should match this route
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      success: function (response) {
        let duplicateFiles = response.errors?.filter(err => err.message.includes("already exists")) || [];
        let otherErrors = response.errors?.filter(err => !err.message.includes("already exists")) || [];

        let showSuccess = () => {
          if (response.uploaded && response.uploaded.length > 0) {
            return Swal.fire({
              title: "Success",
              text: `${response.uploaded.length} file(s) uploaded successfully.`,
              icon: "success",
              confirmButtonText: "OK"
            });
          } else {
            return Promise.resolve();
          }
        };

        let showDuplicates = () => {
          if (duplicateFiles.length > 0) {
            let duplicatesHtml = `<ul>`;
            duplicateFiles.forEach(err => {
              duplicatesHtml += `<li>${err.file} already exists.</li>`;
            });
            duplicatesHtml += `</ul>`;

            return Swal.fire({
              title: "Duplicate Files",
              html: duplicatesHtml,
              icon: "warning",
              confirmButtonText: "OK"
            });
          } else {
            return Promise.resolve();
          }
        };

        let showErrors = () => {
          if (otherErrors.length > 0) {
            let errorHtml = `<ul>`;
            otherErrors.forEach(err => {
              errorHtml += `<li>${err.file}: ${err.message}</li>`;
            });
            errorHtml += `</ul>`;

            return Swal.fire({
              title: "Upload Errors",
              html: errorHtml,
              icon: "error",
              confirmButtonText: "OK"
            });
          } else {
            return Promise.resolve();
          }
        };

        showSuccess()
          .then(showDuplicates)
          .then(showErrors)
          .then(() => {
            if (response.uploaded && response.uploaded.length > 0) {
              location.reload();
            }
          });
      },
      error: function (xhr) {
        console.error("Upload Error:", xhr.responseText);
        Swal.fire("Error", "An error occurred during upload.", "error");
      }
    });
  });
});
