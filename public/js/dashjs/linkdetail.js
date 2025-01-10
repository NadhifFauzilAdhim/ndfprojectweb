$(function () {
    // Data untuk diagram
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
            type: "area",
            fontFamily: "inherit",
            foreColor: "#adb0bb",
            height: 320,
            animations: {
                enabled: true,
                easing: "easeinout",
                speed: 800,
            },
        },
        colors: ["#007bff"], 
        stroke: {
            width: 3,
            curve: "smooth",
        },
        markers: {
            size: 5,
            colors: ["#ffffff"], // Warna putih untuk isi marker
            strokeColors: "#007bff", // Warna biru untuk pinggiran marker
            strokeWidth: 2,
            hover: {
                size: 7,
            },
        },
        dataLabels: {
            enabled: false,
        },
        legend: {
            show: true,
            position: "top",
            horizontalAlign: "right",
            markers: {
                radius: 12,
            },
        },
        grid: {
            borderColor: "rgba(0,0,0,0.1)",
            strokeDashArray: 3,
            xaxis: {
                lines: {
                    show: true,
                },
            },
            yaxis: {
                lines: {
                    show: true,
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
            tickAmount: 5,
            labels: {
                formatter: function(val) {
                    return val + "k"; 
                },
            },
        },
        tooltip: {
            theme: "dark",
            x: {
                show: true,
            },
            y: {
                formatter: function(val) {
                    return val + " Visits";
                },
            },
        },
        fill: {
            type: "gradient",
            gradient: {
                shade: "light",
                type: "vertical",
                shadeIntensity: 0.25,
                gradientToColors: ["#80d0ff"], 
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 0.3,
            },
        },
    };
    
    var chart = new ApexCharts(
        document.querySelector("#traffic-overview"),
        chart
    );
    chart.render();
});

$(function () {
    // Data dari controller
    var topReferers = toprefDataGlobal;
    topReferers.labels = topReferers.labels.map(label => label ?? 'Direct');
    var options = {
        series: topReferers.data, 
        chart: {
            width: 330,
            type: 'pie',
        },
        labels: topReferers.labels, 
        legend: {
            position: 'bottom', 
        },
        responsive: [{
            breakpoint: 300,
            options: {
                chart: {
                    width: 100,
                },
                legend: {
                    position: 'bottom', 
                },
            },
        }],
    };
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
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

    // Block IP Address
    blockForm.on('submit', function (e) {
        e.preventDefault();

        const formData = blockForm.serialize();
        const errorContainer = $('#ip-address-error');
        const blockUrl = blockForm.data('block-url');

        if (!blockUrl) {
            console.error('Block URL is missing.');
            return;
        }

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
                if (data.success) {
                    showToast('IP Address blocked successfully!', 'success');
            
                    let ul = blockedIpsContainer.find('ul.list-group-flush');
                    if (!ul.length) {
                        ul = $('<ul class="list-group list-group-flush"></ul>');
                        blockedIpsContainer.empty();
                        blockedIpsContainer.append(ul);
                    }
            
                    const newIpItem = `
                        <li class="list-group-item d-flex justify-content-between align-items-center" id="ip-${data.blockedIp.id}">
                            <input type="text" class="form-control me-2" value="${data.blockedIp.ip_address}" readonly>
                            <button class="btn btn-sm btn-outline-danger unblock-btn" data-id="${data.blockedIp.id}">Unblock</button>
                        </li>`;
                    ul.append(newIpItem);
            
                    blockForm.trigger('reset');
                }
            },
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                const errorMessage = response?.message || 'Error blocking IP!';
                const errorDetails = response?.errors
                    ? Object.values(response.errors).flat().join(' ')
                    : error;
            
                console.error('Error blocking IP:', errorMessage, errorDetails);
                showToast(`${errorMessage}: ${errorDetails}`, 'error');
            }
            
        });
    });

    blockedIpsContainer.on('click', '.unblock-btn', function () {
        const ipId = $(this).data('id');

        $.ajax({
            url: `${blockedIpsContainer.data('unblock-url')}/${ipId}`,
            type: 'POST', 
            data: { _method: 'DELETE' }, 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
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
        e.preventDefault();

        const formData = form.serialize() + '&_method=PUT'; 
        slugError.text(''); 

        $.ajax({
            url: form.data('update-url'), 
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json',
            },
            success: function (data) {
                if (data.success) {
                    showToast('Link updated successfully!', 'success');
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON?.errors || {};
                if (errors.slug) {
                    slugError.text(errors.slug[0]);
                }
                console.error('Update Error:', errors);
            }
        });
    });
});



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

function showQRCode(url) {
    const qrCodeContainer = document.getElementById('qrCodeContainer');
    const downloadButton = document.getElementById('downloadQrCode');

    qrCodeContainer.innerHTML = '';
    // Generate URL QR Code menggunakan API eksternal
    const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(url)}`;
    // Tampilkan QR Code di modal
    const qrCodeImg = document.createElement('img');
    qrCodeImg.src = qrCodeUrl;
    qrCodeImg.alt = 'QR Code';
    qrCodeImg.classList.add('img-fluid');
    qrCodeContainer.appendChild(qrCodeImg);

    downloadButton.onclick = function () {
        const link = document.createElement('a');
        link.href = qrCodeUrl;
        link.download = 'qrcode.png'; // Nama file yang akan diunduh
        link.click(); // Trigger download
    };
}


