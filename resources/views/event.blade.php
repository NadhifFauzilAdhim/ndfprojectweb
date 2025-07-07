<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="bloghero overlay inner-page">
     <img src="{{ asset('img/puppet.png') }}" alt="" class="img-fluid blob">
      <div class="container">
          <div class="row align-items-center justify-content-center text-center pt-5">
              <div class="col-lg-10 mt-5">
                <div class="section text-center">
                  <h1 class="text-white">Event Developer</h1>
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
                                      class="form-control border-0"
                                      id="keyword"
                                      placeholder="Search For Event"
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
                @if (!empty($error) || !empty($data['error']))
                <div class="row justify-content-center">
                    <div class="col-md-8 text-center">
                        <div class="p-5 mb-4 bg-light border rounded-3 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-exclamation-triangle-fill text-danger mb-4" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                            <h1 class="display-5 fw-bold">Oops! An Error Occurred.</h1>
                            <p class="fs-4 col-md-10 mx-auto">{{ $error ?? $data['error'] }}</p>
                             <p class="text-muted">Please try refreshing the page, or check back again later.</p>
                        </div>
                    </div>
                </div>
                 @else
                <div class="row g-4">
                 @forelse ($data['listEvents'] as $event)
                    <div class="col-lg-6 col-xl-4 col-md-6 d-flex align-items-stretch">
                        <div class="blog-item h-100 @if($event['IsAvailable']) custom-blinking-shadow @endif d-flex flex-column" data-aos="fade-up" data-aos-delay="100">
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
                            <div class="blog-content p-4 flex-grow-1 d-flex flex-column justify-content-between">
                                <div>
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
                                </div>
                                <div class="d-flex justify-content-between mt-auto">
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
                @endif

                </div>
            </div>
        </div>
    </div>
 
</x-layout>
