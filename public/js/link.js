/*
 * File: link.js
 * Deskripsi: Script untuk halaman link dashboard shortlink
 * Author ; Nadhif Fauzil.
 */

(() => {
    // ==================== UTIL FUNCTIONS ====================
    const isValidUrl = url => /^(https?:\/\/)?([\w.-]+)\.([a-z]{2,})(\/\S*)?$/i.test(url);
    const showToast = (message, type = 'success') => {
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        icon: type,
        text: message,
      });
    };
  
    const postForm = async ({ url, data = {}, useMethod = 'POST' }) => {
      const token = document.querySelector('meta[name="csrf-token"]').content;
      const options = { method: useMethod, headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token } };
      options.body = useMethod === 'DELETE' ? `@csrf\n@method('DELETE')` : JSON.stringify(data);
      return fetch(url, options);
    };
  
    // ==================== DELETE CONFIRMATION ====================
    const confirmDelete = slug => {
      Swal.fire({
        title: 'Apakah Anda yakin?',
        text: 'Link ini akan dihapus secara permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
      }).then(async result => {
        if (result.isConfirmed) {
          await postForm({ url: `/dashboard/link/${slug}`, useMethod: 'DELETE' });
          location.reload();
        }
      });
    };
  
    // ==================== MODAL HANDLERS ====================
    const setupDeleteModal = () => {
      const modalEl = document.getElementById('deleteModal');
      const inputEl = modalEl.querySelector('#deleteConfirmationInput');
      const btnEl = modalEl.querySelector('#deleteButton');
  
      modalEl.addEventListener('show.bs.modal', ({ relatedTarget: btn }) => {
        const id = btn.dataset.id;
        modalEl.querySelector('#deleteForm').action = `/dashboard/link/${id}`;
        inputEl.value = '';
        btnEl.disabled = true;
        inputEl.oninput = () => btnEl.disabled = inputEl.value !== 'DELETE';
      });
    };
  
    const setupEditModal = () => {
      const modalEl = document.getElementById('editModal');
      modalEl.addEventListener('show.bs.modal', ({ relatedTarget: btn }) => {
        const { id, targetUrl, active } = btn.dataset;
        const form = modalEl.querySelector('#editForm');
        const urlInput = modalEl.querySelector('#editTargetUrl');
        const switchEl = modalEl.querySelector('#flexSwitchCheckChecked');
        const labelEl = modalEl.querySelector('#switchLabel');
  
        form.action = `/dashboard/link/${id}`;
        urlInput.value = targetUrl;
        switchEl.checked = active === '1';
        labelEl.textContent = switchEl.checked ? 'Active' : 'Inactive';
        switchEl.onchange = () => labelEl.textContent = switchEl.checked ? 'Active' : 'Inactive';
      });
    };
  
    // ==================== CHART INITIALIZATION ====================
    const initChart = visitData => {
      const config = {
        series: [
          { 
            name: 'This week', 
            data: visitData.thisWeek 
          },
          { 
            name: 'Last week', 
            data: visitData.lastWeek 
          }
        ],
        chart: { 
          type: 'area', 
          height: 320, 
          toolbar: { show: false }, 
          animations: { enabled: true } 
        },
        stroke: { 
          width: 3, 
          curve: 'smooth' 
        },
        markers: { 
          size: 5,
          colors: ['#fff'],
          strokeColors: ['#007bff', '#ff6b6b'],
          strokeWidth: 2,
          hover: { size: 7 } 
        },  
        grid: { 
          borderColor: 'rgba(0,0,0,0.1)',
          strokeDashArray: 3,
          xaxis: { lines: { show: true } },
          yaxis: { lines: { show: true } } 
        },
        xaxis: { 
          categories: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
          axisTicks: { show: false },
          axisBorder: { show: false } 
        },
        yaxis: { 
          tickAmount: 5,
          labels: { 
            formatter: val => `${val} Visit` 
          } 
        },
        tooltip: { 
          theme: 'dark',
          x: { show: true },
          y: { 
            formatter: val => `${val} Visit` 
          } 
        },
        colors: ['#007bff', '#ff6b6b'],
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'light',
            type: 'vertical',
            shadeIntensity: 0.25,
            gradientToColors: ['#80d0ff', '#ff9f9f'],
            opacityFrom: 1,
            opacityTo: 0.3,
          }
        },
      };
      new ApexCharts(document.querySelector('#traffic-overview'), config).render();
    };
  
    // ==================== QR CODE GENERATOR ====================
    const generateQRCode = async url => {
      if (!isValidUrl(url)) return showToast('URL tidak valid!', 'warning');
  
      const modalEl = document.getElementById('qrCodeModal');
      const modal = new bootstrap.Modal(modalEl);
      const container = modalEl.querySelector('#qrCodeContainer');
      const loader = container.querySelector('.qr-code-loader');
      const downloadBtn = modalEl.querySelector('#downloadQrCode');
      const urlEl = modalEl.querySelector('#qrCodeUrl');
  
      container.innerHTML = '';
      container.append(loader);
      loader.style.display = 'block';
  
      try {
        const res = await postForm({ url: '/qrcode/generate', data: { url } });
        const base64 = await res.text();
        loader.style.display = 'none';
  
        const img = document.createElement('img');
        img.src = base64;
        img.alt = 'QR Code';
        img.classList.add('img-fluid');
        container.append(img);
        urlEl.textContent = url;
  
        downloadBtn.onclick = () => {
          const a = document.createElement('a');
          a.href = base64;
          a.download = 'qrcode.png';
          a.click();
        };
      } catch {
        showToast('Gagal membuat QR Code.', 'error');
      }
  
      modal.show();
    };
  
    const setupQRCode = () => {
      const form = document.getElementById('qrForm');
      form.addEventListener('submit', e => {
        e.preventDefault();
        const url = form.querySelector('#qr_target_url').value.trim();
        generateQRCode(url);
      });
  
      document.querySelectorAll('.generate-qr').forEach(btn => {
        btn.addEventListener('click', () => {
          const url = btn.dataset.url.trim();
          generateQRCode(url);
        });
      });
    };
  
    // ==================== DYNAMIC TITLE UPDATE ====================
    const setupTitleUpdater = () => {
      document.querySelectorAll('.form-control[data-link-slug]').forEach(input => {
        input.addEventListener('blur', async () => {
          const newTitle = input.value.trim();
          const prev = input.dataset.previousTitle?.trim();
          const slug = input.dataset.linkSlug;
          if (!slug || newTitle === prev) return showToast('Title tidak berubah.', 'info');
  
          try {
            const res = await postForm({ url: `/dashboard/link/${slug}/update-title`, data: { title: newTitle } });
            const json = await res.json();
            if (res.ok && json.success) showToast('Title updated!');
            else throw new Error(json.message);
          } catch (err) {
            showToast(err.message || 'Error update title.', 'error');
          }
        });
      });
    };
  
    // ==================== SHARE MODAL ====================
    const setupShareModal = () => {
      const modalEl = document.getElementById('shareLinkModal');
  
      modalEl.addEventListener('show.bs.modal', ({ relatedTarget: btn }) => {
        const slug = btn.dataset.id;
        modalEl.querySelector('#linkId').value = slug;
      });
  
      const btnShare = modalEl.querySelector('#shareButton');
      if (btnShare) {
        btnShare.addEventListener('click', async () => {
          const linkId = modalEl.querySelector('#linkId').value;
          const sharedWith = modalEl.querySelector('#sharedWith').value;
          const sendNotif = modalEl.querySelector('#sendNotification').checked;
          try {
            const res = await postForm({
              url: '/dashboard/link/share',
              data: { link_id: linkId, shared_with: sharedWith, send_notification: sendNotif }
            });
            const json = await res.json();
            if (res.ok) showToast(json.message || 'Link shared!');
            else throw new Error(json.error);
            $('#shareLinkModal').modal('hide');
          } catch (err) {
            showToast(err.message, 'error');
          }
        });
      }
    };
  
    // ==================== INITIALIZATION ====================
    document.addEventListener('DOMContentLoaded', () => {
      setupDeleteModal();
      setupEditModal();
      initChart(window.visitDataGlobal || []);
      console.log(window.visitDataGlobal);
      setupQRCode();
      setupTitleUpdater();
      setupShareModal();
  
      // Show toasts on load
      document.querySelectorAll('.toast:not(.copy-toast)').forEach(el => new bootstrap.Toast(el).show());
    });
  
    // expose untuk tombol delete inline
    window.confirmDelete = confirmDelete;
  })();
  