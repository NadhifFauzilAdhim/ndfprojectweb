$(document).ready(function () {
    $('#generate-button').on('click', function () {
        const title = $('#generate-title').val();
        const language = $('#language').val();
        const $button = $(this);
        const $spinner = $button.find('.spinner-border');

        if (!title) {
            alert('Silakan masukkan judul untuk AI!');
            return;
        }
        $button.prop('disabled', true);
        $spinner.removeClass('d-none');
        $.ajax({
            url: "/dashboard/posts/generate", 
            method: "POST",
            data: {
                title: title,
                language: language,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            },
            success: function (response) {
                if (response.success) {
                    $('#summernote').summernote('code', response.body);
                    showToast('Konten berhasil digenerate!', 'success');
                } else {
                    showToast('Konten berhasil dibuat!', 'error');
                }
            },
            error: function () {
                showToast('Konten gagal dibuat!', 'error');
            },
            complete: function () {
                $spinner.addClass('d-none');
                $button.prop('disabled', false);
            },
        });
    });
});

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
