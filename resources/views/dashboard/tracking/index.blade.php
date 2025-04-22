<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
     <div class="container-fluid">
        <div class="card s">
          <div class="card-body">
            <div class="row">
              @forelse ($trackings as $tracking) 
              <div class="col-md-4">
                <div class="card border-0 shadow mb-4">
                  <div class="card-body">
                    <div class="row d-flex align-items-center mb-2">
                        <div class="col-12 d-flex align-items-center">
                            <img data-src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($tracking->target_url) }}&size=32" 
                                 alt="Favicon" 
                                 class="rounded me-2 lazyload" 
                                 style="width: 25px; height: 25px; flex-shrink: 0;">
                                 <input type="text" 
                                 class="form-control border-0 p-0 text-dark fw-bold fs-5" 
                                 value="{{ $tracking->title  }}" 
                                @if ($tracking->title)
                                 placeholder="Type Here To Change Title"
                                @endif
                                 data-link-slug="{{ $tracking->slug }}" 
                                 data-previous-title="{{ $tracking->title }}">

                        </div>
                    </div>
                    <!-- Shortened Link -->
                    <div class="row d-flex align-items-center mb-2">
                        <div class="col-10">
                            <h6 class="card-title text-truncate mb-0">
                                <input type="text" 
                                       class="form-control border-0 p-0 text-dark fw-bold" 
                                       id="linkInput-{{ $tracking->slug }}" 
                                       value="{{ 'linksy.site/' . $tracking->slug }}" 
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
                    <p class=""> <a href="{{ $tracking->target_url }}" target="_blank" class="d-block text-truncate link-dark">
                        {{ Str::limit(strip_tags($tracking->target_url), 80) }}
                    </a></p>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="text-muted small">
                            <i class="bi bi-calendar me-1"></i> {{ $tracking->created_at->format('d M Y') }}
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-graph-up-arrow me-1"></i> <b>{{ $tracking->visits }}</b> visits
                        </div>
                        <div class="text-muted small">
                            <i class="bi bi-person-check"></i> <b>{{ $tracking->unique_visits }}</b> unique
                        </div>
                    </div>
                
                  </div>
                </div>
              </div>
              @empty
                <h4>No Data</h4>
              @endforelse
            </div>
          </div>
        </div>
        <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Design and Developed by <a href="https://adminmart.com/" target="_blank"
              class="pe-1 text-primary text-decoration-underline">AdminMart.com</a> Distributed by <a href="https://themewagon.com/" target="_blank"
              class="pe-1 text-primary text-decoration-underline">ThemeWagon</a></p>
        </div>
      </div>
    
</x-dashlayout>
