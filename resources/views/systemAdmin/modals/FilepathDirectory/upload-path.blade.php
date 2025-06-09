<div class="modal fade" id="filePathSettingsModal" tabindex="-1" aria-labelledby="filePathSettingsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="filePathSettingsModalLabel">Set Upload Destination Path</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="uploadPathForm">
        @csrf
        <div class="modal-body">
            <div class="mb-3 position-relative">
              <label for="upload_path" class="form-label">New File Path</label>
              <input type="text" class="form-control" id="upload_path" name="upload_path"
                placeholder="e.g. storage/uploads/documents" autocomplete="off" required>

              <div id="path_dropdown" class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                <!-- Options will be populated here -->
              </div>

              <div class="form-text">This will be the default folder for all uploaded files.</div>
            </div>
          </div>

  
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Path</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  let fetchedPaths = [];

  // Submit form with SweetAlert
  document.getElementById('uploadPathForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const uploadPath = document.getElementById('upload_path').value;
    const token = document.querySelector('input[name="_token"]').value;

    fetch('/upload-path', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({ upload_path: uploadPath })
    })
    .then(response => response.json())
    .then(data => {
    Swal.fire({
      title: 'Success',
      text: data.message,
      icon: 'success',
      confirmButtonText: 'OK'
    }).then(() => {
      const modal = bootstrap.Modal.getInstance(document.getElementById('filePathSettingsModal'));
      modal.hide();
      location.reload(); // Reload the page after modal is hidden
    });
  })

    .catch(error => {
      console.error('Error:', error);
      Swal.fire({
        title: 'Error',
        text: 'An error occurred while saving the path.',
        icon: 'error'
      });
    });
  });

  // Fetch existing paths on modal open
  document.getElementById('filePathSettingsModal').addEventListener('show.bs.modal', function () {
    fetch('/upload-paths')
      .then(response => response.json())
      .then(data => {
        fetchedPaths = data.paths || [];
        populateDropdown('');
      });
  });

  // Filter dropdown based on input
  document.getElementById('upload_path').addEventListener('input', function () {
    const query = this.value.toLowerCase();
    populateDropdown(query);
  });

  // Show dropdown on focus
  document.getElementById('upload_path').addEventListener('focus', function () {
    populateDropdown(this.value.toLowerCase());
  });

  function populateDropdown(filter = '') {
    const dropdown = document.getElementById('path_dropdown');
    dropdown.innerHTML = '';

    const filtered = fetchedPaths.filter(path => path.toLowerCase().includes(filter));

    if (filtered.length > 0) {
      dropdown.style.display = 'block';
      filtered.forEach(path => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'list-group-item list-group-item-action';
        button.textContent = path;
        button.onclick = function () {
          document.getElementById('upload_path').value = path;
          dropdown.style.display = 'none';
        };
        dropdown.appendChild(button);
      });
    } else {
      dropdown.style.display = 'none';
    }
  }

  // Hide dropdown on click outside
  document.addEventListener('click', function(event) {
    if (!document.getElementById('upload_path').contains(event.target) &&
        !document.getElementById('path_dropdown').contains(event.target)) {
      document.getElementById('path_dropdown').style.display = 'none';
    }
  });
</script>
