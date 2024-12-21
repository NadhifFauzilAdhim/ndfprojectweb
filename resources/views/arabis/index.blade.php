<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Arabis Group</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;400;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/templatemo-festava-live.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <script type="text/javascript">
      window.$crisp = [];
      window.CRISP_WEBSITE_ID = "{{ config('services.crisp.website_id') }}";
      (function () {
        d = document;
        s = d.createElement("script");
        s.src = "https://client.crisp.chat/l.js";
        s.async = 1;
        d.getElementsByTagName("head")[0].appendChild(s);
      })();
    </script>
</head>

<body>
    <main>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="home">
                    <img src="{{ asset('img/project/ndfproject-logo-white.png') }}" width="200px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav align-items-lg-center ms-auto me-lg-5">
                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_1">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_2">About</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_3">Member</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_4">Project</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link click-scroll" href="#section_6">Contact</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">NDFproject</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <section class="hero-section" id="section_1">
            <div class="section-overlay"></div>
            <div class="container d-flex justify-content-center align-items-center">
                <div class="row">

                    <div class="col-12 mt-auto mb-5 text-center">
                        <small>informatics study group</small>
                        <h1 class="text-white mb-5">Arabis Group</h1>
                        <a class="btn custom-btn smoothscroll" href="#section_2">Let's begin</a>
                    </div>
                    <div class="col-lg-12 col-12 mt-auto d-flex flex-column flex-lg-row text-center">
                        <div class="location-wrap mx-auto py-3 py-lg-0">
                            <p id='currentDateTime'></span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="video-wrap">
                <img src="{{ asset('img/banner.png')  }}" class="custom-video" poster="">
            </div>
        </section>

        <section class="about-section section-padding" id="section_2">
            <div class="container">
                <div class="row">
                    <div class="alert alert-warning text-center" role="alert">
                        <a href="https://sites.google.com/view/arabisgroup/home" class="site-footer-link text-black">This is a new website, click to return to the old website</a>
                    </div>
                    <div class="col-lg-12 col-12 mb-4 mb-lg-0 d-flex align-items-center">
                        <div class="services-info">
                            <h2 class="text-white mb-4 mt-4">About Arabis Group</h2>

                            <p class="text-white">Arabis Group is a team of computer science students who are driven by passion and share a common objective of personal growth and making significant contributions to the field of information technology.
                                As a group, we strive to create a dynamic environment where members can learn, collaborate, and excel in their respective areas of interest within the realm of technology. We firmly believe that by coming together, we can achieve far greater heights than we could individually.
                            </p>

                            <h6 class="text-white mt-4">Vision</h6>

                            <p class="text-white mb-4">Our primary vision is to establish ourselves as a center of innovation and knowledge among computer science students, serving as a platform for them to enhance their technical skills and develop essential soft skills demanded by the IT industry. We are committed to fostering an atmosphere of continuous learning, mutual support, and knowledge sharing, empowering our members to realize their full potential and make positive impacts on society.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding section-bg" id="section_5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-12 mx-auto">
                        <h4 class="text-center mb-4 pt-4">Project</h4>
                    </div>
                    <div class="col-lg-12 ">
                        <div class="text-center">

                            <img class="img-fluid " src="{{ asset('img/project/hydroease.png') }}" alt="" width="500px">
                        </div>
                        <div class="col-lg-8 col-12 mx-auto">
                            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" data-bs-interval="4000">
                                        <img src="{{ asset('img/project/HydoEasePIC1.png') }}" class="d-block w-100" alt="...">
                                    </div>
                                    <div class="carousel-item" data-bs-interval="4000">
                                        <img src="{{ asset('img/project/HydoEasePIC2.png') }}" class="d-block w-100" alt="...">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-12 col-12 mb-4 mb-lg-0 d-flex align-items-center">
                            <div class="services-info text-center">
                                <h4 class=" mb-4 mt-2">Apa itu HydroEase?</h4>
                                <p class="">HydroEase menggabungkan hidroponik dengan kenyamanan IoT, mengajak Anda untuk menanam tanaman yang lebih sehat dan berkelanjutan dengan mudah. Untuk meningkatkan kebun pribadi ataupun merevolusi bisnis pertanian, HydroEase adalah sistem hidroponik efisien terbaik Anda, membuat standar baru untuk presisi dan produktivitas di bidang pertanian. Rasakan masa depan pertanian dengan HydroEase hari ini.
                                </p>
                            </div>
                        </div>
                        <div class="text-center mb-4">
                            <a class="btn  btn-success smoothscroll" href="https://launchinpad.com/project/hydroease-hydroponic-efficiency-automation-8dafb66">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-padding mt-5" id="sectionproject">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12 text-center mb-4 " data-aos="fade-in" data-aos-duration="1000"></div>
                    <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0" data-aos="fade-in" data-aos-duration="1000">
                        <div class="custom-block-wrap">
                            <img src="{{ asset('img/project/webdev.png') }}" class="custom-block-image img-fluid" alt="" />
                            <div class="custom-block">
                                <div class="custom-block-body">
                                    <h5 class="mb-1 text-center">Web Develoment</h5>
                                </div>
                                <a href="{{ route('home') }}" class="custom-btn btn">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-0" data-aos="fade-in" data-aos-duration="1000">
                        <div class="custom-block-wrap">
                            <img src="{{ asset('img/project/microcontroller.png') }}" class="custom-block-image img-fluid" alt="" />
                            <div class="custom-block">
                                <div class="custom-block-body">
                                    <h5 class="mb-1 text-center">Microcontroller</h5>
                                </div>
                                <a href="{{ route('home') }}" class="custom-btn btn">Learn Mores</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12" data-aos="fade-in" data-aos-duration="1000">
                        <div class="custom-block-wrap">
                            <img src="{{ asset('img/project/Softwaredev.png') }}" class="custom-block-image img-fluid" alt="" />
                            <div class="custom-block">
                                <div class="custom-block-body">
                                    <h5 class="mb-1 text-center">Software Develoment</h5>
                                </div>
                                <a href="{{ route('home') }}" class="custom-btn btn">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="member-section section-padding" id="section_3">
            <div class="container-xxl py-5">
                <div class="container py-5 px-lg-5">
                    <div class="wow fadeInUp" data-wow-delay="0.1s">
                        <h2 class="text-center mb-5">Our Team</h2>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item bg-light rounded">
                                <div class="text-center border-bottom p-4">
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('img/member/nadhif.png') }}" alt="">
                                    <h5>Nadhif Fauzil Adhim</h5>
                                    <span>22.11.5035</span>
                                </div>
                                <div class="d-flex justify-content-center p-4">
                                    <a class="btn btn-square mx-1" href="https://www.instagram.com/nadhif_f.a/"><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square mx-1" href="https://www.linkedin.com/in/nadhif-fauzil-adhim"><i class="fab fa-linkedin-in"></i></a>
                                    <a class="btn btn-square mx-1" href="https://ndfproject.my.id/"><i class="bi bi-browser-edge"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="team-item bg-light rounded">
                                <div class="text-center border-bottom p-4">
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('img/member/ferdi.png') }}" alt="">
                                    <h5>Dwi Ferdiyanto</h5>
                                    <span>22.11.5018</span>
                                </div>
                                <div class="d-flex justify-content-center p-4">
                                    <a class="btn btn-square mx-1" href="https://www.instagram.com/ferdynto_/"><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                            <div class="team-item bg-light rounded">
                                <div class="text-center border-bottom p-4">
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('img/member/arip.png') }}" alt="">
                                    <h5>Rif'aa Subekti</h5>
                                    <span>22.11.5060</span>
                                </div>
                                <div class="d-flex justify-content-center p-4">
                                    <a class="btn btn-square mx-1" href="https://www.instagram.com/arip.suroso/"><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square mx-1" href="https://www.linkedin.com/in/rifaa-subekti"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="team-item bg-light rounded">
                                <div class="text-center border-bottom p-4">
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('img/member/julian.png') }}" alt="">
                                    <h5>Julian Kiyosaki H</h5>
                                    <span>22.11.5041</span>
                                </div>
                                <div class="d-flex justify-content-center p-4">
                                    <a class="btn btn-square mx-1" href="https://www.instagram.com/kiyosaki.h/"><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="team-item bg-light rounded">
                                <div class="text-center border-bottom p-4">
                                    <img class="img-fluid rounded-circle mb-4" src="{{ asset('img/member/aji.png') }}" alt="">
                                    <h5>Muhajir Faturrahman</h5>
                                    <span>22.11.5056</span>
                                </div>
                                <div class="d-flex justify-content-center p-4">
                                    <a class="btn btn-square mx-1" href="https://www.instagram.com/sann.shiii/"><i class="fab fa-instagram"></i></a>
                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="project-section section-padding pt-4" id="section_4">
            <div class="col-12 text-center pt-5">
                <h2 class="mb-4">Post</h2>
            </div>
            
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="design-tab-pane" role="tabpanel" aria-labelledby="design-tab" tabindex="0">
                                <div class="row">
                                    @forelse ($posts as $item )
                                    <div class="col-lg-4 col-md-6 col-12 mb-4 mb-lg-3">
                                        <div class="custom-block bg-white shadow-lg">
                                            <a href="/blog/{{ $item['slug'] }}">
                                                <div class="">
                                                    <div>
                                                        <h6 class="mb-2 text-center">{{ Str::limit(strip_tags($item['title']), 70) }}</h6>
                                                        <p class="mb-0 text-center">{{ $item->author->name }}</p>
                                                        
                                                    </div>
                                                    <span class="badge bg-design rounded-pill ms-auto">1</span>
                                                </div>
                                                <img 
                                                src="{{ $item->category->image ? $item->category->image : asset('img/programmer_text_2.jpg') }}" 
                                                class="img-fluid rounded-top w-100 fixed-size mb-4" 
                                                alt="Category Image">
                                                <a href="/blog/{{ $item['slug'] }}" class="custom-btn btn">Read More</a>
                                            </a>
                                        </div>
                                    </div>
                                    @empty
                                        
                                    @endforelse
                                    
                                   
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="contact-section section-padding" id="section_6">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-12 mx-auto">
                        <h2 class="text-center mb-4">Contact</h2>
                        <div class="tab-content shadow-lg mt-5" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-ContactForm" role="tabpanel" aria-labelledby="nav-ContactForm-tab">
                                <form class="custom-form contact-form mb-5 mb-lg-0" action="#" method="POST" role="form">
                                    <div class="contact-form-body">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="Full name" required>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12">
                                                <input type="email" name="email" id="email" pattern="[^ @]*@[^ @]*" class="form-control" placeholder="Email address" required>
                                            </div>
                                        </div>
                                        <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required>
                                        <textarea name="message" rows="3" class="form-control" id="message" placeholder="Message"></textarea>
                                        <div class="col-lg-4 col-md-10 col-8 mx-auto">
                                            <button type="submit" class="form-control" id="submitbutton">Send message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="site-footer  section-padding">
        <div class="site-footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <img src="{{ asset('img/project/ndfproject-logo-white.png') }}" width="200px">
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-12 mb-4 pb-2">
                    <h5 class="site-footer-title mb-3">Links</h5>

                    <ul class="site-footer-links">
                        <li class="site-footer-link-item">
                            <a href="#" class="site-footer-link">Home</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="#" class="site-footer-link">About</a>
                        </li>

                        <li class="site-footer-link-item">
                            <a href="#" class="site-footer-link">Contact</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                    <h5 class="site-footer-title mb-3">Have a question?</h5>

                    <p class="text-white d-flex mb-1">
                        <a href="tel: 090-080-0760" class="site-footer-link">
                            058727785062
                        </a>
                    </p>

                    <p class="text-white d-flex">
                        <a href="mailto:grouparabis@gmail.com" class="site-footer-link">
                            grouparabis@gmail.com
                        </a>
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 col-11 mb-4 mb-lg-0 mb-md-0">
                    <h5 class="site-footer-title mb-3">Location</h5>
                    <p class="text-white d-flex mt-3 mb-2">
                        Condong Catur, Jogjakarta
                    </p>
                </div>
            </div>
        </div>

        <div class="site-footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-12 mt-5">
                        <p class="copyright-text text-center">Copyright &copy; <script>
								document.write(new Date().getFullYear());
							</script> | Arabis Group | <a href="https://ndfproject.my.id">NDFProject</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JAVASCRIPT FILES -->
    <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery/jquery.sticky.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script>
        function updateDateTime() {
            var currentDateTimeElement = document.getElementById('currentDateTime');
            var currentDate = new Date();
            var formattedDateTime = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getDate() +
                ' ' + currentDate.getHours() + ':' + currentDate.getMinutes() + ':' + currentDate.getSeconds();
            currentDateTimeElement.innerHTML = formattedDateTime;
        }

        setInterval(updateDateTime, 1000);

        // Initial call to set the initial value
        updateDateTime();
    </script>

</body>

</html>