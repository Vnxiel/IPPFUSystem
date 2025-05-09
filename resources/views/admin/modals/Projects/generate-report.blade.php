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
