<x-layout>

    <x-slot:title>{{ $title }}</x-slot:title>
      <div id="blog-section" class="blog">
        <div class="container-fluid blog py-5">
            <div class="container py-5" data-aos="fade-up">
                <div class="row">
                    <section id="facts" class="facts">
                        <div class="container">
                  
                          <div class="section">
                            <h2 class="text-center">Event Developer Terbaru</h2>
                          </div>
                            <div class="row height d-flex justify-content-center align-items-center">
                              <div class="col-md-6">
                                <form action="{{ route('events.search') }}" method="GET">
                                    <input type="text" class="form-control form-input" placeholder="Search anything..." name="q">
                                    <span class="left-pan"><i class="fa fa-microphone"></i></span>
                                </form>
                              </div>
                            </div>
                          <div class="row justify-content-md-center no-gutters">
                  
                            <div class="col-lg-3 col-md-3 d-md-flex align-items-md-stretch" data-aos="fade-up">
                              <div class="count-box">
                                <i class="bi bi-newspaper"></i>
                                <span data-purecounter-start="0" data-purecounter-end="{{ count($data['listEvents']) }}" data-purecounter-duration="1" class="purecounter"></span>
                                <p><strong>Event</strong></p>
                              </div>
                            </div>
                  
                            <div class="col-lg-3 col-md-3 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="100">
                              <div class="count-box">
                                <i class="bi bi-file-arrow-up"></i>
                                <span data-purecounter-start="0" data-purecounter-end="{{ count($upcoming) }}" data-purecounter-duration="1" class="purecounter"></span>
                                <p><strong>Upcoming</strong></p>
                              </div>
                            </div>
                  
                            <div class="col-lg-3 col-md-3 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="200">
                              <div class="count-box">
                                <i class="bi bi-people"></i>
                                <span data-purecounter-start="0" data-purecounter-end="5" data-purecounter-duration="1" class="purecounter"></span>
                                <p><strong>Participant</strong></p>
                              </div>
                            </div>
                          </div>
                  
                        </div>
                      </section><!-- End Facts Section -->
                    
                </div>
                <div class="row g-4">
                    @forelse ($data['listEvents'] as $event)
                        <div class="col-lg-6 col-xl-4 col-md-6 wow fadeInUp @if($event['IsAvailable']) custom-blinking-shadow @endif" data-aos-delay="100">
                            <div class="blog-item">
                                <div class="blog-img">
                                    @if($event['mediaCover'])
                                        <img src="{{ $event['mediaCover'] }}" class="img-fluid rounded-top w-100 fixed-size" alt="">
                                    @else
                                        <img src="{{ asset('img/programmer_text_2.jpg') }}" class="img-fluid rounded-top w-100 fixed-size" alt="">
                                    @endif
                                    <div class="blog-categiry py-2 px-4">
                                        <a href="/blog?category={{ $event['id'] }}">
                                            <span class="text-white" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tooltip on top">{{ $event['category'] }} | <i class="bi bi-person-fill-check"></i> {{ $event['registrants'] }} / {{ $event['quota'] }}</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="blog-content p-4">
                                    <div class="blog-comment d-flex justify-content-between mb-3">
                                        <div class="small"><i class="bi bi-clock-history text-primary"></i> {{ $event['beginTime'] }}</div>
                                        <div class="small"><i class="bi bi-alarm text-primary"></i> {{ $event['timeLeft'] }}</div>
                                    </div>
                                    <a href="{{ route('eventdetail', ['id' => $event['id']]) }}" class="h4 d-inline-block mb-3">{{ $event['name']}}</a>
                                    <p class="mb-3">{{ Str::limit(strip_tags( $event['summary']), 100) }}</p>
                                    <a href="{{ route('eventdetail', ['id' => $event['id']]) }}" class="btn p-0">Read more <i class="bi bi-arrow-right"></i></a>
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
