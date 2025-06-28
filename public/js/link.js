/*
 * File: link.js
 * Deskripsi: Script untuk halaman link dashboard shortlink (termasuk manajemen kategori)
 * Author: Nadhif Fauzil.
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
      const options = {
          method: useMethod,
          headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': token,
              'Accept': 'application/json'
          }
      };
      if (useMethod !== 'GET' && useMethod !== 'HEAD') {
           options.body = JSON.stringify(data);
      }
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
              document.getElementById(`deleteForm-${slug}`).submit();
          }
      });
  };

  // ==================== MODAL HANDLERS ====================
  const setupDeleteModal = () => {
      const modalEl = document.getElementById('deleteModal');
      if (!modalEl) return;

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
    if (!modalEl) return;

    modalEl.addEventListener('show.bs.modal', ({ relatedTarget: btn }) => {
        const { id, targetUrl, active, categoryId } = btn.dataset;

        const form = modalEl.querySelector('#editForm');
        const urlInput = modalEl.querySelector('#editTargetUrl');
        const categorySelect = modalEl.querySelector('#editLinkCategory');
        const visibilitySelect = modalEl.querySelector('#editVisibility');

        form.action = `/dashboard/link/${id}`;
        urlInput.value = targetUrl;

        if (categorySelect) {
            categorySelect.value = categoryId || "";
        }

        if (visibilitySelect) {
            visibilitySelect.value = active === '1' ? '1' : '0';
        }
    });
};

  const setupAddCategoryModal = () => {
      const addCategoryForm = document.getElementById('addCategoryForm');
      if (!addCategoryForm) return;

      const saveCategoryBtn = document.getElementById('saveCategoryBtn');
      const categoryNameInput = document.getElementById('categoryName');
      const categoryNameError = document.getElementById('categoryNameError');
      const addCategoryModalEl = document.getElementById('addCategoryModal');
      const addCategoryModal = new bootstrap.Modal(addCategoryModalEl);
      
      const createFormCategorySelect = document.getElementById('link_category_id_select');
      const editFormCategorySelect = document.getElementById('editLinkCategory');

      addCategoryForm.addEventListener('submit', function (e) {
          e.preventDefault();

          saveCategoryBtn.disabled = true;
          saveCategoryBtn.querySelector('.spinner-border').classList.remove('d-none');
          categoryNameInput.classList.remove('is-invalid');
          const storeUrl = '/dashboard/link-category';
          postForm({
              url: storeUrl,
              data: { name: categoryNameInput.value }
          })
          .then(response => {
              if (!response.ok) {
                  return response.json().then(err => { throw err });
              }
              return response.json();
          })
          .then(data => {
              if (data.success) {
                  const newOption = new Option(data.data.name, data.data.id);
                  if (createFormCategorySelect) {
                      createFormCategorySelect.add(newOption.cloneNode(true));
                  }
                  if (editFormCategorySelect) {
                      editFormCategorySelect.add(newOption.cloneNode(true));
                  }
                  if (createFormCategorySelect) {
                      newOption.selected = true;
                  }
                  
                  addCategoryModal.hide();
                  addCategoryForm.reset();
                  showToast('Category added successfully!', 'success');
              }
          })
          .catch(error => {
              console.error('Error:', error);
              if (error.errors && error.errors.name) {
                  categoryNameInput.classList.add('is-invalid');
                  categoryNameError.textContent = error.errors.name[0];
              } else {
                  showToast(error.message || 'An unexpected error occurred.', 'error');
              }
          })
          .finally(() => {
              saveCategoryBtn.disabled = false;
              saveCategoryBtn.querySelector('.spinner-border').classList.add('d-none');
          });
      });

      addCategoryModalEl.addEventListener('hidden.bs.modal', function () {
          categoryNameInput.classList.remove('is-invalid');
          addCategoryForm.reset();
      });
  };
  
  document.addEventListener('DOMContentLoaded', setupEditModal);
  
    let trafficChart = null;

    const initChart = visitData => {
        const config = {
            series: [{
                name: 'This week',
                data: visitData.thisWeek || []
            }, {
                name: 'Last week',
                data: visitData.lastWeek || []
            }],
            chart: {
                type: 'area', // Tipe default
                height: 320,
                toolbar: { show: true },
                animations: { enabled: true },
                zoom: { enabled: false }
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
                xaxis: { lines: { show: false } },
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
            dataLabels: {
                enabled: false
            }
        };

        if (trafficChart) {
            trafficChart.destroy();
        }

        trafficChart = new ApexCharts(document.querySelector('#traffic-overview'), config);
        trafficChart.render();
    };

    const setupChartSelector = () => {
      const selector = document.getElementById('chartTypeSelector');
      if (selector) {
          selector.addEventListener('change', (e) => {
              const newType = e.target.value;
              if (trafficChart) {
                  trafficChart.updateOptions({
                      chart: { type: newType },
                      stroke: { curve: newType === 'bar' ? 'straight' : 'smooth' }
                  });
              }
          });
      }
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

    const setupCategoryShared = () => { 
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
        // Menangani klik pada tombol toggle share
        document.body.addEventListener('click', function (event) {
            if (event.target.closest('.toggle-share-btn')) {
                const button = event.target.closest('.toggle-share-btn');
                const categoryId = button.dataset.categoryId;
                const isCurrentlyShared = button.classList.contains('btn-info');
    
                // Tampilkan konfirmasi
                Swal.fire({
                    title: isCurrentlyShared ? 'Buat Pribadi?' : 'Bagikan Kategori?',
                    text: isCurrentlyShared
                        ? 'Kategori akan menjadi pribadi dan tidak dapat diakses publik.'
                        : 'Kategori akan dibagikan dan bisa diakses publik.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: isCurrentlyShared ? 'Ya, buat pribadi' : 'Ya, bagikan',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        fetch(`/dashboard/link-category/${categoryId}/toggle-share`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                '_method': 'PATCH', 
                            },
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    const isShared = data.shared;
                                    navigator.clipboard.writeText(`https://linksy.site/vault/${categoryId}`); // Simpan link ke clipboard
                                    button.classList.toggle('btn-info', isShared);
                                    button.classList.toggle('btn-outline-secondary', !isShared);
                                    button.textContent = isShared ? 'Shared' : 'Private';
    
                                    // Perbarui tooltip
                                    const newTitle = isShared
                                        ? 'This category is shared. Click to make private.'
                                        : 'This category is private. Click to share.';
                                    button.setAttribute('data-bs-original-title', newTitle);
    
                                    const tooltipInstance = bootstrap.Tooltip.getInstance(button);
                                    if (tooltipInstance) {
                                        tooltipInstance.setContent({ '.tooltip-inner': newTitle });
                                    }
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.message,
                                        timer: 1500,
                                        showConfirmButton: false,
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: data.message || 'Terjadi kesalahan saat memperbarui status.',
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal memperbarui status kategori.',
                                });
                            });
                    }
                });
            }
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
      setupAddCategoryModal(); 
      setupQRCode();
      setupTitleUpdater();
      setupShareModal();
      setupCategoryShared();
      
      if(typeof ApexCharts !== 'undefined' && document.querySelector('#traffic-overview')) {
          initChart(window.visitDataGlobal || { thisWeek: [], lastWeek: [] });
          setupChartSelector();
      }
      document.querySelectorAll('.toast:not(.copy-toast)').forEach(el => new bootstrap.Toast(el).show());
  });
  window.confirmDelete = confirmDelete;
})();
  