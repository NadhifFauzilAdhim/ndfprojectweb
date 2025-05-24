/*
 * File: link.js
 * Deskripsi: Script untuk Scanner QR Code
 * Author ; Nadhif Fauzil.
 */



    let html5QrCode = null;
    let isScanning = false;
    let isFlashOn = false;
    let currentZoom = 1;
    let zoomSlider = document.getElementById('zoomSlider');
    let zoomValue = document.getElementById('zoomValue');
    let lastScannedUrl = null;

    const scanQRBtn = document.getElementById("scanQRBtn");
    if (scanQRBtn) {
        scanQRBtn.addEventListener("click", () => {
            const modalEl = document.getElementById('scanQRModal');
            if (modalEl) {
                new bootstrap.Modal(modalEl).show();
            }
        });
    }
    const scanQRBtn2 = document.getElementById("scanQRBtn2");
    if (scanQRBtn2) {
        scanQRBtn2.addEventListener("click", () => {
            const modalEl = document.getElementById('scanQRModal');
            if (modalEl) {
                new bootstrap.Modal(modalEl).show();
            }
        });
    }

    document.getElementById('scanQRModal').addEventListener('shown.bs.modal', startScanner);
    document.getElementById('scanQRModal').addEventListener('hidden.bs.modal', stopScanner);
    document.getElementById('toggleFlashBtn').addEventListener('click', toggleFlash);
    document.getElementById('copyBtn').addEventListener('click', handleCopy);
    document.getElementById('saveBtn').addEventListener('click', handleSave);

    document.getElementById('uploadImageBtn')
    .addEventListener('click', () => document.getElementById('imageInput').click());
    document.getElementById('imageInput')
    .addEventListener('change', event => {
        const file = event.target.files[0];
        if (!file) return;
        scanImageFile(file);
    });

    async function startScanner() {
        try {
          html5QrCode = new Html5Qrcode("reader");
          const container = document.querySelector('.scanner-container');
          const containerWidth = container.clientWidth;
          const boxSize = Math.floor(containerWidth * 0.8);
      
          const config = {
            fps: 10,
            qrbox: { width: boxSize, height: boxSize }, // persegi
            aspectRatio: 1.0,
            focusMode: "continuous",
            showTorchButtonIfSupported: true
          };
      
          await html5QrCode.start(
            { facingMode: "environment" },
            config,
            onScanSuccess
          );
      
          isScanning = true;
          initFlashControl();
          initZoomControl();
        } catch (err) {
          console.error("Gagal memulai kamera:", err);
          showToast('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan!', 'warning');
        }
      }
      

    async function scanImageFile(file) {
        if (isScanning) {
          await html5QrCode.stop();
          isScanning = false;
          document.querySelector('#reader').style.display = 'none';
        }
      
        try {
          const result = await html5QrCode.scanFileV2(file, /* showImage= */ true);
          onScanSuccess(result.decodedText);
        } catch (err) {
          console.error('Gagal scan dari gambar:', err);
          showToast('Tidak dapat membaca QR dari gambar ini', 'error');
          document.querySelector('#reader').style.display = 'block';
          startScanner();
        } finally {
          document.getElementById('imageInput').value = '';
        }
      }

    async function initZoomControl() {
        try {
            const capabilities = await html5QrCode.getRunningTrackCapabilities();
            if (!capabilities.zoom || capabilities.zoom.max < 1.1) {
                zoomSlider.style.display = 'none';
                return;
            }
    
            zoomSlider.min = capabilities.zoom.min;
            zoomSlider.max = capabilities.zoom.max;
            zoomSlider.step = capabilities.zoom.step || 0.1;
            currentZoom = capabilities.zoom.min;
            zoomSlider.value = currentZoom;
            zoomValue.textContent = `${Math.round(currentZoom * 100)}%`;
            zoomSlider.style.display = 'block';
            zoomSlider.addEventListener('input', applyZoom);
        } catch (error) {
            console.error("Gagal menginisialisasi kontrol zoom:", error);
            zoomSlider.style.display = 'none';
        }
    }
    

    async function applyZoom() {
        if (!html5QrCode || !isScanning) return;
    
        try {
            currentZoom = parseFloat(zoomSlider.value);
            await html5QrCode.applyVideoConstraints({
                advanced: [{ zoom: currentZoom }]
            });
            zoomValue.textContent = `${Math.round(currentZoom * 100)}%`;
        } catch (err) {
            console.error('Gagal mengatur zoom:', err);
            showToast('Gagal mengatur zoom', 'error');
        }
    }


    function resetScannerState() {
        isScanning = false;
        isFlashOn = false;

        const flashBtn = document.getElementById('toggleFlashBtn');
        flashBtn.style.display = 'none';

        zoomSlider.style.display = 'none';
        zoomValue.textContent = '100%';
        currentZoom = 1;

        const flashIcon = document.querySelector('#toggleFlashBtn i');
        flashIcon.classList.remove('bi-lightbulb-fill');
        flashIcon.classList.add('bi-lightbulb');
        document.getElementById('actionButtons').classList.add('d-none');
        document.getElementById('result').textContent = '';
        lastScannedUrl = null;
    }


    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => {
                isScanning = false;
                resetScannerState();
            }).catch(console.error);
        }
        resetScannerState();
        document.querySelector('#reader').style.display = 'block';
    }

    function initFlashControl() {
        const flashBtn = document.getElementById('toggleFlashBtn');
        try {
            const settings = html5QrCode.getRunningTrackSettings();
            if ('torch' in settings) {
                flashBtn.style.display = 'inline-block';
                flashBtn.disabled = false;
                updateFlashUI(); 
            } else {
                flashBtn.style.display = 'none';
            }
        } catch (error) {
            console.error("Error checking torch capability:", error);
            flashBtn.style.display = 'none';
        }
    }

    async function toggleFlash() {
        if (!html5QrCode || !isScanning) return;
    
        try {
            isFlashOn = !isFlashOn;
            const constraints = {
                torch: isFlashOn,
                advanced: [{ torch: isFlashOn }] 
            };
            await html5QrCode.applyVideoConstraints(constraints);
            const settings = html5QrCode.getRunningTrackSettings();
            if (settings.torch !== isFlashOn) {
                throw new Error('Gagal mengubah status flash');
            }
            
            updateFlashUI();
        } catch (err) {
            console.error("Gagal mengubah flash:", err);
            showToast('Perangkat tidak mendukung flash', 'error');
            isFlashOn = !isFlashOn;
        }
    }

    function updateFlashUI() {
        const flashIcon = document.querySelector('#toggleFlashBtn i');
        flashIcon.classList.toggle('bi-lightbulb', !isFlashOn);
        flashIcon.classList.toggle('bi-lightbulb-fill', isFlashOn);
    }

    // Utilities
    function resetScannerState() {
        if (html5QrCode && isScanning) {
            html5QrCode.applyVideoConstraints({ torch: false }).catch(console.error);
        }
        
        isScanning = false;
        isFlashOn = false;
        const flashBtn = document.getElementById('toggleFlashBtn');
        flashBtn.style.display = 'none';
        const flashIcon = document.querySelector('#toggleFlashBtn i');
        flashIcon.classList.remove('bi-lightbulb-fill');
        flashIcon.classList.add('bi-lightbulb');
    }

    function isValidURL(url) {
        const pattern = /^(https?:\/\/)?([\w.-]+)\.([a-z]{2,})(\/\S*)?$/i;
        return pattern.test(url);
    }
    
    function onScanSuccess(decodedText) {

        if (!isValidURL(decodedText)) {
            stopScanner();
            showToast('URL tidak valid!', 'error');
            document.getElementById('result').textContent = 'URL tidak valid!';
            setTimeout(startScanner, 2000);
            return;
        }
        document.querySelector('#reader').style.display = 'none';
        document.getElementById('result').textContent = decodedText;
        document.getElementById('actionButtons').classList.remove('d-none');
        lastScannedUrl = decodedText;
    }
    
    function handleCopy() {
        if (!lastScannedUrl) return;
        navigator.clipboard.writeText(lastScannedUrl)
            .then(() => showToast('Tersalin ke clipboard', 'success'))
            .catch(err => {
                console.error('Gagal menyalin:', err);
                showToast('Gagal menyalin', 'error');
            });
    }
    
    function handleSave() {
        if (!lastScannedUrl) return;
        fetch('/qrcode/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ url: lastScannedUrl })
        })
        .then(handleResponse)
        .then(data => {
            if (data.success) {
                showToast('Berhasil menyimpan link', 'success');
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('scanQRModal')).hide();
                    setTimeout(() => location.reload(), 1000);
                }, 1500);
            }
        })
        .catch(handleError);
    }
    
    function resetScannerState() {
        if (html5QrCode && isScanning) {
            html5QrCode.applyVideoConstraints({ torch: false }).catch(console.error);
        }
        
        isScanning = false;
        isFlashOn = false;
        const flashBtn = document.getElementById('toggleFlashBtn');
        flashBtn.style.display = 'none';
        const flashIcon = document.querySelector('#toggleFlashBtn i');
        flashIcon.classList.remove('bi-lightbulb-fill');
        flashIcon.classList.add('bi-lightbulb');
        
        // Reset UI hasil scan
        document.getElementById('actionButtons').classList.add('d-none');
        document.getElementById('result').textContent = '';
        lastScannedUrl = null;
    }

    function handleResponse(response) {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    }

    function handleError(error) {
        showToast(error.message || 'Terjadi kesalahan', 'error');
        console.error('Error:', error);
    }

    function showToast(message, type = 'success') {
        Swal.fire({
            text: message,
            icon: type, 
            toast: true,
            position: 'top-end', 
            showConfirmButton: false,
            timer: 3000, 
            timerProgressBar: true,
        });
    }