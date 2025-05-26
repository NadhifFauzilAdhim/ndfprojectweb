<x-dashlayout>
  <x-slot:title>{{ $title  }}</x-slot:title>
  <script src="https://static.elfsight.com/platform/platform.js" async></script>
<div class="elfsight-app-16c599f4-70fd-4b71-aa1d-bfb0ee7810ef" data-elfsight-app-lazy></div>
  <div class="container-fluid">
    <div class="alert alert-warning text-center" role="alert"> <i class="bi bi-info-circle-fill me-2"></i>Maaf, karena tingginya tingkat spam, fitur post hanya tersedia untuk pengguna terverifikasi. </div>
      <div class="row">
        <div class="col-lg-4">
          <div class="card rounded-5">
            <div class="card-body text-center card-fixed-size">
              @if(Auth::user()->avatar)
                <img data-src="{{ asset('storage/'. auth()->user()->avatar) }}" alt="image" class="img-fluid img-fluid rounded-circle lazyload" width="205">
              @elseif(Auth::user()->google_avatar)
                <img data-src="{{ Auth::user()->google_avatar }}" alt="image" class="img-fluid img-fluid rounded-circle lazyload" width="205">
              @else
                <img data-src="https://img.icons8.com/color/500/user-male-circle--v1.png" alt="image" class="img-fluid img-fluid rounded-circle lazyload" width="205">
              @endif
          
              <h4 class="mt-7">
                <small>Welcome !</small> <br> {{ Auth::user()->name }} 
                <i class="bi bi-patch-check-fill me-1 text-primary"></i>
              </h4>
              <p class="card-subtitle mt-2 mb-1 fs-2">
                We're glad to have you here. Explore the features and tools available on your dashboard to make the most out of your experience.
              </p>
             
              <div style="margin-top: -89px;">
                <img src="{{ asset('img/frog.gif') }}" alt="Cat sitting gif" class="img-fluid lazyload" style="width: 271px;">
              </div>
            </div>
          </div>
          
          <div class="d-block d-lg-none mt-4 mobiprof-menu">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3 text-center">
                        <div class="col-3">
                            <a href="/dashboard/link" class="text-decoration-none">
                                <div class="mobiprof-icon-wrapper mobiprof-bg-primary">
                                    <iconify-icon icon="solar:link-bold-duotone" class="mobiprof-icon animate-pulse-grow"></iconify-icon>
                                </div>
                                <div class="mobiprof-label">Linksy</div>
                            </a>
                        </div>
    
                        <div class="col-3">
                            <a href="/dashboard/tracking" class="text-decoration-none">
                                <div class="mobiprof-icon-wrapper mobiprof-bg-success">
                                    <iconify-icon icon="solar:map-point-hospital-bold-duotone" class="mobiprof-icon bounce-icon"></iconify-icon>
                                </div>
                                <div class="mobiprof-label">Tracker</div>
                            </a>
                        </div>
    
                        <div class="col-3">
                            <a href="#" class="text-decoration-none">
                                <div class="mobiprof-icon-wrapper mobiprof-bg-danger">
                                    <iconify-icon icon="solar:multiple-forward-right-bold-duotone" class="mobiprof-icon animate-pulse-grow"></iconify-icon>
                                </div>
                                <div class="mobiprof-label">LinkNest</div>
                            </a>
                        </div>
    
                        <div class="col-3">
                            <a href="/dashboard/profile" class="text-decoration-none">
                                <div class="mobiprof-icon-wrapper mobiprof-bg-warning">
                                    <iconify-icon icon="solar:user-bold-duotone" class="mobiprof-icon"></iconify-icon>
                                </div>
                                <div class="mobiprof-label">Profile</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
          <div class="col-lg-8">
              <div class="card rounded-5">
                  <div class="card-body">
                      <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                          Traffic Overview
                          <span>
                              <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Traffic Overview"></iconify-icon>
                          </span>
                      </h5>
                      <div id="traffic-overview" >
                      </div>
                  </div>
              </div>
          </div>
      
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100 rounded-5 shadow-sm">
            <div class="card-body">
                <h5 class="card-title d-flex align-items-center gap-2 pb-3">Link Static<span><iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Locations"></iconify-icon></span>
                </h5>
                <div class="row">
                <div class="col-4">
                    <iconify-icon icon="solar:link-bold-duotone" class="fs-7 d-flex text-primary"></iconify-icon>
                    <span class="fs-11 mt-2 d-block text-nowrap">Link Created</span>
                    <h4 class="mb-0 mt-1">{{ $totalLinks }}</h4>
                </div>
                <div class="col-4">
                    <iconify-icon icon="solar:cursor-line-duotone" class="fs-7 d-flex text-secondary"></iconify-icon>
                    <span class="fs-11 mt-2 d-block text-nowrap">Total Visit</span>
                    <h4 class="mb-0 mt-1">{{ $totalVisit }}</h4>
                </div>
                <div class="col-4">
                    <iconify-icon icon="solar:shield-user-broken" class="fs-7 d-flex text-success"></iconify-icon>
                    <span class="fs-11 mt-2 d-block text-nowrap">Unique Visit</span>
                    <h4 class="mb-0 mt-1">{{ $totalUniqueVisit }}</h4>
                </div>
                </div>
                <div class="border-0 rounded-3" style="max-height: 250px; overflow-y: auto;">
                    <div class="vstack gap-3 p-3">
                        @forelse ($topLinks as $link)
                        <div class="link-card p-2 p-sm-3 rounded-3 bg-white shadow-sm">
                            <div class="row g-2 align-items-center">
                                <!-- Favicon Column -->
                                <div class="col-auto">
                                    <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($link->target_url) }}&size=32" 
                                        alt="Favicon" 
                                        class="favicon rounded-2"
                                        width="32"
                                        height="32">
                                </div>
                                
                                <!-- Link Info Column -->
                                <div class="col text-truncate pe-2">
                                    <div class="d-flex flex-column truncate-container">
                                        <a href="{{ url('dashboard/link/').'/'.$link->slug }}" 
                                        class="link-slug text-dark text-decoration-none fw-medium text-truncate">
                                            {{ $link->title }}
                                        </a>
                                        <small class="text-muted domain-name text-truncate">
                                            {{ parse_url($link->target_url, PHP_URL_HOST) }}
                                        </small>
                                    </div>
                                </div>
                                
                                <!-- Stats Column -->
                                <div class="col-auto">
                                    <div class="d-flex flex-column text-nowrap">
                                        <span class="total-visits fw-bold text-dark">{{ $link->visits }}</span>
                                        <small class="text-success trend-badge">
                                            +{{ $link->visits_last_7_days ?: '-' }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state text-center p-3 rounded-3 bg-light">
                            <iconify-icon icon="solar:link-broken" class="fs-1 text-muted mb-2"></iconify-icon>
                            <p class="text-muted mb-0 fs-14">No links available</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-5">
              <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Last Visits History</h5>
                <div class="table-responsive" style="max-height: 350px; overflow-y: auto; overflow-x: hidden;">
                  <table class="table align-middle mb-0">
                    <thead class="sticky-top" style="top: 0; z-index: 1;">
                      <tr>
                        <th scope="col" class="ps-0 text-nowrap">Link</th>
                        <th scope="col" class="text-center text-nowrap">Date</th>
                        <th scope="col" class="text-center text-nowrap">#</th>
                      </tr>
                    </thead>
                    <tbody class="table-group-divider">
                      @forelse ($lastLinkVisit as $visit)
                        <tr>
                          <td class="ps-0 fw-medium text-truncate" style="max-width: 180px;">
                            <span class="d-block text-truncate" title="{{ $visit->link->title }}">
                              <small>{{ $visit->link->title }}</small>
                            </span>
                          </td>
                          <td class="text-center fw-medium text-nowrap">
                            <small>{{ $visit->created_at->diffForHumans() }}</small>
                          </td>
                          <td class="text-center">
                            <a href="/dashboard/link/{{ $visit->link->slug }}" class="text-decoration-none text-dark" title="Lihat Detail">
                              <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" width="20" height="20"></iconify-icon>
                            </a>
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="3" class="text-center text-muted">
                            Tidak ada data <span class="ms-1">&#129300;</span>
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      
        <div class="col-lg-4 d-flex align-items-stretch">
            <div class="card w-100 rounded-5 shadow-sm">
            <div class="card-body card-fixed-size">
                <h5 class="card-title">Your post comment</h5>
                <!-- Make this div scrollable by setting a max height -->
                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table text-nowrap align-middle mb-0">
                    <thead>
                    <tr class="border-2 border-bottom border-primary border-0">
                        <th scope="col" class="ps-0">Post</th>
                        <th scope="col">User</th>
                        <th scope="col">Comments</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody class="table-group-divider">
                    @forelse($comments as $comment)
                        <tr>
                            <th scope="row" class="ps-0 fw-medium">
                            <a href="/blog/{{ $comment->post->slug }}" class="link-primary">
                                <span class="table-link1 text-truncate d-block"><small>{{ Str::limit(strip_tags($comment->post->title), 30) }}</small></span>
                            </a>
                            </th>
                            <td class="fw-medium"><small>{{ $comment->user->name }}</small></td>
                            <td>
                            <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block"><small>{{ Str::limit(strip_tags($comment->body), 30) }}</small></a>
                            </td>
                            <td>
                            <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block"><small>{{ $comment->created_at->diffForHumans() }}</small></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                        <td colspan="3" class="text-center">Anda Belum memiliki Post &#129300;</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
            </div>
            {{ $comments->links() }}  
            </div>
        </div>
      
      @forelse($posts as $post)
      <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card overflow-hidden hover-img w-100 rounded-5 shadow-sm">
          <div class="position-relative">
            <a href="javascript:void(0)">
             @if($post->image)
                <img data-src="{{ asset('storage/' . $post->image) }}" class="img-fluid rounded-top w-100 fixed-size lazyload" alt="">
            @else
            <img 
            data-src="{{ $post->category->image ? $post->category->image : asset('img/programmer_text_2.jpg') }}" 
            class="img-fluid rounded-top w-100 fixed-size lazyload" 
            alt="Category Image">
            @endif
            </a>
            <span class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">-
              views</span>
           
          </div>
          <div class="card-body p-4">
            <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">{{ $post->category->name }}</span>
            <a class="d-block my-1 fs-5 text-dark fw-semibold link-primary" href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
            <p>{{ Str::limit(strip_tags($post['body']), 100) }}</p>
            <div class="d-flex align-items-center gap-4">
             
              <div class="d-flex align-items-center fs-2 ms-auto">
                <i class="ti ti-point text-dark"></i>{{  $post['created_at']->diffForHumans() }}
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty

      @endforelse
      {{ $posts->links() }}
     
    </div>
    <script src="{{ asset('js/dashjs/dashboard.js') }}"></script>
    <script> const visitDataGlobal = @json($visitData);</script>
</x-dashlayout>