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
                <div class="row">
                    {{-- Temporary Component --}}
                    
                    <style>.hide-scrollbar{scrollbar-width:none;-ms-overflow-style:none}.hide-scrollbar::-webkit-scrollbar{display:none}</style>
                    <div class="col-lg-7 d-flex align-items-stretch mb-4">
                        <div class="card w-100 rounded-4 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title fw-semibold mb-0">Traffic Overview</h5>
                                    <div class="d-flex align-items-center gap-2">
                                        <select id="chartTypeSelector" class="form-select form-select-sm" style="width: auto;">
                                            <option value="area" selected>Area</option>
                                            <option value="bar">Bar</option>
                                            <option value="line">Line</option>
                                            <option value="radar">Radar</option>
                                        </select>
                                        <iconify-icon icon="solar:question-circle-bold-duotone" class="fs-5 text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="Monthly traffic data"></iconify-icon>
                                    </div>
                                </div>
                                {{-- Container untuk library chart (misal: ApexCharts) --}}
                                <div id="traffic-overview" style="min-height: 320px;"></div>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-5 d-flex align-items-stretch mb-4"> 
                        <div class="card w-100 rounded-4 shadow-sm">
                            <div class="card-body">
                                <div class="row g-3 mb-4">
                                    <div class="col-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <span class="bg-primary-subtle text-primary p-2 rounded-3 d-flex">
                                                    <iconify-icon icon="solar:link-bold-duotone" width="24" height="24"></iconify-icon>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h4 class="mb-0 fw-bolder">{{ $totalLinks }}</h4>
                                                <small class="text-muted text-nowrap">Links</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <span class="bg-info-subtle text-info p-2 rounded-3 d-flex">
                                                    <iconify-icon icon="solar:cursor-line-duotone" width="24" height="24"></iconify-icon>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h4 class="mb-0 fw-bolder">{{ $totalVisit }}</h4>
                                                <small class="text-muted text-nowrap">Visit</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-2">
                                                <span class="bg-success-subtle text-success p-2 rounded-3 d-flex">
                                                    <iconify-icon icon="solar:shield-user-bold-duotone" width="24" height="24"></iconify-icon>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h4 class="mb-0 fw-bolder">{{ $totalUniqueVisit }}</h4>
                                                <small class="text-muted text-nowrap">Unique</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion accordion-flush" id="performanceAccordion">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headerPerformance">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePerformance" aria-expanded="true" aria-controls="collapsePerformance">
                                                <h5 class="mb-0 fw-semibold">Link Performance</h5>
                                            </button>
                                        </h2>
                                        
                                        <div id="collapsePerformance" class="accordion-collapse collapse show" aria-labelledby="headerPerformance" data-bs-parent="#performanceAccordion">
                                            <div class="accordion-body">
                                                <h6 class="fw-semibold text-muted mb-3">Top Performing Links</h6>
                                                <div class="flex-grow-1 hide-scrollbar" style="max-height: 150px; overflow-y: auto;">
                                                    <div class="vstack gap-3">
                                                        @forelse ($topLinks as $link)
                                                            <a href="{{ url('dashboard/link/').'/'.$link->slug }}" class="text-decoration-none">
                                                                <div class="d-flex align-items-center">
                                                                    {{-- Konten Top Link seperti sebelumnya --}}
                                                                    <div class="flex-shrink-0 me-3">
                                                                        <img src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($link->target_url) }}&size=32" alt="Favicon" class="rounded-2" width="32" height="32">
                                                                    </div>
                                                                    <div class="flex-grow-1 text-truncate">
                                                                        <p class="mb-0 fw-medium text-dark text-truncate">{{ $link->title }}</p>
                                                                        <small class="text-muted text-truncate d-block">{{ parse_url($link->target_url, PHP_URL_HOST) }}</small>
                                                                    </div>
                                                                    <div class="flex-shrink-0 ms-3 text-end">
                                                                        <p class="mb-0 fw-bold text-dark">{{ $link->visits }} <span class="fw-normal text-muted">visits</span></p>
                                                                        <small class="text-success fw-medium">+{{ $link->visits_last_7_days ?: '0' }} last 7d</small>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @empty
                                                            <div class="text-center p-4 rounded-3 bg-light">
                                                                <iconify-icon icon="solar:chart-line-duotone" class="fs-1 text-muted mb-2"></iconify-icon>
                                                                <p class="text-muted mb-0">No link data to show.</p>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headerHistory">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHistory" aria-expanded="false" aria-controls="collapseHistory">
                                                <h5 class="mb-0 fw-semibold">Last Visits History</h5>
                                            </button>
                                        </h2>
                                        <div id="collapseHistory" class="accordion-collapse collapse" aria-labelledby="headerHistory" data-bs-parent="#performanceAccordion">
                                            <div class="accordion-body">
                                                <div class="pe-3 hide-scrollbar" style="max-height: 250px; overflow-y: auto;">
                                                    @forelse ($lastvisitData as $visit)
                                                        <a href="/dashboard/link/{{ $visit->link->slug }}" title="Lihat Detail: {{ $visit->link->title }}" class="text-decoration-none">
                                                            <div class="d-flex align-items-center py-2 border-bottom border-200">
                                                               {{-- Konten Last Visit seperti sebelumnya --}}
                                                               <div class="flex-shrink-0 me-3">
                                                                   <img data-src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($visit->link->target_url) }}&size=32" alt="Favicon" class="rounded me-2 lazyload" style="width: 25px; height: 25px; flex-shrink: 0;">
                                                               </div>
                                                               <div class="flex-grow-1">
                                                                   <h6 class="mb-0 text-dark text-truncate" style="max-width: 180px;">{{ $visit->link->title }}</h6>
                                                                   <small class="text-muted">{{ $visit->created_at->diffForHumans() }}</small>
                                                               </div>
                                                               <div class="flex-shrink-0 ms-2">
                                                                   <iconify-icon icon="solar:alt-arrow-right-line-duotone" width="20" height="20" class="text-muted"></iconify-icon>
                                                               </div>
                                                            </div>
                                                        </a>
                                                    @empty
                                                        <div class="d-flex flex-column align-items-center justify-content-center text-center text-muted" style="min-height: 200px;">
                                                            <iconify-icon icon="solar:file-text-line-duotone" width="50" height="50"></iconify-icon>
                                                            <p class="mt-3 mb-0">Tidak ada riwayat kunjungan.</p>
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                    </div>
                
                     
                    <div class="col-lg-12 mb-4">
                        <div class="row g-2 align-items-center">
                            <!-- Create New -->
                                <div class="shadow-sm rounded-5">
                                    <div class="card-body">
                                        <div class="row g-2 align-items-center">
                                            
                                        <div class="col-6 col-sm-4 col-md-2">
                                            <button 
                                                class="btn btn-primary w-100 py-2 d-flex flex-column flex-md-row align-items-center justify-content-center gap-1 shadow-sm"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#collapseForm"
                                                aria-expanded="false"
                                                aria-controls="collapseForm"
                                                style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px;">
                                                <iconify-icon icon="solar:clipboard-add-bold-duotone" class="fs-5"></iconify-icon>
                                                <span class="d-inline d-md-none small">Create</span>
                                                <span class="d-none d-md-inline">Create New</span>
                                            </button>
                                        </div>
                                        
                                        <div class="col-6 col-sm-4 col-md-2">
                                            <a 
                                                class="btn btn-primary w-100 py-2 d-flex flex-column flex-md-row align-items-center justify-content-center gap-1 shadow-sm"
                                                href="/dashboard/tracking"
                                                style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px;">
                                                <iconify-icon icon="solar:map-point-hospital-bold-duotone" class="fs-5"></iconify-icon>
                                                <span class="d-inline d-md-none small">Track</span>
                                                <span class="d-none d-md-inline">Tracker</span>
                                            </a>
                                        </div>
                                        
                                        <div class="col-6 col-sm-4 col-md-2">
                                            <button 
                                                class="btn btn-primary w-100 py-2 d-flex flex-column flex-md-row align-items-center justify-content-center gap-1 shadow-sm"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#qrCollapseForm"
                                                aria-expanded="false"
                                                aria-controls="qrCollapseForm"
                                                style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px;">
                                                <iconify-icon icon="solar:qr-code-bold-duotone" class="fs-5"></iconify-icon>
                                                <span class="d-inline d-md-none small">QR</span>
                                                <span class="d-none d-md-inline">Generate QR</span>
                                            </button>
                                        </div>
                                        
                                        <div class="col-6 col-sm-4 col-md-2">
                                            <button 
                                                class="btn btn-primary w-100 py-2 d-flex flex-column flex-md-row align-items-center justify-content-center gap-1 shadow-sm"
                                                type="button"
                                                id="scanQRBtn2"
                                                style="background: linear-gradient(135deg, #007bff, #0056b3); border: none; border-radius: 10px;">
                                                <iconify-icon icon="solar:scanner-bold-duotone" class="fs-5"></iconify-icon>
                                                <span class="d-inline d-md-none small">Scan</span>
                                                <span class="d-none d-md-inline">Scan QR</span>
                                            </button>
                                        </div>
                                        
                                        <div class="col-12 col-sm-8 col-md-4 mt-2">
                                            <form action="/dashboard/link" method="GET">
                                                <div class="input-group">
                                                    <input type="text" name="search" class="form-control" placeholder="Cari link..." aria-label="Search" value="{{ request('search') }}">
                                                    <button class="btn btn-outline-secondary" type="submit">
                                                        <i class="bi bi-search"></i> </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                        <!-- Collapsible form -->
                        <div class="collapse mt-4" id="collapseForm">
                            <div class="card card-body shadow-sm border-0">
                                <form id="linkform" action="/dashboard/link" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="url_target" class="form-label fw-bold">URL Destination</label>
                                        <input type="text" class="form-control @error('target_url') is-invalid @enderror shadow-sm" id="target_url" name="target_url" placeholder="https://example.com" value="{{ old('target_url') }}" required>
                                        @error('target_url')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                            
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <label for="short_link" class="form-label fw-bold">Shortened Link</label>
                                            <div class="input-group shadow-sm">
                                                <span class="input-group-text bg-light" id="basic-addon3">linksy.site/</span>
                                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="short_link" name="slug" placeholder="custom-slug" value="{{ old('slug') }}" aria-describedby="basic-addon3" required>
                                            </div>
                                            @error('slug')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-lg-3 col-md-6 mb-4">
                                            <label for="visibility_select" class="form-label fw-bold">Visibility</label>
                                            <select class="form-select shadow-sm @error('active') is-invalid @enderror" id="visibility_select" name="active" aria-label="Visibility select">
                                                <option value="1" {{ old('active', '1') == '1' ? 'selected' : '' }}>Visible to Everyone</option>
                                                <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Private (Only You)</option>
                                            </select>
                                            @error('active')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                            
                                        <div class="col-lg-3 col-md-6 mb-4">
                                            <label for="link_category_id_select" class="form-label fw-bold">Category <span class="fw-normal">(Optional)</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-folder"></i></span>
                                                <select class="form-select @error('link_category_id') is-invalid @enderror" id="link_category_id_select" name="link_category_id">
                                                    <option value="">-- No Category --</option>
                                                    @foreach($linkCategories as $category)
                                                    <option value="{{ $category->id }}" {{ old('link_category_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#addCategoryModal" title="Add New Category">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>
                                            </div>
                                            @error('link_category_id')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                            
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary px-4" id="linkSubmitBtn">
                                            <span id="linkBtnSpinner" class="spinner-border spinner-border-sm me-2 d-none" role="status" aria-hidden="true"></span>
                                            <span id="linkBtnText"><i class="bi bi-check-circle me-2"></i>Create</span>
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
                <div class="row">
                    <div class="container">
                        <div class="row nav nav-tabs justify-content-center d-flex flex-wrap" id="linkTabs" role="tablist">
                            <div class="col-4 p-1">
                                <button class="nav-link active btn btn-sm w-100" id="your-links-tab" data-bs-toggle="tab" data-bs-target="#your-links" type="button" role="tab">
                                    <iconify-icon icon="solar:link-bold-duotone" class="fs-5" style="position: relative; top: 3px;"></iconify-icon> 
                                    <span class="d-none d-sm-inline"> Your Links</span>
                                </button>
                            </div>
                            <div class="col-4 p-1">
                                <button class="nav-link btn btn-sm w-100" id="shared-links-tab" data-bs-toggle="tab" data-bs-target="#shared-links" type="button" role="tab">
                                    <iconify-icon icon="solar:round-arrow-down-line-duotone" class="fs-5" style="position: relative; top: 3px;"></iconify-icon> 
                                    <span class="d-none d-sm-inline"> Shared to You</span>
                                </button>
                            </div>
                            <div class="col-4 p-1">
                                <button class="nav-link btn btn-sm w-100" id="links-you-shared-tab" data-bs-toggle="tab" data-bs-target="#links-you-shared" type="button" role="tab">
                                    <iconify-icon icon="solar:square-share-line-line-duotone" class="fs-5" style="position: relative; top: 3px;"></iconify-icon> 
                                    <span class="d-none d-sm-inline"> Shared by You</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-4 tab-content" id="linkTabsContent">
                        <!-- Your Links -->
                        <div class="tab-pane fade show active" id="your-links" role="tabpanel" aria-labelledby="your-links-tab">
    
                            <div class="category-filter-container bg-light-subtle p-2 rounded-4 mb-4">
                                <div class="d-flex overflow-x-auto hide-scrollbar">
                                    <ul class="nav nav-pills flex-nowrap gap-2">
                            
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center gap-2 py-2 px-3 rounded-pill text-nowrap {{ !request('category') ? 'active' : '' }}" 
                                               href="{{ route('link.index') }}#linkTabsContent">
                                                <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                                                All
                                            </a>
                                        </li>
                            
                                        @foreach ($linkCategories as $category)
                                        <li class="d-flex align-items-center border rounded-pill border-0 px-2 py-2 category-item {{ $category->shared ? 'bg-primary-subtle' : '' }} {{ request('category') == $category->slug ? 'bg-primary-subtle' : '' }}">
                                                <a href="{{ route('link.index', ['category' => $category->slug, 'search' => request('search')]) }}#linkTabsContent"
                                                    class="nav-link d-flex align-items-center gap-2 py-2 px-3 rounded-pill text-nowrap  {{ request('category') == $category->slug ? 'active' : '' }}">
                                                    <iconify-icon icon="solar:folder-line-duotone"></iconify-icon>
                                                    {{ $category->name }}
                                                </a>
                                            
                                                @if(request('category') == $category->slug)
                                                <div class="d-flex align-items-center gap-2 ms-2">
                                                    <button type="button"
                                                            class="btn btn-info d-flex align-items-center border rounded-pill border-0 px-3 py-2 toggle-share-btn"
                                                            data-category-id="{{ $category->slug }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="{{ $category->shared ? 'Shared category. Click to make private.' : 'Private category. Click to share.' }}">
                                                        {{ $category->shared ? 'Shared' : 'Private' }}
                                                    </button>
                                                    
                                                    <form method="POST" action="{{ route('linkCategory.destroy', $category) }}" class="delete-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        
                                                        <button type="submit" 
                                                                class="btn btn-danger d-flex align-items-center p-2" 
                                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus Kategori">
                                                            <iconify-icon icon="solar:trash-bin-trash-line-duotone"></iconify-icon>
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    
                            
                                        <li class="nav-item">
                                            <a class="nav-link d-flex align-items-center gap-2 py-2 px-3 rounded-pill text-nowrap {{ request('category') == 'uncategorized' ? 'active' : '' }}" 
                                               href="{{ route('link.index', ['category' => 'uncategorized', 'search' => request('search')]) }}#linkTabsContent">
                                                 <iconify-icon icon="solar:file-remove-line-duotone"></iconify-icon>
                                                No Category
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <button type="button"
                                                    class="nav-link d-flex align-items-center gap-2 py-2 px-3 rounded-pill text-nowrap btn "
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addCategoryModal"
                                                    title="Tambah Kategori Baru">
                                                <i class="bi bi-plus-lg"></i> Add Category
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            
                           
                            
                            <div class="row">
                                @forelse ($links as $link)
                                <div class="col-md-4 d-flex align-items-stretch">
                                    <div class="card {{ ($link->scheduled && $link->active) ? 'scheduled-active' : '' }} shadow border-0 w-100 card-hover rounded-5 ">
                                        <div class="card-body">
                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-12 d-flex align-items-center">
                                                    <img data-src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($link->target_url) }}&size=32"
                                                         alt="Favicon"
                                                         class="rounded me-2 lazyload"
                                                         style="width: 25px; height: 25px; flex-shrink: 0;">
                                                    <input type="text"
                                                           class="form-control border-0 p-0 text-dark fw-bold fs-5 bg-transparent"
                                                           value="{{ $link->title ?? '' }}"
                                                           placeholder="Type Here To Change Title"
                                                           data-link-slug="{{ $link->slug }}"
                                                           data-previous-title="{{ $link->title }}">
                                                </div>
                                            </div>
                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-10">
                                                    <h6 class="card-title text-truncate mb-0">
                                                        <input type="text"
                                                               class="form-control border-0 p-0 text-dark fw-bold bg-transparent"
                                                               id="linkInput-{{ $link->slug }}"
                                                               value="{{ 'linksy.site/' . $link->slug }}"
                                                               readonly>
                                                    </h6>
                                                </div>
                                                <div class="col-2 text-start px-0">
                                                    <button class="btn btn-outline-dark btn-sm"
                                                            onclick="copyFunction('{{ $link->slug }}')">
                                                        <iconify-icon icon="solar:copy-line-duotone"></iconify-icon>
                                                    </button>
                                                </div>
                                            </div>
                                            <p class="text-muted small mb-1">Destination:</p>
                                            <a href="{{ $link->target_url }}" target="_blank" class="d-block text-truncate link-dark text-decoration-none"
                                               style="transition: color 0.2s;"
                                               onmouseover="this.classList.replace('link-dark', 'text-primary')"
                                               onmouseout="this.classList.replace('text-primary', 'link-dark')">
                                                {{ Str::limit(strip_tags($link->target_url), 80) }}
                                            </a>
                        
                                            <div class="mt-3 mb-2">
                                                <span class="badge bg-primary-subtle text-primary-emphasis rounded-pill fw-medium py-1 px-3 small" style="font-size: 0.75rem;">
                                                    <iconify-icon icon="solar:folder-with-files-line-duotone" class="me-1" style="position: relative; top: 2px; font-size: 0.8rem;"></iconify-icon>
                                                    <small>{{ $link->linkCategory->name ?? 'No Category' }}</small>
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between mt-2">
                                                <div class="text-muted small">
                                                    <iconify-icon icon="solar:calendar-bold" class="me-1" style="position: relative; top: 3px;"></iconify-icon> {{ $link->created_at->format('d M Y') }}
                                                </div>
                                                <div class="text-muted small">
                                                    <iconify-icon icon="solar:graph-up-bold" class="me-1" style="position: relative; top: 3px;"></iconify-icon> <b>{{ $link->visits }}</b> visits
                                                </div>
                                                <div class="text-muted small">
                                                    <iconify-icon icon="solar:user-check-bold" class="me-1" style="position: relative; top: 3px;"></iconify-icon> <b>{{ $link->unique_visits }}</b> unique
                                                </div>
                                            </div>
                                            
                                            @if($link->scheduled)
                                            <div class="d-flex justify-content-between mt-2">
                                                @if($link->start_time)
                                                <div class="text-success small">
                                                    <iconify-icon icon="mdi:clipboard-text-date" class="me-1" style="position: relative; top: 3px;"></iconify-icon>
                                                    Start: {{ $link->start_time->format('d M Y, H:i') }}
                                                </div>
                                                @endif
                                                
                                                @if($link->end_time)
                                                <div class="text-danger small">
                                                    <iconify-icon icon="mdi:clipboard-text-date" class="me-1" style="position: relative; top: 3px;"></iconify-icon>
                                                    End: {{ $link->end_time->format('d M Y, H:i') }}
                                                </div>
                                                @endif
                                            </div>
                                            @endif
                                            
                                            <div class="d-flex justify-content-end mt-3 position-relative dropup">
                                                
                                                @if($link->scheduled)
                                                <button class="btn btn-outline-info btn-sm rounded-pill me-2">
                                                    <iconify-icon icon="gala:clock"></iconify-icon>
                                                </button>
                                                @endif
                                                @if($link->password_protected)
                                                <button class="btn btn-outline-info btn-sm rounded-pill me-2">
                                                    <iconify-icon icon="solar:key-outline"></iconify-icon>
                                                </button>
                                                @endif
                                                
                                                <button class="btn btn-outline-{{ $link->active ? 'primary' : 'danger' }} btn-sm rounded-pill me-2">
                                                    <iconify-icon icon="solar:earth-bold-duotone"></iconify-icon>
                                                </button>
                                                
                                                <a class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center gap-1 px-3 py-1 me-2 shadow-sm transition"
                                                   href="/dashboard/link/{{ $link->slug }}"
                                                >
                                                    <iconify-icon icon="solar:chart-bold"></iconify-icon>
                                                    <span>Analytic</span>
                                                </a>
                                                
                                                <button class="btn btn-outline-primary btn-sm rounded-pill" data-bs-toggle="dropdown">
                                                    <iconify-icon icon="solar:menu-dots-bold"></iconify-icon>
                                                </button>
                                                
                                                <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                                    <li>
                                                        <a class="dropdown-item" href="/dashboard/link/{{ $link->slug }}#link-settings">
                                                            <iconify-icon icon="solar:settings-bold" class="me-2"></iconify-icon>Link Settings
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button
                                                            class="dropdown-item generate-qr"
                                                            data-url="{{ 'https://linksy.site/' . $link->slug }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#qrCodeModal"
                                                        >
                                                            <iconify-icon icon="solar:qr-code-bold" class="me-2"></iconify-icon> Generate QR
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="#"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#editModal"
                                                           data-id="{{ $link->slug }}"
                                                           data-target-url="{{ $link->target_url }}"
                                                           data-category-id="{{ $link->link_category_id }}" 
                                                           data-active="{{ $link->active }}">
                                                            <iconify-icon icon="solar:pen-bold" class="me-2"></iconify-icon> Quick Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#shareLinkModal"
                                                                data-id="{{ $link->slug }}">
                                                            <iconify-icon icon="solar:share-bold" class="me-2"></iconify-icon> Share Link
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger"
                                                           href="#"
                                                           data-bs-toggle="modal"
                                                           data-bs-target="#deleteModal"
                                                           data-id="{{ $link->slug }}">
                                                            <iconify-icon icon="solar:trash-bin-minimalistic-bold" class="me-2"></iconify-icon> Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12">
                                    <div class="text-center p-5 bg-light rounded-3">
                                        <iconify-icon icon="solar:file-remove-line-duotone" width="80" class="text-muted mb-3"></iconify-icon>
                                        <h4 class="fw-light">No Links Found</h4>
                                        <p class="text-muted">Tidak ada link yang ditemukan pada filter ini. Coba buat link baru atau pilih kategori lain.</p>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                            
                            <div class="mt-4">
                                {{ $links->links() }}
                            </div>
                        </div>
                        <!-- Shared Links -->
                        <div class="tab-pane fade" id="shared-links" role="tabpanel" aria-labelledby="shared-links-tab">
                            <div class="row">
                                @forelse ($sharedLinks as $sharedlink)
                                <div class="col-md-4 d-flex align-items-stretch ">
                                    <div class="card shadow border-0 w-100 card-hover rounded-5">
                                        <div class="card-body">
                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-12 d-flex align-items-center">
                                                    <img data-src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($sharedlink->target_url) }}&size=32" 
                                                         alt="Favicon" 
                                                         class="rounded me-2 lazyload" 
                                                         style="width: 25px; height: 25px; flex-shrink: 0;">
                                                    <input type="text" 
                                                           class="form-control border-0 p-0 text-dark fw-bold fs-5" 
                                                           value="{{ $sharedlink->title }}" 
                                                           readonly>
                                                </div>
                                            </div>
                                            <p class="text-muted small mb-1">Destination:</p>
                                            <a href="{{ $sharedlink->target_url }}" target="_blank" class="d-block text-truncate link-dark text-decoration-none"
                                               style="transition: color 0.2s;"
                                               onmouseover="this.classList.replace('link-dark', 'text-primary')"
                                               onmouseout="this.classList.replace('text-primary', 'link-dark')">
                                                {{ Str::limit(strip_tags($sharedlink->target_url), 80) }}
                                            </a>
                            
                                            <div class="mt-2">
                                                <p class="text-muted small mb-1">
                                                    <iconify-icon icon="solar:user-speak-rounded-bold-duotone" class="me-1" style="position: relative; top: 3px;"></iconify-icon>
                                                    Shared by: @<b>{{ $sharedlink->user->username }}</b>
                                                </p>
                                                 <p class="text-muted small mb-1">
                                                    <iconify-icon icon="solar:calendar-minimalistic-bold-duotone" class="me-1" style="position: relative; top: 3px;"></iconify-icon>
                                                    Shared on: {{ \Carbon\Carbon::parse($sharedlink->share_created_at)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            @empty
                                <div class="empty-container text-center w-100">
                                    <p>No links have been shared with you yet.</p>
                                </div>
                            @endforelse
                                {{ $sharedLinks->links() }}
                            </div>
                        </div>
                        <!-- Links You Shared -->
                        <div class="tab-pane fade" id="links-you-shared" role="tabpanel" aria-labelledby="links-you-shared-tab">
                            <div class="row g-3">
                                @forelse ($mySharedLinks as $sharedLink)
                                <div class="col-md-4 d-flex align-items-stretch ">
                                    <div class="card shadow border-0 w-100 card-hover rounded-5">
                                        <div class="card-body">
                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-12 d-flex align-items-center">
                                                    <img data-src="https://t2.gstatic.com/faviconV2?client=SOCIAL&type=FAVICON&fallback_opts=TYPE,SIZE,URL&url={{ urlencode($sharedLink->link->target_url) }}&size=32" 
                                                         alt="Favicon" 
                                                         class="rounded me-2 lazyload" 
                                                         style="width: 25px; height: 25px; flex-shrink: 0;">
                                                    <input type="text" 
                                                           class="form-control border-0 p-0 text-dark fw-bold fs-5" 
                                                           value="{{ $sharedLink->link->title }}" 
                                                           readonly>
                                                </div>
                                            </div>
                                            <p class="text-muted small mb-1">Destination:</p>
                                            <a href="{{ $sharedLink->link->target_url }}" target="_blank" class="d-block text-truncate link-dark text-decoration-none"
                                               style="transition: color 0.2s;"
                                               onmouseover="this.classList.replace('link-dark', 'text-primary')"
                                               onmouseout="this.classList.replace('text-primary', 'link-dark')">
                                                {{ Str::limit(strip_tags($sharedLink->link->target_url), 80) }}
                                            </a>
                            
                                            <div class="mt-2">
                                                <p class="text-muted small mb-1">
                                                    <iconify-icon icon="solar:user-bold-duotone" class="me-1" style="position: relative; top: 3px;"></iconify-icon>
                                                    Shared to: @<b>{{ $sharedLink->sharedWith->username }}</b>
                                                </p>
                                                <p class="text-muted small mb-1">
                                                    <iconify-icon icon="solar:calendar-add-bold-duotone" class="me-1" style="position: relative; top: 3px;"></iconify-icon>
                                                    Shared on: {{ $sharedLink->created_at->format('d M Y') }}
                                                </p>
                                            </div>
                                            
                                            <div class="d-flex justify-content-end mt-3 position-relative dropup">
                                                @if($sharedLink->link->password_protected)
                                                    <button class="btn btn-outline-dark btn-sm rounded-pill me-2" title="Password Protected">
                                                        <iconify-icon icon="solar:key-outline"></iconify-icon>
                                                    </button>
                                                @endif
                            
                                                <button class="btn btn-outline-{{ $sharedLink->link->active ? 'primary' : 'danger' }} btn-sm rounded-pill me-2" title="{{ $sharedLink->link->active ? 'Link Active' : 'Link Inactive' }}">
                                                    <iconify-icon icon="solar:earth-bold-duotone"></iconify-icon>
                                                </button>
                            
                                                <a class="btn btn-outline-primary btn-sm rounded-pill d-flex align-items-center gap-1 px-3 py-1 me-2 shadow-sm transition" 
                                                   href="/dashboard/link/{{ $sharedLink->link->slug }}"
                                                   title="View Analytics for Original Link">
                                                    <iconify-icon icon="solar:chart-bold"></iconify-icon>
                                                    <span>Analytic</span>
                                                </a>
                            
                                                <button class="btn btn-outline-primary btn-sm rounded-pill" data-bs-toggle="dropdown" title="More Options">
                                                    <iconify-icon icon="solar:menu-dots-bold"></iconify-icon>
                                                </button>
                            
                                                <ul class="dropdown-menu dropdown-menu-end" style="z-index: 1050;">
                                                    <li>
                                                        <a class="dropdown-item" href="/dashboard/link/{{ $sharedLink->link->slug }}" title="View Details of Original Link">
                                                            <iconify-icon icon="solar:info-circle-bold" class="me-2"></iconify-icon> Detail Link Asli
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button 
                                                            class="dropdown-item generate-qr" 
                                                            data-url="{{ 'https://linksy.site/' . $sharedLink->link->slug }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#qrCodeModal"
                                                            title="Generate QR Code for Original Link"
                                                        >
                                                            <iconify-icon icon="solar:qr-code-bold" class="me-2"></iconify-icon> QR Link Asli
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('links.share.delete', $sharedLink->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unshare this link?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <iconify-icon icon="solar:trash-bin-minimalistic-bold" class="me-2"></iconify-icon> Hapus Bagikan
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-container text-center w-100"> <p>No shared links found.</p>
                                </div>
                            @endforelse
                            </div>
                            <div class="mt-3">
                                {{ $mySharedLinks->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal for Sharing Link -->
        <div class="modal fade" id="shareLinkModal" tabindex="-1" aria-labelledby="shareLinkModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0" style="border-radius: 20px;">
                    <div class="modal-header bg-gradient-primary text-white" style="border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                        <div class="d-flex align-items-center w-100">
                            <div class="icon-shape bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-send fs-4 text-dark"></i>
                            </div>
                            <div>
                                <h5 class="modal-title mb-0" id="shareLinkModalLabel" style="font-weight: 600;">Share Resource</h5>
                                <p class="mb-0 small opacity-75 text-dark">Collaborate by sharing with team members</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    
                    <div class="modal-body py-4 px-5">
                        <form id="shareLinkForm">
                            <div class="mb-4">
                                <label for="sharedWith" class="form-label fw-500 mb-3">Recipient's Username</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person-circle text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control border-start-0 ps-2" 
                                           id="sharedWith" 
                                           name="shared_with" 
                                           placeholder="e.g. johndoe123"
                                           style="height: 50px;"
                                           required>
                                </div>
                                <div class="form-text mt-2">Enter the exact username of the person you want to share with</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-500 mb-3">Sharing Options</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check form-check-card">
                                        <input class="form-check-input" type="checkbox" id="sendNotification">
                                        <label class="form-check-label small" for="sendNotification">
                                            Send notification
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="linkId" name="link_id">
                        </form>
                    </div>
        
                    <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px; padding: 1.5rem 2rem;">
                        <button type="button" class="btn btn- btn-neutral" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <button  id="shareButton" type="button" class="btn  btn-primary px-4" >
                            <i class="bi bi-send-check me-2"></i>Share Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-lg border-0">
                    <div class="modal-header border-bottom-0 pt-4 px-4">
                        <h5 class="modal-title fw-semibold" id="addCategoryModalLabel">Add New Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4">
                        <form id="addCategoryForm" novalidate>
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text"
                                       class="form-control rounded-3"
                                       id="categoryName"
                                       name="name"
                                       placeholder="Enter category name"
                                       required
                                       maxlength="50">
                                <div id="categoryNameError" class="invalid-feedback mt-1"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="addCategoryForm" class="btn btn-primary d-flex align-items-center gap-2" id="saveCategoryBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            <span>Create Category</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
       
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0" style="border-radius: 20px;">
                    <div class="modal-header bg-gradient-danger text-white" style="border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                        <div class="d-flex align-items-center w-100">
                            <div class="icon-shape bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-exclamation-triangle fs-4 text-dark"></i>
                            </div>
                            <div class="text-dark">
                                <h5 class="modal-title mb-0" id="deleteModalLabel" style="font-weight: 600;">Delete Short Link</h5>
                                <p class="mb-0 small opacity-75">This action cannot be undone</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
        
                    <div class="modal-body py-2 px-5">
                        <div class="text-center mb-4">
                            <h5 class="fw-semibold mb-2">Confirm Deletion</h5>
                            <p class="text-muted">This will permanently remove the short link and all its analytics data</p>
                        </div>
        
                        <div class="mb-4">
                            <label class="form-label fw-500 mb-3">Type <span class="text-danger">DELETE</span> to confirm:</label>
                            <div class="input-group input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key-fill text-danger"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-start-0 ps-2" 
                                       id="deleteConfirmationInput"
                                       placeholder="Enter 'DELETE'"
                                       autocomplete="off">
                            </div>
                            <div class="form-text text-danger mt-2">
                                <i class="bi bi-exclamation-circle me-2"></i>This action is irreversible
                            </div>
                        </div>
                    </div>
        
                    <div class="modal-footer bg-light" style="border-radius: 0 0 20px 20px; padding: 1.5rem 2rem;">
                        <button type="button" class="btn btn btn-neutral" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </button>
                        <form id="deleteForm" action="" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn btn-danger px-4" 
                                    id="deleteButton" 
                                    disabled
                                    style="position: relative; overflow: hidden;">
                                <i class="bi bi-trash3 me-2"></i>Delete Permanently
                                <div class="hover-effect" style="position: absolute; background: rgba(255,255,255,0.2); top: -50%; left: -50%; width: 200%; height: 200%; transform: rotate(45deg) translate(-30px, 100%); transition: all 0.3s;"></div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- QR Code Modal -->
        <div class="modal fade" id="qrCodeModal" tabindex="-1" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-0" style="border-radius: 20px;">
                    <div class="modal-header bg-gradient-primary text-white" style="border-radius: 20px 20px 0 0; padding: 1.5rem;">
                        <div class="w-100 text-center">
                            <h5 class="modal-title mb-1" id="qrCodeModalLabel" style="font-weight: 600;">
                                <i class="bi bi-qr-code-scan me-2"></i>QR Code
                            </h5>
                            <p class="mb-0 small opacity-75" id="qrCodeUrl"></p>
                        </div>
                        <button type="button" class="btn-close btn-close-white position-absolute end-3 top-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
        
                    <div class="modal-body text-center py-4 px-5">
                        <div id="qrCodeContainer" class="position-relative">
                            <div class="qr-code-loader">
                                <div class="circle-spinner">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <button id="downloadQrCode" class="btn btn-lg btn-primary px-4 rounded-pill hover-scale">
                                <i class="bi bi-download me-2"></i>Download
                            </button>
                        </div>
        
                        <div class="social-share mt-4">
                            <p class="text-muted small mb-2">Share to:</p>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-icon hover-scale text-facebook">
                                    <i class="bi bi-facebook"></i>
                                </button>
                                <button class="btn btn-icon hover-scale text-twitter">
                                    <i class="bi bi-twitter-x"></i>
                                </button>
                                <button class="btn btn-icon hover-scale text-instagram">
                                    <i class="bi bi-instagram"></i>
                                </button>
                                <button class="btn btn-icon hover-scale text-whatsapp">
                                    <i class="bi bi-whatsapp"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0" style="border-radius: 20px;">
                    <div class="modal-header bg-gradient-primary text-white" style="border-radius: 20px 20px 0 0; padding: 1.5rem 2rem;">
                        <div class="d-flex align-items-center w-100">
                            <div class="icon-shape bg-white bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-pencil-square fs-4 text-dark"></i>
                            </div>
                            <div class="text-dark">
                                <h5 class="modal-title mb-0" id="editModalLabel" style="font-weight: 600;">Edit Short Link</h5>
                                <p class="mb-0 small opacity-75">Update your URL destination and settings</p>
                            </div>
                            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                    </div>
                    
                    <div class="modal-body py-4 px-5">
                        <form id="editForm" action="" method="POST">
                            @csrf
                            @method('PATCH')
                            
                            <div class="mb-4">
                                <label for="editTargetUrl" class="form-label fw-500 mb-3">Destination URL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-link-45deg text-muted"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control border-start-0 ps-2" 
                                           id="editTargetUrl" 
                                           name="target_url"
                                           placeholder="https://example.com"
                                           style="height: 50px;"
                                           required>
                                </div>
                                <div class="form-text mt-2">Enter the full URL including http:// or https://</div>
                            </div>
        
                            <div class="mb-4">
                                <label for="editLinkCategory" class="form-label fw-500 mb-3">Category</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-folder2-open text-muted"></i>
                                    </span>
                                    <select class="form-select border-start-0" id="editLinkCategory" name="link_category_id">
                                        <option value="">-- No Category --</option>
                                        @foreach($linkCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-text mt-2">Choose a category or leave it empty.</div>
                            </div>
        
                            <div class="mb-4">
                                <label for="editVisibility" class="form-label fw-500 mb-3">Link Visibility</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-eye text-muted"></i>
                                    </span>
                                    <select class="form-select border-start-0" id="editVisibility" name="visibility" required>
                                        <option value="1">Public</option>
                                        <option value="0">Private</option>
                                    </select>
                                </div>
                                <div class="form-text mt-2">Choose whether this link is Public or Private.</div>
                            </div>
        
                            <input type="hidden" name="quickedit" value="1">
                            
                            <div class="modal-footer bg-light px-0 pb-0 mt-4" style="border-radius: 0 0 20px 20px;">
                                <button type="button" class="btn btn-neutral" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-2"></i>Discard
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-save2 me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.visitDataGlobal = @json($visitData);  
        </script>
        <script src="{{ asset('js/link.js') }}"></script>
        <script src="{{ asset('js/dashjs/utils.js') }}"></script>
</x-dashlayout>
