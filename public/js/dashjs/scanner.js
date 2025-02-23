    // JavaScript
    let html5QrCode = null;
    let isScanning = false;
    let isFlashOn = false;
    let currentZoom = 1;
    let zoomSlider = document.getElementById('zoomSlider');
    let zoomValue = document.getElementById('zoomValue');

    document.getElementById("scanQRBtn").addEventListener("click", () => {
        new bootstrap.Modal(document.getElementById('scanQRModal')).show();
    });

    document.getElementById('scanQRModal').addEventListener('shown.bs.modal', startScanner);
    document.getElementById('scanQRModal').addEventListener('hidden.bs.modal', stopScanner);
    document.getElementById('toggleFlashBtn').addEventListener('click', toggleFlash);

    async function startScanner() {
        try {
            html5QrCode = new Html5Qrcode("reader");
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
                focusMode: "continuous"
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
            showToast('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan!', 'error');
        }
    }

 function initZoomControl() {
    const videoElement = document.querySelector('#reader video');
    if (!videoElement) return;

    const track = videoElement.srcObject.getVideoTracks()[0];
    if (!track) return;

    const capabilities = track.getCapabilities();
    const settings = track.getSettings();

    if (!capabilities.zoom || capabilities.zoom.max < 1.1) {
        document.getElementById('zoomSlider').style.display = 'none';
        return;
    }

    zoomSlider.min = capabilities.zoom.min;
    zoomSlider.max = capabilities.zoom.max;
    zoomSlider.step = capabilities.zoom.step;
    currentZoom = settings.zoom || 1;
    zoomSlider.value = currentZoom;
    zoomValue.textContent = `${Math.round(currentZoom * 100)}%`;
    zoomSlider.style.display = 'block';
    zoomSlider.addEventListener('input', applyZoom);
}

// Fungsi untuk mengaplikasikan zoom
async function applyZoom() {
    const videoElement = document.querySelector('#reader video');
    if (!videoElement || !videoElement.srcObject) return;

    const track = videoElement.srcObject.getVideoTracks()[0];
    if (!track || !track.applyConstraints) return;

    try {
        currentZoom = parseFloat(zoomSlider.value);
        await track.applyConstraints({
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
}

    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => {
                isScanning = false;
                resetScannerState();
            }).catch(console.error);
        }
        resetScannerState();
    }

    function initFlashControl() {
        const flashBtn = document.getElementById('toggleFlashBtn');
        try {
            const torchCapability = html5QrCode.torchFeature();
            if (torchCapability.supported) {
                flashBtn.style.display = 'inline-block';
                flashBtn.disabled = false;
            } else {
                flashBtn.style.display = 'none';
            }
        } catch (error) {
            console.error("Error checking torch capability:", error);
            flashBtn.style.display = 'none';
        }
    }

    function toggleFlash() {
        if (!html5QrCode || !isScanning) return;

        const track = html5QrCode.getRunningTrack();
        if (!track || !track.applyConstraints) return;

        isFlashOn = !isFlashOn;
        
        track.applyConstraints({ advanced: [{ torch: isFlashOn }] })
            .then(() => updateFlashUI())
            .catch(err => {
                console.error("Gagal mengubah flash:", err);
                showToast('Gagal mengubah flash', 'error');
                isFlashOn = !isFlashOn;
            });
    }

    function updateFlashUI() {
        const flashIcon = document.querySelector('#toggleFlashBtn i');
        flashIcon.classList.toggle('bi-lightbulb', !isFlashOn);
        flashIcon.classList.toggle('bi-lightbulb-fill', isFlashOn);
    }

    // Utilities
    function resetScannerState() {
        isScanning = false;
        isFlashOn = false;
        
        const flashBtn = document.getElementById('toggleFlashBtn');
        flashBtn.style.display = 'none';
        
        const flashIcon = document.querySelector('#toggleFlashBtn i');
        flashIcon.classList.remove('bi-flashlight-fill');
        flashIcon.classList.add('bi-flashlight');
    }

    function isValidURL(url) {
        const pattern = /^(https?:\/\/)?([\w.-]+)\.([a-z]{2,})(\/\S*)?$/i;
        return pattern.test(url);
    }
    
    function onScanSuccess(decodedText) {
        stopScanner();
        if (!isValidURL(decodedText)) {
            showToast('URL tidak valid!', 'error');
            document.getElementById('result').textContent = 'URL tidak valid!';
            setTimeout(startScanner, 1000);
            return;
        }
        document.getElementById('result').textContent = decodedText;
        fetch('/qrcode/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ url: decodedText })
        })
        .then(handleResponse)
        .then(data => {
            if (data.success) {
                showToast('Berhasil menyimpan link', 'success');
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('scanQRModal')).hide();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }, 1500);
            }
        })
        .catch(handleError);
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