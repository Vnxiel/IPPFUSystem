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
          <div class="mb-3">
            <label for="uploadPathInput" class="form-label">New File Path</label>
            <input type="text" class="form-control" id="uploadPathInput" name="upload_path"
              placeholder="e.g. storage/uploads/documents" required>
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