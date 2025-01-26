<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        <!-- Toast Notifications -->
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

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/dashboard/link') }}">Link</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $link->slug }}</li>
            </ol>
        </nav>

        <!-- Statistik -->
        <div class="row mb-4">
            <div class="col-6 col-md-3 text-center">
                <i class="bi bi-cloud-check-fill text-primary fs-6"></i>
                <span class="fs-6 mt-2 d-block text-secondary">Records</span>
                <h4 class="mb-0 mt-1 text-dark">{{ $link->visits }}</h4>
            </div>
            <div class="col-6 col-md-3 text-center">
                <i class="bi bi-arrow-up-right-circle-fill text-success fs-6"></i>
                <span class="fs-6 mt-2 d-block text-secondary">Redirected</span>
                <h4 class="mb-0 mt-1 text-dark">{{ $redirectedCount }}</h4>
            </div>
            <div class="col-6 col-md-3 text-center">
                <i class="bi bi-exclamation-circle-fill text-danger fs-6"></i>
                <span class="fs-6 mt-2 d-block text-secondary">Rejected</span>
                <h4 class="mb-0 mt-1 text-dark">{{ $rejectedCount }}</h4>
            </div>
            <div class="col-6 col-md-3 text-center">
                <i class="bi bi-people-fill text-info fs-6"></i>
                <span class="fs-6 mt-2 d-block text-secondary">Unique</span>
                <h4 class="mb-0 mt-1 text-dark">{{ $link->unique_visits }}</h4>
            </div>
        </div>

        <!-- Traffic Overview dan Top Referrers -->
        <div class="row mb-4">
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Traffic Overview</h5>
                        <div id="traffic-overview" class="chart-container"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Top Referrers</h5>
                        <div id="chart" class="chart-container"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Visit History -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <!-- Filter -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <select id="filterUnique" class="form-select w-auto" onchange="applyFilter()">
                                <option value="all">All</option>
                                <option value="unique">Unique Only</option>
                                <option value="rejected">Rejected</option>
                                <option value="redirected">Redirected</option>
                            </select>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>IP Address</th>
                                        <th>Browser</th>
                                        <th>Referer</th>
                                        <th>Location</th>
                                        <th>Unique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($visithistory as $visit)
                                    <tr>
                                        <td>{{ $visit->created_at }}</td>
                                        <td>
                                            @if($visit->status)
                                                <span class="badge bg-info">Redirected</span>
                                            @else
                                                <span class="badge bg-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>{{ $visit->ip_address }}</td>
                                        <td>{{ $visit->user_agent }}</td>
                                        <td>{{ $visit->referer_url ?? 'Direct' }}</td>
                                        <td>{{ $visit->location }}</td>
                                        <td>
                                            @if($visit->is_unique)
                                                <span class="badge bg-primary">Yes</span>
                                            @else
                                                <span class="badge bg-warning">No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No record data.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $visithistory->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Link Details dan QR Code -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="card-title fw-semibold text-primary mb-4">
                            <i class="bi bi-link-45deg"></i> Link Details
                        </h5>
                        <!-- Form untuk mengupdate link -->
                        <form id="link-update-form" method="POST" data-update-url="{{ route('link.update', $link->slug) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{ $link->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="target_url" class="form-label">Long URL</label>
                                <input type="text" class="form-control" id="target_url" name="target_url" value="{{ $link->target_url }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="slug" class="form-label">Short URL</label>
                                <div class="input-group">
                                    <span class="input-group-text">{{ url('r/') }}</span>
                                    <input type="text" class="form-control" id="slug" name="slug" value="{{ $link->slug }}" required>
                                </div>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="activeSwitch" name="active" {{ $link->active ? 'checked' : '' }}>
                                <label class="form-check-label" for="activeSwitch">Active</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold text-primary mb-4">
                            <i class="bi bi-shield-lock"></i> Block IP Address
                        </h5>
                        <form id="block-ip-form" method="POST" action="{{ route('block.ip') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="ip_address" placeholder="Enter IP Address" required>
                                <button type="submit" class="btn btn-danger">Block</button>
                            </div>
                            <input type="hidden" name="link_id" value="{{ $link->id }}">
                        </form>

                        <!-- List of Blocked IPs -->
                        <h6 class="mt-4 text-primary">Blocked IPs</h6>
                        <ul class="list-group">
                            @forelse ($blockedIps as $ip)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $ip->ip_address }}
                                <form method="POST" action="{{ route('unblock-ip', $ip->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Unblock</button>
                                </form>
                            </li>
                            @empty
                            <li class="list-group-item text-muted">No IP addresses are blocked.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk Chart dan QR Code -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showQRCode('{{ url('r/' . $link->slug) }}');
        });

        const visitDataGlobal = @json($chartData);
        const toprefDataGlobal = @json($topReferers);
    </script>
    <script src="{{ asset('js/dashjs/linkdetail.js') }}"></script>
</x-dashlayout>