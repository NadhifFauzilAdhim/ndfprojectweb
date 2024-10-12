<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <style>
        .blog-section img {
            width: 100%; /* Make the image fill the width of its container */
            height: auto; /* Maintain aspect ratio */
            max-width: 100%; /* Ensure the image does not exceed the container's width */
        }
    </style>
    <div class="bloghero overlay inner-page">
        <img src="{{ asset('img/blob.svg') }}" alt="" class="img-fluid blob">
        <div class="container">
          <div class="row align-items-center justify-content-center text-center pt-5" data-aos="fade-up">
            <div class="col-lg-6">
              <h1 class="heading text-white mb-3" >{{ $event['name'] }}</h1>
              <div class="d-flex justify-content-center">
                <p class="me-4"><i class="bbi bi-calendar-check-fill me-1 text-warning"></i>{{ $event['beginTime'] }}</p>
                <p class="me-4"><i class="bi bi-alarm-fill me-1 text-warning"></i>{{ $event['endTime'] }}</p>
                <p class="me-4"><i class="bi bi-person-fill-check me-1 text-warning"></i>{{ $event['registrants'] }} / {{ $event['quota'] }} Participated</p>
              </div>
              <p class="me-4"><i class="bi bi-person-fill-lock" ></i><b>{{ $event['ownerName'] }}</b></p>
            </div>
          </div>
        </div>
      </div>

      <div class="blog-section">
        <div class="container article">
          <div class="row justify-content-center align-items-stretch">
    
            <article class="col-lg-8 order-lg-2 px-lg-5">
              <p>{!! $event['description'] !!}</p>
              <div class="pt-5 categories_tags ">
              </div>
            </article>
    
            <div class="col-md-12 col-lg-1 order-lg-1">
              <div class="share sticky-top">
                <h3>Share</h3>
                  <ul class="list-unstyled share-article d-flex">
                    <li><a href="https://wa.me/?text={{ urlencode('Check out this awesome blog event: ' . $event['name'] . ' ' . url()->current()) }}"><i class="bi bi-whatsapp me-3"></i></a></li>
                    <li><a href="https://x.com/intent/tweet?text={{ urlencode('Check out this awesome blog event: ' . $event['name'] . ' ' . url()->current()) }}"><i class="bi bi-twitter-x"></i></a></li>
                  </ul>
                  <a class="btn btn-primary" href="{{ $event['link'] }}"><i class="bi bi-person-fill-add me-1"></i>Register</a>
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