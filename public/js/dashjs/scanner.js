/*
 * File: Scanner.js
 * Deskripsi: Script untuk Scanner QR Code (Optimized with History)
 * Author ; Nadhif Fauzil.
 */

let html5QrCode = null;
let isScanning = false;
let isFlashOn = false;
let currentZoom = 1;
let lastScannedUrl = null;

const HISTORY_STORAGE_KEY = 'qrScanHistoryLinks';
const MAX_HISTORY_ITEMS = 10; 

// Cache DOM elements
const zoomSlider = document.getElementById('zoomSlider');
const zoomValue = document.getElementById('zoomValue'); 
const readerElement = document.getElementById('reader');
const resultElement = document.getElementById('result');
const actionButtonsElement = document.getElementById('actionButtons');
const scanQRModalElement = document.getElementById('scanQRModal');
const toggleFlashBtnElement = document.getElementById('toggleFlashBtn');
const imageInputElement = document.getElementById('imageInput');
const saveBtnElement = document.getElementById('saveBtn');
const copyBtnElement = document.getElementById('copyBtn'); // Cache copy button
const uploadImageBtnElement = document.getElementById('uploadImageBtn');

// DOM Elements for History
const scanHistorySectionElement = document.getElementById('scanHistorySection');
const scanHistoryListElement = document.getElementById('scanHistoryList');
const clearHistoryBtnElement = document.getElementById('clearHistoryBtn');
const noHistoryMessageElement = document.getElementById('noHistoryMessage');


const showScanModal = () => {
    if (scanQRModalElement) {
        const modalInstance = bootstrap.Modal.getInstance(scanQRModalElement) || new bootstrap.Modal(scanQRModalElement);
        modalInstance.show();
    } else {
        console.error("Elemen modal 'scanQRModal' tidak ditemukan.");
    }
};

document.querySelectorAll("#scanQRBtn, #scanQRBtn2").forEach(btn => {
    btn?.addEventListener("click", showScanModal);
});

if (scanQRModalElement) {
    scanQRModalElement.addEventListener('shown.bs.modal', () => {
        startScanner();
        renderHistoryList(); // Muat riwayat saat modal ditampilkan
    });
    scanQRModalElement.addEventListener('hidden.bs.modal', stopScanner);
}

toggleFlashBtnElement?.addEventListener('click', toggleFlash);
copyBtnElement?.addEventListener('click', handleCopy);
saveBtnElement?.addEventListener('click', handleSave);
uploadImageBtnElement?.addEventListener('click', () => imageInputElement?.click());
imageInputElement?.addEventListener('change', event => {
    const file = event.target.files[0];
    if (!file) return;
    scanImageFile(file);
});
clearHistoryBtnElement?.addEventListener('click', handleClearHistory);


async function startScanner() {
    if (!readerElement) {
        console.error("Elemen 'reader' untuk scanner tidak ditemukan.");
        showToast('Kesalahan konfigurasi: Elemen reader tidak ada.', 'error');
        return;
    }
    readerElement.style.display = 'block';
    if (resultElement) resultElement.textContent = ''; // Bersihkan hasil sebelumnya
    actionButtonsElement?.classList.add('d-none'); // Sembunyikan tombol aksi

    try {
        html5QrCode = new Html5Qrcode("reader");
        const container = document.querySelector('.scanner-container');
        if (!container) {
            console.error("Elemen '.scanner-container' tidak ditemukan.");
            showToast('Kesalahan layout: Kontainer scanner tidak ditemukan.', 'error');
            return;
        }
        const containerWidth = container.clientWidth;
        const boxSize = Math.floor(containerWidth * 0.8);

        const config = {
            fps: 10,
            qrbox: { width: boxSize, height: boxSize },
            aspectRatio: 1.0,
            focusMode: "continuous",
            rememberLastUsedCamera: true,
        };

        await html5QrCode.start(
            { facingMode: "environment" },
            config,
            onScanSuccess,
            (errorMessage) => {
            }
        );

        isScanning = true;
        initFlashControl();
        initZoomControl();
    } catch (err) {
        console.error("Gagal memulai kamera:", err);
        const permissionError = (err.name === "NotAllowedError" || err.message?.includes("Permission denied"));
        if (permissionError) {
            showToast('Izin kamera ditolak. Mohon izinkan akses kamera di pengaturan browser Anda.', 'error');
        } else {
            showToast('Tidak dapat mengakses kamera. Pastikan tidak ada aplikasi lain yang menggunakan kamera.', 'warning');
        }
        resetScannerState();
    }
}

async function scanImageFile(file) {
    if (!html5QrCode) {
        html5QrCode = new Html5Qrcode("reader"); // Initialize if not already
    }
    if (isScanning && html5QrCode.getState() === Html5QrcodeScannerState.SCANNING) { // Check if scanner is actually scanning
        await html5QrCode.stop().catch(err => console.warn("Warning stopping scanner for file scan:", err));
        isScanning = false; // Ensure isScanning is updated
    }
    if (readerElement) readerElement.style.display = 'none'; // Hide live feed for image scan

    try {
        const result = await html5QrCode.scanFileV2(file, /* showImage= */ true);
        onScanSuccess(result.decodedText, result.result); // Pass result object
    } catch (err) {
        console.error('Gagal scan dari gambar:', err);
        const noQRFound = err.message?.toLowerCase().includes("qr code parse error") || err.message?.toLowerCase().includes("no qr code found");
        if (noQRFound) {
            showToast('Tidak ada QR code yang terdeteksi pada gambar.', 'warning');
        } else {
            showToast('Tidak dapat membaca QR dari gambar ini.', 'error');
        }
        // Optionally restart live scanner or just leave it to user to close/retry
        // if (readerElement) readerElement.style.display = 'block'; // Show reader again only if desired
    } finally {
        if (imageInputElement) imageInputElement.value = '';
    }
}

function stopScanner() {
    if (html5QrCode && isScanning) {
        html5QrCode.stop()
            .then(() => {
                console.log("QR Code scanning stopped.");
            })
            .catch(err => {
                console.warn("Scanner already stopped or error stopping:", err);
            })
            .finally(() => {
                resetScannerState();
            });
    } else {
        resetScannerState(); // Call reset even if not scanning to ensure clean state
    }
}

// --- UI Control Functions (Flash, Zoom) ---
async function initZoomControl() {
    if (!html5QrCode || !isScanning || !html5QrCode.getRunningTrackCapabilities || !zoomSlider ) return;
    // zoomValue element check is removed here, will be checked inside when used

    try {
        const capabilities = html5QrCode.getRunningTrackCapabilities();
        const zoomCapability = capabilities?.zoom;

        if (!zoomCapability || zoomCapability.max <= (zoomCapability.min || 1)) {
            zoomSlider.style.display = 'none';
            if (zoomValue) zoomValue.style.display = 'none'; // Hide zoom value if slider is hidden
            return;
        }

        zoomSlider.min = zoomCapability.min || 1;
        zoomSlider.max = zoomCapability.max;
        zoomSlider.step = zoomCapability.step || 0.1;
        currentZoom = html5QrCode.getRunningTrackSettings()?.zoom || zoomCapability.min || 1;
        zoomSlider.value = currentZoom;
        if (zoomValue) zoomValue.textContent = `${Math.round(currentZoom * 100)}%`;
        
        zoomSlider.style.display = 'inline-block'; // Or 'block' depending on layout
        if (zoomValue) zoomValue.style.display = 'inline-block';
        
        zoomSlider.removeEventListener('input', applyZoom);
        zoomSlider.addEventListener('input', applyZoom);
    } catch (error) {
        console.warn("Gagal menginisialisasi kontrol zoom:", error); // Changed to warn
        if (zoomSlider) zoomSlider.style.display = 'none';
        if (zoomValue) zoomValue.style.display = 'none';
    }
}

async function applyZoom() {
    if (!html5QrCode || !isScanning || !zoomSlider ) return;

    try {
        currentZoom = parseFloat(zoomSlider.value);
        await html5QrCode.applyVideoConstraints({
            advanced: [{ zoom: currentZoom }]
        });
        if (zoomValue) zoomValue.textContent = `${Math.round(currentZoom * 100)}%`;
    } catch (err) {
        console.warn('Gagal mengatur zoom:', err); // Changed to warn
        // Optionally reflect actual zoom if it failed to set to currentZoom
        const settings = html5QrCode.getRunningTrackSettings();
        if (settings && typeof settings.zoom !== 'undefined') {
            zoomSlider.value = settings.zoom;
            if (zoomValue) zoomValue.textContent = `${Math.round(settings.zoom * 100)}%`;
        }
    }
}

function initFlashControl() {
    if (!html5QrCode || !isScanning || !toggleFlashBtnElement || typeof html5QrCode.getRunningTrackCapabilities !== 'function') {
        if (toggleFlashBtnElement) toggleFlashBtnElement.style.display = 'none';
        return;
    }

    try {
        const capabilities = html5QrCode.getRunningTrackCapabilities();
        if (capabilities && capabilities.torch) {
            toggleFlashBtnElement.style.display = 'inline-block';
            toggleFlashBtnElement.disabled = false;
            const settings = html5QrCode.getRunningTrackSettings();
            isFlashOn = !!settings.torch;
            updateFlashUI();
        } else {
            toggleFlashBtnElement.style.display = 'none';
        }
    } catch (error) {
        console.warn("Error checking torch capability:", error);
        if (toggleFlashBtnElement) toggleFlashBtnElement.style.display = 'none';
    }
}

async function toggleFlash() {
    if (!html5QrCode || !isScanning || !toggleFlashBtnElement) return;

    const newFlashState = !isFlashOn;
    try {
        await html5QrCode.applyVideoConstraints({
            advanced: [{ torch: newFlashState }]
        });
        const settings = html5QrCode.getRunningTrackSettings();
        if (settings.torch === newFlashState) {
            isFlashOn = newFlashState;
            updateFlashUI();
        } else {
            console.warn('Flash state did not change as expected.');
            showToast('Gagal mengubah status flash perangkat.', 'warning');
            isFlashOn = !!settings.torch; // Sync with actual state
            updateFlashUI();
        }
    } catch (err) {
        console.error("Gagal mengubah flash:", err);
        showToast('Perangkat tidak mendukung kontrol flash atau terjadi kesalahan.', 'error');
        if (toggleFlashBtnElement) toggleFlashBtnElement.style.display = 'none'; // Hide if error indicates no support
    }
}

function updateFlashUI() {
    if (!toggleFlashBtnElement) return;
    const flashIcon = toggleFlashBtnElement.querySelector('i');
    if (flashIcon) {
        flashIcon.classList.toggle('bi-lightbulb', !isFlashOn);
        flashIcon.classList.toggle('bi-lightbulb-fill', isFlashOn);
    }
    toggleFlashBtnElement.setAttribute('aria-pressed', isFlashOn.toString());
}

function resetScannerState() {
    if (html5QrCode && isScanning && isFlashOn) {
        html5QrCode.applyVideoConstraints({ advanced: [{ torch: false }] })
            .catch(err => console.warn("Gagal mematikan flash saat reset:", err));
    }

    isScanning = false;
    isFlashOn = false;
    currentZoom = 1;
    // lastScannedUrl = null; // Don't reset lastScannedUrl here, it might be needed if modal is just temporarily hidden

    if (toggleFlashBtnElement) {
        toggleFlashBtnElement.style.display = 'none';
        const flashIcon = toggleFlashBtnElement.querySelector('i');
        if (flashIcon) {
            flashIcon.classList.remove('bi-lightbulb-fill');
            flashIcon.classList.add('bi-lightbulb');
        }
    }

    if (zoomSlider) {
        zoomSlider.style.display = 'none';
        zoomSlider.value = 1;
    }
    if (zoomValue) {
        zoomValue.textContent = '100%';
        zoomValue.style.display = 'none'; // Hide it along with slider
    }
    if (readerElement) readerElement.style.display = 'block'; // Show reader for next scan
    // if (resultElement) resultElement.textContent = ''; // Cleared on startScanner
    // actionButtonsElement?.classList.add('d-none'); // Cleared on startScanner
}

function isValidURL(url) {
    // More robust URL validation might be needed depending on requirements
    try {
        new URL(url); // Check if it can be parsed as a URL
        // Basic pattern to avoid overly simple strings being treated as URLs
        const pattern = /^(https?:\/\/)([a-z0-9-]+\.)+[a-z]{2,}(:\d+)?(\/.*)?$/i;
        return pattern.test(url);
    } catch (_) {
        return false;
    }
}

// `qrCodeResult` is the full result object from the library, may contain more info
function onScanSuccess(decodedText, qrCodeResult) {
    if (!isValidURL(decodedText)) {
        showToast('URL tidak valid! Silakan pindai QR Code URL yang benar.', 'error');
        if (resultElement) resultElement.textContent = 'URL tidak valid!';
        actionButtonsElement?.classList.add('d-none');
        lastScannedUrl = null;
        setTimeout(() => {
            if (resultElement && resultElement.textContent === 'URL tidak valid!') {
                resultElement.textContent = '';
            }
        }, 3000);
        
        // For live scanner, try to resume if it was paused by library automatically
        if (isScanning && html5QrCode && typeof html5QrCode.resume === 'function' && html5QrCode.getState() === Html5QrcodeScannerState.PAUSED) {
             html5QrCode.resume();
        } else if (!isScanning && readerElement) { // If it was an image scan, show reader again for live scan
            readerElement.style.display = 'block';
        }
        return;
    }

    if (isScanning && html5QrCode && typeof html5QrCode.pause === 'function') {
        html5QrCode.pause(/* shouldPauseVideo= */ true);
    }
    if (readerElement) readerElement.style.display = 'none';
    if (resultElement) resultElement.textContent = decodedText;
    actionButtonsElement?.classList.remove('d-none');
    lastScannedUrl = decodedText;

    addUrlToHistory(decodedText); // Tambahkan ke riwayat

    if (isFlashOn && html5QrCode && isScanning) { // Check isScanning as flash is for live camera
        // Turn off flash after successful scan to save battery, but only if it was user-initiated
        // No, let user control flash. Don't turn it off automatically.
        // toggleFlash().catch(err => console.warn("Could not turn off flash on success:", err));
    }
}

function handleCopy() {
    if (!lastScannedUrl) {
        showToast('Tidak ada hasil untuk disalin.', 'info');
        return;
    }
    navigator.clipboard.writeText(lastScannedUrl)
        .then(() => showToast('Tersalin ke clipboard', 'success'))
        .catch(err => {
            console.error('Gagal menyalin:', err);
            showToast('Gagal menyalin. Coba lagi atau salin manual.', 'error');
        });
}

async function handleSave() {
    if (!lastScannedUrl) {
         showToast('Tidak ada hasil untuk disimpan.', 'info');
        return;
    }
    if (!saveBtnElement) return;

    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenElement) {
        showToast('Token CSRF tidak ditemukan. Tidak dapat menyimpan.', 'error');
        console.error('CSRF token meta tag not found.');
        return;
    }

    const originalButtonContent = saveBtnElement.innerHTML;
    saveBtnElement.disabled = true;
    saveBtnElement.innerHTML = `
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Menyimpan...
    `;

    fetch('/qrcode/scan', { // Ganti dengan URL endpoint Anda
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfTokenElement.content
        },
        body: JSON.stringify({ url: lastScannedUrl })
    })
    .then(handleResponse)
    .then(data => {
        if (data.success) {
            showToast('Berhasil menyimpan link', 'success');
            setTimeout(() => {
                const modalInstance = bootstrap.Modal.getInstance(scanQRModalElement);
                modalInstance?.hide();
                // Optional: Reload page after modal is hidden if necessary
                 scanQRModalElement.addEventListener('hidden.bs.modal', () => location.reload(), { once: true });
            }, 1500);
        } else {
            showToast(data.message || 'Gagal menyimpan link di server.', 'error');
        }
    })
    .catch(handleError) // Error already has message property from handleResponse
    .finally(() => {
        saveBtnElement.disabled = false;
        saveBtnElement.innerHTML = originalButtonContent;
    });
}

function handleResponse(response) {
    if (!response.ok) {
        return response.json()
            .catch(() => ({ // If response.json() itself fails
                success: false,
                message: response.statusText || `Kesalahan HTTP: ${response.status}`
            }))
            .then(errObj => Promise.reject(errObj)); // errObj will have 'message'
    }
    return response.json();
}

function handleError(error) { // error here is expected to be an object with a 'message' property
    const message = error?.message || 'Terjadi kesalahan jaringan atau server.';
    showToast(message, 'error');
    console.error('Error Details:', error); // Log the whole error object
}

function showToast(message, type = 'success') {
    if (typeof Swal === 'undefined') {
        console.warn('SweetAlert (Swal) is not defined. Toast not shown:', message);
        alert(`${type.toUpperCase()}: ${message}`);
        return;
    }
    Swal.fire({
        text: message,
        icon: type,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
}

// --- Scan History Functions ---
function getHistory() {
    try {
        const historyJson = localStorage.getItem(HISTORY_STORAGE_KEY);
        return historyJson ? JSON.parse(historyJson) : [];
    } catch (e) {
        console.error("Error parsing history from localStorage:", e);
        return []; // Return empty array on error
    }
}

function saveHistory(historyArray) {
    try {
        localStorage.setItem(HISTORY_STORAGE_KEY, JSON.stringify(historyArray));
    } catch (e) {
        console.error("Error saving history to localStorage:", e);
        showToast("Gagal menyimpan riwayat ke penyimpanan lokal.", "error");
    }
}

function addUrlToHistory(url) {
    if (!url) return;
    let history = getHistory();
    // Hapus URL jika sudah ada untuk dipindahkan ke atas
    history = history.filter(item => item !== url);
    // Tambahkan URL baru ke awal (paling baru)
    history.unshift(url);
    // Batasi jumlah item riwayat
    if (history.length > MAX_HISTORY_ITEMS) {
        history = history.slice(0, MAX_HISTORY_ITEMS);
    }
    saveHistory(history);
    renderHistoryList(); // Perbarui tampilan riwayat
}

function renderHistoryList() {
    if (!scanHistoryListElement || !scanHistorySectionElement || !noHistoryMessageElement) return;

    const history = getHistory();
    scanHistoryListElement.innerHTML = ''; // Bersihkan daftar sebelumnya

    if (history.length === 0) {
        scanHistorySectionElement.style.display = 'block'; // Tetap tampilkan sectionnya
        noHistoryMessageElement.style.display = 'list-item'; // Tampilkan pesan "Riwayat kosong"
        if (clearHistoryBtnElement) clearHistoryBtnElement.style.display = 'none'; // Sembunyikan tombol hapus
    } else {
        scanHistorySectionElement.style.display = 'block'; // Tampilkan section riwayat
        noHistoryMessageElement.style.display = 'none'; // Sembunyikan pesan "Riwayat kosong"
        if (clearHistoryBtnElement) clearHistoryBtnElement.style.display = 'inline-block'; // Tampilkan tombol hapus

        history.forEach(url => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item d-flex justify-content-between align-items-center py-1 ps-2 pe-1';
            listItem.style.cursor = 'pointer';

            const urlSpan = document.createElement('span');
            urlSpan.className = 'text-truncate';
            urlSpan.textContent = url;
            urlSpan.title = url; // Tooltip untuk URL penuh
            urlSpan.style.maxWidth = '85%'; // Sisakan ruang untuk tombol

            const useButton = document.createElement('button');
            useButton.className = 'btn btn-sm btn-secondary py-0 px-1 use-history-btn';
            useButton.innerHTML = '<i class="bi bi-cloud-arrow-up"></i>';
            useButton.title = 'Gunakan link ini';
            useButton.addEventListener('click', (e) => {
                e.stopPropagation(); // Hindari trigger event click pada listItem
                if (isScanning && html5QrCode && typeof html5QrCode.pause === 'function') {
                    html5QrCode.pause(true);
                }
                if (readerElement) readerElement.style.display = 'none';
                if (resultElement) resultElement.textContent = url;
                actionButtonsElement?.classList.remove('d-none');
                lastScannedUrl = url;
                showToast(`Link dari riwayat: ${url}`, 'info');
            });
            
            listItem.addEventListener('click', () => { // Klik pada item juga akan memicu
                 useButton.click(); // Simulasikan klik tombol "gunakan"
            });

            listItem.appendChild(urlSpan);
            listItem.appendChild(useButton);
            scanHistoryListElement.appendChild(listItem);
        });
    }
}

function handleClearHistory() {
    Swal.fire({
        title: 'Bersihkan Riwayat?',
        text: "Tindakan ini akan menghapus semua riwayat pindaian dari peramban Anda.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            saveHistory([]); 
            renderHistoryList(); 
            showToast('Riwayat pindaian telah dibersihkan.', 'success');
        }
    });
}