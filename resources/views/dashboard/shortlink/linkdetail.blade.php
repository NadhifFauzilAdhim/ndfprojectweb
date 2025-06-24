<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container-fluid p-4">
        <nav class="mb-4" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/dashboard/link') }}">Link</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $link->slug }}</li>
            </ol>
        </nav>
        @if($countdown['target_time'])
        <div id="countdown-banner" class="alert {{ $countdown['status_class'] }} shadow-sm rounded-5 p-3 mb-4" role="alert" data-countdown-target="{{ $countdown['target_time'] }}">
            <div class="d-flex flex-column pt-3 flex-md-row align-items-center justify-content-center text-center gap-3">
                <div class="fw-semibold">
                    <i class="bi bi-stopwatch me-2"></i>{{ $countdown['message'] }}
                </div>
                <div id="countdown-timer" class="d-flex justify-content-center gap-3">
                    <div>
                        <h4 id="days" class="fw-bold mb-0">00</h4>
                        <span class="small">Days</span>
                    </div>
                    <div><h4 class="fw-bold mb-0">:</h4></div>
                    <div>
                        <h4 id="hours" class="fw-bold mb-0">00</h4>
                        <span class="small">Hours</span>
                    </div>
                    <div><h4 class="fw-bold mb-0">:</h4></div>
                    <div>
                        <h4 id="minutes" class="fw-bold mb-0">00</h4>
                        <span class="small">Mins</span>
                    </div>
                    <div><h4 class="fw-bold mb-0">:</h4></div>
                    <div>
                        <h4 id="seconds" class="fw-bold mb-0">00</h4>
                        <span class="small">Secs</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="card shadow-sm mb-4 rounded-5 rounded-5">
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

                <div class="row text-center">
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-cloud-check-fill text-primary fs-3"></i>
                                <p class="text-muted mb-1 mt-2">Records</p>
                                <h4 class="mb-0">{{ $link->visits }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-arrow-up-right-circle-fill text-success fs-3"></i>
                                <p class="text-muted mb-1 mt-2">Redirected</p>
                                <h4 class="mb-0">{{ $redirectedCount }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-exclamation-circle-fill text-danger fs-3"></i>
                                <p class="text-muted mb-1 mt-2">Rejected</p>
                                <h4 class="mb-0">{{ $rejectedCount }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <i class="bi bi-people-fill text-info fs-3"></i>
                                <p class="text-muted mb-1 mt-2">Unique</p>
                                <h4 class="mb-0">{{ $link->unique_visits }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm h-100 rounded-5">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                            Traffic Overview
                            <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Traffic Overview"></iconify-icon>
                        </h5>
                        <div id="traffic-overview"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                            Top Referrers
                            <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Top Referrers"></iconify-icon>
                        </h5>
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm h-100 rounded-5">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                            Location
                            <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Visitor Locations"></iconify-icon>
                        </h5>
                        <div id="location-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card shadow-sm h-100 rounded-5">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-cpu me-2"></i> AI-Powered Link Analysis
                        </h5>
                        <button id="generate-summary-btn" class="btn btn-primary w-100 mb-3" data-link-id="{{ $link->slug }}">
                            <i class="bi bi-magic me-2"></i> Generate Insight
                        </button>
                        <div id="summary-loading" class="d-none">
                            <div class="d-flex align-items-center text-primary">
                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                <span>Analyzing traffic patterns...</span>
                            </div>
                        </div>
                        <div id="summary-result" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mb-4 rounded-5">
            <div class="card-body">
                <div class="alert alert-primary text-center" role="alert">
                    <i class="bi bi-info-circle-fill"></i> <span class="fw-bold">Visit History</span> - View this link's visit history. Records are automatically deleted after 60 days.
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <select id="filterUnique" class="form-select w-auto" onchange="applyFilter()">
                        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All Visits</option>
                        <option value="unique" {{ request('filter') == 'unique' ? 'selected' : '' }}>Unique Only</option>
                        <option value="rejected" {{ request('filter') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="redirected" {{ request('filter') == 'redirected' ? 'selected' : '' }}>Redirected</option>
                    </select>
                </div>
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @forelse ($visithistory as $visit)
                        <div class="swiper-slide">
                            <div class="card border card-hover h-100">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title fw-bold text-primary">
                                        <i class="bi bi-calendar-event me-2"></i>{{ $visit->created_at }}
                                    </h6>
                                    <p class="card-text mb-1">
                                        <i class="bi bi-info-circle me-2 text-primary"></i> Status:
                                        @if($visit->status)
                                            <span class="badge rounded-pill bg-info ms-1"><small>Redirected</small></span>
                                        @else
                                            <span class="badge rounded-pill bg-danger ms-1"><small>Rejected</small></span>
                                        @endif
                                    </p>
                                    <p class="card-text mb-1 d-flex align-items-center">
                                        <i class="bi bi-hdd-network me-2 text-primary"></i> IP Address: <span class="ip-address me-2">{{ $visit->ip_address }}</span>
                                        <button class="btn btn-sm btn-outline-primary reveal-ip-provider-btn" data-ip="{{ $visit->ip_address }}">
                                            Reveal Provider <i class="bi bi-globe"></i>
                                        </button>
                                    </p>
                                    <div class="ip-provider-info mt-1 mb-2 small text-muted" style="display: none;">
                                        Loading...
                                    </div>
                    
                                    <p class="card-text mb-1"><i class="bi bi-browser-edge me-2 text-primary"></i> Browser: {{ $visit->user_agent }}</p>
                                    <p class="card-text mb-1"><i class="bi bi-link me-2 text-primary"></i> Referer: {{ $visit->referer_url ?? 'Direct' }}</p>
                                    <p class="card-text mb-1"><i class="bi bi-geo-alt-fill me-2 text-primary"></i> Location: {{ $visit->location }}</p>
                                    <p class="card-text mb-auto"><i class="bi bi-check-circle me-2 text-primary"></i> Unique:
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
                            <div class="text-center text-muted">No visit history found.</div>
                        </div>
                    @endforelse
                    </div>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $visithistory->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4" id="link-settings">
            <div class="card-body p-lg-5">
                <h5 class="card-title fw-bold text-primary mb-4">
                    <i class="bi bi-link-45deg"></i> Link Settings
                </h5>
                @if(!$link->active)
                <div class="alert alert-warning text-center shadow-sm" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i> This link is currently inactive based on its visibility or schedule.
                </div>
                @endif
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <form id="link-update-form" method="POST" data-update-url="{{ route('link.update', $link->slug) }}">
                                    @csrf
                                    @method('PUT')

                                    <h6 class="text-info mb-3 fw-semibold"><i class="bi bi-info-circle"></i> Basic Info</h6>
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control shadow-sm" id="title" name="title" value="{{ $link->title }}" placeholder="Enter the title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="target_url" class="form-label">Long URL</label>
                                        <input type="text" class="form-control shadow-sm" id="target_url" name="target_url" value="{{ $link->target_url }}" placeholder="Enter the original URL" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Short URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-primary">linksy.site/</span>
                                            <input type="text" class="form-control shadow-sm" id="slug" name="slug" value="{{ $link->slug }}" placeholder="Custom short link" required>
                                            <div class="invalid-feedback" id="slug-error"></div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="activeSelect" class="form-label">Visibility</label>
                                        <select class="form-select shadow-sm" id="activeSelect" name="visibility" required>
                                            <option value="1" {{ $link->active ? 'selected' : '' }}>Public — Accessible to everyone</option>
                                            <option value="0" {{ !$link->active ? 'selected' : '' }}>Private — Restricted access</option>
                                        </select>
                                    </div>

                                    <h6 class="text-info mb-3 fw-semibold"><i class="bi bi-calendar-event"></i> Time Scheduler</h6>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" role="switch" id="timeSchedulerSwitch" name="scheduled" {{ $link->scheduled ? 'checked' : '' }}>
                                        <label class="form-check-label" for="timeSchedulerSwitch">Enable time-based activation</label>
                                    </div>
                                    <div id="scheduler-fields" style="{{ $link->scheduled ? '' : 'display: none;' }}">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="start_time" class="form-label">Activation Time</label>
                                                <input type="datetime-local" class="form-control shadow-sm" id="start_time" name="start_time" value="{{ $link->start_time ? $link->start_time->format('Y-m-d\TH:i') : '' }}">
                                                <div class="form-text">When the link should become active.</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="end_time" class="form-label">Expiration Time</label>
                                                <input type="datetime-local" class="form-control shadow-sm" id="end_time" name="end_time" value="{{ $link->end_time ? $link->end_time->format('Y-m-d\TH:i') : '' }}">
                                                <div class="form-text">When the link goes inactive. Leave blank for no expiry.</div>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="text-warning mb-3 fw-semibold"><i class="bi bi-shield-lock"></i> Password Protection</h6>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="passwordProtectionSwitch" name="password_protected" {{ $link->password_protected ? 'checked' : '' }}>
                                        <label class="form-check-label" for="passwordProtectionSwitch">Require Password</label>
                                    </div>
                                    <div id="password-field-container" style="{{ $link->password_protected ? '' : 'display: none;' }}">
                                        <input type="password" class="form-control mt-3 shadow-sm" id="password" name="password" placeholder="Enter new password">
                                        <div class="form-text">Leave blank to keep the current password.</div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-4 w-100 shadow-sm p-3">
                                        <i class="bi bi-save"></i> Save Changes
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body text-center p-4">
                                <h6 class="text-primary mb-3">QR Code</h6>
                                <div id="qrCodeContainer" class="mb-3"></div>
                                <button id="downloadQrCode" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-cloud-arrow-down"></i> Download
                                </button>
                            </div>
                        </div>

                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h6 class="text-primary">Block IP Address</h6>
                                <form id="block-ip-form" data-block-url="{{ url('/block-ip') }}">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control shadow-sm" name="ip_address" placeholder="Enter IP Address" required>
                                        <button class="btn btn-danger shadow-sm" type="submit">Block</button>
                                    </div>
                                    <input type="hidden" name="link_id" value="{{ $link->id }}">
                                </form>

                                <h6 class="mt-4 text-primary">Blocked IPs</h6>
                                <div id="blocked-ips-container" data-unblock-url="{{ url('/unblock-ip') }}" style="max-height: 200px; overflow-y: auto;">
                                    @if($blockedIps->isEmpty())
                                    <p class="text-muted small">No IP addresses are blocked.</p>
                                    @else
                                    <ul class="list-group list-group-flush">
                                        @foreach($blockedIps as $ip)
                                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                            <span class="text-muted">{{ $ip->ip_address }}</span>
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

    <script src="{{ asset('js/dashjs/linkdetail.js') }}"></script>
    <script src="{{ asset('js/dashjs/linksummary.js') }}"></script>
    <script src="{{ asset('js/dashjs/ipProvider.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showQRCode('{{ url('r/' . $link->slug) }}');
            const countdownBanner = document.getElementById('countdown-banner');
            if (countdownBanner) {
                const targetTime = new Date(countdownBanner.dataset.countdownTarget).getTime();

                const countdownInterval = setInterval(function() {
                    const now = new Date().getTime();
                    const distance = targetTime - now;
                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        countdownBanner.innerHTML = `<div class="text-center fw-semibold"><i class="bi bi-check-circle-fill me-2"></i>Waktu yang ditentukan telah tercapai. Silakan refresh halaman untuk melihat status terbaru.</div>`;
                        return;
                    }
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    document.getElementById("days").innerText = String(days).padStart(2, '0');
                    document.getElementById("hours").innerText = String(hours).padStart(2, '0');
                    document.getElementById("minutes").innerText = String(minutes).padStart(2, '0');
                    document.getElementById("seconds").innerText = String(seconds).padStart(2, '0');

                }, 1000);
            }
        });
        const visitDataGlobal = @json($chartData);
        const toprefDataGlobal = @json($topReferers);
        const locationData = @json($location);
    </script>
</x-dashlayout>