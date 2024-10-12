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
                                    <button type="button" class="btn btn-sm btn-info" onclick="document.getElementById('image').click();">Select Image</button>
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
                    <div class="card-body text-center">
                        @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="image" class="img-fluid rounded-circle" width="205">
                        @else
                        <img src="https://img.icons8.com/color/500/user-male-circle--v1.png" alt="image" class="img-fluid rounded-circle" width="205">
                        @endif
                        <h4 class="mt-7">{{ $user->name }} <i class="bi bi-patch-check-fill me-1 text-primary"></i><span class="badge text-bg-success rounded-pill ms-1">@if($user->is_admin)<small>Admin</small>@endif</span></h4>
                        <p class="card-subtitle mt-2 mb-3">Joined on {{ $user->created_at }}</p>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#changeImageModal">Change Image</button>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @if(session()->has('success'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif
                        <h5 class="card-title fw-semibold">Change Password</h5>
                        <div class="card">
                            <div class="card-body">
                                <form action="/dashboard/profile/{{ $user->username }}/change-password" method="POST">
                                    @method('PUT')
                                    @csrf
                                    <div class="mb-3">
                                        <label for="old_password" class="form-label">Password lama</label>
                                        <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" id="old_password">
                                        @error('old_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Password Baru</label>
                                        <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="new_password">
                                        @error('new_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="newpassword" class="form-label">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
                                        @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    
                                    <div class="row text-center">
                                      <div class="col-6">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
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
    </script>
  </x-dashlayout>
  