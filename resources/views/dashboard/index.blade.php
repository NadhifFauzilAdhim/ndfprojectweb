<x-dashlayout>
    <x-slot:title>{{ $title  }}</x-slot:title>
    <script src="https://static.elfsight.com/platform/platform.js" async></script>
<div class="elfsight-app-16c599f4-70fd-4b71-aa1d-bfb0ee7810ef" data-elfsight-app-lazy></div>
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body text-center card-fixed-size">
                <img src="{{ asset('img/product-tip.png') }}" alt="image" class="img-fluid" width="205">
                <h4 class="mt-7"><small>Welcome !</small> <br> {{ Auth::user()->name }}</h4>
                <p class="card-subtitle mt-2 mb-1 fs-2">We're glad to have you here. Explore the features and tools available on your dashboard to make the most out of your experience.</p>
                
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
              <h5 class="card-title">Your post comment</h5>
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
                    @forelse($comments as $comment)
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
                      <tr>
                        <td colspan="3" class="text-center">Anda Belum memiliki Post &#129300;</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
            {{ $comments->links() }}  
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
      <script src="{{ asset('js/dashjs/dashboard.js') }}"></script>
</x-dashlayout>