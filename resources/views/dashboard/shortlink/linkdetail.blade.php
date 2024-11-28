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
                        <!-- Pesan akan muncul di sini -->
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
                                <h5 class="card-title fw-bold mb-4"><i class="bi bi-graph-up-arrow"></i> Visit Statistics</h5>
                                <div class="row">
                                    <div class="card mb-5 col-lg-8 same-height">
                                        <div class="card-body shadow-sm mb-3">
                                            <div id="traffic-overview" ></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card same-height">
                                            <div class="card-body">
                                                <h5 class="card-title">Top Referers</h5>
                                                @forelse($topReferers as $referer)
                                                    <div class="card mb-2">
                                                        <div class="card-body p-3 d-flex align-items-center">
                                                            <i class="bi bi-link-45deg text-primary me-3" style="font-size: 1.5rem;"></i>
                                                            <div>
                                                                <h6 class="card-subtitle text-truncate mb-1">
                                                                    {{ $referer->referer_url ?? 'Direct' }}
                                                                </h6>
                                                                <p class="card-text mb-0">
                                                                    Visits: <span class="fw-bold">{{ $referer->visit_count }}</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="text-center text-muted">
                                                        <i class="bi bi-exclamation-circle me-2"></i>
                                                        No referer data available.
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-3 text-center">
                                        <i class="bi bi-cloud-check-fill text-primary fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary">Records</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $link->visits }}</h4>
                                    </div>
                                    <div class="col-3 text-center">
                                        <i class="bi bi-arrow-up-right-circle-fill text-success fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary">Redirected</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $redirectedCount }}</h4>
                                    </div>
                                    <div class="col-3 text-center">
                                        <i class="bi bi-exclamation-circle-fill text-danger fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary">Rejected</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $rejectedCount }}</h4>
                                    </div>
                                    <div class="col-3 text-center">
                                        <i class="bi bi-people-fill text-info fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary">Unique</span>
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
                                                        <i class="bi bi-info-circle me-2 text-success"></i>
                                                        Status:
                                                        @if($visit->status)
                                                            <span class="badge rounded-pill bg-success ms-1"><small>Redirected</small></span>
                                                        @else
                                                            <span class="badge rounded-pill bg-danger ms-1"><small>Rejected</small></span>
                                                        @endif
                                                    </p>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-hdd-network me-2 text-success"></i>
                                                        IP Address: {{ $visit->ip_address }}
                                                    </p>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-browser-edge me-2 text-success"></i>
                                                        Browser: {{ $visit->user_agent }}
                                                    </p>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-link me-2 text-success"></i>
                                                        Referer: {{ $visit->referer_url ?? 'Direct' }}
                                                    </p>
                                                    <p class="card-text mb-1">
                                                        <i class="bi bi-geo-alt-fill me-2 text-success"></i>
                                                        Location: {{ $visit->location }}
                                                    </p>
                                                    <p class="card-text">
                                                        <i class="bi bi-check-circle me-2 text-success"></i>
                                                        Unique:
                                                        @if($visit->is_unique)
                                                            <span class="badge bg-success"><small>Yes</small></span>
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
                <div class="row">
                    <h5 class="card-title fw-semibold mb-4 text-primary"><i class="bi bi-link-45deg"></i> Detail Link</h5>
                    <div class="col-lg-8">
                        @if(!$link->active)
                                <div class="alert alert-warning d-flex align-items-center justify-content-center text-center shadow-sm" role="alert">
                                    <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                                    <span>Link non-active</span>
                                </div>
                        @endif
                        
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <form id="link-update-form" method="POST" data-update-url="{{ route('link.update', $link->slug) }}">
                                    @csrf
                                    @method('PUT')
                                
                                    <div class="mb-4">
                                        <label for="target_url" class="form-label fw-bold">Long URL</label>
                                        <input 
                                            type="text" 
                                            class="form-control border-primary shadow-sm" 
                                            id="target_url" 
                                            name="target_url" 
                                            value="{{ $link->target_url }}" 
                                            placeholder="Enter the original URL" 
                                            required>
                                    </div>
                                
                                    <div class="mb-4">
                                        <label for="slug" class="form-label fw-bold">Short URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-primary" id="basic-addon3">{{ url('r/') }}</span>
                                            <input 
                                                type="text" 
                                                class="form-control border-primary shadow-sm" 
                                                id="slug" 
                                                name="slug" 
                                                value="{{ $link->slug }}" 
                                                placeholder="Custom short link" 
                                                required>
                                            <div class="invalid-feedback" id="slug-error"></div>
                                        </div>
                                    </div>
                                
                                    <div class="form-check form-switch mt-4">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            role="switch" 
                                            id="activeSwitch" 
                                            name="active" 
                                            {{ $link->active ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="activeSwitch">
                                            {{ $link->active ? '🔔 Active' : '🔕 Inactive' }}
                                        </label>
                                    </div>
                                
                                    <div class="card mt-4 bg-light border-primary shadow-sm rounded">
                                        <div class="card-body">
                                            <h4 class="mb-3 text-warning"><i class="bi bi-shield-lock"></i> Password Protection</h4>
                                            <div class="form-check form-switch">
                                                <input 
                                                    class="form-check-input" 
                                                    type="checkbox" 
                                                    role="switch" 
                                                    id="passwordProtectionSwitch" 
                                                    name="password_protected" 
                                                    {{ $link->password_protected ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="passwordProtectionSwitch">Require Password</label>
                                            </div>
                                            <div class="mt-3">
                                                <input 
                                                    type="password" 
                                                    class="form-control border-primary shadow-sm" 
                                                    id="password" 
                                                    name="password" 
                                                    placeholder="Enter password (optional)">
                                                <div class="form-text">Leave blank to keep the current password.</div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary mt-4 w-100 fw-bold shadow">
                                        <i class="bi bi-save"></i> Update
                                    </button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="">
                            <div class="card">
                                <div class="card-body text-center">
                                   <div id="qrCodeContainer" class="qrCodeContainer mb-3"></div>
                                    <button id="downloadQrCode" class="btn btn-primary mb-3"><i class="bi bi-cloud-arrow-down"></i> Download</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="">
                            <div class="card  shadow-sm border-0">
                                <div class="card-body text-center">
                                    <!-- Form Block IP -->
                                    <form id="block-ip-form" class="text-start" data-block-url="{{ url('/block-ip') }}">
                                        @csrf
                                        <h5 class="text-primary fw-bold">Block an IP Address</h5>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="ip_address" placeholder="Enter IP Address" required>
                                            <button class="btn btn-danger" type="submit">Block</button>
                                        </div>
                                        <input type="hidden" name="link_id" value="{{ $link->id }}">
                                        <div id="ip-address-error" class="text-danger small"></div>
                                    </form>                                
                                    <!-- List of Blocked IPs -->
                                    <div class="mt-4"
                                        <h5 class="text-primary fw-bold">Blocked IPs</h5>
                                        <div id="blocked-ips-container" data-unblock-url="{{ url('/unblock-ip') }}">
                                            @if($blockedIps->isEmpty())
                                                <p class="text-muted">No IP addresses are blocked.</p>
                                            @else
                                                <ul class="list-group list-group-flush">
                                                    @foreach($blockedIps as $ip)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center" id="ip-{{ $ip->id }}">
                                                            <input type="text" class="form-control me-2" value="{{ $ip->ip_address }}" readonly>
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
          </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showQRCode('{{ url('r/' . $link->slug) }}'); 
        });
    </script>
    <script>const visitDataGlobal = @json($chartData);</script>
    <script src="{{ asset('js/dashjs/linkdetail.js') }}"></script>
    
    
</x-dashlayout>