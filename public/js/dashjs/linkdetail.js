$(function () {
    // Data untuk diagram
    var visitData = visitDataGlobal;

    var chart = {
        series: [
            {
                name: "Visits",
                data: visitData, // Gunakan data dari server
            }
        ],
        chart: {
            toolbar: {
                show: false,
            },
            type: "line",
            fontFamily: "inherit",
            foreColor: "#adb0bb",
            height: 320,
            stacked: false,
        },
        // Warna untuk garis
        colors: ["#007bff"], 
        plotOptions: {},
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: false,
        },
        stroke: {
            width: 2,
            curve: "smooth",
            dashArray: [0], // Solid line
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: false,
                },
            },
        },
        xaxis: {
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false,
            },
            categories: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"], // Hari dalam seminggu
        },
        yaxis: {
            tickAmount: 4,
        },
        markers: {
            strokeColor: ["#007bff"],
            strokeWidth: 2,
        },
        tooltip: {
            theme: "dark",
        },
    };

    var chart = new ApexCharts(
        document.querySelector("#traffic-overview"),
        chart
    );
    chart.render();
});

document.addEventListener("DOMContentLoaded", function() {
    const toastElList = [].slice.call(document.querySelectorAll('.toast:not(.copy-toast)'));
    const toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl);
    });
    toastList.forEach(toast => toast.show());
});
function applyFilter() {
    const filter = document.getElementById('filterUnique').value;
    const urlParams = new URLSearchParams(window.location.search);
    urlParams.set('filter', filter);
    window.location.search = urlParams.toString();
}



$(document).ready(function () {
    const blockForm = $('#block-ip-form');
    const blockedIpsContainer = $('#blocked-ips-container');
    const blockedIpsForm = $('#block-ip-form');

    // Fungsi untuk menampilkan toast
    function showToast(message, type = 'success') {
        const toast = $('#toast-notification');
        const toastMessage = $('#toast-message');

        // Set pesan toast
        toastMessage.text(message);

        // Set warna berdasarkan tipe
        toast.removeClass('text-bg-success text-bg-danger');
        toast.addClass(type === 'success' ? 'text-bg-success' : 'text-bg-danger');

        // Tampilkan toast
        const bootstrapToast = new bootstrap.Toast(toast[0]);
        bootstrapToast.show();
    }

    // Handle Block IP
    $(document).ready(function () {
        const blockForm = $('#block-ip-form'); // Form selector
        const blockedIpsContainer = $('#blocked-ips-container'); // Container for blocked IPs
    
        blockForm.on('submit', function (e) {
            e.preventDefault(); // Cegah pengiriman form secara normal
    
            const formData = blockForm.serialize(); // Serialize form data
            const errorContainer = $('#ip-address-error'); // Error container
            const blockUrl = blockForm.data('block-url'); // Ambil URL dari atribut data-block-url
    
            if (!blockUrl) {
                console.error('Block URL is missing.');
                return;
            }
    
            // Clear previous error
            errorContainer.text('');
    
            $.ajax({
                url: blockUrl,
                type: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'Accept': 'application/json',
                },
                success: function (data) {
                    if (data.errors) {
                        if (data.errors.ip_address) {
                            errorContainer.text(data.errors.ip_address[0]);
                        }
                    } else if (data.success) {
                        showToast('IP Address blocked successfully!', 'success');
    
                        // Cari elemen <ul> di dalam #blocked-ips-container
                        let ul = blockedIpsContainer.find('ul.list-group-flush');
    
                        // Jika <ul> belum ada, buat elemen <ul> baru
                        if (!ul.length) {
                            ul = $('<ul class="list-group list-group-flush"></ul>');
                            blockedIpsContainer.empty(); // Hapus pesan "No IP addresses are blocked."
                            blockedIpsContainer.append(ul);
                        }
    
                        // Tambahkan elemen baru ke dalam <ul>
                        const newIpItem = `
                            <li class="list-group-item d-flex justify-content-between align-items-center" id="ip-${data.blockedIp.id}">
                                <input type="text" class="form-control me-2" value="${data.blockedIp.ip_address}" readonly>
                                <button class="btn btn-sm btn-outline-danger unblock-btn" data-id="${data.blockedIp.id}">Unblock</button>
                            </li>`;
                        ul.append(newIpItem);
    
                        blockForm.trigger('reset'); // Reset form setelah berhasil
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error blocking IP:', xhr.responseJSON?.message || error);
                    if (xhr.responseJSON?.message) {
                        errorContainer.text(xhr.responseJSON.message);
                    }
                }
            });
        });
    });
    
    // Handle Unblock IP
    blockedIpsContainer.on('click', '.unblock-btn', function () {
        const ipId = $(this).data('id');

        $.ajax({
            url: `${blockedIpsContainer.data('unblock-url')}/${ipId}`,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                'Accept': 'application/json',
            },
            success: function (data) {
                if (data.success) {
                    showToast('IP Address unblocked successfully!', 'success');
                    $(`#ip-${ipId}`).remove();
                }
            },
            error: function (xhr, status, error) {
                console.error('Error unblocking IP:', error);
            }
        });
    });
});

$(document).ready(function () {
    const form = $('#link-update-form');
    const slugError = $('#slug-error');

    form.on('submit', function (e) {
        e.preventDefault(); // Cegah pengiriman normal

        const formData = form.serialize(); // Serialize form data
        slugError.text(''); // Bersihkan pesan error sebelumnya

        $.ajax({
            url: form.data('update-url'), // URL update dari atribut `data-update-url`
            type: 'PUT', // Gunakan method PUT
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                'Accept': 'application/json'
            },
            success: function (data) {
                if (data.success) {
                    // Tampilkan notifikasi sukses
                    showToast('Link updated successfully!', 'success');
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        showToast('URL updated successfully!', 'success');
                    }
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors || {};
                if (errors.slug) {
                    slugError.text(errors.slug[0]);
                }
                // Tangani error lainnya
                console.error('Update Error:', errors);
            }
        });
    });
});


// Fungsi untuk menampilkan toast
function showToast(message, type = 'success') {
    const toast = document.getElementById('toast-notification');
    const toastMessage = document.getElementById('toast-message');

    // Set pesan toast
    toastMessage.innerText = message;

    // Set warna berdasarkan tipe
    toast.classList.remove('text-bg-success', 'text-bg-danger');
    if (type === 'success') {
        toast.classList.add('text-bg-success');
    } else if (type === 'error') {
        toast.classList.add('text-bg-danger');
    }

    // Tampilkan toast
    const bootstrapToast = new bootstrap.Toast(toast);
    bootstrapToast.show();
}

