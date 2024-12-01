var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var linkId = button.getAttribute('data-id'); 
    var form = deleteModal.querySelector('#deleteForm');
    form.action = '/dashboard/link/' + linkId; 
});

var editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var linkId = button.getAttribute('data-id');
    var targetUrl = button.getAttribute('data-target-url');
    var isActive = button.getAttribute('data-active'); 

    var form = editModal.querySelector('#editForm');
    form.action = '/dashboard/link/' + linkId;

    var input = editModal.querySelector('#editTargetUrl');
    input.value = targetUrl;

    var checkbox = editModal.querySelector('#flexSwitchCheckChecked');
    var label = editModal.querySelector('#switchLabel');
    checkbox.checked = (isActive == 1);  // Checked jika active bernilai 1
    label.textContent = checkbox.checked ? 'Active' : 'Inactive';
    checkbox.addEventListener('change', function () {
        label.textContent = checkbox.checked ? 'Active' : 'Inactive';
    });
});

function confirmDelete(slug) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Link ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            const deleteForm = document.createElement('form');
            deleteForm.action = `/dashboard/link/${slug}`;
            deleteForm.method = 'POST';
            deleteForm.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(deleteForm);
            deleteForm.submit();
        }
    });
}




$(function () {
    var visitData = visitDataGlobal;

    var chart = {
        series: [
            {
                name: "Visits",
                data: visitData,
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
        colors: ["#007bff"], // Blue color for the line
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
            dashArray: [0], // Solid line (no dashes)
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
            categories: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
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

document.addEventListener("DOMContentLoaded", function () {
    const toastElList = [].slice.call(document.querySelectorAll('.toast:not(.copy-toast)'));
    const toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl);
    });
    toastList.forEach(toast => toast.show());
});

function showQRCode(url) {
    const qrCodeContainer = document.getElementById('qrCodeContainer');
    const downloadButton = document.getElementById('downloadQrCode');

    // Hapus QR Code lama jika ada
    qrCodeContainer.innerHTML = '';

    // Generate URL QR Code menggunakan API eksternal
    const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(url)}`;

    // Tampilkan QR Code di modal
    const qrCodeImg = document.createElement('img');
    qrCodeImg.src = qrCodeUrl;
    qrCodeImg.alt = 'QR Code';
    qrCodeImg.classList.add('img-fluid');
    qrCodeContainer.appendChild(qrCodeImg);

    // Atur aksi tombol untuk mengunduh QR Code
    downloadButton.onclick = function () {
        const link = document.createElement('a');
        link.href = qrCodeUrl;
        link.download = 'qrcode.png'; // Nama file yang akan diunduh
        link.click(); // Trigger download
    };
}
