let html5QrCode;
    let isScanning = false;

    document.getElementById("scanQRBtn").addEventListener("click", function() {
        const modal = new bootstrap.Modal(document.getElementById('scanQRModal'));
        modal.show();
    });
    document.getElementById('scanQRModal').addEventListener('shown.bs.modal', function () {
        startScanner();
    });
    document.getElementById('scanQRModal').addEventListener('hidden.bs.modal', function () {
        stopScanner();
    });
    async function startScanner() {
        html5QrCode = new Html5Qrcode("reader");
        const config = { 
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.0,
            focusMode: "continuous"
        };
        try {
            await html5QrCode.start(
                { facingMode: "environment" }, 
                config,
                onScanSuccess,
                onScanFailure
            );
            isScanning = true;
        } catch (err) {
            console.error("Gagal memulai kamera:", err);
            alert("Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan!");
        }
    }
    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => {
                isScanning = false;
            }).catch((err) => {
                console.error("Gagal menghentikan scanner:", err);
            });
        }
    }
    function onScanSuccess(decodedText) {
        stopScanner();
        fetch('/qrcode/scan', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ url: decodedText })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
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
        .catch(error => {
            showToast(error.message, 'error');
            console.error('Error:', error);
        });
    }

    function onScanFailure(error) {
        console.warn(`Gagal scan: ${error}`);
    }

    function showToast(message, type = 'success') {
        Swal.fire({
            text: message,
            icon: type, // Tipe icon: 'success', 'error', 'warning', 'info', atau 'question'
            toast: true,
            position: 'top-end', // Posisi notifikasi
            showConfirmButton: false,
            timer: 3000, // Durasi dalam milidetik
            timerProgressBar: true,
        });
    }