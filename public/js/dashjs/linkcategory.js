document.addEventListener('DOMContentLoaded', function () {
    const addCategoryForm = document.getElementById('addCategoryForm');
    if (!addCategoryForm) return; 

    const saveCategoryBtn = document.getElementById('saveCategoryBtn');
    const categoryNameInput = document.getElementById('categoryName');
    const categoryNameError = document.getElementById('categoryNameError');
    const addCategoryModalEl = document.getElementById('addCategoryModal');
    const addCategoryModal = new bootstrap.Modal(addCategoryModalEl);
    const categorySelect = document.getElementById('link_category_id_select');
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    addCategoryForm.addEventListener('submit', function (e) {
        e.preventDefault();
        
        saveCategoryBtn.disabled = true;
        saveCategoryBtn.querySelector('.spinner-border').classList.remove('d-none');
        categoryNameInput.classList.remove('is-invalid');

        const storeUrl = '/dashboard/link-category';

        fetch(storeUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken, 
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                name: categoryNameInput.value
            })
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
                categorySelect.add(newOption);
                newOption.selected = true;
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
                showToast('An unexpected error occurred. Please try again.', 'error');
            }
        })
        .finally(() => {
            saveCategoryBtn.disabled = false;
            saveCategoryBtn.querySelector('.spinner-border').classList.add('d-none');
        });
    });

    /**
     * Fungsi untuk menampilkan notifikasi toast menggunakan SweetAlert2.
     * @param {string} message - Pesan yang akan ditampilkan.
     * @param {string} type - Tipe notifikasi ('success', 'error', 'warning', 'info').
     */
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
    addCategoryModalEl.addEventListener('hidden.bs.modal', function () {
        categoryNameInput.classList.remove('is-invalid');
        addCategoryForm.reset();
    });
});