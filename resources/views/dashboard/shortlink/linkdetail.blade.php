<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        @if(session()->has('success'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-3"></i>{{ session('success') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @elseif(session()->has('error'))
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div class="toast align-items-center text-bg-warning border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-diamond-fill me-3"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        @endif
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="toast-notification" class="toast notif-toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toast-message">
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                              <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                              <li class="breadcrumb-item"><a href="{{ url('/dashboard/link') }}">Link</a></li>
                              <li class="breadcrumb-item active" aria-current="page">{{ $link->slug }}</li>
                            </ol>
                          </nav>
                    </div>
                   
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                @if($link->password_protected)
                                <div class="alert alert-warning d-flex align-items-center justify-content-center text-center shadow-sm" role="alert">
                                    <i class="bi bi-shield-lock-fill me-2 fs-5"></i>
                                    <span>Password Protection is Enabled</span>
                                </div>
                                @endif
                                <div class="text-center mt-4 mb-4">
                                    <h5>{{ $link->title }}</h5>
                                </div>
                               
                                <div class="row">
                                    <div class=" mb-5 col-lg-8 d-flex align-items-stretch">
                                        <div class="card-body ">
                                            <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                                                    Traffic Overview
                                                <span>
                                                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Traffic Overview"></iconify-icon>
                                                </span>
                                            </h5>
                                                <div id="traffic-overview"></div>
                                        </div>
                                    </div>
                                    <div class=" mb-5 col-lg-4 d-flex align-items-stretch">
                                        <div class="card-body ">
                                            <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                                                    Top Referrers
                                                <span>
                                                    <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Traffic Overview"></iconify-icon>
                                                </span>
                                            </h5>
                                                <div id="chart"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-3 text-center">
                                        <i class="bi bi-cloud-check-fill text-primary fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary d-none d-sm-block">Records</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $link->visits }}</h4>
                                    </div>
                                    <div class="col-3 text-center">
                                        <i class="bi bi-arrow-up-right-circle-fill text-success fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary d-none d-sm-block">Redirected</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $redirectedCount }}</h4>
                                    </div>
                                    <div class="col-3 text-center">
                                        <i class="bi bi-exclamation-circle-fill text-danger fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary d-none d-sm-block">Rejected</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $rejectedCount }}</h4>
                                    </div>
                                    <div class="col-3 text-center">
                                        <i class="bi bi-people-fill text-info fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary d-none d-sm-block">Unique</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $link->unique_visits }}</h4>
                                    </div>
                                    
                                </div>
                                <!-- Table -->
                                <div class="swiper mt-2">
                                    <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                                        <div>
                                            <label for="filterUnique" class="me-2 fw-bold"></label>
                                            <select id="filterUnique" class="form-select d-inline-block w-auto" onchange="applyFilter()">
                                                <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
                                                <option value="unique" {{ request('filter') == 'unique' ? 'selected' : '' }}>Unique Only</option>
                                                <option value="rejected" {{ request('filter') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                <option value="redirected" {{ request('filter') == 'redirected' ? 'selected' : '' }}>Redirected</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="swiper-wrapper">
                                        @forelse ($visithistory as $visit)
                                        <div class="swiper-slide">
                                            <div class="card border card-hover">
                                                <div class="card-body ">
                                                    <h6 class="card-title fw-bold">
                                                        <i class="bi bi-calendar-event me-2 text-primary"></i>
                                                        {{ $visit->created_at }}
                                                    </h6>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-info-circle me-2 text-primary"></i>
                                                        Status:
                                                        @if($visit->status)
                                                            <span class="badge rounded-pill bg-info ms-1"><small>Redirected</small></span>
                                                        @else
                                                            <span class="badge rounded-pill bg-danger ms-1"><small>Rejected</small></span>
                                                        @endif
                                                    </p>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-hdd-network me-2 text-primary"></i>
                                                        IP Address: {{ $visit->ip_address }}
                                                    </p>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-browser-edge me-2 text-primary"></i>
                                                        Browser: {{ $visit->user_agent }}
                                                    </p>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-link me-2 text-primary"></i>
                                                        Referer: {{ $visit->referer_url ?? 'Direct' }}
                                                    </p>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-geo-alt-fill me-2 text-primary"></i>
                                                        Location: {{ $visit->location }}
                                                    </p>
                                                    <p class="card-text">
                                                        <i class="bi bi-check-circle me-2 text-primary"></i>
                                                        Unique:
                                                        @if($visit->is_unique)
                                                            <span class="badge bg-primary"><small>Yes</small></span>
                                                        @else
                                                            <span class="badge rounded-pill bg-warning"><small>No</small></span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        @empty
                                            <div class="swiper-slide">
                                                <div class="text-center text-muted">No record data.</div>
                                            </div>
                                        @endforelse
                                    </div>
                                    <!-- Add navigation buttons -->
                                   
                                </div>
                                <!-- Pagination -->
                                <div class="mt-4">
                                    {{ $visithistory->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>                  
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold text-primary mb-4">
                    <i class="bi bi-link-45deg"></i> Link Details
                </h5>
                <div class="row g-4">
                    <div class="col-lg-8">
                        <!-- Alert for Non-Active Link -->
                        @if(!$link->active)
                        <div class="alert alert-warning text-center shadow-sm" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> Link is inactive
                        </div>
                        @endif
        
                        <!-- Form for Link Details -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <form id="link-update-form" method="POST" data-update-url="{{ route('link.update', $link->slug) }}">
                                    @csrf
                                    @method('PUT')
        
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input 
                                            type="text" 
                                            class="form-control shadow-sm" 
                                            id="title" 
                                            name="title" 
                                            value="{{ $link->title }}" 
                                            placeholder="Enter the title" 
                                            required>
                                    </div>
        
                                    <div class="mb-3">
                                        <label for="target_url" class="form-label">Long URL</label>
                                        <input 
                                            type="text" 
                                            class="form-control shadow-sm" 
                                            id="target_url" 
                                            name="target_url" 
                                            value="{{ $link->target_url }}" 
                                            placeholder="Enter the original URL" 
                                            required>
                                    </div>
        
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Short URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-primary">{{ url('r/') }}</span>
                                            <input 
                                                type="text" 
                                                class="form-control shadow-sm" 
                                                id="slug" 
                                                name="slug" 
                                                value="{{ $link->slug }}" 
                                                placeholder="Custom short link" 
                                                required>
                                            <div class="invalid-feedback" id="slug-error"></div>
                                        </div>
                                    </div>
        
                                    <div class="form-check form-switch mt-3">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            id="activeSwitch" 
                                            name="active" 
                                            {{ $link->active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activeSwitch">
                                            {{ $link->active ? 'Active' : 'Inactive' }}
                                        </label>
                                    </div>
        
                                    <!-- Password Protection -->
                                    <div class="card mt-4 border-0 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="text-warning mb-3">
                                                <i class="bi bi-shield-lock"></i> Password Protection
                                            </h6>
                                            <div class="form-check form-switch">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    id="passwordProtectionSwitch" 
                                                    name="password_protected" 
                                                    {{ $link->password_protected ? 'checked' : '' }}>
                                                <label class="form-check-label" for="passwordProtectionSwitch">Require Password</label>
                                            </div>
                                            <input 
                                                type="password" 
                                                class="form-control mt-3 shadow-sm" 
                                                id="password" 
                                                name="password" 
                                                placeholder="Enter password (optional)">
                                            <div class="form-text">Leave blank to keep the current password.</div>
                                        </div>
                                    </div>
        
                                    <button type="submit" class="btn btn-primary mt-4 w-100 shadow">
                                        <i class="bi bi-save"></i> Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-lg-4">
                        <!-- QR Code Section -->
                        <div class="card shadow-sm border-0">
                            <div class="card-body text-center">
                                <div id="qrCodeContainer" class="qrCodeContainer mb-3"></div>
                                <button id="downloadQrCode" class="btn btn-primary">
                                    <i class="bi bi-cloud-arrow-down"></i> Download QR Code
                                </button>
                            </div>
                        </div>
        
                        <!-- Block IP Section -->
                        <div class="card mt-4 shadow-sm border-0">
                            <div class="card-body">
                                <h6 class="text-primary">Block IP Address</h6>
                                <form id="block-ip-form" data-block-url="{{ url('/block-ip') }}">
                                    @csrf
                                    <div class="input-group">
                                        <input 
                                            type="text" 
                                            class="form-control shadow-sm" 
                                            name="ip_address" 
                                            placeholder="Enter IP Address" 
                                            required>
                                        <button class="btn btn-danger shadow-sm" type="submit">Block</button>
                                    </div>
                                    <input type="hidden" name="link_id" value="{{ $link->id }}">
                                </form>
        
                                <!-- List of Blocked IPs -->
                                <h6 class="mt-4 text-primary">Blocked IPs</h6>
                                <div id="blocked-ips-container" data-unblock-url="{{ url('/unblock-ip') }}">
                                    @if($blockedIps->isEmpty())
                                        <p class="text-muted">No IP addresses are blocked.</p>
                                    @else
                                        <ul class="list-group list-group-flush">
                                            @foreach($blockedIps as $ip)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $ip->ip_address }}</span>
                                                    <button class="btn btn-sm btn-outline-danger unblock-btn" data-id="{{ $ip->id }}">Unblock</button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showQRCode('{{ url('r/' . $link->slug) }}'); 
        });
    </script>
    <script>
        const visitDataGlobal = @json($chartData);
        const toprefDataGlobal = @json($topReferers);
        console.log(toprefDataGlobal);
    </script>
    <script src="{{ asset('js/dashjs/linkdetail.js') }}"></script>
    
    
</x-dashlayout>