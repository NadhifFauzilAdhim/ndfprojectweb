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
                        <div class="alert alert-primary d-flex align-items-center justify-content-center gap-2" role="alert">
                            <iconify-icon icon="solar:check-circle-bold" class="fs-4"></iconify-icon>
                            <span>Open API is ready! <a href="{{ route('ipdocuments') }}" class="fw-bold text-decoration-none">Click here to check it out.</a></span>
                        </div>
                    </div>
                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="card w-100">
                            <div class="card-body shadow-sm">
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
                        <div class="card w-100">
                          <div class="card-body shadow-sm">
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
              
                             <div class="vstack gap-4 ">
                                <div class="vstack gap-4 mt-7 pt-2">
                                    @forelse ($topLinks as $link) 
                                        <div class="mt-1">
                                            <div class="hstack justify-content-between">
                                                <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($link->target_url) }}&size=16" 
                                             alt="Favicon" 
                                             class="rounded me-2" 
                                             style="width: 16px; height: 16px; flex-shrink: 0;">
                                                <span class="fs-3 fw-medium">
                                                    <a href="{{ url('dashboard/link/').'/'.$link->slug }}">{{ $link->slug }}</a>
                                                </span>
                                                <h6 class="fs-3 fw-medium text-dark lh-base mb-0  " style="width: 12px">
                                                    <div class="d-flex justify-content-between">
                                                        <small>{{ $link->visits }}</small>
                                                        <small class="text-success">
                                                            +{{ $link->visits_last_7_days ? $link->visits_last_7_days : '-' }}
                                                        </small>
                                                    </div>
                                                </h6>
                                            </div>
                                        </div>  
                                    @empty
                                        <h6 class="fs-3 fw-medium text-dark lh-base mb-0 text-center">
                                            No Data
                                        </h6>
                                    @endforelse
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <div class="col-lg-12">
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-12 col-md-4">
                                    <button 
                                        class="btn btn-primary  align-items-center w-100 py-2 position-relative" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#collapseForm" 
                                        aria-expanded="false" 
                                        aria-controls="collapseForm" 
                                        style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);"
                                    >
                                        <i class="bi bi-plus-circle fs-4 me-2"></i>
                                        <span>Create New Link</span>
                                    </button>
                                </div>
                                <div class="col-12 col-md-4">
                                    <button 
                                        class="btn btn-primary  align-items-center w-100 py-2 position-relative" 
                                        type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#qrCollapseForm" 
                                        aria-expanded="false" 
                                        aria-controls="qrCollapseForm" 
                                        style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);"
                                    >
                                        <i class="bi bi-plus-circle fs-4 me-2"></i>
                                        <span>Generate QR</span>
                                    </button>
                                </div>
                                <!-- Form Search -->
                                <div class="col-12 col-md-4">
                                    <form action="/dashboard/link" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search Link" aria-label="Search" aria-describedby="button-addon2" value="{{ request('search') }}">
                                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        
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
                                                <span class="input-group-text bg-light " id="basic-addon3">{{ url('r/') }}</span>
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
                </div>

                <div class="row">
                    <div class="container">
                        <div class="row nav nav-tabs justify-content-center d-flex flex-wrap" id="linkTabs" role="tablist">
                            <div class="col-4 p-1">
                                <button class="nav-link active btn btn-sm w-100" id="your-links-tab" data-bs-toggle="tab" data-bs-target="#your-links" type="button" role="tab">
                                    <i class="bi bi-link"></i>
                                    <span class="d-none d-sm-inline"> Your Links</span>
                                </button>
                            </div>
                            <div class="col-4 p-1">
                                <button class="nav-link btn btn-sm w-100" id="shared-links-tab" data-bs-toggle="tab" data-bs-target="#shared-links" type="button" role="tab">
                                    <i class="bi bi-share"></i>
                                    <span class="d-none d-sm-inline"> Shared Links</span>
                                </button>
                            </div>
                            <div class="col-4 p-1">
                                <button class="nav-link btn btn-sm w-100" id="links-you-shared-tab" data-bs-toggle="tab" data-bs-target="#links-you-shared" type="button" role="tab">
                                    <i class="bi bi-send"></i>
                                    <span class="d-none d-sm-inline"> Links You Shared</span>
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
                                <div class="card shadow border-0 w-100 card-hover">
                                    <div class="card-body">
                                        <div class="row d-flex align-items-center mb-3">
                                            <div class="col-12 d-flex align-items-center">
                                                <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($link->target_url) }}&size=32" 
                                                     alt="Favicon" 
                                                     class="rounded me-2" 
                                                     style="width: 32px; height: 32px; flex-shrink: 0;">
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
                                                           value="{{ request()->getHost() . '/r/' . $link->slug }}" 
                                                           readonly>
                                                </h6>
                                            </div>
                                            <div class="col-2">
                                                <button class="btn {{ $link->active ? 'btn-outline-primary' : 'btn-outline-danger' }} btn-sm" 
                                                        onclick="copyFunction('{{ $link->slug }}')">
                                                    <i class="bi bi-clipboard"></i>
                                                </button>
                                            </div>
                                        </div>
                            
                                        <!-- Destination URL -->
                                        <p class="text-muted small mb-2">Destination:</p>
                                        <a href="{{ $link->target_url }}" target="_blank" class="d-block text-truncate link-dark">
                                            {{ Str::limit(strip_tags($link->target_url), 80) }}
                                        </a>
                            
                                        <!-- Statistics -->
                                        <div class="d-flex justify-content-between mt-3">
                                            <div class="text-muted small">
                                                <i class="bi bi-calendar me-1"></i> {{ $link->created_at->format('d M Y') }}
                                            </div>
                                            <div class="text-muted small">
                                                <i class="bi bi-graph-up-arrow me-1"></i> <b>{{ $link->visits }}</b> visits
                                            </div>
                                            <div class="text-muted small">
                                                <i class="bi bi-person-check"></i> <b>{{ $link->unique_visits }}</b> unique
                                            </div>
                                        </div>
                            
                                        <!-- Security Status -->
                                        <div class="d-flex align-items-center mt-3 justify-content-between">
                                            @if($link->password_protected)
                                            <i class="bi bi-lock-fill text-danger me-2">  
                                                <span class="text-danger small">Protected</span>
                                            </i>
                                            @else
                                            <i class="bi bi-unlock text-success me-2"> 
                                                <span class="text-success small">Unprotected</span>
                                            </i>
                                            @endif
                                            <div class="badge rounded-pill"  
                                                style="background-color: {{ $link->active ? '#2f80ed' : '#ff7eb3' }}; color: white;" 
                                                data-bs-toggle="popover" 
                                                data-bs-trigger="hover focus"
                                                data-bs-title="{{ $link->active ? 'Public Link' : 'Private Link' }}" 
                                                data-bs-content="{{ $link->active ? 'This link is publicly accessible.' : 'This link is private and only accessible to you.' }}">
                                                <small>{{ $link->active ? 'Public' : 'Private' }}</small>
                                            </div>
                                        </div>
                            
                                        <div class="d-flex justify-content-end mt-3 position-relative dropup">
                                            <button class="btn btn-outline-secondary btn-sm rounded-pill" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                                <li>
                                                    <a class="dropdown-item text-primary" href="/dashboard/link/{{ $link->slug }}">
                                                        <i class="bi bi-info-circle me-2"></i> Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#qrCodeModal" 
                                                            onclick="showQRCode('https://linksy.site/{{ $link->slug }}')">
                                                        <i class="bi bi-qr-code me-2"></i> Generate QR
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-primary" 
                                                       href="#" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#editModal" 
                                                       data-id="{{ $link->slug }}" 
                                                       data-target-url="{{ $link->target_url }}" 
                                                       data-active="{{ $link->active }}">
                                                        <i class="bi bi-pencil me-2"></i> Quick Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item text-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#shareLinkModal" 
                                                            onclick="prepareShareModal('{{ $link->slug }}')">
                                                        <i class="bi bi-share me-2"></i> Share Link
                                                    </button>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" 
                                                       href="#" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#deleteModal" 
                                                       data-id="{{ $link->slug }}">
                                                        <i class="bi bi-trash me-2"></i> Delete
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
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($link->target_url) }}&size=32" alt="Favicon" class="rounded me-2" style="width: 32px; height: 32px;">
                                                <span class="fw-bold fs-5">{{ $link->title ?? 'Shared Link' }}</span>
                                            </div>
                
                                            <p class="text-muted small mb-2">Shared by: <b>{{ $link->user->name }}</b></p>
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
                            <div class="row">
                                @forelse ($mySharedLinks as $sharedLink)
                                <div class="col-md-4 d-flex align-items-stretch">
                                    <div class="card shadow border-0 w-100">
                                        <div class="card-body d-flex flex-column">
                                            <!-- Favicon and Link Title -->
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($sharedLink->link->target_url) }}&size=32" 
                                                    alt="Favicon" class="rounded me-2" style="width: 32px; height: 32px;">
                                                <span class="fw-bold fs-5 text-truncate" style="max-width: 200px;">{{ $sharedLink->link->title ?? 'Shared Link' }}</span>
                                            </div>
                            
                                            <!-- Shared with User -->
                                            <p class="text-muted small mb-2">
                                                Shared with: <b>{{ $sharedLink->sharedWith->name }}</b>
                                            </p>
                            
                                            <!-- Link URL -->
                                            <a href="{{ $sharedLink->link->target_url }}" target="_blank" class="d-block text-truncate link-dark">
                                                {{ Str::limit(strip_tags($sharedLink->link->target_url), 80) }}
                                            </a>
                            
                                            <!-- Delete Button -->
                                            <div class="mt-auto d-flex justify-content-end mt-1">
                                                <form action="{{ route('links.share.delete', $sharedLink->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm "><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center w-100"><p>No links shared by you.</p></div>
                                @endforelse
                                {{ $mySharedLinks->links() }}
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
                
            </div>
        </div>

                <!-- Modal for Sharing Link -->
        <div class="modal fade" id="shareLinkModal" tabindex="-1" aria-labelledby="shareLinkModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="shareLinkModalLabel">Share Link</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="shareLinkForm">
                            <div class="mb-3">
                                <label for="sharedWith" class="form-label">Share with User</label>
                                <input type="text" class="form-control" id="sharedWith" name="shared_with" placeholder="Enter username" required>
                            </div>
                            <input type="hidden" id="linkId" name="link_id">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="shareLink()">Share</button>
                    </div>
                </div>
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
                        <p>Are you sure you want to delete this link?</p>
                        <p>Type <strong>DELETE</strong> below to confirm:</p>
                        <input
                            type="text"
                            id="deleteConfirmationInput"
                            class="form-control"
                            placeholder="Type DELETE to confirm"
                        />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" id="deleteButton" disabled>Delete</button>
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
    <!-- Tambahkan ini di bagian <head> jika belum ada -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</x-dashlayout>
