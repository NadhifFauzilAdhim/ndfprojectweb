<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title fw-semibold mb-4 text-center">Create New Post</h4>
                <div class="card">
                    <div class="card-body">
                        <form action="/dashboard/posts" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Masukan Judul</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Masukan Judul" name="title" value="{{ old('title') }}" required autofocus>
                                @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="slug" class="form-label">Buat Custom URL</label>
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon3">https://ndfproject.my.id/blog/</span>
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror" oninput="generateSlug()" id="slug" name="slug" aria-describedby="basic-addon3 basic-addon4" value="{{ old('slug') }}" required>
                                                @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="form-text" id="basic-addon4">Link ini akan digunakan sebagai URL</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Pilih Kategori Post</label>
                                            <select class="form-select" aria-label="Default select example" name="category_id" required>
                                                @foreach ($categories as $category)
                                                @if(old('category_id') == $category->id)
                                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                                @else
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Area untuk drag and drop gambar -->
                            <div class="mb-3">
                                <label for="image" class="form-label @error('image') is-invalid @enderror">Pilih File Banner <small>max size 2mb optional</small></label>
                                <div id="drop-area" class="border rounded p-4 mb-3 text-center" style="border-style: dashed;">
                                    <i class="bi bi-cloud-arrow-up-fill fs-6 text-primary"></i>
                                    <p class="fw-bold">Drag & drop your image here or click to select a file</p>
                                    <input class="form-control d-none" type="file" id="image" name="image" onchange="previewImage()" accept="image/*">
                                    <div class="d-flex justify-content-center">
                                        <img id="imgPreview" src="#" alt="Pratinjau Gambar" class="img-fluid mt-3" style="display: none; max-height: 300px;">
                                    </div>
                                </div>
                                @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="generate-title" class="form-label"><strong>Generate Post with AI ✨</strong></label>
                                <div class="input-group">
                                    <input type="text" class="form-control w-75" id="generate-title" placeholder="Judul untuk AI" aria-label="Judul untuk AI">
                                    <select id="language" class="form-select">
                                        <option value="id" selected>Indonesia</option>
                                        <option value="en">Inggris</option>
                                    </select>
                                    <button type="button" id="generate-button" class="btn btn-outline-primary">
                                        Generate
                                        <span class="spinner-border spinner-border-sm ms-2 d-none" role="status" aria-hidden="true"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="summernote" class="form-label">Tulis Post Anda</label>
                                <textarea id="summernote" name="body" class="form-control">
                                    {{ old('body') }}
                                </textarea>
                                @error('body')
                                <div class="alert alert-danger" role="alert">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Create Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/dashjs/filehandle.js') }}"></script>
    <script src="{{ asset('js/dashjs/generate-post.js') }}"></script>
</x-dashlayout>