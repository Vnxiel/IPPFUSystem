function downloadFile(filePath) {

  if (!filePath) {
    Swal.fire({
      icon: 'error',
      title: 'Missing File Path',
      text: 'File path is missing. Cannot download.',
      confirmButtonColor: '#e74c3c'
    });
    return;
  }

  const decodedPath = decodeURIComponent(filePath);
  const cleanedFilename = decodedPath.split("/").pop();
  const fileUrl = `/download-file/${cleanedFilename}`;
  const fileExt = cleanedFilename.split('.').pop().toLowerCase();

  const previewableTypes = ['jpg', 'jpeg', 'png', 'pdf'];

  const triggerDownload = () => {
    const downloadLink = document.createElement("a");
    downloadLink.href = fileUrl;
    downloadLink.download = cleanedFilename;
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
  };

  if (previewableTypes.includes(fileExt)) {
    let contentHtml = `
      <div style="background: #f9f9f9; border-radius: 10px; padding: 10px;">
        <div style="margin-bottom: 10px; font-weight: bold; color: #2c3e50;">File Name: ${cleanedFilename}</div>
    `;

    if (['jpg', 'jpeg', 'png'].includes(fileExt)) {
      contentHtml += `
        <img src="${fileUrl}" 
             style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
      `;
    } else if (fileExt === 'pdf') {
      contentHtml += `
        <iframe src="${fileUrl}" 
                style="width: 100%; height: 400px; border: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        </iframe>
      `;
    }

    contentHtml += `</div>`;

    Swal.fire({
      title: `<strong style="color:#34495e;">📄 Preview File</strong>`,
      html: contentHtml,
      width: '60%',
      padding: '1.5em',
      background: '#ffffff',
      showCancelButton: true,
      confirmButtonText: '<i class="fa fa-download"></i> Download',
      cancelButtonText: 'Close',
      confirmButtonColor: '#3498db',
      cancelButtonColor: '#95a5a6',
      customClass: {
        popup: 'animated fadeIn',
        confirmButton: 'swal2-confirm-custom',
        cancelButton: 'swal2-cancel-custom'
      }
    }).then(result => {
      if (result.isConfirmed) {
        triggerDownload();
      }
    });
  } else {
    // Directly download for non-previewable types
    triggerDownload();
  }
}
