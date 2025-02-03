var deleteModal = document.getElementById('deleteModal');
var deleteInput = deleteModal.querySelector('#deleteConfirmationInput');
var deleteButton = deleteModal.querySelector('#deleteButton');

deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; 
    var linkId = button.getAttribute('data-id'); 
    var form = deleteModal.querySelector('#deleteForm');
    form.action = '/dashboard/link/' + linkId;

    deleteInput.value = '';
    deleteButton.disabled = true;
});

deleteInput.addEventListener('input', function () {
    if (deleteInput.value === 'DELETE') {
        deleteButton.disabled = false;
    } else {
        deleteButton.disabled = true;
    }
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
    checkbox.checked = (isActive == 1);  
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
            colors: ["#ffffff"], 
            strokeColors: "#007bff", 
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

    qrCodeContainer.innerHTML = '';
    const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(url)}`;
    const qrCodeImg = document.createElement('img');
    qrCodeImg.src = qrCodeUrl;
    qrCodeImg.alt = 'QR Code';
    qrCodeImg.classList.add('img-fluid');
    qrCodeContainer.appendChild(qrCodeImg);

    downloadButton.onclick = function () {
        const link = document.createElement('a');
        link.href = qrCodeUrl;
        link.download = 'qrcode.png'; 
        link.click();
    };
}


document.getElementById('qrForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Mencegah pengiriman formulir

    const urlInput = document.getElementById('qr_target_url');
    const url = urlInput.value.trim();
    console.log(url);

    if (url) {
        showQRCode(url);
        const qrCodeModal = new bootstrap.Modal(document.getElementById('qrCodeModal'));
        qrCodeModal.show();
    } else {
        alert('Please enter a valid URL.');
    }
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

document.addEventListener('DOMContentLoaded', () => {
    const titleInputs = document.querySelectorAll('.form-control[data-link-slug]'); 

    titleInputs.forEach(input => {
        input.addEventListener('blur', async (event) => {
            const newTitle = event.target.value.trim();
            const linkSlug = event.target.dataset.linkSlug; 
            const previousTitle = input.dataset.previousTitle?.trim(); 

            if (newTitle === previousTitle) {
                showToast('Title is unchanged.', 'info');
                return;
            }

            if (newTitle && linkSlug) {
                try {
                    const response = await fetch(`/dashboard/link/${linkSlug}/update-title`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: JSON.stringify({ title: newTitle })
                    });

                    const result = await response.json();

                    if (response.ok && result.success) {
                        showToast('Title updated!');
                    } else {
                        console.error(result.message || 'Failed to update title.');
                        alert(result.message || 'An error occurred while updating the title.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An error occurred while updating the title. Please try again later.');
                }
            }
        });
    });
});

function prepareShareModal(linkSlug) {
    $('#linkId').val(linkSlug);
}

function shareLink() {
    const linkId = $('#linkId').val();
    const sharedWith = $('#sharedWith').val();

    $.ajax({
        url: '/dashboard/link/share',
        type: 'POST',
        data: JSON.stringify({
            link_id: linkId,
            shared_with: sharedWith
        }),
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.message) {
                showToast(response.message, 'success');
                $('#shareModal').modal('hide'); 
            } else if (response.error) {
                showToast(response.error, 'error');
            }
        },
        error: function(xhr) {
            const response = JSON.parse(xhr.responseText);
            if (response.error) {
                showToast(response.error, 'error');
            } else {
                showToast('An unknown error occurred.', 'error');
            }
        }
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
