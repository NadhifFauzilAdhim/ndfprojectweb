function copyFunction(slug) {
    var copyText = document.getElementById("linkInput-" + slug);
    var fullLink = "https://" + copyText.value; // Tambahkan https:// di depan teks

    navigator.clipboard.writeText(fullLink).then(function() {
        Swal.fire({
            title: 'Tautan Disalin!',
            text: 'Tautan berhasil disalin ke clipboard.',
            icon: 'success',
            showConfirmButton: false,
            timer: 1500
        });
    }).catch(function(error) {
        Swal.fire({
            title: 'Gagal Menyalin!',
            text: 'Terjadi kesalahan saat menyalin teks.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
        console.error("Error copying text: ", error);
    });
}
