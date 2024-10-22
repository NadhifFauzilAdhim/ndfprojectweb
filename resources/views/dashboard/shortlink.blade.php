<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container-fluid">
        
        <div class="card">
            <div class="card-body">
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

                <div class="row">
                    <div class="col-lg-12">
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
                    <div class="col-lg-12">
                        <div class="card-body">
                           
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
                                <i class="bi bi-link-45deg fs-5"></i>Create New
                            </button>
                            <div class="collapse mt-3" id="collapseForm">
                                <div class="card card-body">
                                    <form action="/dashboard/link" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="url_target" class="form-label">Url Destination</label>
                                            <input type="text" class="form-control @error('target_url') is-invalid @enderror shadow-sm" id="target_url" name="target_url" value="{{ old('target_url') }}">
                                            @error('target_url')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text" id="basic-addon3">{{ url('r/') }}</span>
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror shadow-sm" id="short_link" name="slug" value="{{ old('slug') }}" aria-describedby="basic-addon3 basic-addon4">
                                                @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @forelse ($links as $link)
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-header @if($link->active) linkactivecolor @else linkinactivecolor @endif" >
                                <h6 class="card-title">
                                    <input type="text" value="{{ url('r/' . $link->slug) }}" id="linkInput-{{ $link->slug }}" class="form-control text-dark shadow-sm bg-white" readonly>
                                </h6>
                            </div>
                            
                            <div class="card-body shadow-sm">
                                <h6 class="card-subtitle mb-2 ">Url Destination</h6>
                                <p class="card-text"><a href="{{ $link->target_url }}" target="_blank" class="text-dark link-success">{{ $link->target_url }}</a></p>
                                <div class="row mb-4 align-items-center text-center">
                                    <div class="col-6">
                                        <h6 class="card-subtitle mb-2 "><i class="bi bi-calendar-check me-1"></i>Created</h6>
                                        <p class="card-text">{{ $link->created_at }}</p>
                                    </div>
                                    <div class="col-6">
                                        <h6 class="card-subtitle mb-2 "><i class="bi bi-box-arrow-up-right me-1"></i>Visits</h6>
                                        <p class="card-text">{{ $link->visits }}</p>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-warning btn-sm dropdown-toggle rounded-pill" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                          Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                          <li>
                                            <a class="dropdown-item text-danger bg-transparent" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $link->slug }}">
                                            <i class="bi bi-trash-fill"></i> Delete
                                            </a>
                                          </li>
                                          <li>
                                            <a class="dropdown-item text-warning bg-transparent" href="#" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $link->slug }}" data-target-url="{{ $link->target_url }}"  data-active="{{ $link->active }}">
                                                <i class="bi bi-pencil-square"></i>  Edit
                                            </a>
                                          </li>
                                        </ul>
                                      </div>
                                    <button class="btn btn-sm btn-outline-secondary" onclick="copyFunction('{{ $link->slug }}')"><i class="bi bi-copy me-1"></i>Copy Link</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center">
                        <h4 class="home__title">Nampaknya Belum Ada Link &#129300;</h4>
                       
                    </div>
                    @endforelse
                </div>

                {{ $links->links() }}
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this link?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Link</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm" action="" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="editTargetUrl" class="form-label">Url Destination</label>
                                <input type="text" class="form-control" id="editTargetUrl" name="target_url">
                            </div>
                            <label for="editTargetUrl" class="form-label">Status</label>
                            <div class="form-check form-switch mb-5">
                                
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" name="active" value="1">
                                <label class="form-check-label" for="flexSwitchCheckChecked" id="switchLabel">Active</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Short Link Form -->
      
    </div>
    <script>
        $(function () {
            // -----------------------------------------------------------------------
            // Traffic Overview
            // -----------------------------------------------------------------------
            var visitData = @json($visitData);

            var chart = {
                series: [
                    {
                        name: "Visits",
                        data: visitData,
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
    <!-- Script to handle delete modal -->
    <script src="{{ asset('js/link.js') }}"></script>
</x-dashlayout>
