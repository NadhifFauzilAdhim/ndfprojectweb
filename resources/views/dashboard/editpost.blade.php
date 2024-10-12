<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title fw-semibold mb-4 text-center">Edit Post <br><small>Last updated: {{ $post->updated_at }}</small></h4>
                <div class="card">
                    <div class="card-body">
                        <form action="/dashboard/posts/{{ $post->slug }}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Masukan Judul</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Masukan Judul" name="title" value="{{ old('title', $post->title) }}" required autofocus>
                                @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Buat Custom URL</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon3">https://ndfproject.my.id/blog/</span>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" oninput="generateSlug()" id="slug" name="slug" aria-describedby="basic-addon3 basic-addon4" value="{{ old('slug', $post->slug) }}" required>
                                    @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-text" id="basic-addon4">Link ini akan digunakan sebagai URL</div>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Pilih Kategori Post</label>
                                <select class="form-select" aria-label="Default select example" name="category_id" required>
                                    @foreach ($categories as $category)
                                    @if(old('category_id', $post->category_id) == $category->id)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @endif
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label @error('image') is-invalid @enderror">Pilih File Banner</label>
                                <input class="form-control" type="file" id="image" name="image" onchange="previewImage()">
                                @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                                <div class="d-flex justify-content-center">
                                  @if($post->image)
                                  <img id="imgPreview" src="{{ asset('storage/' . $post->image ) }}" alt="Pratinjau Gambar" class="img-fluid mt-3" >
                                  @else
                                  <img id="imgPreview" src="#" alt="Pratinjau Gambar" class="img-fluid mt-3" >
                                  @endif
                                </div>
                            </div>
                            <input type="hidden" name="oldImagePoster" value="{{ $post->image }}">
                            <div class="mb-3">
                                <label for="x" class="form-label">Tulis Post Anda</label>
                                @error('body')
                                <div class="alert alert-danger" role="alert">
                                    {{ $message }}
                                </div>
                                @enderror
                                <input id="x" type="hidden" name="body" value="{{ old('body', $post->body) }}">
                                <trix-editor input="x"></trix-editor>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const title = document.querySelector('#title');
        const slug = document.querySelector('#slug');

        title.addEventListener('change', function() {
            fetch('/dashboard/posts/checkSlug?title=' + title.value)
                .then(response => response.json())
                .then(data => slug.value = data.slug)
        });

        function previewImage() {
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('#imgPreview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            };
        }
    </script>
</x-dashlayout>
