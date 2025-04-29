<div>
        <x-slot:title>Tracking Links</x-slot:title>
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <button class="btn btn-primary" wire:click="openAddModal">
                            Add New Tracking Link
                        </button>
                    </div>

                    <!-- Add Tracking Modal -->
                    <div wire:ignore.self class="modal fade" tabindex="-1" role="dialog" wire:model="showAddModal">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add New Tracking Link</h5>
                                    <button type="button" class="btn-close" wire:click="$set('showAddModal', false)"></button>
                                </div>
                                <form wire:submit.prevent="save">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Link Title</label>
                                            <input type="text" wire:model="title" class="form-control" required>
                                            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Target URL</label>
                                            <input type="url" wire:model="target_url" class="form-control" required>
                                            @error('target_url') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Custom Slug</label>
                                            <input type="text" wire:model="slug" class="form-control">
                                            <small class="text-muted">Leave blank to auto-generate</small>
                                            @error('slug') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" wire:click="$set('showAddModal', false)">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
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
                                                <span class="badge bg-primary">{{ $tracking->unique_visits }} Unique</span>
                                                <button class="badge bg-danger border-0" 
                                                        wire:click="delete({{ $tracking->id }})"
                                                        onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Map and Location Info -->
                                        <div class="row">
                                            <div class="col-md-7 mb-4">
                                                @if($tracking->trackingHistories->first()?->location)
                                                    <iframe
                                                        src="https://maps.google.com/maps?q={{ $tracking->trackingHistories->first()->location['lat'] }},{{ $tracking->trackingHistories->first()->location['lng'] }}&z=15&output=embed"
                                                        style="border: 0; width: 100%; height: 300px"
                                                        allowfullscreen>
                                                    </iframe>
                                                @else
                                                    <div class="text-center">
                                                        <img src="{{ asset('img/location.png') }}" width="75%" alt="location not found">
                                                        <div class="alert alert-warning mt-2">Location data not available</div>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div class="col-md-5">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body">
                                                        <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2"></i>Location Details</h6>
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">
                                                                <div class="row d-flex align-items-center mb-2">
                                                                    <div class="col-10">
                                                                        <input type="text" 
                                                                               class="form-control border-0 p-0 text-dark fw-bold" 
                                                                               value="{{ 'linksy.site/t/' . $tracking->slug }}" 
                                                                               readonly>
                                                                    </div>
                                                                    <div class="col-2 text-start px-0">
                                                                        <button class="btn btn-outline-dark btn-sm" 
                                                                                wire:click="copySlug('{{ $tracking->slug }}')">
                                                                            <i class="bi bi-clipboard"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <!-- ... (rest of the location details) ... -->
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
                            </div>
                        @endforelse
                    </div>

                    {{ $trackings->links() }}
                </div>
            </div>
        </div>

    @script
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('notify', (data) => {
                Swal.fire({
                    text: data.message,
                    icon: data.type,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });

            Livewire.on('copy-to-clipboard', (data) => {
                navigator.clipboard.writeText(data.text);
            });
        });
    </script>
    @endscript
</div>