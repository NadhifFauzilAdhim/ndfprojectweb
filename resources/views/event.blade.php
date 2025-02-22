<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="bloghero overlay inner-page">
      <div class="container">
          <div class="row align-items-center justify-content-center text-center pt-5">
              <div class="col-lg-10 mt-5">
                <div class="section text-center">
                  <h1 class="text-white">Event Developer</h1>
                  <div class="row justify-content-center no-gutters">
                    <div class="col-3 d-flex justify-content-center align-items-center" data-aos="fade-up">
                      <div class="count-box text-center text-primary">
                        <i class="bi bi-calendar-event text-primary fs-8"></i>
                        <span  data-purecounter-start="0" data-purecounter-end="{{ count($data['listEvents']) }}" data-purecounter-duration="1" class="purecounter"></span>
                        <p><strong>Event</strong></p>
                      </div>
                    </div>
                    <div class="col-3 d-flex justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="100">
                      <div class="count-box text-center text-warning">
                        <i class="bi bi-file-arrow-up fs-8"></i>
                        <span data-purecounter-start="0" data-purecounter-end="{{ count($upcoming) }}" data-purecounter-duration="1" class="purecounter"></span>
                        <p><strong>Upcoming</strong></p>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="row justify-content-center">
                      <div class="col-lg-6">
                          <form
                              action="{{ route('events.search') }}"
                              method="GET"
                              class="custom-form mt-4 pt-2 mb-5"
                              role="search"
                              data-aos="fade"
                              data-aos-delay="300"
                          >
                              <div class="input-group input-group-lg">
                                  <span class="input-group-text bi-search" id="basic-addon1"></span>
                                  <input
                                      name="q"
                                      type="q"
                                      style="z-index: 10;"
                                      class="form-control"
                                      id="keyword"
                                      placeholder="Search For Article, Project or News"
                                      aria-label="Search"
                                      value="{{ request('q') }}"
                                  />
                                  <button type="submit" class="form-control">Search</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="video-wrap">
         
          <img src="{{ asset('img/banner_blog.jpg') }}" class="custom-video" alt="">
      </div>
  </div> 
      <div id="blog-section" class="blog">
        <!-- Share Modal -->
        <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="shareModalLabel">Share</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <div class="container">
                        <div class="row d-flex">
                          <div class="col-8">
                            <input type="text" class="form-control mb-3" id="shareEventUrl" readonly>
                          </div>
                          <div class="col-2">
                            <a id="shareWhatsapp" target="_blank" class="btn btn-success me-1">
                              <i class="bi bi-whatsapp"></i> 
                          </a>
                          </div>
                          <div class="col-2">
                            <a id="shareX" target="_blank" class="btn btn-dark">
                              <i class="bi bi-twitter-x"></i> 
                          </a>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      </div>
        <div class="container-fluid blog py-5">
            <div class="container py-5" data-aos="fade-up">
                <div class="row g-4">
                  @forelse ($data['listEvents'] as $event)
                  <div class="col-lg-6 col-xl-4 col-md-6 ">
                      <div class="blog-item  @if($event['IsAvailable']) custom-blinking-shadow @endif" data-aos="fade-up" data-aos-delay="100">
                          <div class="blog-img">
                              @if($event['mediaCover'])
                                  <img data-src="{{ $event['mediaCover'] }}" class="img-fluid rounded-top w-100 fixed-size lazyload" alt="">
                              @else
                                  <img data-src="{{ asset('img/programmer_text_2.jpg') }}" class="img-fluid rounded-top w-100 fixed-size lazyload" alt="">
                              @endif
                              <div class="blog-categiry py-2 px-4">
                                  <a href="">
                                      <span class="text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">
                                          {{ $event['category'] }} | <i class="bi bi-person-fill-check"></i> {{ $event['registrants'] }} / {{ $event['quota'] }}
                                      </span>
                                  </a>
                              </div>
                          </div>
                          <div class="blog-content p-4">
                              <div class="blog-comment d-flex justify-content-between mb-3">
                                  
                                  <div class="small"><i class="bi bi-alarm text-primary"></i> {{ $event['timeLeft'] }}</div>
                                  <div class="d-flex">
                                    <!-- Favorite button -->
                                    <button class="btn p-0 favorite-btn me-3" data-event-id="{{ $event['id'] }}">
                                        <i class="bi bi-heart text-danger"></i>
                                    </button>
                                    <!-- Share button -->
                                    <button class="btn p-0 share-btn" data-event-link="{{ route('eventdetail', ['id' => $event['id']]) }}" data-bs-toggle="modal" data-bs-target="#shareModal">
                                        <i class="bi bi-share"></i>
                                    </button>
                                </div>
                              </div>
                              <a href="{{ route('eventdetail', ['id' => $event['id']]) }}" class="h4 d-inline-block mb-3">{{ Str::limit(strip_tags( $event['name']), 50) }}</a>
                              <p class="mb-3">{{ Str::limit(strip_tags( $event['summary']), 100) }}</p>
                              <div class="d-flex justify-content-between">
                                  <a href="{{ route('eventdetail', ['id' => $event['id']]) }}" class="btn p-0">Read more <i class="bi bi-arrow-right"></i></a>
                                  
                              </div>
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
                </div>
            </div>
        </div>
    </div>
 
</x-layout>
