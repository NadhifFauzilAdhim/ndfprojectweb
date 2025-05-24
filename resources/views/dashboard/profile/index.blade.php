<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <div class="modal fade" id="changeImageModal" tabindex="-1" aria-labelledby="changeImageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeImageModalLabel">Change Profile Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/dashboard/profile/{{ $user->username }}/change-image" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload New Image <br>
                                    <small>*Max File Size 2Mb</small>
                                </label>
                                <div id="drop-area" class="border rounded p-4 text-center" 
                                     ondrop="dropHandler(event);" 
                                     ondragover="dragOverHandler(event);"
                                     ondragleave="dragLeaveHandler(event);">
                                    <p>Drag & Drop your image here or click to select</p>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror d-none" 
                                           id="image" name="image" accept="image/*" onchange="previewImage(event)">
                                    <button type="button" class="btn btn-sm btn-outline-info" onclick="document.getElementById('image').click();">Select Image</button>
                                </div>
                                @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- Image preview -->
                            <div class="mb-3 d-flex justify-content-center">
                                <img id="preview" src="#" alt="Image Preview" class="img-fluid rounded-circle d-none" width="205"/>
                            </div>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body p-4 text-center">
                        <div class="position-relative mx-auto" style="width: 180px">
                            @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 class="profile-img shadow-lg" alt="profile">
                            @elseif($user->google_avatar)
                                <img src="{{ $user->google_avatar }}" 
                                     class="profile-img shadow-lg" alt="profile">
                            @else
                                <img src="https://img.icons8.com/color/500/user-male-circle--v1.png" 
                                     class="profile-img shadow-lg" alt="profile">
                            @endif
                            <button class="btn btn-light rounded-circle p-2 shadow-sm btn-edit-image" 
                                    data-bs-toggle="modal" data-bs-target="#changeImageModal">
                                <i class="bi bi-pencil-fill text-primary"></i>
                            </button>
                        </div>
                        
                        <h2 class="mt-4 mb-1 fw-bold">{{ $user->name }}</h2>
                        
                        <div class="d-flex align-items-center justify-content-center gap-2 mb-3">
                            <span class="badge bg-primary-soft text-primary rounded-pill">
                                @if($user->is_admin) Admin @endif
                            </span>
                            @if($user->gauth_id)
                            <span class="badge bg-success-soft text-success rounded-pill">
                                <i class="bi bi-google me-1"></i>Connected
                            </span>
                            @endif
                        </div>
                        
                        <div class="text-muted small">
                            <i class="bi bi-clock-history me-1"></i>
                            Member since {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>
            </div>
  
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Your Profile</h5>
                        <div class="card">
                            <div class="card-body">
                                <form action="/dashboard/profile/{{ $user->username }}" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $user->name) }}">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username', $user->username) }}">
                                        @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" value="{{ $user->email }}" disabled>
                                    </div>
                                    <div class="row text-center">
                                      <div class="col-6">
                                        <button type="submit" class="btn btn-outline-primary">Change Profile</button>
                                      </div>
                                      <div class="col-6">
                                        <a class="btn btn-outline-warning" href="{{ url('/dashboard/profile/change-password') }}">Change Password</a>
                                      </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <!-- JavaScript for drag and drop -->
    <script>
        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var dataURL = reader.result;
                var preview = document.getElementById('preview');
                preview.src = dataURL;
                preview.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
  
        function dragOverHandler(event) {
            event.preventDefault();
            document.getElementById('drop-area').classList.add('dragging');
        }
  
        function dragLeaveHandler(event) {
            event.preventDefault();
            document.getElementById('drop-area').classList.remove('dragging');
        }
  
        function dropHandler(event) {
            event.preventDefault();
            document.getElementById('drop-area').classList.remove('dragging');
            var files = event.dataTransfer.files;
            document.getElementById('image').files = files;
            previewImage({target: document.getElementById('image')});
        }
  
        // Auto-show toast when page loads if there's a session message
        document.addEventListener("DOMContentLoaded", function() {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            const toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl);
            });
            toastList.forEach(toast => toast.show());
        });
    </script>
     <style>
        .profile-img {
            width: 180px;
            height: 180px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
        }
        
        .btn-edit-image {
            position: absolute;
            right: 10px;
            bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .btn-edit-image:hover {
            transform: scale(1.1);
        }
        
        .drop-zone {
            transition: all 0.3s ease;
            background: #f8f9fa;
            cursor: pointer;
        }
        
        .drop-zone.dragging {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }
        
        .preview-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        
        .bg-primary-soft {
            background-color: rgba(13, 110, 253, 0.1);
        }
        
        .bg-success-soft {
            background-color: rgba(25, 135, 84, 0.1);
        }
        
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }
    </style>
  </x-dashlayout>
  