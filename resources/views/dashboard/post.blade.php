<x-dashlayout>
<x-slot:title>{{ $title  }}</x-slot:title>
<div class="container-fluid">
    <div class="card">
        <div class="row">
            <div class="col-md-12">
              @if(session()->has('success'))
              <div class="alert alert-success text-center" role="alert">
                {{ session('success') }}
              </div>
              @endif
                <a href="/dashboard/posts/create" class="btn btn-primary mt-4 ms-4">Create New Post</a>    
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
                  <h6 class="card-text"><i class="bi bi-bookmark-check-fill text-secondary"></i> In Category {{ $post->category->name }}</h6>
                  <h6 class="card-text"><i class="bi bi-calendar-check-fill text-secondary"></i> Posted on {{ $post->created_at }}</h6>
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
      </div>
    </div>
   
  </div>
</x-dashlayout>