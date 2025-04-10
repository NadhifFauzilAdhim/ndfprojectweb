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
       
          <img data-src="{{ asset('img/cat.png') }}" alt="" class="img-fluid blob lazyload">
        <div class="container">
            
            <div class="row align-items-center justify-content-center text-center pt-5">
                <div class="col-lg-10 mt-5">
                    @if(request('author') && $posts->count() > 0)
        <div class="author-avatar-frame mb-3"> <!-- Tambahkan div wrapper ini -->
            @if($posts->first()->author->avatar)
            <img data-src="{{ asset('public/' . $posts->first()->author->avatar) }}" alt="" width="150" class="rounded-circle lazyload">
            @elseif($posts->first()->author->google_avatar)
            <img data-src="{{ $posts->first()->author->google_avatar }}" alt="" width="150" class="rounded-circle lazyload">
            @else
            <img data-src="https://img.icons8.com/color/512/user-male-circle--v1.png" alt="" width="150" class="rounded-circle lazyload">
            @endif
        </div>
        <h1  class="heading text-white mb-3" data-aos="fade-up">{{ $posts->count() }} Article By {{ $posts->first()->author->name }}</h1>
        <style>.author-avatar-frame{position:relative;display:inline-block;border-radius:50%;padding:8px;background:linear-gradient(45deg,#ff6b6b,#4ecdc4,#45b7d1,#96f2d7);background-size:400% 400%;animation:6s infinite gradientFrame;box-shadow:0 0 20px rgba(78,205,196,.3)}.author-avatar-frame::before{content:'';position:absolute;top:-2px;left:-2px;right:-2px;bottom:-2px;background:inherit;border-radius:inherit;z-index:-1;animation:inherit;filter:blur(10px)}.author-avatar-frame img{position:relative;z-index:1;border:3px solid #fff;transition:transform .3s}@keyframes gradientFrame{0%,100%{background-position:0 50%}50%{background-position:100% 50%}}@media (hover:hover){.author-avatar-frame:hover img{transform:scale(1.05) rotate(5deg)}}</style>
                    @elseif(request('category'))
                        <h1 class="heading text-white mb-3" data-aos="fade-up">Post in Category @if($posts) {{ $posts->first()->category->name }} @endif</h1> 
                    @elseif($type == 'all')
                       <div class="row align-items-center justify-content-center">
                        <div class="col-lg-6">
                          <img data-src="{{ asset('img/myspace_logo.png') }}" alt="" class="img-fluid lazyload">
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
                  <!-- Main Content Column -->
                  <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Perhatian!</strong> Blog ini telah dipindahkan ke <a href="https://blog.ndfproject.my.id" class="alert-link">blog.ndfproject.my.id</a> untuk memberikan pengalaman membaca yang lebih nyaman.  
                    Jangan lupa bookmark ya!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  <div class="col-lg-8"> 
                      <div class="row g-4 mb-5">
                          @forelse ($posts as $item)
                          <div class="col-lg-6 col-xl-6 col-md-6 wow fadeInUp d-flex align-items-stretch" data-aos-delay="100">
                              <div class="blog-item h-100 d-flex flex-column shadow rounded-5 overflow-hidden">
                                  <div class="blog-img position-relative" style="height: 200px; overflow: hidden;">
                                      @if($item->image)
                                          <img data-src="{{ asset('public/' . $item->image) }}" class="img-fluid w-100 h-100 object-fit-cover lazyload" alt="" > 
                                      @else
                                          <img data-src="{{ $item->category->image ? $item->category->image : asset('img/programmer_text_2.jpg') }}" class="img-fluid w-100 h-100 object-fit-cover lazyload" alt="Category Image">
                                      @endif
                                      <div class="blog-categiry py-2 px-4" >
                                          <a href="/blog?category={{ $item->category->slug }}">
                                              <span class="text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">{{ $item->category->name }}</span>
                                          </a>
                                      </div>
                                  </div>
                                  <div class="blog-content p-4 d-flex flex-column flex-grow-1">
                                      <div class="d-flex align-items-center mb-3">
                                            @if ($item->author->avatar)
                                            <img data-src="{{ asset('public/' . $item->author->avatar) }}" class="rounded-circle me-2 lazyload" width="40" height="40" alt="Author Image">
                                            @elseif ($item->author->google_avatar)
                                            <img data-src="{{ $item->author->google_avatar }}" class="rounded-circle me-2 lazyload" width="40" height="40" alt="Author Image">
                                            @else
                                            <img data-src="https://img.icons8.com/color/48/user-male-circle--v1.png" class="rounded-circle me-2 lazyload" width="40" height="40" alt="Author Image">
                                            @endif
                                          <div class="small">
                                              <a href="/blog?author={{ $item->author->username }}" class="text-dark text-decoration-none fw-bold">
                                                  {{ $item->author->name }}
                                              </a>
                                              <div class="d-flex text-muted small gap-3">
                                                  <div>
                                                      <i class="bi bi-clock-history"></i> {{ $item['created_at']->diffForHumans() }}
                                                  </div>
                                                  <div>
                                                      <i class="bi bi-eye"></i> {{ $item['views'] }} views
                                                  </div>
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
                      </div>
                      {{ $posts->links() }}
                  </div>
  
                  <!-- Top Posts Sidebar -->
                  <div class="col-lg-4">
                      <div class="sidebar sticky-top" style="top: 100px;">
                          <h3 class="mb-4 fw-bold">🔥 Top Posts</h3>
                          
                          @forelse ($topPosts as $item)
                          <div class="col-lg-12 col-xl-12 col-md-6 wow fadeInUp d-flex align-items-stretch mt-2" data-aos-delay="100">
                              <div class="blog-item h-100 d-flex flex-column shadow rounded-5 overflow-hidden">
  
                                  <div class="blog-content p-4 d-flex flex-column flex-grow-1">
                                     
                                      <a href="/blog/{{ $item['slug'] }}" class="h5 text-decoration-none text-dark fw-bold d-block mb-2 text-truncate" style="max-width: 100%;">
                                          {{ Str::limit(strip_tags($item['title']), 80) }}
                                      </a>
                                      <div class="d-flex align-items-center mb-3">
                                          @if ($item->author->avatar)
                                          <img data-src="{{ asset('public/' . $item->author->avatar) }}" class="rounded-circle me-2 lazyload" width="40" height="40" alt="Author Image">
                                          @elseif ($item->author->google_avatar)
                                          <img data-src="{{ $item->author->google_avatar }}" class="rounded-circle me-2 lazyload" width="40" height="40" alt="Author Image">
                                          @else
                                          <img data-src="https://img.icons8.com/color/512/user-male-circle--v1.png" class="rounded-circle me-2 lazyload" width="40" height="40" alt="Author Image">
                                          @endif
                                          <div class="small">
                                              <a href="/blog?author={{ $item->author->username }}" class="text-dark text-decoration-none fw-bold">
                                                  {{ $item->author->name }}
                                              </a>
                                              <div class="d-flex text-muted small gap-3">
                                                  <div>
                                                      <i class="bi bi-clock-history"></i> {{ $item['created_at']->diffForHumans() }}
                                                  </div>
                                                  <div>
                                                      <i class="bi bi-eye"></i> {{ $item['views'] }} views
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
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
  
                      </div>
                  </div>
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
  