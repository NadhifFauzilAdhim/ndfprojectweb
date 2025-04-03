<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="container-fluid px-lg-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-semibold text-primary">Post Management</h4>
                            <div class="alert alert-warning alert-dismissible fade show py-2" role="alert">
                                <i class="bi bi-shield-exclamation me-2"></i>Admin Zone
                                <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-4">
                        @if(session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-md-8">
                                <form action="/dashboard/postmanagement" method="GET">
                                    <div class="input-group search-bar">
                                        <span class="input-group-text bg-transparent border-end-0">
                                            <i class="bi bi-search text-muted"></i>
                                        </span>
                                        <input type="text" name="search" class="form-control border-start-0" 
                                               placeholder="Search posts..." aria-label="Search">
                                        <button class="btn btn-primary px-4" type="submit">
                                            <i class="bi bi-arrow-right-short"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive rounded-3 border">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="ps-4">Post Title</th>
                                        <th scope="col">Author</th>
                                        <th scope="col" class="text-center">Date</th>
                                        <th scope="col" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @forelse ($posts as $post)
                                    <tr class="align-middle">
                                        <td class="ps-4">
                                            <a href="{{ route('blog.show', $post->slug) }}" 
                                               class="text-dark fw-semibold post-title">
                                                {{ \Illuminate\Support\Str::limit($post->title, 50, $end='...') }}
                                            </a>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <div class="avatar-title bg-primary text-white rounded-circle">
                                                        {{ strtoupper(substr($post->author->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <span class="fw-medium">{{ $post->author->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center text-muted">
                                            {{ $post->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-link text-danger p-1" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal" 
                                                    data-slug="{{ $post->slug }}"
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete Post">
                                                <i class="bi bi-trash3-fill fs-5"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bi bi-file-earmark-x fs-1 text-muted mb-2"></i>
                                                <p class="text-muted mb-0">No posts found</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $posts->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title text-danger" id="deleteModalLabel">
                        <i class="bi bi-exclamation-octagon-fill me-2"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-3">
                        <i class="bi bi-trash3-fill fs-1 text-danger"></i>
                    </div>
                    <p class="text-center mb-4">Are you sure you want to delete this post? This action cannot be undone.</p>
                    <div class="mb-4">
                        <label for="reason" class="form-label fw-medium">Reason for deletion (optional):</label>
                        <textarea class="form-control" id="reason" name="reason" 
                                  rows="2" placeholder="Enter reason here..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <input type="hidden" id="reasonInput" name="delete_reason">
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="bi bi-trash3-fill me-2"></i>Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete Modal Handler
            const deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const slug = button.getAttribute('data-slug');
                const form = document.getElementById('deleteForm');
                form.action = `/dashboard/postmanagement/${slug}`;
                
                // Handle reason input
                const reasonInput = document.getElementById('reasonInput');
                const reasonTextarea = document.getElementById('reason');
                reasonTextarea.addEventListener('input', function() {
                    reasonInput.value = this.value;
                });
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        });
    </script>

    <style>
        .search-bar .form-control {
            border-radius: 0.75rem;
            height: 45px;
        }
        .search-bar .input-group-text {
            border-radius: 0.75rem 0 0 0.75rem;
        }
        .search-bar .btn {
            border-radius: 0 0.75rem 0.75rem 0;
            height: 45px;
        }
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 0.875rem;
        }
        .post-title:hover {
            color: var(--bs-primary) !important;
            text-decoration: underline;
        }
        .table-hover tbody tr {
            transition: all 0.2s ease;
        }
        .modal-header {
            padding: 1.5rem;
        }
        .modal-footer {
            padding: 1rem 1.5rem;
        }
    </style>
</x-dashlayout>