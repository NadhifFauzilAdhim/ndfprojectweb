<x-layout>
  <x-slot:title>{{ $title }}</x-slot:title>
  
  <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 2000;">
    <div id="toastMessage" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
         
            <div class="toast-body">
              Cek My Blog <a href="/blog" class="link text-warning">Here</a>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
  </div>
     <!-- ======= About Section ======= -->
     <section id="hero" class="d-flex flex-column justify-content-center align-items-center">

      <div class="hero-container" data-aos="fade-in">
        <h1 class="">Nadhif Fauzil Adhim</h1>
        <p class="text-md-start">I'm <span class="typed" data-typed-items="Student, Tech Entusiast, Developer"></span></p>
        <div class="container">
      <div class="row justify-content-center">
        <div class="col-auto">
          <a class="btn btn-light rounded-pill py-2 px-3 px-md-5 mt-2 name-text" target="_blank" href="https://www.linkedin.com/in/nadhif-fauzil-adhim-99a330294">
            <i class="bi bi-linkedin ms-2"></i> LinkedIn
          </a>
        </div>
        <div class="col-auto">
          <a class="btn btn-dark rounded-pill py-2 px-3 px-md-5 mt-2" target="_blank" href="https://www.instagram.com/nadhif_f.a/">
            <i class="bi bi-instagram me-2"></i> Instagram
          </a>
        </div>
        <div class="col-auto">
          <a class="btn btn-dark rounded-pill py-2 px-3 px-md-5 mt-2 fw-bold" target="_blank" href="https://github.com/NadhifFauzilAdhim">
            <i class="bi bi-github ms-3"></i> GitHub
          </a>
        </div>
      </div>
  </div>
      </div>
      <div class="video-wrap">
        <video autoplay loop muted class="custom-video" poster="{{ asset('img/poster.png') }}">
          <source src="{{ asset('vid/bannervid.mp4') }}" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
  
    </section><!-- End Hero -->
     <section id="about" class="about">
        <div class="container">
  
          <div class="section-title">
            <h2>About</h2>
            <p>Hayy!! My name is Nadhif Fauzil Adhim. I am a computer science student at AMIKOM University. I have a strong interest in the world of technology, especially in the fields of Computer Science, Web Develoment, and IoT</p>
          </div>
  
          <div class="row">
            <div class="col-lg-4" data-aos="fade-right">
              <img src="img/author.png" class="img-fluid author-image" alt="">
            </div>
            <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
              <h3>Web Developer &amp; IoT Entusiast</h3>
              <p class="fst-italic">
                As a UI/UX & Web Developer, I am passionate about creating engaging and user-friendly digital experiences
              </p>
              <div class="row">
                <div class="col-lg-6">
                  <ul>
                    <li><i class="bi bi-chevron-right"></i> <strong>Birthday:</strong> <span>10 Nov 2003</span></li>
                    <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong> <span>www.ndfproject.my.id</span></li>
                    <li><i class="bi bi-chevron-right"></i> <strong>Phone:</strong> <span>+62 8572 7785 062</span></li>
                    <li><i class="bi bi-chevron-right"></i> <strong>City:</strong> <span>Kulon Progo</span></li>
                  </ul>
                </div>
                <div class="col-lg-6">
                  <ul>
                    <li><i class="bi bi-chevron-right"></i> <strong>Age:</strong> <span id="umurSpan">20</span></li>
                    <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong> <span>Bachelor</span></li>
                    <li><i class="bi bi-chevron-right"></i> <strong>PhEmailone:</strong> <span>analyticgames@gmail.com</span></li>
                  </ul>
                </div>
              </div>
              <p>
                The selection of tasks and the commitment to overcoming challenges are integral parts of my developmental journey. I am always enthusiastic about delivering creative solutions and approaching each task with determination and dedication.
              </p>
            </div>
          </div>
  
        </div>
      </section><!-- End About Section -->
  
      <!-- ======= Facts Section ======= -->
      <section id="facts" class="facts">
        <div class="container">
  
          <div class="section-title">
            <h2>Static</h2>
            <p>Static overview detailing the number of projects, certificates, and skills that I have successfully completed, providing a comprehensive snapshot of my accomplishments in these areas.</p>
          </div>
  
          <div class="row justify-content-md-center no-gutters">
  
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up">
                    <div class="count-box">
                        <i class="bi bi-trophy"></i>
                        <span data-purecounter-start="0" data-purecounter-end="16" data-purecounter-duration="1" class="purecounter"></span>
                        <p><strong>Certificate</strong></p>
                    </div>
                </div>
    
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="100">
                    <div class="count-box">
                        <i class="bi bi-file-arrow-up"></i>
                        <span data-purecounter-start="0" data-purecounter-end="7" data-purecounter-duration="1" class="purecounter"></span>
                        <p><strong>Projects</strong></p>
                    </div>
                </div>
    
                <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch" data-aos="fade-up" data-aos-delay="200">
                    <div class="count-box">
                        <i class="bi bi-lightbulb"></i>
                        <span data-purecounter-start="0" data-purecounter-end="4" data-purecounter-duration="1" class="purecounter"></span>
                        <p><strong>Skills Mastered</strong></p>
                    </div>
                </div>
          </div>
  
        </div>
      </section><!-- End Facts Section -->
  
      <!-- ======= Skills Section ======= -->
      <section id="skills" class="skills section-bg">
        <div class="container">
  
          <div class="section-title">
            <h2>Learing Progress</h2>
            <p>Currently expanding my skills through learning initiatives in web development and the Internet of Things (IoT). </p>
          </div>
  
          <div class="row skills-content">
  
            <div class="col-lg-6" data-aos="fade-up">
  
              <div class="progress">
                <span class="skill">Bootstrap <i class="val">95%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar --bs-primary-bg-subtle" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
  
              <div class="progress">
                <span class="skill">JavaScript<i class="val">85%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
  
              <div class="progress">
                <span class="skill">Laravel<i class="val">90%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
  
            </div>
  
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
  
              <div class="progress">
                <span class="skill">PHP <i class="val">95%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
  
              <div class="progress">
                <span class="skill">MySql <i class="val">95%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
  
              <div class="progress">
                <span class="skill">Python <i class="val">70%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
              <div class="progress">
                <span class="skill">C++ &amp; C# <i class="val">70%</i></span>
                <div class="progress-bar-wrap">
                  <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
              </div>
  
  
            </div>
  
          </div>
  
        </div>
      </section><!-- End Skills Section -->
  
      <!-- ======= Resume Section ======= -->
      <section id="resume" class="resume">
        <div class="container">
  
          <div class="section-title">
            <h2>Resume</h2>
          </div>
  
          <div class="row">
            <div class="col-lg-6" data-aos="fade-up">
              <h3 class="resume-title">Sumary</h3>
              <div class="resume-item pb-0">
                <h4>Nadhif Fauzil Adhim</h4>
                <p><em>undergraduate student majoring in Computer Science, I am deeply passionate about the field of Information Technology (IT). My academic journey revolves around gaining a solid foundation in computer science principles, algorithms, and data structures</em></p>
                <ul>
                  <li>Kulon Progo, Yogyakarta, 55672</li>
                  <li>(62) 85 727 785 062</li>
                  <li>analyticgames@gmail.com</li>
                </ul>
              </div>
  
              <h3 class="resume-title">Education</h3>
              <div class="resume-item">
                <h4>Bachelor of informatics</h4>
                
                <h5>2022 </h5>
                <p><em>Universitas Amikom Yogyakarta</em></p>
             
                  <p>GPA: 3.8/4.0</p>
             
                <p>
                  Currently pursuing my Bachelor's degree in Informatics at Universitas Amikom Yogyakarta, I am developing a strong foundation in computer science principles and gaining practical insights to thrive in the evolving field of Information Technology.
                </p>
              </div>
              <div class="resume-item">
                <h4>STUDENT HIGH SCHOOL</h4>
                <h5>2019 - 2022</h5>
                <p><em>SMA Negeri 1 Kalibawang</em></p>
                <p> I engaged in diverse academic subjects and extracurricular activities, honing my skills and cultivating a strong foundation for future endeavors. The experiences gained during this time have contributed significantly to my personal and academic growth.</p>
              </div>
            </div>
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
              <h3 class="resume-title">Experience</h3>
              <div class="resume-item">
                <h4>SAMSUNG INNOVATION CAMPUS batch 5</h4>
                <h5>2024</h5>
                <p><em>Samsung Innovation Campus Batch 5 AI & IoT Stage 1 - 3</em></p>
                <ul>
                  <li>Participated in the Samsung Innovation Campus Batch 5 2024. The program focused on providing an in-depth understanding of Artificial Intelligence (AI) and its practical applications. Gained knowledge on integrating AI with Internet of Things (IoT) technologies, creating smart solutions that enhance IoT devices to be more intelligent and autonomous.</li>
                  
                </ul>
              </div>
              <div class="resume-item">
                <h4>Lab Assistant</h4>
                <h5>2023 - 2024</h5>
                <p><em>Universitas Amikom Yogyakarta</em></p>
                <ul>
                  <li>Lead the instruction and guidance on programming languages, focusing on Algorithms and Programming, Advanced Programming, Microcontrollers, and Database Systems.</li>
                  <li>Crafted and delivered engaging curriculum content, tailored to these subjects, to support student learning and skill development.</li>
                  <li>Provided hands-on assistance, supervised project work, and assessed students' progress to foster a collaborative and interactive learning environment.</li>
                </ul>
              </div>
              <div class="resume-item">
                <h4>STUDENT COUNCIL (OSIS) TECHNOLOGY INFORMATION SECTION</h4>
                <h5>2020-2022</h5>
                <p><em>SMA Negeri 1 Kalibawang</em></p>
                <ul>
                  <li>Developing and implementing various marketing programs, including logos, brochures, infographics, and presentations, to enhance communication between OSIS and the student .</li>
                </ul>
              </div>
            </div>
          </div>
  
        </div>
      </section>
      <section id="portfolio" class="portfolio section-bg">
        <div class="container">
            <div class="section-title">
                <h2>Certificate</h2>
                <p>These certificates reflect a commitment to continuous learning</p>
            </div>
    
            <!-- Slider main container -->
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <!-- Slides -->
                    <div class="swiper-slide">
                        <div class="portfolio-item Web-dev featured">
                            <div class="portfolio-wrap">
                                <img src="certificate/SertifikatAMCC.jpeg" class="img-fluid" alt="">
                                <div class="portfolio-links">
                                    <a href="https://amcc.or.id" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
    
                   
                    <!-- Contoh slide kedua -->
                    <div class="swiper-slide">
                        <div class="portfolio-item featured">
                            <div class="portfolio-wrap">
                                <img src="certificate/SertifikatAsisten.jpeg" class="img-fluid" alt="">
                                <div class="portfolio-links">
                                    <a href="https://forumasisten.or.id/sertifikat/4871198960f1f156a5/show" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                      <div class="portfolio-item featured">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatAsisten.jpeg" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a  href="https://forumasisten.or.id/sertifikat/4871198960f1f156a5/show" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="portfolio-item featured">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatMikro.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a  href="https://forumasisten.or.id/sertifikat/5601646117cee6daa5d/show" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="portfolio-item featured">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatSBD.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a  href="https://forumasisten.or.id/sertifikat/707151011e6d5f4f3c8/show" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="portfolio-item featured IoT">
                        <div class="portfolio-wrap">
                          <img src="certificate/SICStage1.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href=" " target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="portfolio-item featured IoT">
                        <div class="portfolio-wrap">
                          <img src="certificate/SICStage2.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href=" " target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="portfolio-item featured IoT">
                        <div class="portfolio-wrap">
                          <img src="certificate/SICStage3.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href=" " target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">
                      <div class="portfolio-item">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatPythonAlgorithm.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://badgr.com/public/assertions/-5JsF-_9TjC-ITtVvv_8rg?identity__email=nadya15a3@gmail.com" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="swiper-slide">

                      <div class="portfolio-item IoT ">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatPythonDasar.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://badgr.com/public/assertions/fhm-f9N4RkWAtFsj1h9w7w?identity__email=nadya15a3@gmail.com" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">

                      <div class="portfolio-item IoT ">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatPythonLanjut.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://badgr.com/public/assertions/M6e1x0CoRFK9JkCoJecclw?identity__email=nadya15a3@gmail.com" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">

                      <div class="portfolio-item IoT ">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatIoT.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://badgr.com/public/assertions/LK1xozEMTHSsqSI38ch93A?identity__email=nadya15a3@gmail.com" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">

                      <div class="portfolio-item IoT ">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatIoTFundamental.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://badgr.com/public/assertions/LK1xozEMTHSsqSI38ch93A?identity__email=nadya15a3@gmail.com" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">

                      <div class="portfolio-item IoT ">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatIoTSoftware.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://badgr.com/public/assertions/z_YkmXG6RPuXybWMOUgUJw?identity__email=nadya15a3@gmail.com" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">

                      <div class="portfolio-item Web-dev ">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatFrontEnd.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://www.dicoding.com/certificates/2VX34365NZYQ" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">

                      <div class="portfolio-item IoT ">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatIoTHealthMonitoringSystem.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://badgr.com/public/assertions/1ey6ROu9T3C6yRBtcc1tUQ?identity__email=nadya15a3@gmail.com" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">

                      <div class="portfolio-item Web-dev ">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatFrontEndJavascript.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://www.dicoding.com/certificates/EYX4J09JWZDL" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="swiper-slide">

                      <div class="portfolio-item Web-dev ">
                        <div class="portfolio-wrap">
                          <img src="certificate/SertifikatReact.png" class="img-fluid" alt="">
                          <div class="portfolio-links">
                            <a href="https://www.dicoding.com/certificates/N9ZOY11VYPG5" target="_blank"><i class="bi bi-check2-square"> </i>
                              <h6>Check Credential</h6>
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>
    
  <section id="project" class="project">
      <div class="container-fluid blog ">
              <div class="container ">
                  <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.2s" style="max-width: 800px;">
                      <h1 class="display-4 mb-4">Project</h1>
                      <p class="mb-0">In the ever-evolving world of technology development, we are dedicated to creating innovative solutions that blend creativity with advanced technology.
                      </p>
                  </div>
                  <div class="row g-4 justify-content-center">
                      <div class="col-lg-6 col-xl-4 wow fadeInUp d-flex align-items-stretch" data-aos-delay="100">
                          <div class="blog-item w-100">
                              <div class="blog-img">
                                  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                      <div class="carousel-item active">
                                      <img src="img/project/kostifyadv.png" class="img-fluid rounded-top w-100" alt="">
                                      </div>
                                      <div class="carousel-item">
                                      <img src="img/project/kostifyadv1.png" class="img-fluid rounded-top w-100" alt="">
                                      </div>
                                      <div class="carousel-item">
                                      <img src="img/project/kostifyadv2.png" class="img-fluid rounded-top w-100" alt="">
                                      </div>
                                    </div>
                                  </div>
                                  <div class="blog-categiry py-2 px-4">
                                      <span>Web Apps</span>
                                  </div>
                              </div>
                              <div class="blog-content p-4">
                                  <div class="blog-comment d-flex justify-content-between mb-3">
                                      <div class="small"><span class="bi bi-code-slash text-primary"></span> Nadhif Fauzil A</div>
                                      <div class="small"><span class="bi bi-globe-americas text-primary"></span> Open Source</div>
                                      <div class="small"><span class="bi bi-calendar2-check text-primary"></span> Juni 2024</div>
                                  </div>
                                  
                                  <a href="https://github.com/NadhifFauzilAdhim/Kostify-Aplikasi-Cari-Kost-Native" class="h4 d-inline-block mb-3">Kostify: Cari Tempat Tinggal Dan Property dengan mudah</a>
                                  <p class="mb-3"> tememukan kost atau tempat tinggal ideal Anda hanya dengan beberapa klik saja. Nikmati kemudahan dan kecepatan dalam mencari tempat tinggal impian Anda tanpa ribet.</p>
                                  {{-- <a href="https://github.com/NadhifFauzilAdhim/Kostify-Aplikasi-Cari-Kost-Native" class="btn p-0">Github  <i class="bi bi-arrow-right"></i></a> --}}
                                  <a href="https://github.com/NadhifFauzilAdhim/Kostify-Aplikasi-Cari-Kost-Native" class="btn btn-sm btn-outline-dark me-2">
                                    <i class="bi bi-github"></i> Source Code
                                  </a>
                                  <a href="https://kostify.my.id" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Website
                                  </a>
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-6 col-xl-4 wow fadeInUp d-flex align-items-stretch" data-aos-delay="100">
                          <div class="blog-item w-100">
                              <div class="blog-img">
                                  <!-- <img src="img/project/hydroeaselogo.png" class="img-fluid rounded-top w-100" alt=""> -->
                                  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                      <div class="carousel-item active">
                                      <img src="img/project/hydroeaselogo.png" class="img-fluid rounded-top w-100" alt="">
                                      </div>
                                      <div class="carousel-item">
                                      <img src="img/project/hydroeasepic1.png" class="img-fluid rounded-top w-100" alt="">
                                      </div>
                                      <div class="carousel-item">
                                      <img src="img/project/hydroeasepic2.png" class="img-fluid rounded-top w-100" alt="">
                                      </div>
                                    </div>
                                  
                                  </div>
                                  <div class="blog-categiry py-2 px-4">
                                      <span>IoT</span>
                                  </div>
                              </div>
                              <div class="blog-content p-4">
                                  <div class="blog-comment d-flex justify-content-between mb-3">
                                  <div class="small"><span class="bi bi-code-slash text-primary"></span> Arabis Group</div>
                                  <div class="small"><span class="bi bi-globe-americas text-primary"></span> Open Colab</div>
                                  <div class="small"><span class="bi bi-calendar2-check text-primary"></span> Februari 2024</div>
                                  </div>
                                  <a href="https://launchinpad.com/project/hydroease-hydroponic-efficiency-automation-8dafb66" class="h4 d-inline-block mb-3">HydroEase: Hydroponic Efficiency Automated System</a>
                                  <p class="mb-3">HydroEase menggabungkan hidroponik dengan kenyamanan IoT, mengajak Anda untuk menanam tanaman yang lebih sehat dan berkelanjutan dengan mudah. </p>
                                  <a href="https://launchinpad.com/project/hydroease-hydroponic-efficiency-automation-8dafb66" class="btn btn-sm btn-outline-dark me-2">
                                    <i class="bi bi-file-earmark-code"></i> Documentation
                                  </a>
                                  
                              </div>
                          </div>
                      </div>
                      <div class="col-lg-6 col-xl-4 wow fadeInUp d-flex align-items-stretch" data-aos-delay="100">
                          <div class="blog-item w-100">
                              <div class="blog-img">
                                  <img src="img/project/Linksyproject.png" class="img-fluid rounded-top w-100" alt="">
                                  <div class="blog-categiry py-2 px-4">
                                      <span>Web Apps</span>
                                  </div>
                              </div>
                              <div class="blog-content p-4">
                                  <div class="blog-comment d-flex justify-content-between mb-3">
                                  <div class="small"><span class="bi bi-code-slash text-primary"></span> Nadhif Fauzil A</div>
                                      <div class="small"><span class="bi bi-globe-americas text-primary"></span> Open Source</div>
                                      <div class="small"><span class="bi bi-calendar2-check text-primary"></span> Desember 2024</div>
                                  </div>
                                  <a href="{{ route('ipdocuments') }}" class="h4 d-inline-block mb-3">Linksy Link Management</a>
                                  <br>
                                  <p class="mb-5">Linksy transforms your URLs into powerful, shareable links. Whether you're tracking campaigns or simplifying sharing, we’ve got you covered with the smartest link management tool.</p>

                                  <a href="https://linksy.site/apidocumentation" class="btn btn-sm btn-outline-dark me-2">
                                    <i class="bi bi-file-earmark-code"></i> Documentation
                                  </a>
                                  <a href="https://linksy.site" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Website
                                  </a>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
      <section id="testimonials" class="testimonials section-bg">
        <div class="container">
  
          <div class="section-title">
            <h2>Arabis Group Member</h2>
            <p>Arabis Group is a team of computer science students who are driven by passion and share a common objective of personal growth and making significant contributions to the field of information technology. As a group, we strive to create a dynamic environment where members can learn, collaborate, and excel in their respective areas of interest within the realm of technology. We firmly believe that by coming together, we can achieve far greater heights than we could individually.</p>
          </div>
  
          <div class="testimonials-slider " data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="testimonial-item" data-aos="fade-up">
                  <img src="img/member/nadhif.png" class="testimonial-img" alt="">
                  <h3>Nadhif Fauzil Adhim</h3>
                  <h4>Backend Developer</h4>
                </div>
              </div><!-- End testimonial item -->
  
              <div class="swiper-slide">
                <div class="testimonial-item" data-aos="fade-up" data-aos-delay="100">
                  <img src="img/member/ferdi.png" class="testimonial-img" alt="">
                  <h3>Dwi Ferdiyanto</h3>
                  <h4>Informatics Student</h4>
                </div>
              </div><!-- End testimonial item -->
  
              <div class="swiper-slide">
                <div class="testimonial-item" data-aos="fade-up" data-aos-delay="200">
                  <img src="img/member/julian.png" class="testimonial-img" alt="">
                  <h3>Julian Kiyosaki H</h3>
                  <h4>Mobile Developer</h4>
                </div>
              </div><!-- End testimonial item -->
  
              <div class="swiper-slide">
                <div class="testimonial-item" data-aos="fade-up" data-aos-delay="300">
                  <img src="img/member/aji.png" class="testimonial-img" alt="">
                  <h3>Muhajir Faturrahman</h3>
                  <h4>Multimedia</h4>
                </div>
              </div><!-- End testimonial item -->
  
              <div class="swiper-slide">
                <div class="testimonial-item" data-aos="fade-up" data-aos-delay="400">
  
                  <img src="img/member/arip.png" class="testimonial-img" alt="">
                  <h3>Rif'aa Surososastro</h3>
                  <h4>Informatics Student</h4>
                </div>
              </div><!-- End testimonial item -->
  
            </div>
            <div class="swiper-pagination"></div>
          </div>
  
        </div>
      </section><!-- End Testimonials Section -->
  
      <!-- ======= Contact Section ======= -->
      <section id="contact" class="contact">
        <div class="container">
  
          <div class="section-title">
            <h2>Contact</h2>
            <p>
              You can contact me through</p>
          </div>
  
          <div class="row" data-aos="fade-in">
  
            <div class="col-lg-5 d-flex align-items-stretch">
              <div class="info">
                <div class="address">
                  <i class="bi bi-geo-alt"></i>
                  <h4>Location:</h4>
                  <p>Kulon Progo, Yogyakarta, 55672</p>
                </div>
  
                <div class="email">
                  <i class="bi bi-envelope"></i>
                  <h4>Email:</h4>
                  <p>analyticgames@gmail.com</p>
                </div>
  
                <div class="phone">
                  <i class="bi bi-phone"></i>
                  <h4>Call:</h4>
                  <p>+62 8572 7785 062</p>
                </div>
  
                <iframe src="https://maps.google.com/maps?q=kalibawang&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
              </div>
  
            </div>
  
            <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
              <form action="" method="POST" role="form" class="php-email-form">
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="name">Your Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="name">Your Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                  </div>
                </div>
                <div class="form-group">
                  <label for="name">Subject</label>
                  <input type="text" class="form-control" name="subject" id="subject" required>
                </div>
                <div class="form-group">
                  <label for="name">Message</label>
                  <textarea class="form-control" name="message" rows="10" id="message" required></textarea>
                </div>
                <div class="my-3">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>
                </div>
                <div class="text-center"><button type="submit" id="btn-submit">Send Message</button></div>
              </form>
              <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000" id="liveToastMailSend">
                <div class="toast-body">
                  <div class="sent-message alert alert-success" role="alert">Your message has been sent. Thank you!</div>
                  <div class="error-message alert alert-danger" role="alert"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section><!-- End Contact Section -->  
      <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.getElementById('toastMessage');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    </script>

    
</x-layout>