<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
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
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body shadow-sm">
                                <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                                    Traffic Overview
                                    <span>
                                        <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Traffic Overview"></iconify-icon>
                                    </span>
                                </h5>
                                <div id="traffic-overview" ></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                          <div class="card-body">
                            </h5>
                            <div class="row">
                                <div class="col-4 text-center">
                                    <i class="bi bi-cloud-check-fill text-primary fs-7"></i>
                                    <span class="fs-11 mt-2 d-block text-nowrap">Records</span>
                                    <h4 class="mb-0 mt-1">{{ $link->visits }}</h4>
                                </div>
                                <div class="col-4 text-center">
                                    <i class="bi bi-arrow-up-right-circle-fill text-success fs-7"></i>
                                    <span class="fs-11 mt-2 d-block text-nowrap">Redirected</span>
                                    <h4 class="mb-0 mt-1">{{ $visithistory->where('status', 1)->count() }}</h4>
                                </div>
                                <div class="col-4 text-center">
                                    <i class="bi bi-exclamation-circle-fill text-danger fs-7"></i>
                                    <span class="fs-11 mt-2 d-block text-nowrap">Rejected</span>
                                    <h4 class="mb-0 mt-1">{{ $visithistory->where('status', 0)->count() }}</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table text-nowrap align-middle mb-0 text-center">
                                    <thead>
                                        <tr class="border-2 border-bottom border-primary border-0"> 
                                            <th scope="col" class="ps-0">Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        @forelse ($visithistory as $visit)
                                        <tr>
                                            <th scope="row" class="ps-0 fw-medium">
                                                <span class="table-link1 text-truncate d-block">{{ $visit->created_at }} </span>
                                            </th>
                                            <td>
                                                <span class="table-link1 text-truncate d-block">@if($visit->status) <span class="badge rounded-pill text-bg-success fs-1">Redirected</span> @else <span class="badge rounded-pill text-bg-danger fs-1">Rejected</span>  @endif  </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No record data.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                    
                                </table>
                                
                            </div>
                            {{ $visithistory->links() }}
                           
                          </div>
                        </div>
                      </div>
                   
                  
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <h5 class="card-title fw-semibold mb-4">Detail</h5>
                        <div class="card">
                            <div class="card-body">
                            <form>
                                <div class="mb-3">
                                <label for="target_url" class="form-label">Long URL</label>
                                <input type="text" class="form-control" id="target_url" value="{{ $link->target_url }}">
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Short URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon3">{{ url('r/') }}</span>
                                        <input type="text" class="form-control" id="slug" value="{{ $link->slug }}">
                                    </div>
                                </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                              <h4 class="mt-7">Link Management</h4>
                              <form action="">
                                
                                  <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Active</label>
                                  </div>
                                  <div class="form-check form-switch mt-4">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                    <label class="form-check-label" for="flexSwitchCheckChecked">Password Protection</label>
                                  </div>
                                  <div class="mt-4">
                                    <label for="target_url" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="target_url" >
                                  </div>
                                 
                              </form>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
          </div>
    </div>
    
        
        <script>
            $(function () {
                // -----------------------------------------------------------------------
                // Traffic Overview
                // -----------------------------------------------------------------------
                // var visitData = @json($link);
    
                var chart = {
                    series: [
                        {
                            name: "Visits",
                            data: [20, 50, 40, 60, 50, 45, 30],
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
                    // Set the color to blue
                    colors: ["#007bff"],  // Blue color for the line
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
                        // Remove dashed line
                        dashArray: [0],  // Solid line (no dashes)
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
                        categories: ["Sun","Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
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
                const toastElList = [].slice.call(document.querySelectorAll('.toast'));
                const toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl);
                });
                toastList.forEach(toast => toast.show());
            });
        </script>
</x-dashlayout>