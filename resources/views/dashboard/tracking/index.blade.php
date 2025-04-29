<x-dashlayout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <div class="container-fluid">
      <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#addTrackingModal">
                    <span class="d-inline d-sm-none fs-3"><i class="bi bi-plus-circle-fill"></i></span> <!-- hanya tampil di mobile -->
                    <span class="d-none d-sm-inline">Add New Tracking Link</span> <!-- tampil mulai dari sm ke atas -->
                </button>
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
          
          <!-- Add Tracking Link Modal -->
          <div class="modal fade" id="addTrackingModal" tabindex="-1" aria-labelledby="addTrackingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('dashboard.tracking.store') }}" method="POST" class="modal-content">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTrackingModalLabel">Add New Tracking Link</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Link Title</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-pencil-fill"></i></span>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Enter link title" required value="{{ old('title') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="target_url" class="form-label">Target URL</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" name="target_url" class="form-control" id="target_url" placeholder="https://example.com" required value="{{ old('target_url') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Tracking Link</button>
                    </div>
                </form>
            </div>
        </div>
        
              <div class="row">
                  @forelse ($trackings as $tracking)
                  <div class="col-md-12 mb-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <!-- Header Section -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <img data-src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&url={{ urlencode($tracking->target_url) }}&size=32" 
                                             alt="Favicon" 
                                             class="lazyload rounded me-2"
                                             style="width: 32px; height: 32px;">
                                        <h4 class="mb-0 fw-bold">{{ $tracking->title ?? 'Untitled Link' }}</h4>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ $tracking->target_url }}" class="text-muted text-truncate d-block" target="_blank">
                                            {{ Str::limit($tracking->target_url, 50) }}
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 text-center mt-2">
                                    <span class="badge bg-success">{{ $tracking->visits }} Total Visits</span>
                                    <span class="badge bg-primary ">{{ $tracking->unique_visits }} Unique</span>
                                    <form action="{{ route('dashboard.tracking.destroy', $tracking) }}"
                                        method="POST"
                                        class="d-inline-block"
                                        onsubmit="return confirm('Yakin ingin dihapus?')">
                                    @csrf @method('DELETE')
                                    <button class="badge bg-danger border-0">
                                      <i class="bi bi-trash"></i>Delete
                                    </button>
                                  </form>
                                </div>
                            </div>
                
                            <!-- Map and Location Info -->
                            <div class="row">
                                <!-- Map Container -->
                                <div class="col-md-7 mb-4">
                                  @if($tracking->trackingHistories->first() && isset($tracking->trackingHistories->first()->location['lat']) && isset($tracking->trackingHistories->first()->location['lng']))
                                    <iframe
                                        src="https://maps.google.com/maps?q={{ $tracking->trackingHistories->first()->location['lat'] }},{{ $tracking->trackingHistories->first()->location['lng'] }}&z=15&output=embed"
                                        frameborder="0"
                                        style="border: 0; width: 100%; height: 100%"
                                        allowfullscreen
                                    ></iframe>
                                @else
                                <div class="text-center">
                                  <img src="{{ asset('img/location.png') }}"  width="75%" alt="location not found">
                                    <div class="alert alert-warning text-center">Location data is not yet available for this tracking.</div>
                                </div>
                                @endif
                              </div>
                                <!-- Location Details -->
                                <div class="col-md-5">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i>Location Details</h6>
                                            <ul class="list-group list-group-flush">
                                              <li class="list-group-item">
                                                <div class="row d-flex align-items-center mb-2">
                                                  <div class="col-10">
                                                      <h6 class="card-title text-truncate mb-0">
                                                          <input type="text" 
                                                                 class="form-control border-0 p-0 text-dark fw-bold" 
                                                                 value="{{ 'linksy.site/t/' . $tracking->slug }}" 
                                                                 readonly>
                                                      </h6>
                                                  </div>
                                                  <div class="col-2 text-start px-0">
                                                      <button class="btn {{ $tracking->active ? 'btn-outline-dark' : 'btn-outline-danger' }} btn-sm" 
                                                              onclick="copyFunction('{{ $tracking->slug }}')">
                                                          <i class="bi bi-clipboard"></i>
                                                      </button>
                                                  </div>
                                              </div>
                                              </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span>
                                                        <i class="bi bi-geo me-2"></i>
                                                        {{ $tracking->trackingHistories->first()->user_agent ?? 'Unknown ISP' }}
                                                    </span>
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-globe me-2"></i>
                                                    ISP: {{ $tracking->trackingHistories->first()->ip_address ?? 'Unknown ISP' }}
                                                </li>
                                                <li class="list-group-item">
                                                    <i class="bi bi-pin-map me-2"></i>
                                                    Coordinates: {{ $tracking->trackingHistories->first()->location['lat'] ?? 'N/A' }}, {{ $tracking->trackingHistories->first()->location['lng'] ?? 'N/A' }}
                                                </li>
                                                
                                                <li class="list-group-item">
                                                    <i class="bi bi-clock-history me-2"></i>
                                                    Last Visit: {{ $tracking->trackingHistories->first()->created_at ?? 'N/A' }}
                                                </li>
                                                <li class="mt-2">
                                                  <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2"></i>Recent Activity</h6>
                                                    <div class="activity-timeline">
                                                      @forelse($tracking->trackingHistories as $history)

                                                        <div class="d-flex align-items-center mb-2">
                                                            <div class="icon-marker bg-primary text-white rounded-circle me-2">
                                                                <i class="bi bi-pin-map"></i>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted">{{ $history->created_at->diffForHumans() }}</small>
                                                                <div class="text-truncate">
                                                                    Visited from ip {{ $history->ip_address }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        <p class="text-muted text-center">No recent activity found.</p>
                                                        @endforelse
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                  @empty
                  <div class="col-12 text-center py-5">
                      <h4 class="text-muted">No tracking data available</h4>
                      <p class="text-muted">Start creating links to see tracking information</p>
                  </div>
                  @endforelse
              </div>
          </div>
      </div>
  </div>

</x-dashlayout>