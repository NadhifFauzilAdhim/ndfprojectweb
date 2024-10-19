<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if(session()->has('success'))
                        <div class="alert alert-success text-center" role="alert">  
                            {{ session('success') }}
                        </div>
                        @endif
                        @if(session()->has('error'))
                        <div class="alert alert-danger text-center" role="alert">  
                            {{ session('error') }}
                        </div>
                        @endif
                        <div class="container">
                            <div class="alert alert-warning text-center" role="alert">  
                               Admin Zone 
                              </div>
                            <div class="row d-flex">
                                <h5 class="card-title">All Post</h5>
                                <form action="/dashboard/postmanagement" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Search Post" aria-label="Search" aria-describedby="button-addon2">
                                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">Search</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table text-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="border-2 border-bottom border-primary border-0"> 
                                        <th scope="col" class="ps-0">Post Name</th>
                                        <th scope="col">Author</th>
                                        <th scope="col" class="text-center">Date</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    @forelse ($posts as $post)
                                    <tr>
                                        <th scope="row" class="ps-0 fw-medium">
                                            <span class="table-link1 text-truncate d-block"><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a> </span>
                                        </th>
                                        <td class=" fw-medium">{{ $post->author->name }}</td>
                                        <td class=" fw-medium">{{ $post->created_at }}</td>
                                        <td class="text-center fw-medium">
                                            <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-slug="{{ $post->slug }}">Delete</button>
                                        </td>
                                        
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No categories found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $posts->links() }}
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
    </div>

    <!-- Modal for delete confirmation -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center">Are you sure you want to delete this Post?</p>
                    <div class="mb-3">
                        <label for="reason" class="form-label">Reason for deletion (optional):</label>
                        <input type="text" class="form-control" id="reason" name="reason" placeholder="Enter reason here">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="" method="POST" class="d-inline">
                        @method('delete')
                        @csrf
                        <input type="hidden" id="reasonInput" name="delete_reason">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; 
                var slug = button.getAttribute('data-slug'); 
                var form = document.getElementById('deleteForm');
                form.action = '/dashboard/postmanagement/' + slug; 
            });
        });
    </script>
</x-dashlayout>
