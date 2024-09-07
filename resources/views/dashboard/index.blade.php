<x-dashlayout>
    <x-slot:title>{{ $title  }}</x-slot:title>
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body text-center card-fixed-size">
                <img src="{{ asset('img/product-tip.png') }}" alt="image" class="img-fluid" width="205">
                <h4 class="mt-7"><small>Welcome !</small> <br> {{ Auth::user()->name }}</h4>
                <p class="card-subtitle mt-2 mb-1 fs-2">We're glad to have you here. Explore the features and tools available on your dashboard to make the most out of your experience.</p>
                  <button class="btn btn-primary mb-3">Explore</button>
              </div>
            </div>
          </div>
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
        
        <div class="col-lg-8">
          <div class="card">
            <div class="card-body card-fixed-size">
              <h5 class="card-title">Your post comment based on the 3 newest posts.</h5>
              <!-- Make this div scrollable by setting a max height -->
              <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                <table class="table text-nowrap align-middle mb-0">
                  <thead>
                    <tr class="border-2 border-bottom border-primary border-0">
                      <th scope="col" class="ps-0">Post</th>
                      <th scope="col">User</th>
                      <th scope="col">Comments</th>
                      <th scope="col"></th>
                    </tr>
                  </thead>
                  <tbody class="table-group-divider">
                    @forelse($posts as $post)
                      @forelse($post->comments as $comment)
                        <tr>
                          <th scope="row" class="ps-0 fw-medium">
                            <a href="/blog/{{ $comment->post->slug }}" class="link-primary">
                              <span class="table-link1 text-truncate d-block"><small>{{ Str::limit(strip_tags($comment->post->title), 30) }}</small></span>
                            </a>
                          </th>
                          <td class="fw-medium"><small>{{ $comment->user->name }}</small></td>
                          <td>
                            <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block"><small>{{ Str::limit(strip_tags($comment->body), 30) }}</small></a>
                          </td>
                          <td>
                            <a href="javascript:void(0)" class="link-primary text-dark fw-medium d-block"><small>{{ $comment->created_at->diffForHumans() }}</small></a>
                          </td>
                        </tr>
                      @empty
                        
                      @endforelse
                    @empty
                      <tr>
                        <td colspan="3" class="text-center">Anda Belum memiliki Post &#129300;</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body card-fixed-size">
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
          <div class="card overflow-hidden hover-img ">
            <div class="position-relative">
              <a href="javascript:void(0)">
                @if($post->image )
                <img src="{{ asset('storage/' . $post->image ) }}" class="card-img-top fixed-size" alt="matdash-img">
                @else
                <img src="{{ asset('img/programmer_text_2.jpg') }}" class="card-img-top img-fluid fixed-size" alt="Default Image">
                @endif
              </a>
              <span class="badge text-bg-light text-dark fs-2 lh-sm mb-9 me-9 py-1 px-2 fw-semibold position-absolute bottom-0 end-0">-
                views</span>
             
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