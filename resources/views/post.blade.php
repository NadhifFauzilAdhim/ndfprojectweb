<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="bloghero overlay inner-page">
        <img src="{{ asset('img/puppet.png') }}" alt="" class="img-fluid blob">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center pt-5">
            <div class="col-lg-6">
              <h1 class="heading text-white mb-3" data-aos="fade-up" >{{ $post['title'] }}</h1>
              <div class="d-flex justify-content-center" data-aos="fade-up">
                <p class="me-4"><i class="bi bi-feather me-1"></i></i><a href="/blog?author={{ $post->author->username }}" class="link-opacity-50-hover text-white">{{ $post->author->name }}</a></p>
                <p class="me-4"><i class="bbi bi-calendar-check-fill me-1"></i>{{ $post['created_at'] }}</p>
                <p><i class="bi bi-bookmark me-1"></i><a href="/blog?category={{ $post->category->slug }}" class="link-opacity-50-hover text-white">{{ $post->category->name }}</a></p>
              </div>
              
            </div>
          </div>
        </div>
      </div>
     
      <div class="blog-section">
        <div class="container article">
          <div class="row justify-content-center align-items-stretch">
            @if(!$post->is_published)
            <div class="alert alert-warning text-center" role="alert">
              <i class="bi bi-exclamation-circle-fill"></i> This post is not published, only author can see it
            </div>
            @endif
            <article class="col-lg-8 order-lg-2 px-lg-5">
             
              <p>{!! $post['body'] !!}</p>
              <div class="pt-5 categories_tags ">
                <p>Categories:  <a href="#">{{ $post->category->name }}</a></p>
              </div>
    
    
              <div class="pt-5">
                @auth
                <div class="comment-form-wrap pt-5">
                    <h3 class="mb-2">Leave a comment</h3>
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <!-- Form untuk mengirimkan komentar -->
                    <form action="{{ url('/post/' . $post->slug . '/comment') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                        </div> 
                    </form>
                </div>
                @else
                <div class="alert alert-warning text-center" role="alert">
                    Login To Comment
                </div>
                @endauth
                <h3 class="mb-5 mt-4">{{ count($post->comments) }} Comments</h3>
                @forelse($post->comments as $comment)
                <ul class="comment-list">
                    <li class="comment">
                        <!-- Komentar Utama -->
                        <div class="vcard bio">
                            @if($comment->user->avatar)
                                <img data-src="{{ asset('storage/' . $comment->user->avatar) }}" alt="Image placeholder" class="lazyload">
                            @elseif($comment->user->google_avatar)
                                <img data-src="{{ $comment->user->google_avatar }}" alt="Image placeholder" class="lazyload">
                            @else
                                <img data-src="https://img.icons8.com/color/48/user-male-circle--v1.png" alt="Image placeholder" class="lazyload">
                            @endif
                        </div>
                        <div class="comment-body">
                            <h3>{{ $comment->user->name }}</h3>
                            <div class="meta">{{ $comment->created_at->format('F j, Y \a\t g:i a') }}</div>
                            <p>{{ $comment->body }}</p>
            
                            <div class="d-flex">
                                <p><a href="javascript:void(0);" class="reply" data-comment-id="{{ $comment->id }}">Reply</a></p>
            
                                @if(Auth::check() && Auth::id() == $comment->user_id)
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');" class="ms-3">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-warning rounded-pill ms-1"><small>Delete</small></button>
                                    </form>
                                @endif
                            </div>
            
                            <!-- Reply Form (Initially hidden) -->
                            <div id="reply-form-{{ $comment->id }}" class="reply-form d-none mt-3">
                                <form action="/comments/{{ $comment->id }}/reply" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="body" class="form-control" rows="3" placeholder="Write your reply here..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Reply</button>
                                </form>
                            </div>
                        </div>
            
                        <!-- Balasan Komentar -->
                        <ul class="children">
                            @foreach($comment->commentreplies as $reply)
                                <li class="comment">
                                    <div class="vcard bio">
                                        @if($reply->user->avatar)
                                            <img data-src="{{ asset('storage/' . $reply->user->avatar) }}" alt="Image placeholder" class="lazyload">
                                        @elseif($reply->user->google_avatar)
                                            <img data-src="{{ $reply->user->google_avatar }}" alt="Image placeholder" class="lazyload">
                                        @else
                                            <img data-src="https://img.icons8.com/color/48/user-male-circle--v1.png" alt="Image placeholder" class="lazyload">
                                        @endif
                                    </div>
                                    <div class="comment-body">
                                        <h3>{{ $reply->user->name }} <small class="fs-6">reply</small></h3>
                                        <div class="meta">{{ $reply->created_at->format('F j, Y \a\t g:i a') }}</div>
                                        <p>{{ $reply->body }}</p>
            
                                        <!-- Delete Button for Reply -->
                                        @if(Auth::check() && Auth::id() == $reply->user_id)
                                            <form action="{{ route('commentReply.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reply?');" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-warning rounded-pill ms-1"><small>Delete</small></button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </li>          
                </ul>
            @empty
                <p>No Comments</p>
            @endforelse
              </div>
            </article>
    
            <div class="col-md-12 col-lg-1 order-lg-1">
              <div class="share sticky-top">
                <h3>Share</h3>
                  <ul class="list-unstyled share-article d-flex">
                    <li><a href="https://wa.me/?text={{ urlencode('Check out this awesome blog post: ' . $post->title . ' ' . url()->current()) }}"><i class="bi bi-whatsapp me-3"></i></a></li>
                    <li><a href="https://x.com/intent/tweet?text={{ urlencode('Check out this awesome blog post: ' . $post->title . ' ' . url()->current()) }}"><i class="bi bi-twitter-x"></i></a></li>
                  </ul>
              </div>
              
            </div>
            <div class="col-lg-3 mb-5 mb-lg-0 order-lg-3">
              <div class="share floating-block sticky-top ">
                <div style="position: relative; width: 100%; height: 0; padding-top: 177.7778%;
              padding-bottom: 0; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); margin-top: 1.6em; margin-bottom: 0.9em; overflow: hidden;
              border-radius: 8px; will-change: transform;">
                <iframe loading="lazy" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; border: none; padding: 0;margin: 0;"
                  src="https:&#x2F;&#x2F;www.canva.com&#x2F;design&#x2F;DAGPZrOlJxU&#x2F;za6c0pgrynlAEEzwJFeBPw&#x2F;view?embed" allowfullscreen="allowfullscreen" allow="fullscreen">
                </iframe>
              </div>
              
                <h2 class="mb-3 text-black">Subscribe to Blog</h2>
                <form action="#">
                  <input type="email" class="form-control mb-2" placeholder="Enter email">
                  <input type="submit" value="Subscribe" class="btn btn-primary btn-block">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script src="{{ asset('js/blog.js') }}"></script>
</x-layout>