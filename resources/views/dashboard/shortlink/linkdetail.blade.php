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
                                                <div class="table-responsive">
                                                    <table class="table text-nowrap align-middle mb-0">
                                                        <thead>
                                                            <tr class="border-2 border-bottom border-primary border-0"> 
                                                                <th scope="col" class="ps-0">Referer URL</th>
                                                                <th scope="col" class="ps-0">Visits</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-group-divider">
                                                            @forelse($topReferers as $referer)
                                                                <tr>
                                                                    <td class="ps-0 fw-medium">
                                                                        <span class="table-link1 text-truncate d-block">
                                                                            {{ $referer->referer_url ?? 'Direct' }}
                                                                        </span>
                                                                    </td>
                                                                    <td class="ps-0">
                                                                        {{ $referer->visit_count }}
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="2" class="text-center text-muted">No referer data available.</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <!-- Records -->
                                    <div class="col-3 text-center">
                                        <i class="bi bi-cloud-check-fill text-primary fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary">Records</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $link->visits }}</h4>
                                    </div>
                                    <!-- Redirected -->
                                    <div class="col-3 text-center">
                                        <i class="bi bi-arrow-up-right-circle-fill text-success fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary">Redirected</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $redirectedCount }}</h4>
                                    </div>
                                    <!-- Rejected -->
                                    <div class="col-3 text-center">
                                        <i class="bi bi-exclamation-circle-fill text-danger fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary">Rejected</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $rejectedCount }}</h4>
                                    </div>
                                    <!-- Unique -->
                                    <div class="col-3 text-center">
                                        <i class="bi bi-people-fill text-info fs-6"></i>
                                        <span class="fs-6 mt-2 d-block text-secondary">Unique</span>
                                        <h4 class="mb-0 mt-1 text-dark">{{ $link->unique_visits }}</h4>
                                    </div>
                                </div>
                                <!-- Table -->
                                <div class="table-responsive mt-4">
                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <div>
                                            <label for="filterUnique" class="me-2 fw-bold"></label>
                                            <select id="filterUnique" class="form-select d-inline-block w-auto" onchange="applyFilter()">
                                                <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All</option>
                                                <option value="unique" {{ request('filter') == 'unique' ? 'selected' : '' }}>Unique Only</option>
                                            </select>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-hover align-middle text-center">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th scope="col" class="ps-0">Date</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">IP Address</th>
                                                <th scope="col">Browser</th>
                                                <th scope="col">Referer</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Unique</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($visithistory as $visit)
                                            <tr>
                                                <td class="ps-0 fw-medium">{{ $visit->created_at }}</td>
                                                <td>
                                                    @if($visit->status)
                                                        <span class="badge bg-success">Redirected</span>
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
                                                        <span class="badge bg-success">Yes</span>
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
                                <form method="POST" action="{{ route('link.update', $link->slug) }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="mb-4">
                                        <label for="target_url" class="form-label fw-bold ">Long URL</label>
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
                                        <label for="slug" class="form-label fw-bold ">Short URL</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-primary" id="basic-addon3">{{ url('r/') }}</span>
                                            <input 
                                                type="text" 
                                                class="form-control border-primary shadow-sm @if($errors->has('slug')) is-invalid @endif" 
                                                id="slug" 
                                                name="slug" 
                                                value="{{ $link->slug }}" 
                                                placeholder="Custom short link" 
                                                required>
                                            @if ($errors->has('slug'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('slug') }}
                                                </div>
                                            @endif
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
                                        <label class="form-check-label fw-bold" for="activeSwitch">{{ $link->active ? '🔔 Active' : '🔕 Inactive' }}</label>
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
                                                <label class="form-check-label fw-bold " for="passwordProtectionSwitch">Require Password</label>
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
                        <div class="card same-height shadow-sm border-0">
                            <div class="card-body text-center">
                                <form method="POST" action="{{ route('block.ip') }}" class="text-start">
                                    @csrf
                                    <h5 class="text-primary fw-bold">Block an IP Address</h5>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="ip_address" placeholder="Enter IP Address" required>
                                        <button class="btn btn-danger" type="submit">Block</button>
                                    </div>
                                    <input type="hidden" name="link_id" value="{{ $link->id }}">
                                    @if($errors->has('ip_address'))
                                        <div class="text-danger small">{{ $errors->first('ip_address') }}</div>
                                    @endif
                                </form>
                                
                                <!-- List of Blocked IPs -->
                                <div class="mt-4">
                                    <h5 class="text-primary fw-bold">Blocked IPs</h5>
                                    @if($blockedIps->isEmpty())
                                        <p class="text-muted">No IP addresses are blocked.</p>
                                    @else
                                        <ul class="list-group list-group-flush">
                                            @foreach($blockedIps as $ip)
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>{{ $ip->ip_address }}</span>
                                                    <form method="POST" action="{{ route('unblock.ip', $ip->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-outline-danger" type="submit">Unblock</button>
                                                    </form>
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
            $(function () {
        // Data untuk diagram
        var visitData = @json($chartData);

        var chart = {
            series: [
                {
                    name: "Visits",
                    data: visitData, // Gunakan data dari server
                }
            ],
            chart: {
                toolbar: {
                    show: false,
                },
                type: "line",
                fontFamily: "inherit",
                foreColor: "#adb0bb",
                height: 320,
                stacked: false,
            },
            // Warna untuk garis
            colors: ["#007bff"], 
            plotOptions: {},
            dataLabels: {
                enabled: false,
            },
            legend: {
                show: false,
            },
            stroke: {
                width: 2,
                curve: "smooth",
                dashArray: [0], // Solid line
            },
            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
            },
            xaxis: {
                axisBorder: {
                    show: false,
                },
                axisTicks: {
                    show: false,
                },
                categories: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"], // Hari dalam seminggu
            },
            yaxis: {
                tickAmount: 4,
            },
            markers: {
                strokeColor: ["#007bff"],
                strokeWidth: 2,
            },
            tooltip: {
                theme: "dark",
            },
        };

        var chart = new ApexCharts(
            document.querySelector("#traffic-overview"),
            chart
        );
        chart.render();
    });
            document.addEventListener("DOMContentLoaded", function() {
            const toastElList = [].slice.call(document.querySelectorAll('.toast:not(.copy-toast)'));
            const toastList = toastElList.map(function (toastEl) {
                return new bootstrap.Toast(toastEl);
            });
            toastList.forEach(toast => toast.show());
        });
        </script>
        <script>
            function applyFilter() {
                const filter = document.getElementById('filterUnique').value;
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('filter', filter);
                window.location.search = urlParams.toString();
            }
        </script>
</x-dashlayout>