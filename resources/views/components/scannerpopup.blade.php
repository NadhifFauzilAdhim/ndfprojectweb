<div>
    <div class="modal fade" id="scanQRModal" tabindex="-1" aria-labelledby="scanQRModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
          <div class="modal-content rounded-4">
            <div class="modal-header border-0 pb-0">
              <div class="w-100 d-flex justify-content-between align-items-center">
                <h5 class="modal-title mb-3"> <i class="bi bi-qr-code-scan me-2"></i>QR Code Scanner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            </div>
            <div class="modal-body pt-0">
              <div class="scanner-container position-relative overflow-hidden rounded-3">
                <div id="reader" style="width: 100%; height: 300px;"></div>
                <div class="scanning-frame">
                  <div class="corner top-left"></div>
                  <div class="corner top-right"></div>
                  <div class="corner bottom-left"></div>
                  <div class="corner bottom-right"></div>
                </div>
                <button type="button" 
                        id="toggleFlashBtn" 
                        class="btn btn-primary btn-sm position-absolute shadow-sm"
                        style="display: none; bottom: 16px; right: 16px; width: 40px; height: 40px; border-radius: 20px">
                  <i class="bi bi-lightbulb"></i>
                </button>
              </div>
              <div class="text-center mt-4">
                <!-- Tombol untuk upload gambar QR -->
                <div class="text-center mb-3">
                    <button id="uploadImageBtn" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-upload me-1"></i> Scan dari Gambar
                    </button>
                    <input type="file" id="imageInput" accept="image/*" style="display: none;" />
                </div>
  
                <p class="text-muted mb-2 small">Arahkan kamera ke QR Code</p>
                <div class="mb-3">
                  <input type="range" class="form-range" id="zoomSlider" min="1" max="10" step="0.1" value="1">
                </div>
                <div class="scan-result bg-light rounded-2 p-2">
                  <p class="mb-0 small">
                    <span class="text-muted">Hasil:</span> 
                    <span id="result" class="fw-bold text-primary text-wrap d-inline-block w-100">
                    </span>
                  </p>
                  <div id="actionButtons" class="mt-2 d-none">
                    <button id="copyBtn" class="btn btn-sm btn-outline-secondary me-2"><i class="bi bi-clipboard-check me-1"></i>Copy</button>
                    <button id="saveBtn" class="btn btn-sm btn-primary"><i class="bi bi-cloud-arrow-up me-1"></i>Simpan</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</div>