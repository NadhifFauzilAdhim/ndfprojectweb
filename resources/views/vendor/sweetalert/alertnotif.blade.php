<script>
    document.addEventListener("DOMContentLoaded", function() {
        @if(session()->has('success'))
            Swal.fire({
                text: "{{ session('success') }}",
                icon: 'success',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                });
        @elseif(session()->has('error'))
            Swal.fire({
                text: "{{ session('error') }}",
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
        @endif
    });
</script>