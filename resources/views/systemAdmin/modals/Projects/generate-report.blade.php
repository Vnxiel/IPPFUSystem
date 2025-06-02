<!-- Enhanced Bootstrap Modal -->
<div class="modal fade" id="generateProjectModal" tabindex="-1" aria-labelledby="generateProjectLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <div class="modal-header bg-primary text-white rounded-top-4">
        <h5 class="modal-title d-flex align-items-center" id="generateProjectLabel">
          <i class="bi bi-file-earmark-text me-2"></i> Generate Project Report
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="fs-5 text-muted mb-3">Would you like to generate the project report?</p>

        <!-- Reviewer and Noted By inputs -->
        <div class="mb-3 text-start">
          <label for="reviewerInput" class="form-label fw-semibold">Reviewed by:</label>
          <input type="text" class="form-control" id="reviewedByInput" placeholder="Enter reviewer name" />
        </div>

        <div class="mb-3 text-start">
          <label for="notedByInput" class="form-label fw-semibold">Noted By:</label>
          <input type="text" class="form-control" id="notedByInput" placeholder="Enter noted by name" />
        </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <div>
          <button type="button" id="confirmGenerateBtn" class="btn btn-primary me-2">Generate</button>
          <button type="button" id="generatePdfWithPicsBtn" class="btn btn-outline-primary">Generate with Pictures</button>
        </div>
      </div>
    </div>
  </div>
</div>
