<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if(session()->has('success'))
                        <div class="toast-container position-fixed top-0 end-0 p-3">
                            <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        <i class="bi bi-check-circle-fill me-3"></i>{{ session('success') }}
                                    </div>
                                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(session()->has('error'))
                        <div class="toast-container position-fixed top-0 end-0 p-3">
                            <div class="toast align-items-center text-bg-warning border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        <i class="bi bi-exclamation-diamond-fill me-3"></i> {{ session('error') }}
                                    </div> 
                                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="alert alert-warning text-center" role="alert">
                            Admin Zone 
                           </div>
                        <h5 class="card-title">All Categories</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle text-center">
                                <thead>
                                    <tr class="border-2 border-bottom border-primary border-0"> 
                                        <th scope="col" class="ps-0">Categories</th>
                                        <th scope="col">Link</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Post</th>
                                        <th scope="col" class="text-center">Slug</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @forelse ($categories as $category)
                                    <tr>
                                        <th scope="row" class="ps-0 fw-medium">
                                            <span class="table-link1 text-truncate d-block">{{ $category->name }} </span>
                                        </th>
                                        <td>
                                            <a href="/blog?category={{ $category->slug }}" class="link-primary text-dark fw-medium d-block">Goto</a>
                                        </td>
                                        <td>
                                            <a href="{{ $category->image }}" class="link-primary text-dark fw-medium d-block image-data-url">Goto</a>
                                        </td>
                                        <td class=" fw-medium">{{ $category->posts()->count() }} Post</td>
                                        <td class="text-center fw-medium">{{ $category->slug }}</td>
                                        <td class="text-center fw-medium">
                                            <button 
                                                class="btn btn-primary btn-sm" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal" 
                                                data-slug="{{ $category->slug }}"
                                            >
                                                Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-slug="{{ $category->slug }}">Delete</button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No categories found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold mb-2">Add New Post Categories</h5>
                        <div class="card">
                            <div class="card-body">
                                <form action="/dashboard/categories" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp" oninput="generateSlug()">
                                    </div>
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" class="form-control" id="slug" name="slug" aria-describedby="emailHelp">
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image URL</label>
                                        <input type="text" class="form-control" id="image" name="image" aria-describedby="emailHelp">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="editName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editName" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="editSlug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="editSlug" name="slug">
                        </div>
                        <div class="mb-3">
                            <label for="editImage" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="editImage" name="image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" form="editForm">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        const name = document.querySelector('#name');
        const slug = document.querySelector('#slug');

        name.addEventListener('change', function() {
            fetch('/dashboard/categories/checkSlug?name=' + name.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        document.addEventListener('DOMContentLoaded', function() {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; 
            var slug = button.getAttribute('data-slug'); 
            var row = button.closest('tr');
            var name = row.querySelector('.table-link1').innerText;
            var image = row.querySelector('td .image-data-url ').getAttribute('href'); // Ambil href dari link image.

            var form = document.getElementById('editForm');
            var editName = document.getElementById('editName');
            var editSlug = document.getElementById('editSlug');
            var editImage = document.getElementById('editImage');

            form.action = '/dashboard/categories/' + slug; 
            editName.value = name; 
            editSlug.value = slug; 
            editImage.value = image; 
        });
    });

        document.addEventListener("DOMContentLoaded", function() {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            const toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl);
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
</x-dashlayout>
