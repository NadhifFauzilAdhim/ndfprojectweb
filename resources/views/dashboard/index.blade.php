<x-dashlayout>
    <x-slot:title>{{ $title  }}</x-slot:title>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title d-flex align-items-center gap-2 mb-4">
                            Traffic Overview
                            <span>
                                <iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Traffic Overview"></iconify-icon>
                            </span>
                        </h5>
                        <div id="traffic-overview" >
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body text-center">
              <img src="{{ asset('img/product-tip.png') }}" alt="image" class="img-fluid" width="205">
              <h4 class="mt-7">Welcome !</h4>
              <p class="card-subtitle mt-2 mb-3">Duis at orci justo nulla in libero id leo
                molestie sodales phasellus justo.</p>
                <button class="btn btn-primary mb-3">Explore</button>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Your Post Comment</h5>
              <div class="table-responsive">
                <table class="table text-nowrap align-middle mb-0">
                  <thead>
                    <tr class="border-2 border-bottom border-primary border-0"> 
                      <th scope="col" class="ps-0">Page Title</th>
                      <th scope="col" >Link</th>
                      <th scope="col" class="text-center">Pageviews</th>
                      <th scope="col" class="text-center">Page Value</th>
                    </tr>
                  </thead>
                  <tbody class="table-group-divider">
                    <tr>
                      <th scope="row" class="ps-0 fw-medium">
                        <span class="table-link1 text-truncate d-block">Welcome to our
                          website</span>
                      </th>
                      <td>
                        <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">/index.html</a>
                      </td>
                      <td class="text-center fw-medium">18,456</td>
                      <td class="text-center fw-medium">$2.40</td>
                    </tr>
                    <tr>
                      <th scope="row" class="ps-0 fw-medium">
                        <span class="table-link1 text-truncate d-block">Modern Admin
                          Dashboard Template</span>
                      </th>
                      <td>
                        <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">/dashboard</a>
                      </td>
                      <td class="text-center fw-medium">17,452</td>
                      <td class="text-center fw-medium">$0.97</td>
                    </tr>
                    <tr>
                      <th scope="row" class="ps-0 fw-medium">
                        <span class="table-link1 text-truncate d-block">Explore our
                          product catalog</span>
                      </th>
                      <td>
                        <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">/product-checkout</a>
                      </td>
                      <td class="text-center fw-medium">12,180</td>
                      <td class="text-center fw-medium">$7,50</td>
                    </tr>
                    <tr>
                      <th scope="row" class="ps-0 fw-medium">
                        <span class="table-link1 text-truncate d-block">Comprehensive
                          User Guide</span>
                      </th>
                      <td>
                        <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">/docs</a>
                      </td>
                      <td class="text-center fw-medium">800</td>
                      <td class="text-center fw-medium">$5,50</td>
                    </tr>
                    <tr>
                      <th scope="row" class="ps-0 fw-medium border-0">
                        <span class="table-link1 text-truncate d-block">Check out our
                          services</span>
                      </th>
                      <td class="border-0">
                        <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block">/services</a>
                      </td>
                      <td class="text-center fw-medium border-0">1300</td>
                      <td class="text-center fw-medium border-0">$2,15</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title d-flex align-items-center gap-2 mb-5 pb-3">Sessions by
                device<span><iconify-icon icon="solar:question-circle-bold" class="fs-7 d-flex text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="tooltip-success" data-bs-title="Locations"></iconify-icon></span>
              </h5>
              <div class="row">
                <div class="col-4">
                  <iconify-icon icon="solar:laptop-minimalistic-line-duotone" class="fs-7 d-flex text-primary"></iconify-icon>
                  <span class="fs-11 mt-2 d-block text-nowrap">Computers</span>
                  <h4 class="mb-0 mt-1">87%</h4>
                </div>
                <div class="col-4">
                  <iconify-icon icon="solar:smartphone-line-duotone" class="fs-7 d-flex text-secondary"></iconify-icon>
                  <span class="fs-11 mt-2 d-block text-nowrap">Smartphone</span>
                  <h4 class="mb-0 mt-1">9.2%</h4>
                </div>
                <div class="col-4">
                  <iconify-icon icon="solar:tablet-line-duotone" class="fs-7 d-flex text-success"></iconify-icon>
                  <span class="fs-11 mt-2 d-block text-nowrap">Tablets</span>
                  <h4 class="mb-0 mt-1">3.1%</h4>
                </div>
              </div>
    
              <div class="vstack gap-4 mt-7 pt-2">
                <div>
                  <div class="hstack justify-content-between">
                    <span class="fs-3 fw-medium">Computers</span>
                    <h6 class="fs-3 fw-medium text-dark lh-base mb-0">87%</h6>
                  </div>
                  <div class="progress mt-6" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                  </div>
                </div>
    
                <div>
                  <div class="hstack justify-content-between">
                    <span class="fs-3 fw-medium">Smartphones</span>
                    <h6 class="fs-3 fw-medium text-dark lh-base mb-0">9.2%</h6>
                  </div>
                  <div class="progress mt-6" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-secondary" style="width: 50%"></div>
                  </div>
                </div>
    
                <div>
                  <div class="hstack justify-content-between">
                    <span class="fs-3 fw-medium">Tablets</span>
                    <h6 class="fs-3 fw-medium text-dark lh-base mb-0">3.1%</h6>
                  </div>
                  <div class="progress mt-6" role="progressbar" aria-label="Warning example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-success" style="width: 35%"></div>
                  </div>
                </div>
    
              </div>
            </div>
          </div>
        </div>
        
        
        @forelse($posts as $post)
        <div class="col-lg-4">
          
          <div class="card overflow-hidden hover-img">
            <div class="position-relative">
              <a href="javascript:void(0)">
                @if($post->image )
                <img src="{{ asset('storage/' . $post->image ) }}" class="card-img-top fixed-size" alt="matdash-img">
                @else
                <img src="{{ asset('img/programmer_text_2.jpg') }}" class="card-img-top img-fluid fixed-size" alt="Default Image">
                @endif
              </a>
              {{-- <span class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">2
                min Read</span> --}}
             
            </div>
            <div class="card-body p-4">
              <span class="badge text-bg-light fs-2 py-1 px-2 lh-sm  mt-3">{{ $post->category->name }}</span>
              <a class="d-block my-1 fs-5 text-dark fw-semibold link-primary" href="/blog/{{ $post->slug }}">{{ $post->title }}</a>
              <p>{{ Str::limit(strip_tags($post['body']), 100) }}</p>
              <div class="d-flex align-items-center gap-4">
               
                <div class="d-flex align-items-center fs-2 ms-auto">
                  <i class="ti ti-point text-dark"></i>{{  $post['created_at']->diffForHumans() }}
                </div>
              </div>
            </div>
          </div>
        </div>
        @empty


        @endforelse
        {{ $posts->links() }}
       
      </div>
</x-dashlayout>