<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 2000;">
      <div id="toastMessage" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="d-flex">
              <div class="toast-body">
                @if(!Auth::check())
                Waktunya berbagi cerita kamu! Login dan mulai blog kamu sekarang!
                <a href="{{ route('login') }}" class="link text-warning">Login</a>
                @else
                Waktunya berbagi cerita kamu!  <a href="{{ route('dashboard') }}" class="link text-warning">Create Post</a>
                @endif
              </div>
              <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
      </div>
  </div>
  <div class="bloghero overlay inner-page">
        <img src="{{ asset('img/cat.png') }}" alt="" class="img-fluid blob">
      <div class="container">
          <div class="row align-items-center justify-content-center text-center pt-5">
              <div class="col-lg-10 mt-5">
                  @if(request('author') && $posts->count() > 0)
                      <img src="{{ asset('uploads/' . $posts->first()->author->avatar) }}" alt="" width="150" class="rounded-circle ">
                      <h1 class="heading text-white mb-3" data-aos="fade-up">{{ $posts->count() }} Article By {{ $posts->first()->author->name }}</h1> 

                      <div class="d-flex justify-content-center" data-aos="fade-up">
                      </div>
                  @elseif(request('category'))
                      <h1 class="heading text-white mb-3" data-aos="fade-up">Post in Category @if($posts) {{ $posts->first()->category->name }} @endif</h1> 
                  @elseif($type == 'all')
                     <div class="row align-items-center justify-content-center">
                      <div class="col-lg-6">
                        <img src="{{ asset('img/myspace.png') }}" alt="" class="img-fluid ">
                      </div>
                     </div>
                  @endif
                  <div class="row justify-content-center">
                      <div class="col-lg-6">
                          <form
                              action=""
                              method="GET"
                              class="custom-form mt-4 pt-2 mb-5"
                              role="search"
                              data-aos="fade"
                              data-aos-delay="300"
                          >
                              @if(request('category'))
                                  <input type="hidden" name="category" value="{{ request('category') }}">
                              @endif
                              @if(request('author'))
                                  <input type="hidden" name="author" value="{{ request('author') }}">
                              @endif
                              <div class="input-group input-group-lg">
                                  <span class="input-group-text bi-search" id="basic-addon1"></span>
                                  <input
                                      name="search"
                                      type="search"
                                      style="z-index: 10;"
                                      class="form-control"
                                      id="keyword"
                                      placeholder="Search For Article, Project or News"
                                      @if(request('search'))
                                          value="{{ request('search') }}"
                                      @endif
                                      aria-label="Search"
                                  />
                                  <button type="submit" class="form-control" style="max-width:70px"><i class="bi bi-search"></i></button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>  
  <div id="blog-section" class="blog">
    <div class="container-fluid py-5">
        <div class="container py-5" data-aos="fade-up">
            <div class="row g-4">
                @forelse ($posts as $item)
                <div class="col-lg-6 col-xl-4 col-md-6 wow fadeInUp d-flex align-items-stretch" data-aos-delay="100">
                    <div class="blog-item h-100 d-flex flex-column shadow rounded-5 overflow-hidden">
                        <div class="blog-img position-relative" style="height: 200px; overflow: hidden;">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="">
                            @else
                                <img src="{{ $item->category->image ? $item->category->image : asset('img/programmer_text_2.jpg') }}" class="img-fluid w-100 h-100 object-fit-cover" alt="Category Image">
                            @endif
                            <div class="blog-categiry py-2 px-4" >
                                <a href="/blog?category={{ $item->category->slug }}">
                                    <span class="text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">{{ $item->category->name }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="blog-content p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('storage/' . $item->author->avatar) }}" class="rounded-circle me-2" width="40" height="40" alt="Author Image">
                                <div class="small">
                                    <a href="/blog?author={{ $item->author->username }}" class="text-dark text-decoration-none fw-bold">
                                        {{ $item->author->name }}
                                    </a>
                                    <div class="text-muted small">
                                        <i class="bi bi-clock-history"></i> {{ $item['created_at']->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <a href="/blog/{{ $item['slug'] }}" class="h5 text-decoration-none text-dark fw-bold d-block mb-2 text-truncate" style="max-width: 100%;">
                                {{ Str::limit(strip_tags($item['title']), 80) }}
                            </a>
                            <p class="text-muted flex-grow-1">{{ $item['excerpt'] }}</p>
                            <div class="d-flex justify-content-between mt-auto">
                                <a href="/blog/{{ $item['slug'] }}" class="btn p-0 fw-bold">Read more <i class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center w-100">
                    <h1 class="home__title">Nampaknya tidak ada &#129300;</h1>
                    <p class="home__description">Cek kembali kata kunci yang anda cari</p>
                </div>
                @endforelse
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
  <script>
      document.addEventListener('DOMContentLoaded', function () {
          var toastEl = document.getElementById('toastMessage');
          var toast = new bootstrap.Toast(toastEl);
          toast.show();
      });
  </script>
</x-layout>
