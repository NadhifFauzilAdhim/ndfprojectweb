
<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
      <div class="bloghero overlay inner-page">
          <img src="{{ asset('img/blob.svg') }}" alt="" class="img-fluid blob">
          <div class="container">
            <div class="row align-items-center justify-content-center text-center pt-5">
              <div class="col-lg-6">
                <h1 class="heading text-white mb-3" data-aos="fade-up" >Blog / News / Project</h1>
                <p class="mb-3">Dapatkan berita terkini dan update terbaru </p>
              </div>
            </div>
          </div>
        </div>
    
      <section id="blog-section" class="blog">
        <div class="container-fluid blog py-5">
                <div class="container py-5">
                    <div class="row g-4 ">
                        @foreach ($posts as $item)
                        <div class="col-lg-6 col-xl-4 col-md-6 wow fadeInUp" data-aos-delay="100">
                            <div class="blog-item">
                                <div class="blog-img">
                                  <img src="{{ asset('img/project/kostifyadv.png') }}" class="img-fluid rounded-top w-100" alt="">
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
                                        <span>{{ $item['category'] }}</span>
                                    </div>
                                </div>
                                <div class="blog-content p-4">
                                    <div class="blog-comment d-flex justify-content-between mb-3">
                                        <div class="small"> <a href="/author/{{ $item->author->username }}"><span class="bi bi-code-slash text-primary"></span> {{ $item->author->name }}</a></div>
                                        <div class="small"><span class="bi bi-calendar2-check text-primary"></span> {{ $item['created_at']->diffForHumans() }}</div>
                                    </div>
                                    <a href="/blog/{{ $item['slug'] }}" class="h4 d-inline-block mb-3">{{ $item['title']}}</a>
                                    <p class="mb-3">{{ Str::limit($item['body'], 100) }}</p>
                                    <a href="/blog/{{ $item['slug'] }}" class="btn p-0">Read more  <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                       
                        
                    </div>
                </div>
            </div>
            </section>
    
</x-layout>