
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
      <div class="bloghero overlay inner-page">
          <img src="{{ asset('img/blob.svg') }}" alt="" class="img-fluid blob">
          <div class="container">
            <div class="row align-items-center justify-content-center text-center pt-5">
              <div class="col-lg-10">
                  @if(request('author'))
                    <h1 class="heading text-white mb-3" data-aos="fade-up">{{ $posts->count() }} Article By  {{ $posts->first()->author->name }}</h1>  
                      <div class="d-flex justify-content-center" data-aos="fade-up">
                        <span class="badge rounded-pill text-bg-primary me-4"><i class="bi bi-calendar-check me-1"></i>Bergabung : {{ $posts->first()->author->created_at }}</span>
                        <span class="badge rounded-pill text-bg-primary"><i class="bi bi-mailbox me-1"></i>Post : {{ $posts->count() }}</span>
                      </div>
                  @elseif(request('category'))
                     <h1 class="heading text-white mb-3" data-aos="fade-up">Post in Category {{ $posts->first()->category->name }}</h1> 
                  @elseif($type == 'all')
                    <img src="{{ asset('img/product-tip.png') }}" class="img-fluid" alt="" width="200px">
                    <h1 class="heading text-white mb-3" data-aos="fade-up" >Blog / News / Project</h1>
                  @endif
             
              </div>
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
                  <span class="input-group-text bi-search" id="basic-addon1">
                  </span>

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

                  <button type="submit"  class="form-control">Search</button>
                </div>
              </form>
              </div>
              
            </div>
            
          </div>
        </div>
    
      <div id="blog-section" class="blog">
        <div class="container-fluid blog py-5">
                <div class="container py-5" data-aos="fade-up">
                    <div class="row g-4 ">
                        @forelse ($posts as $item)
                        <div class="col-lg-6 col-xl-4 col-md-6 wow fadeInUp" data-aos-delay="100">
                            <div class="blog-item">
                                <div class="blog-img">
                                  @if($item->image)
                                  <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid rounded-top w-100 fixed-size" alt="">
                                  @else
                                  <img src="{{ asset('img/programmer_text_2.jpg') }}" class="img-fluid rounded-top w-100 fixed-size" alt="">
                                  @endif
                                    <!-- <img src="img/project/kostifyadv.png" class="img-fluid rounded-top w-100" alt=""> -->
                                    {{-- <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                                      <div class="carousel-inner">
                                        <div class="carousel-item active">
                                        <img src="img/project/kostifyadv.png" class="img-fluid rounded-top w-100" alt="">
                                        </div>
                                        <div class="carousel-item">
                                        <img src="img/project/kostifyadv1.png" class="img-fluid rounded-top w-100" alt="">
                                        </div>
                                        <div class="carousel-item">
                                        <img src="img/project/kostifyadv2.png" class="img-fluid rounded-top w-100" alt="">
                                        </div>
                                      </div>
                                    </div> --}}
                                    <div class="blog-categiry py-2 px-4">
                                      <a href="/blog?category={{ $item->category->slug }}">
                                        <span class="text-white"  data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">{{ $item->category->name }}</span>
                                      </a>
                                    </div>
                                </div>
                                <div class="blog-content p-4">
                                    <div class="blog-comment d-flex justify-content-between mb-3">
                                        <div class="small"> <a href="/blog?author={{ $item->author->username }}"><i class="bi bi-feather"></i> {{ $item->author->name }}</a></div>
                                        <div class="small"><i class="bi bi-clock-history"></i> {{ $item['created_at']->diffForHumans() }}</div>
                                    </div>
                                    <a href="/blog/{{ $item['slug'] }}" class="h4 d-inline-block mb-3">{{ $item['title']}}</a>
                                    <p class="mb-3">{{ Str::limit(strip_tags($item['body']), 100) }}</p>
                                    <a href="/blog/{{ $item['slug'] }}" class="btn p-0">Read more  <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center">
                          <h1 class="home__title">Nampaknya tidak ada &#129300;</h1>
                          <p class="home__description">
                              Cek kembali kata kunci yang anda cari
                          </p>  
                        </div>
                        
                        @endforelse
                        
                        {{ $posts->links() }}
                        
                    </div>
                </div>
            </div>
            </div>
    
</x-layout>