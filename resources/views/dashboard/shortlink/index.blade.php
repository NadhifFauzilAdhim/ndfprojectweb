<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div id="copyToast" class="toast align-items-center text-bg-primary border-0 copy-toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="bi bi-clipboard-check me-2"></i> Link copied to clipboard!
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
                <div class="row">
                    {{-- Temporary Component --}}
                    <div class="carousel slide d-none d-lg-block" data-bs-ride="carousel" data-bs-interval="3000" id="autoPlayCarousel" >
                        <div class="carousel-inner rounded-3 ">
                            <div class="carousel-item active">
                                <div class="col-lg-12 d-none d-lg-block">
                                    <div class="alert alert-info d-flex align-items-center gap-2 p-3 m-2 shadow-sm justify-content-center" role="alert">
                                        <iconify-icon icon="material-symbols:phone-iphone" class="fs-4 text-info"></iconify-icon>
                                        <div>
                                            <span class="fw-medium">Desktop User?</span> 
                                            Beralih ke <u>mode mobile</u> untuk mengakses fitur QR Code
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-lg-12">
                                    <div class="alert alert-success d-flex align-items-center gap-2 p-3 m-2 shadow-sm justify-content-center" role="alert">
                                        <iconify-icon icon="tabler:api" class="fs-4 text-success"></iconify-icon>
                                        <div>
                                            Open API tersedia! 
                                            <a href="{{ route('ipdocuments') }}" class="text-decoration-none fw-medium link-success">
                                                Akses Sekarang ➔
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>.alert{transition:.2s;border-left:3px solid}.alert-info{border-left-color:#0dcaf0;background-color:rgba(13,202,240,.05)}.alert-success{border-left-color:#198754;background-color:rgba(25,135,84,.05)}.alert:hover{box-shadow:0 2px 8px rgba(0,0,0,.1)!important}.link-success:hover{text-decoration:underline!important}</style>
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="card w-100 rounded-5 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                                    Traffic Overview
                                    <span>
                                        <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Traffic Overview"></iconify-icon>
                                    </span>
                                </h5>
                                 <div id="traffic-overview"></div>
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
                                    <div class="link-card p-2 p-sm-3 rounded-3 bg-white shadow-sm card-hover">
                                        <div class="row g-2 align-items-center">
                                            <!-- Favicon Column -->
                                            <div class="col-auto">
                                                <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($link->target_url) }}&size=32" 
                                                    alt="Favicon" 
                                                    class="favicon rounded-2 lazyload"
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
                    <div class="col-lg-12 mb-4">
                        <div class="row g-2 align-items-center">
                            <!-- Create New -->
                            <div class="col-3 col-md-2">
                                <button 
                                    class="btn btn-primary w-100 py-2 d-flex flex-column flex-md-row align-items-center justify-content-center gap-1"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseForm"
                                    aria-expanded="false"
                                    aria-controls="collapseForm"
                                    style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px;">
                                    <iconify-icon icon="solar:clipboard-add-bold-duotone" class="fs-5"></iconify-icon>
                                    <span class="d-inline d-md-none small">Create</span>
                                    <span class="d-none d-md-inline">Create New</span>
                                </button>
                            </div>
                        
                            <!-- Location Tracker -->
                            <div class="col-3 col-md-2">
                                <a 
                                    class="btn btn-primary w-100 py-2 d-flex flex-column flex-md-row align-items-center justify-content-center gap-1"
                                    href="/dashboard/tracking"
                                    style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px;">
                                    <iconify-icon icon="solar:map-point-hospital-bold-duotone" class="fs-5"></iconify-icon>
                                    <span class="d-inline d-md-none small">Track</span>
                                    <span class="d-none d-md-inline">Location Tracker</span>
                                </a>
                            </div>
                        
                            <!-- Generate QR -->
                            <div class="col-3 col-md-2">
                                <button 
                                    class="btn btn-primary w-100 py-2 d-flex flex-column flex-md-row align-items-center justify-content-center gap-1"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#qrCollapseForm"
                                    aria-expanded="false"
                                    aria-controls="qrCollapseForm"
                                    style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px;">
                                    <iconify-icon icon="solar:qr-code-bold-duotone" class="fs-5"></iconify-icon>
                                    <span class="d-inline d-md-none small">QR</span>
                                    <span class="d-none d-md-inline">Generate QR</span>
                                </button>
                            </div>
                        
                            <!-- Scan QR -->
                            <div class="col-3 col-md-2">
                                <button 
                                    class="btn btn-primary w-100 py-2 d-flex flex-column flex-md-row align-items-center justify-content-center gap-1"
                                    type="button"
                                    id="scanQRBtn2"
                                    style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px;">
                                    <iconify-icon icon="solar:scanner-bold-duotone" class="fs-5"></iconify-icon>
                                    <span class="d-inline d-md-none small">Scan</span>
                                    <span class="d-none d-md-inline">Scan QR</span>
                                </button>
                            </div>
                        
                            <!-- Search Form -->
                            <div class="col-12 col-md-4">
                                <form action="/dashboard/link" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Search Link" aria-label="Search" aria-describedby="button-addon2" value="{{ request('search') }}">
                                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
            
                        <!-- Collapsible form -->
                        <div class="collapse mt-4" id="collapseForm">
                            <div class="card card-body shadow-sm border-0">
                                <form id="linkform" action="/dashboard/link" method="POST">
                                    @csrf
                                    <!-- URL Destination Field -->
                                    <div class="mb-4">
                                        <label for="url_target" class="form-label fw-bold">URL Destination</label>
                                        <input type="text" class="form-control @error('target_url') is-invalid @enderror shadow-sm" id="target_url" name="target_url" placeholder="https://example.com" value="{{ old('target_url') }}">
                                        @error('target_url')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <!-- Shortened Link Field -->
                                    <div class="mb-4">
                                        <label for="short_link" class="form-label fw-bold">Shortened Link</label>
                                    
                                        <div class="d-flex flex-column flex-md-row gap-2 align-items-stretch">
                                            <div class="input-group shadow-sm flex-grow-1">
                                                <span class="input-group-text bg-light" id="basic-addon3">linksy.site/</span>
                                    
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="short_link" name="slug" placeholder="custom-slug" value="{{ old('slug') }}" aria-describedby="basic-addon3">
                                            </div>
                                    
                                            <select class="form-select shadow-sm mt-2 mt-md-0 w-auto flex-grow-0" name="active" aria-label="Visibility select">
                                                <option value="1" {{ old('active', '1') == '1' ? 'selected' : '' }}>Visible to Everyone</option>
                                                <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Private (Only You)</option>
                                            </select>
                                        </div>
                                    
                                        @error('slug')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    
                                        @error('active')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary px-4" id="linkSubmitBtn">
                                            <span id="linkBtnSpinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                            <span id="linkBtnText"><i class="bi bi-check-circle me-2"></i>Create</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="collapse mt-4" id="qrCollapseForm">
                            <div class="card card-body shadow-sm border-0">
                                <form id="qrForm">
                                    <div class="mb-4">
                                        <label for="qr_target_url" class="form-label fw-bold">URL Destination</label>
                                        <input type="text" class="form-control shadow-sm" id="qr_target_url" name="qr_target_url" placeholder="https://example.com">
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="bi bi-check-circle me-2"></i>Create
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div class="row nav nav-tabs justify-content-center d-flex flex-wrap" id="linkTabs" role="tablist">
                            <div class="col-4 p-1">
                                <button class="nav-link active btn btn-sm w-100" id="your-links-tab" data-bs-toggle="tab" data-bs-target="#your-links" type="button" role="tab">
                                    <iconify-icon icon="solar:link-bold-duotone" class="fs-5" style="position: relative; top: 3px;"></iconify-icon> 
                                    <span class="d-none d-sm-inline"> Your Links</span>
                                </button>
                            </div>
                            <div class="col-4 p-1">
                                <button class="nav-link btn btn-sm w-100" id="shared-links-tab" data-bs-toggle="tab" data-bs-target="#shared-links" type="button" role="tab">
                                    <iconify-icon icon="solar:round-arrow-down-line-duotone" class="fs-5" style="position: relative; top: 3px;"></iconify-icon> 
                                    <span class="d-none d-sm-inline"> Shared to You</span>
                                </button>
                            </div>
                            <div class="col-4 p-1">
                                <button class="nav-link btn btn-sm w-100" id="links-you-shared-tab" data-bs-toggle="tab" data-bs-target="#links-you-shared" type="button" role="tab">
                                    <iconify-icon icon="solar:square-share-line-line-duotone" class="fs-5" style="position: relative; top: 3px;"></iconify-icon> 
                                    <span class="d-none d-sm-inline"> Shared by You</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4 tab-content">
                        <!-- Your Links -->
                        <div class="tab-pane fade show active" id="your-links" role="tabpanel" aria-labelledby="your-links-tab">
                            <div class="row">
                            @forelse ($links as $link)
                            <div class="col-md-4 d-flex align-items-stretch " >
                                <div class="card shadow border-0 w-100 card-hover rounded-5">
                                    <div class="card-body">
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-12 d-flex align-items-center">
                                                <img data-src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($link->target_url) }}&size=32" 
                                                     alt="Favicon" 
                                                     class="rounded me-2 lazyload" 
                                                     style="width: 25px; height: 25px; flex-shrink: 0;">
                                                     <input type="text" 
                                                     class="form-control border-0 p-0 text-dark fw-bold fs-5" 
                                                     value="{{ $link->title  }}" 
                                                    @if ($link->title)
                                                     placeholder="Type Here To Change Title"
                                                    @endif
                                                     data-link-slug="{{ $link->slug }}" 
                                                     data-previous-title="{{ $link->title }}">

                                            </div>
                                        </div>
                                        <!-- Shortened Link -->
                                        <div class="row d-flex align-items-center mb-2">
                                            <div class="col-10">
                                                <h6 class="card-title text-truncate mb-0">
                                                    <input type="text" 
                                                           class="form-control border-0 p-0 text-dark fw-bold" 
                                                           id="linkInput-{{ $link->slug }}" 
                                                           value="{{ 'linksy.site/' . $link->slug }}" 
                                                           readonly>
                                                </h6>
                                            </div>
                                            <div class="col-2 text-start px-0">
                                                <button class="btn {{ $link->active ? 'btn-outline-dark' : 'btn-outline-danger' }} btn-sm" 
                                                        onclick="copyFunction('{{ $link->slug }}')">
                                                        <iconify-icon icon="solar:copy-line-duotone"></iconify-icon>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Destination URL -->
                                        <p class="text-muted small mb-1">Destination:</p>
                                        <a href="{{ $link->target_url }}" target="_blank" class="d-block text-truncate link-dark text-decoration-none"
                                            style="transition: color 0.2s;"
                                            onmouseover="this.classList.replace('link-dark', 'text-primary')"
                                            onmouseout="this.classList.replace('text-primary', 'link-dark')">
                                            {{ Str::limit(strip_tags($link->target_url), 80) }}
                                         </a>
                            
                                        <!-- Statistics -->
                                        <div class="d-flex justify-content-between mt-2">
                                            <div class="text-muted small">
                                                <iconify-icon icon="solar:calendar-bold" class="me-1" style="position: relative; top: 3px;"></iconify-icon> {{ $link->created_at->format('d M Y') }}
                                            </div>
                                            <div class="text-muted small">
                                                <iconify-icon icon="solar:graph-up-bold" class="me-1" style="position: relative; top: 3px;"></iconify-icon> <b>{{ $link->visits }}</b> visits
                                            </div>
                                            <div class="text-muted small">
                                                <iconify-icon icon="solar:user-check-bold" class="me-1" style="position: relative; top: 3px;"></iconify-icon> <b>{{ $link->unique_visits }}</b> unique
                                            </div>
                                        </div>
                                        <!-- Security Status -->
                                        <div class="d-flex justify-content-end mt-3 position-relative dropup">
                                            @if($link->password_protected)
                                                <button class="btn btn-outline-dark btn-sm rounded-pill me-2">
                                                    <iconify-icon icon="solar:key-outline"></iconify-icon>
                                                </button>
                                            @endif

                                            <button class="btn btn-outline-{{ $link->active ? 'primary' : 'danger' }} btn-sm rounded-pill me-2">
                                                <iconify-icon icon="solar:earth-bold-duotone"></iconify-icon>
                                            </button>

                                            <a class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center gap-1 px-3 py-1 me-2 shadow-sm transition" 
                                            href="/dashboard/link/{{ $link->slug }}"
                                           >
                                                <iconify-icon icon="solar:chart-bold"></iconify-icon>
                                                <span>Analytic</span>
                                            </a>

                                            <button class="btn btn-outline-primary btn-sm rounded-pill" data-bs-toggle="dropdown">
                                                <iconify-icon icon="solar:menu-dots-bold"></iconify-icon>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                                <li>
                                                    <a class="dropdown-item" href="/dashboard/link/{{ $link->slug }}">
                                                        <iconify-icon icon="solar:info-circle-bold" class="me-2"></iconify-icon> Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <button 
                                                        class="dropdown-item generate-qr" 
                                                        data-url="{{ 'https://linksy.site/' . $link->slug }}"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#qrCodeModal"
                                                    >
                                                        <iconify-icon icon="solar:qr-code-bold" class="me-2"></iconify-icon> Generate QR
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" 
                                                       href="#" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#editModal" 
                                                       data-id="{{ $link->slug }}" 
                                                       data-target-url="{{ $link->target_url }}" 
                                                       data-active="{{ $link->active }}">
                                                        <iconify-icon icon="solar:pen-bold" class="me-2"></iconify-icon> Quick Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#shareLinkModal" 
                                                            data-id="{{ $link->slug }}">
                                                        <iconify-icon icon="solar:share-bold" class="me-2"></iconify-icon> Share Link
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" 
                                                       href="#" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#deleteModal" 
                                                       data-id="{{ $link->slug }}">
                                                        <iconify-icon icon="solar:trash-bin-minimalistic-bold" class="me-2"></iconify-icon> Delete
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            @empty
                            <div class="empty-container text-center">
                                <p>No links found.</p>
                            </div>
                            @endforelse
                                {{ $links->links() }}
                            </div>
                        </div>
                
                        <!-- Shared Links -->
                        <div class="tab-pane fade" id="shared-links" role="tabpanel" aria-labelledby="shared-links-tab">
                            <div class="row">
                                @forelse ($sharedLinks as $link)
                                <div class="col-md-4 d-flex align-items-stretch">
                                    <div class="card shadow border-0 w-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-1">
                                                <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($link->target_url) }}&size=32" alt="Favicon" class="rounded me-2" style="width: 32px; height: 32px;">
                                                <input type="text" 
                                                    class="form-control border-0 p-0 text-dark fw-bold fs-5" 
                                                    value="{{ $link->title  }}" 
                                                    readonly>
                                            </div>
                                            <p class="text-muted small mb-1">Shared by: <b>{{ $link->user->name }}</b></p>
                                            <a href="{{ $link->target_url }}" target="_blank" class="d-block text-truncate link-dark">
                                                {{ Str::limit(strip_tags($link->target_url), 80) }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center w-100"><p>No shared links found.</p></div>
                                @endforelse
                                {{ $sharedLinks->links() }}
                            </div>
                        </div>
                        <!-- Links You Shared -->
                        <div class="tab-pane fade" id="links-you-shared" role="tabpanel" aria-labelledby="links-you-shared-tab">
                            <div class="row g-3">
                                @forelse ($mySharedLinks as $sharedLink)
                                <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
                                    <div class="card shadow border-0 w-100">
                                        <div class="card-body d-flex flex-column">
                                            <!-- Favicon and Link Title -->
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($sharedLink->link->target_url) }}&size=32" 
                                                    alt="Favicon" class="rounded me-2" style="width: 32px; height: 32px;">
                                                    <input type="text" 
                                                    class="form-control border-0 p-0 text-dark fw-bold fs-5" 
                                                    value="{{ $sharedLink->link->title  }}" 
                                                    readonly>
                                            </div>
                                            <!-- Shared with User -->
                                            <p class="text-muted small mb-2">
                                                To: <b>{{ $sharedLink->sharedWith->name }}</b>
                                            </p>
                                            <!-- Link URL -->
                                            <div class="d-flex align-items-center">
                                                <a href="{{ $sharedLink->link->target_url }}" target="_blank" class="text-truncate text-decoration-none flex-grow-1">
                                                    {{ Str::limit(strip_tags($sharedLink->link->target_url), 80) }}
                                                </a>
                                            </div>
                                            <!-- Actions -->
                                            <div class="d-flex justify-content-end mt-3">
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-secondary btn-sm rounded-pill" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-three-dots"></i>
                                                    </button>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li>
                                                            <form action="{{ route('links.share.delete', $sharedLink->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="bi bi-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center w-100">
                                    <p>Tidak ada tautan yang Anda bagikan.</p>
                                </div>
                                @endforelse
                            </div>
                            <div class="mt-3">
                                {{ $mySharedLinks->links() }}
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Sharing Link -->
        <div class="modal fade" id="shareLinkModal" tabindex="-1" aria-labelledby="shareLinkModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0" style="border-radius: 20px;">
                    <div class="modal-header bg-gradient-primary text-white" style="border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                        <div class="d-flex align-items-center w-100">
                            <div class="icon-shape bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-send fs-4 text-dark"></i>
                            </div>
                            <div>
                                <h5 class="modal-title mb-0" id="shareLinkModalLabel" style="font-weight: 600;">Share Resource</h5>
                                <p class="mb-0 small opacity-75 text-dark">Collaborate by sharing with team members</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    
                    <div class="modal-body py-4 px-5">
                        <form id="shareLinkForm">
                            <div class="mb-4">
                                <label for="sharedWith" class="form-label fw-500 mb-3">Recipient's Username</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person-circle text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control border-start-0 ps-2" 
                                           id="sharedWith" 
                                           name="shared_with" 
                                           placeholder="e.g. johndoe123"
                                           style="height: 50px;"
                                           required>
                                </div>
                                <div class="form-text mt-2">Enter the exact username of the person you want to share with</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-500 mb-3">Sharing Options</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check form-check-card">
                                        <input class="form-check-input" type="checkbox" id="sendNotification">
                                        <label class="form-check-label small" for="sendNotification">
                                            Send notification
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="linkId" name="link_id">
                        </form>
                    </div>
        
                    <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px; padding: 1.5rem 2rem;">
                        <button type="button" class="btn btn- btn-neutral" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button  id="shareButton" type="button" class="btn  btn-primary px-4" >
                            <i class="bi bi-send-check me-2"></i>Share Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
       
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0" style="border-radius: 20px;">
                    <div class="modal-header bg-gradient-danger text-white" style="border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                        <div class="d-flex align-items-center w-100">
                            <div class="icon-shape bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-exclamation-triangle fs-4 text-dark"></i>
                            </div>
                            <div class="text-dark">
                                <h5 class="modal-title mb-0" id="deleteModalLabel" style="font-weight: 600;">Delete Short Link</h5>
                                <p class="mb-0 small opacity-75">This action cannot be undone</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
        
                    <div class="modal-body py-2 px-5">
                        <div class="text-center mb-4">
                            <h5 class="fw-semibold mb-2">Confirm Deletion</h5>
                            <p class="text-muted">This will permanently remove the short link and all its analytics data</p>
                        </div>
        
                        <div class="mb-4">
                            <label class="form-label fw-500 mb-3">Type <span class="text-danger">DELETE</span> to confirm:</label>
                            <div class="input-group input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key-fill text-danger"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 ps-2" 
                                       id="deleteConfirmationInput"
                                       placeholder="Enter 'DELETE'"
                                       autocomplete="off">
                            </div>
                            <div class="form-text text-danger mt-2">
                                <i class="bi bi-exclamation-circle me-2"></i>This action is irreversible
                            </div>
                        </div>
                    </div>
        
                    <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px; padding: 1.5rem 2rem;">
                        <button type="button" class="btn btn btn-neutral" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn btn-danger px-4" 
                                    id="deleteButton" 
                                    disabled
                                    style="position: relative; overflow: hidden;">
                                <i class="bi bi-trash3 me-2"></i>Delete Permanently
                                <div class="hover-effect" style="position: absolute; background: rgba(255,255,255,0.2); top: -50%; left: -50%; width: 200%; height: 200%; transform: rotate(45deg) translate(-30px, 100%); transition: all 0.3s;"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- QR Code Modal -->
        <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0" style="border-radius: 20px;">
                    <div class="modal-header bg-gradient-primary text-white" style="border-radius: 20px 20px 0 0; padding: 1.5rem;">
                        <div class="w-100 text-center">
                            <h5 class="modal-title mb-1" id="qrCodeModalLabel" style="font-weight: 600;">
                                <i class="bi bi-qr-code-scan me-2"></i>QR Code
                            </h5>
                            <p class="mb-0 small opacity-75" id="qrCodeUrl"></p>
                        </div>
                        <button type="button" class="btn-close btn-close-white position-absolute end-3 top-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
        
                    <div class="modal-body text-center py-4 px-5">
                        <div id="qrCodeContainer" class="position-relative">
                            <div class="qr-code-loader">
                                <div class="circle-spinner">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button id="downloadQrCode" class="btn btn-lg btn-primary px-4 rounded-pill hover-scale">
                                <i class="bi bi-download me-2"></i>Download
                            </button>
                        </div>
        
                        <div class="social-share mt-4">
                            <p class="text-muted small mb-2">Share to:</p>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-icon hover-scale text-facebook">
                                    <i class="bi bi-facebook"></i>
                                </button>
                                <button class="btn btn-icon hover-scale text-twitter">
                                    <i class="bi bi-twitter-x"></i>
                                </button>
                                <button class="btn btn-icon hover-scale text-instagram">
                                    <i class="bi bi-instagram"></i>
                                </button>
                                <button class="btn btn-icon hover-scale text-whatsapp">
                                    <i class="bi bi-whatsapp"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0" style="border-radius: 20px;">
                    <div class="modal-header bg-gradient-primary text-white" style="border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                        <div class="d-flex align-items-center w-100">
                            <div class="icon-shape bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-pencil-square fs-4 text-dark"></i>
                            </div>
                            <div class="text-dark">
                                <h5 class="modal-title mb-0" id="editModalLabel" style="font-weight: 600;">Edit Short Link</h5>
                                <p class="mb-0 small opacity-75">Update your URL destination and settings</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
        
                    <div class="modal-body py-4 px-5">
                        <form id="editForm" action="" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-4">
                                <label for="editTargetUrl" class="form-label fw-500 mb-3">Destination URL</label>
                                <div class="input-group input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-link-45deg text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control border-start-0 ps-2" 
                                           id="editTargetUrl" 
                                           name="target_url"
                                           placeholder="https://example.com"
                                           style="height: 50px;"
                                           required>
                                </div>
                                <div class="form-text mt-2">Enter the full URL including http:// or https://</div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-500 mb-3">Link Status</label>
                                <div class="d-flex align-items-center gap-3 bg-light rounded p-3">
                                    <div class="form-check form-switch custom-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               role="switch" 
                                               id="flexSwitchCheckChecked" 
                                               name="active" 
                                               value="1"
                                               >
                                        <label class="form-check-label ms-3" for="flexSwitchCheckChecked">
                                            <span class="d-block fw-medium">Active Status</span>
                                            <span class="text-muted small">Toggle to enable/disable this short link</span>
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="quickedit" value="1">
                            </div>
        
                            <div class="modal-footer bg-light px-0 pb-0 mt-4" style="border-radius: 0 0 20px 20px;">
                                <button type="button" class="btn btn btn-neutral" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-2"></i>Discard
                                </button>
                                <button type="submit" class="btn btn btn-primary px-4">
                                    <i class="bi bi-save2 me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <script>
        window.visitDataGlobal = @json($visitData);  
        console.log(window.visitDataGlobal);
    </script>
    <script src="{{ asset('js/link.js') }}"></script>
    <script src="{{ asset('js/dashjs/utils.js') }}"></script>
</x-dashlayout>
