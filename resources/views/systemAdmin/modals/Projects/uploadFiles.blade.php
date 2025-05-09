
        <!-- Upload Modal -->
        <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Upload File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="uploadForm" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label for="file" class="form-label">Choose File</label>
                                <input type="file" id="file" class="form-control" multiple accept="image/*, .pdf, .docx, .xlsx, .zip">

                                <small class="text-muted">Accepted: Images, PDF, DOCX, XLSX, ZIP</small>
                            </div>

                            <!-- Image Preview -->
                          <!-- File Previews -->
                            <div id="imagePreviewContainer" class="row g-2 mt-3"></div>
                            <button type="submit" class="btn btn-primary w-100">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>