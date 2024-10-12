<x-dashlayout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <div class="container-fluid">
      <div class="card">
          <div class="card-body">
              <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                  <div class="btn-group mt-3 mb-3" role="group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                          Action
                      </button>
                      <ul class="dropdown-menu">
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
              <h1 class="fw-semibold mb-2 text-center">{{ $post->title }}</h1>
              <p class="fs-4 text-center">Posted {{ $post->created_at }} in Category <b><a href="">{{ $post->category->name }}</a></b></p>
              <div class="d-flex justify-content-center">
                @if($post->image)
                <img class="img-fluid" src="{{ asset('storage/' . $post->image ) }}" alt="">
                @else
                <img class="img-fluid" src="{{ asset('img/programmer_text_2.jpg') }}" alt="">
                @endif
              </div>
              <div class="card">
                  <p>{!! $post->body !!}</p>
              </div>
          </div>
      </div>

      <!-- Modal Konfirmasi Hapus -->
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
  </div>
</x-dashlayout>
