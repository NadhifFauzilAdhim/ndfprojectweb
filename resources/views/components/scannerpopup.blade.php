<div>
  <div class="modal fade" id="scanQRModal" tabindex="-1" aria-labelledby="scanQRModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content rounded-5 shadow-lg"> 
        <div class="modal-header border-0 pb-0">
          <div class="w-100 d-flex justify-content-between align-items-center">
            <h5 class="modal-title mb-0 fw-bold"> 
              <i class="bi bi-qr-code-scan me-2"></i>QR Scanner
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
        </div>
        <div class="modal-body pt-2"> 
          <div class="scanner-container position-relative overflow-hidden rounded-5 mb-3">
            <div id="reader" style="width: 100%; height: 280px;"> <!- Slightly adjusted height if needed -->
              <div id="cameraLoadingSpinner" class="position-absolute top-50 start-50 translate-middle" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading camera...</span>
                </div>
              </div>
            </div>
            <div class="scanning-frame">
              <div class="corner top-left"></div>
              <div class="corner top-right"></div>
              <div class="corner bottom-left"></div>
              <div class="corner bottom-right"></div>
            </div>
            <button type="button" id="toggleFlashBtn" class="btn btn-outline-light btn-sm position-absolute shadow-sm" style="display: none; bottom: 10px; right: 10px; width: 40px; height: 40px; border-radius: 50%;"> <!- Adjusted position, style, and added border-radius 50% -->
              <i class="bi bi-lightbulb"></i> </button>
          </div>

          <div class="controls-section text-center">
            <div class="mb-3">
              <button id="uploadImageBtn" class="btn btn-sm btn-outline-primary w-100">
                <i class="bi bi-upload me-1"></i> Scan from Image
              </button>
              <input type="file" id="imageInput" accept="image/*" style="display: none;" />
            </div>

            <p class="text-muted mb-2 small" id="scanInstruction">
                <i class="bi bi-camera-video me-1"></i> Point your camera at a QR Code
            </p>
            <div id="scanError" class="alert alert-danger alert-sm py-1 small" role="alert" style="display:none;">
                </div>
            <div class="mb-3">
              <div class="d-flex align-items-center justify-content-center">
                <i class="bi bi-zoom-out me-2 text-muted"></i>
                <input type="range" class="form-range w-50" id="zoomSlider" min="1" max="10" step="0.1" value="1">
                <i class="bi bi-zoom-in ms-2 text-muted"></i>
                <span id="zoomValue" class="ms-3 badge bg-secondary text-white">100%</span> <!- Made zoom value a badge -->
              </div>
            </div>
          </div>
          <div class="scan-result" style="background:#f8f9fa;border-radius:10px;padding:1rem;margin-top:1rem;border-left:3px solid #4361ee">
            <div class="section-title">
                <i class="bi bi-clipboard-data"></i> Scan Result
            </div>
            <div id="result" class="mb-2" style="color:#2c3e50;font-size:.9rem;line-height:1.5;word-break:break-all;background:#edf2f7;padding:12px;border-radius:8px;margin-top:8px;font-family:monospace">
                Waiting for scan...
            </div>
            <div id="actionButtons" class="action-buttons text-center">
                <button id="copyBtn" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-clipboard me-1"></i> Copy
                </button>
                <button id="saveBtn" class="btn btn-primary btn-sm">
                    <i class="bi bi-save me-1"></i> Save
                </button>
            </div>
        </div>

          <div id="scanHistorySection" class="mt-3 text-start" style="display: none;">
            <hr> <!- Visual separator -->
            <div class="d-flex justify-content-between align-items-center mb-1">
              <h6 class="mb-0 small text-muted">
                <i class="bi bi-journals me-1"></i>Scan History
              </h6>
              <button id="clearHistoryBtn" class="btn btn-sm btn-outline-danger p-1" title="Clear History">
                <i class="bi bi-eraser-fill"></i>
              </button>
            </div>
            <ul id="scanHistoryList" class="list-group list-group-flush small" style="max-height: 120px; overflow-y: auto;">
              <li id="noHistoryMessage" class="list-group-item text-muted text-center small py-2" style="display: none;">History is empty.</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>