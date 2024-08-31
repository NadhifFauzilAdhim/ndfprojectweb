<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="bloghero overlay inner-page">
        <img src="{{ asset('img/blob.svg') }}" alt="" class="img-fluid blob">
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
    
            <article class="col-lg-8 order-lg-2 px-lg-5">
              @if($post['image'])
              <img class="img-fluid" src="{{ asset('storage/' . $post['image']) }}" alt="">
              @else
              <img class="img-fluid" src="{{ asset('img/programmer_text_2.jpg')  }}" alt="">
              @endif
              <p>{!! $post['body'] !!}</p>
              <div class="pt-5 categories_tags ">
                <p>Categories:  <a href="#">Design</a>, <a href="#">Events</a>  Tags: <a href="#">#html</a>, <a href="#">#trends</a></p>
              </div>
    
              <div class="post-single-navigation d-flex align-items-stretch">
                <a href="#" class="mr-auto w-50 pr-4">
                  <span class="d-block">Previous Post</span>
                  A Mounteering Guide For Beginners
                </a>
                <a href="#" class="ml-auto w-50 text-right pl-4">
                  <span class="d-block">Next Post</span>
                  12 Creative Designers Share Ideas About Web Design
                </a>
              </div>
    
    
              <div class="pt-5">
                <h3 class="mb-5">1 Comments</h3>
                <ul class="comment-list">
                  <li class="comment">
                    <div class="vcard bio">
                      <img src="{{ asset('img/author.png') }}" alt="Image placeholder">
                    </div>
                    <div class="comment-body">
                      <h3>Nadhif Fauzil</h3>
                      <div class="meta">January 9, 2018 at 2:21pm</div>
                      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur quidem laborum necessitatibus, ipsam impedit vitae autem, eum officia, fugiat saepe enim sapiente iste iure! Quam voluptas earum impedit necessitatibus, nihil?</p>
                      <p><a href="#" class="reply">Reply</a></p>
                    </div>
                  </li>
    
                  
                </ul>
                <!-- END comment-list -->
                
                <div class="comment-form-wrap pt-5">
                  <h3 class="mb-5">Leave a comment</h3>
                  <form action="#" class="">
                    <div class="form-group">
                      <label for="name">Name *</label>
                      <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                      <label for="email">Email *</label>
                      <input type="email" class="form-control" id="email">
                    </div>
                    <div class="form-group">
                      <label for="website">Website</label>
                      <input type="url" class="form-control" id="website">
                    </div>
    
                    <div class="form-group">
                      <label for="message">Message</label>
                      <textarea name="message" id="message" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                      <input type="submit" value="Post Comment" class="btn btn-primary btn-md">
                    </div>
    
                  </form>
                </div>
              </div>
              
    
            </article>
    
            <div class="col-md-12 col-lg-1 order-lg-1">
              <div class="share sticky-top">
                <h3>Share</h3>
                <ul class="list-unstyled share-article">
                  <li><a href="#"><i class="bi bi-whatsapp"></i></a></li>
                  <li><a href="#"><i class="bi bi-twitter-x"></i></a></li>
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
                <h2 class="mb-3 text-black">Subscribe to Newsletter</h2>
                <p>Far far away behind the word mountains far from.</p>
                <form action="#">
                  <input type="email" class="form-control mb-2" placeholder="Enter email">
                  <input type="submit" value="Subscribe" class="btn btn-primary btn-block">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
</x-layout>