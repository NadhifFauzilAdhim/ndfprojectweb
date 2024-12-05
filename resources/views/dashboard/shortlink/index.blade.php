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
                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        @if(session()->has('success'))
                            Swal.fire({
                                text: "{{ session('success') }}",
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        @elseif(session()->has('error'))
                            Swal.fire({
                                text: "{{ session('error') }}",
                                icon: 'error',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        @endif
                    });
                </script>

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
                            <!-- Button to toggle form -->
                            <button class="btn btn-primary d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm" aria-expanded="false" aria-controls="collapseForm">
                                <i class="bi bi-link-45deg fs-5 me-2"></i>Create New
                            </button>
                        
                            <!-- Collapsible form -->
                            <div class="collapse mt-4" id="collapseForm">
                                <div class="card card-body shadow-sm border-0">
                                    <form action="/dashboard/link" method="POST">
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
                                            <div class="input-group">
                                                <span class="input-group-text bg-light text-secondary" id="basic-addon3">{{ url('r/') }}</span>
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror shadow-sm" id="short_link" name="slug" placeholder="custom-slug" value="{{ old('slug') }}" aria-describedby="basic-addon3">
                                                @error('slug')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                        
                                        <!-- Submit Button -->
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
                    <!-- QR Code Modal -->
                    <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="qrCodeModalLabel">QR Code</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <div id="qrCodeContainer">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                          </div>
                                    </div>
                                    <button id="downloadQrCode" class="btn btn-primary mt-3">Download QR Code</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    @forelse ($links as $link)
                    <div class="col-md-4 " >
                        <div class="card shadow card-hover">
                          <div class="card-header" data-bs-theme="dark">
                            <h6 class="card-title d-flex align-items-center gap-2">
                                <div class="input-group ">
                                    <input type="text" class="form-control text-dark shadow-sm bg-white" aria-label="link" id="linkInput-{{ $link->slug }}" value="{{ url('r/' . $link->slug) }}">
                                    <button class="btn btn-sm btn-success {{ $link->active ? 'btn-success' : 'btn-danger' }}"  id="button-addon2" onclick="copyFunction('{{ $link->slug }}')"><i class="bi bi-copy me-1"></i></button>
                                </div>
                            </h6>
                          </div>
                          <div class="card-body">
                                <h6 class="card-subtitle mb-2 "> Url Destination</h6>
                                <p class="card-text"><a href="{{ $link->target_url }}" target="_blank" class="text-dark link-success">{{ Str::limit(strip_tags($link->target_url), 80) }}</a></p>
                                <div class="row mb-4">
                                    <div class="col-12 mb-1">
                                        <p class="card-text d-flex align-items-center">
                                            <iconify-icon icon="solar:archive-down-minimlistic-line-duotone" class="fs-6 me-2 "></iconify-icon>
                                            Created {{ $link->created_at }}
                                        </p>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <p class="card-text d-flex align-items-center">
                                            <iconify-icon icon="solar:chart-square-linear" class="fs-6 me-2"></iconify-icon>
                                            <b class="me-1">{{ $link->visits }}</b>Visits  <b class="mx-1">{{ $link->unique_visits }}</b> Unique
                                        </p>
                                    </div>
                                    <div class="col-12">
                                            <p class="card-text d-flex align-items-center">
                                                @if($link->password_protected)<iconify-icon icon="solar:lock-keyhole-minimalistic-linear" class="fs-6 me-2"></iconify-icon>@else<iconify-icon icon="solar:lock-unlocked-broken" class="fs-6 me-2"></iconify-icon>@endif
                                                <b class="me-1"> {{ $link->password_protected ? 'Protected' : 'Unprotected' }}</b>
                                            </p>
                                    </div>
                            
                                </div>
                                <div class="d-flex justify-content-between">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-warning btn-sm dropdown-toggle rounded-pill" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                          Actions
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <a class="dropdown-item text-primary bg-transparent" href="/dashboard/link/{{ $link->slug }}">
                                                    <i class="bi bi-card-checklist"></i> <strong>Detail</strong> 
                                                </a>
                                            </li>
                                            <li>
                                                <button class="dropdown-item text-primary bg-transparent"   data-bs-toggle="modal" data-bs-target="#qrCodeModal" onclick="showQRCode('{{ url('r/' . $link->slug) }}')">
                                                    <i class="bi bi-qr-code me-1"></i> Generate QR 
                                                </button>
                                            </li>
                                          <li>
                                            <a class="dropdown-item text-primary bg-transparent" href="#" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $link->slug }}" data-target-url="{{ $link->target_url }}"  data-active="{{ $link->active }}">
                                                <i class="bi bi-pencil-square"></i> Quick Action
                                            </a>
                                         </li>
                                          <li>
                                            <a class="dropdown-item text-danger bg-transparent" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $link->slug }}">
                                            <i class="bi bi-trash-fill"></i> Delete
                                            </a>
                                          </li>
                                        </ul>
                                      </div>
                                   
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
                                <input type="hidden" name="quickedit" value="1">
                                <label class="form-check-label" for="flexSwitchCheckChecked" id="switchLabel">Active</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <script>
        const visitDataGlobal = @json($visitData);
    </script>
    <script src="{{ asset('js/link.js') }}"></script>
</x-dashlayout>
