function copyFunction(slug) {
    var copyText = document.getElementById("linkInput-" + slug);
    var fullLink = "https://" + copyText.value; // Tambahkan https:// di depan teks

    navigator.clipboard.writeText(fullLink).then(function() {
        Swal.fire({
            text: "Tautan disalin!",
            icon: 'success',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    }).catch(function(error) {
        Swal.fire({
            text: "Gagal menyalin tautan!",
            icon: 'error',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
        console.error("Error copying text: ", error);
    });
}
