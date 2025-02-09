<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            @if(session()->has('success'))
                                Swal.fire({
                                    text: "{{ session('success') }}",
                                    icon: 'success',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });
                            @elseif(session()->has('error'))
                                Swal.fire({
                                    text: "{{ session('error') }}",
                                    icon: 'error',
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                });
                            @endif
                        });
                    </script>
                </div>
                <div class="col-md-12 d-flex">
                    <a href="/dashboard/posts/create" class="btn btn-primary mt-4 ms-4 d-none d-sm-block">
                        New Post
                    </a>
                    <a href="/dashboard/posts/create" class="btn btn-primary mt-4 ms-4 d-block d-sm-none">
                        <i class="bi bi-plus"></i>
                    </a>
                    <form action="/dashboard/posts" method="GET">
                        <div class="input-group mt-4 ms-4">
                            <input type="text" name="search" class="form-control" placeholder="Search Post" aria-label="Search" aria-describedby="button-addon2" value="{{ request('search') }}">
                            <button class="btn btn-outline-primary" type="submit" id="button-addon2"><i class="bi bi-search"></i></button>
                        </div>
                    </form>
                </div>  
            </div>
  
            <div class="card-body">
                <div class="row">
                    @forelse ($posts as $post)
                    <div class="col-md-4 mt-3">
                        <div class="card h-100 d-flex flex-column shadow">
                            @if($post->image)
                            <a href="/dashboard/posts/{{ $post->slug }}">
                                <img src="{{ asset('storage/' . $post->image ) }}" class="card-img-top img-fluid fixed-size" alt="Post Image">
                            </a>
                            @else
                            <a href="/dashboard/posts/{{ $post->slug }}">
                                <img src="{{ asset('img/programmer_text_2.jpg') }}" class="card-img-top img-fluid fixed-size" alt="Default Image">
                            </a>
                            @endif
            
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <h6 class="card-text"><i class="bi bi-bookmark-check"></i> <small>In Category {{ $post->category->name }}</small></h6>
                                <h6 class="card-text"><i class="bi bi-calendar-check"></i> <small>Posted on {{ $post->created_at }}</small></h6>
                                <h6 class="card-text"><i class="bi bi-pencil-square"></i> <small>Modified {{ $post->updated_at->diffForHumans() }}</small></h6>
                                <p class="card-text">{{ $post->excerpt }}</p>
            
                                <div class="btn-group mt-auto" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                            Action
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item fw-bold" href="/dashboard/posts/{{ $post->slug }}"><i class="bi bi-eye"></i> Post Preview</a></li>
                                            <li><a class="dropdown-item fw-bold" href="/blog/{{ $post->slug }}"><i class="bi bi-eye"></i> Lihat Post Asli</a></li>
                                            <li><a class="dropdown-item fw-bold" href="/dashboard/posts/{{ $post->slug }}/edit"><i class="bi bi-pencil-square"></i> Edit Post</a></li>
                                            <li>
                                                <button type="button" class="dropdown-item fw-bold text-danger" onclick="confirmDelete('{{ $post->slug }}', '{{ $post->title }}')">
                                                    <i class="bi bi-trash"></i> Delete Post
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center">
                        <h1 class="home__title">Nampaknya Belum Ada Post &#129300;</h1>
                        <p class="home__description">
                            Anda bisa membuat Post pada menu Create New Post
                        </p>
                    </div>
                    @endforelse
                </div>
                {{ $posts->links() }}
            </div>
            
        </div>
    </div>
  
    <script>
        function confirmDelete(slug, title) {
            Swal.fire({
                title: `Hapus Post "${title}"?`,
                text: "Aksi ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                width: '400px',
                heightAuto: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.action = `/dashboard/posts/${slug}`;
                    form.method = 'POST';
                    form.innerHTML = `
                        @csrf
                        @method('DELETE')
                    `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
  </x-dashlayout>
  