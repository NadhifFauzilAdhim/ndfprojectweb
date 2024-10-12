<x-dashlayout>
<x-slot:title>{{ $title  }}</x-slot:title>
<div class="container-fluid">
    <div class="card">
        <div class="row ">
            <div class="col-md-12">
              @if(session()->has('success'))
              <div class="alert alert-success text-center" role="alert">
                {{ session('success') }}
              </div>
              @endif
               
            </div>
            <div class="col-md-12 d-flex">
              
              <a href="/dashboard/posts/create" class="btn btn-primary mt-4 ms-4">New Post</a>   
              <form action="/dashboard/posts" method="GET">
                <div class="input-group  mt-4 ms-4">
                    <input type="text" name="search" class="form-control" placeholder="Search Post" aria-label="Search" aria-describedby="button-addon2" value="{{ request('search')  }}">
                    <button class="btn btn-outline-primary" type="submit" id="button-addon2">Search</button>
                </div>
            </form> 
            </div>
            
        </div>
       
      <div class="card-body">
        <div class="row">
            @forelse ($posts as $post)
          <div class="col-md-4">
  
            <div class="card">
              @if($post->image)
              <a href="/dashboard/posts/{{ $post->slug }}">
                  <img src="{{ asset('storage/' . $post->image ) }}" class="card-img-top img-fluid fixed-size" alt="Post Image">
              </a>
             @else
              <a href="/dashboard/posts/{{ $post->slug }}">
                  <img src="{{ asset('img/programmer_text_2.jpg') }}" class="card-img-top img-fluid fixed-size" alt="Default Image">
              </a>
              @endif
                 
                <div class="card-body">
                  <h5 class="card-title">{{ $post->title }}</h5>
                  <h6 class="card-text"><i class="bi bi-bookmark-check "></i> <small>In Category {{ $post->category->name }}</small></h6>
                  <h6 class="card-text"><i class="bi bi-calendar-check "></i> <small>Posted on {{ $post->created_at }}</small></h6>
                  <h6 class="card-text"><i class="bi bi-pencil-square"></i> <small>Modified {{ $post->updated_at->diffForHumans() }}</small></h6>
                  <p class="card-text">{{ Str::limit(strip_tags($post->body), 100) }} </p>
                  
                  <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                      <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item fw-bold" href="/dashboard/posts/{{ $post->slug }}"><i class="bi bi-eye"></i> Post Preview</a></li>
                        <li><a class="dropdown-item fw-bold" href="/blog/{{ $post->slug }}"><i class="bi bi-eye"></i> Lihat Post Asli</a></li>
                        <li><a class="dropdown-item fw-bold" href="/dashboard/posts/{{ $post->slug }}/edit"><i class="bi bi-pencil-square"></i> Edit Post</a></li>
                        <li>
                          <button type="button" class="dropdown-item fw-bold text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                              <i class="bi bi-trash"></i> Delete Post
                          </button>
                      </li>
                      
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="deleteModalLabel">Hapus Post {{ $post->title }}</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Aksi ini tidak dapat dibatalkan, Apakah Anda yakin ingin menghapus post ini?
                          
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                          <form action="/dashboard/posts/{{ $post->slug }}" method="POST" class="d-inline">
                              @method('delete')
                              @csrf
                              <button type="submit" class="btn btn-danger">Hapus</button>
                          </form>
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
      </div>
    </div>
    
  </div>
</x-dashlayout>