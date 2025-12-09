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
     <section id="hero" class="d-flex flex-column justify-content-center align-items-center position-relative text-center vh-100">
  
      <div class="hero-overlay"></div>
    
      <div class="hero-container" data-aos="fade-in">
        <h1>Nadhif Fauzil Adhim</h1>
        <p>I'm <span class="typed fw-bold" data-typed-items="Backend Dev, Web Dev, Machine Learning Enthusiast, Assistant Lecturer"></span></p>
        
        <div class="d-flex flex-wrap justify-content-center gap-3 mt-3" data-aos="fade-up" data-aos-delay="200">
          <a class="btn btn-light rounded-pill py-2 px-4 d-flex align-items-center justify-content-center" target="_blank" href="https://www.linkedin.com/in/nadhif-fauzil-adhim-99a330294">
            <i class="bi bi-linkedin"></i> <span class="d-none d-md-inline ms-2 name-text">LinkedIn</span>
          </a>
          <a class="btn btn-dark rounded-pill py-2 px-4 d-flex align-items-center justify-content-center" target="_blank" href="https://www.instagram.com/nadhif_f.a/">
            <i class="bi bi-instagram"></i> <span class="d-none d-md-inline ms-2">Instagram</span>
          </a>
          <a class="btn btn-dark rounded-pill py-2 px-4 fw-bold d-flex align-items-center justify-content-center" target="_blank" href="https://github.com/NadhifFauzilAdhim">
            <i class="bi bi-github"></i> <span class="d-none d-md-inline ms-2">GitHub</span>
          </a>
          
          <div class="dropdown">
            <button class="btn btn-dark rounded-pill py-2 px-4 fw-bold d-flex align-items-center justify-content-center " type="button" id="downloadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-download"></i> <span class="d-none d-md-inline ms-2">Download</span>
            </button>
            <ul class="dropdown-menu bg-dark" aria-labelledby="downloadDropdown">
              <li><a class="dropdown-item text-light bg-transparent" href="https://linksy.site/cv" target="_blank"><i class="bi bi-file-earmark-person me-1"></i>CV</a></li>
              <li><a class="dropdown-item text-light bg-transparent" href="https://linksy.site/portofolio" target="_blank"><i class="bi bi-card-text me-1"></i>Portofolio</a></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="video-wrap position-absolute w-100 h-100 top-0 start-0 z-n1">
        <video autoplay loop muted class="custom-video w-100 h-100 object-fit-cover" poster="{{ asset('img/poster.png') }}">
          <source src="{{ asset('vid/bannervid.mp4') }}" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    
      <div class="scroll-down">
        <a href="#about"><i class="bi bi-chevron-down"></i></a>
      </div>
    
    </section>
     <section id="about" class="about">
        <div class="container py-auto">
  
          <div class="section-title" data-aos="fade-right" data-aos-delay="200">
            <h2>About</h2>
            <p>Hayy!! My name is Nadhif Fauzil Adhim. I am a Computer Science student at Universitas Amikom Yogyakarta with a deep passion for technology and innovation. My primary areas of interest include Web Development, Backend Systems, Internet of Things (IoT), and Machine Learning. I believe technology has the power to solve real-world problems and improve lives, and I am eager to be part of that transformation.

            <br><br> Currently, I am focusing on developing my skills in building scalable and secure web applications, exploring IoT solutions that bridge the digital and physical worlds, and learning how Machine Learning can be applied to create intelligent, data-driven systems. I enjoy working on projects that challenge me to learn new technologies, design efficient architectures, and deliver solutions that are both user-centric and impactful.

            As a lifelong learner.</p>
          </div>
  
          <div class="row">
            <div class="col-lg-4" data-aos="fade-right" data-aos="fade-up" data-aos-delay="200">
              <img data-src="img/author.png" class="img-fluid author-image lazyload" alt="">
            </div>
            <div class="col-lg-8 pt-4 pt-lg-0 content" data-aos="fade-left">
              <h3>Web Developer &amp; Machine Learning Enthusiast</h3>
              <p class="fst-italic">
                I am passionate about creating engaging and user-friendly digital experiences
              </p>
              <div class="row">
                <div class="col-lg-6">
                  <ul>
                    <li><i class="bi bi-chevron-right"></i> <strong>Website:</strong> <span><a href="https://www.ndfproject.my.id" target="_blank">www.ndfproject.my.id</a></span></li>
                    <li><i class="bi bi-chevron-right"></i> <strong>City:</strong> <span>Kulon Progo, Yogyakarta</span></li>
                    <li><i class="bi bi-chevron-right"></i> <strong>Degree:</strong> <span>Bachelor</span></li>
                    <li><i class="bi bi-chevron-right"></i> <strong>Email:</strong> <span><a href="mailto:nadhifauziladhim@gmail.com">nadhifauziladhim@gmail.com</a></span></li>
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
  
          <div class="section-title" data-aos="fade-up" data-aos-delay="200">
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
      <style>.skills{padding:60px 0}.section-title h2{font-size:32px;font-weight:700;margin-bottom:20px;padding-bottom:20px;position:relative;color:#333}.section-title p{margin-bottom:30px}.skills .swiper-slide{height:auto;text-align:center}.skills .skill-wrapper{background:#fff;padding:30px;border-radius:8px;height:100%;display:flex;flex-direction:column;justify-content:center;align-items:center;transition:transform .3s}.skills .skill-wrapper:hover{transform:translateY(-5px)}.skills .skill-wrapper img{height:40px;margin:0 5px 15px}.skills .skill-wrapper h4{font-size:16px;font-weight:700;margin:0 0 10px}.skills .skill-wrapper p{font-style:italic;color:#6c757d;font-size:14px;margin:0}.skills .swiper-pagination{position:static;margin-top:25px}.skills .swiper-pagination-bullet{width:12px;height:12px;background-color:#ddd;opacity:1}.skills .swiper-pagination-bullet-active{background-color:#007bff}.skills .skill-wrapper:has(img + img){flex-wrap:wrap;flex-direction:row;justify-content:center}.skills .skill-wrapper:has(img + img) img{margin-bottom:15px;margin-left:8px;margin-right:8px}.skills .skill-wrapper:has(img + img) h4,.skills .skill-wrapper:has(img + img) p{flex-basis:100%;text-align:center}</style>
      <section id="skills" class="skills section-bg">
        <div class="container">
      
          <div class="section-title" data-aos="fade-up">
            <h2>Skills & Expertise</h2>
            <p>My skills are organized by development fields, showcasing my focus on creating integrated solutions across different technology platforms.</p>
          </div>
      
          <div class="swiper skills-swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">
              
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg" class="lazyload" alt="Laravel">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/livewire/livewire-original.svg" class="lazyload" alt="Livewire">
                  <h4>Laravel & Livewire</h4>
                  <p>Advanced</p>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vuejs/vuejs-original.svg" class="lazyload" alt="VueJS">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg" class="lazyload" alt="React">
                  <h4>Vue & React</h4>
                  <p>Intermediate</p>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/bootstrap/bootstrap-original.svg" class="lazyload" alt="Bootstrap">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg" class="lazyload" alt="Tailwind CSS">
                  <h4>Bootstrap & Tailwind</h4>
                  <p>Advanced</p>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg" class="lazyload" alt="MySQL">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg" class="lazyload" alt="PostgreSQL">
                  <h4>MySQL & PostgreSQL</h4>
                  <p>Advanced</p>
                </div>
              </div>
      
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg" class="lazyload" alt="Python">
                  <h4>Python</h4>
                  <p>Intermediate</p>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tensorflow/tensorflow-original.svg" class="lazyload" alt="TensorFlow">
                  <h4>TensorFlow</h4>
                  <p>Intermediate</p>
                </div>
              </div>
              
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/kotlin/kotlin-original.svg" class="lazyload" alt="Kotlin">
                  <h4>Kotlin</h4>
                  <p>Intermediate</p>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/cplusplus/cplusplus-original.svg" class="lazyload" alt="C++">
                  <h4>C++</h4>
                  <p>Intermediate</p>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/arduino/arduino-original.svg" class="lazyload" alt="Arduino">
                  <h4>Arduino</h4>
                  <p>Advanced</p>
                </div>
              </div>
      
              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/docker/docker-original.svg" class="lazyload" alt="Docker">
                  <h4>Docker</h4>
                  <p>Intermediate</p>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/postman/postman-original.svg" class="lazyload" alt="Postman">
                  <h4>Postman</h4>
                  <p>Advanced</p>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/git/git-original.svg" class="lazyload" alt="Git">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/github/github-original.svg" class="lazyload" alt="GitHub">
                  <h4>Git & GitHub</h4>
                  <p>Advanced</p>
                </div>
              </div>

              <div class="swiper-slide">
                <div class="skill-wrapper">
                  <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/figma/figma-original.svg" class="lazyload" alt="Figma">
                  <h4>Figma</h4>
                  <p>Intermediate</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    <style>
      .skills-category-title {
        font-size: 24px;
        font-weight: 600;
        color: #37517e;
        margin-bottom: 0;
      }
      .skills-hr {
        margin-top: 5px;
        margin-bottom: 15px;
        border: 0;
        border-top: 2px solid #eef0f2;
      }
      .skill-wrapper img {
        height: 40px; /* Menyeragamkan tinggi ikon */
        margin: 0 5px 15px 5px; /* Memberi jarak antar ikon */
      }
    </style>
      <!-- ======= Resume Section ======= -->
      <section id="resume" class="resume">
        <div class="container py-5">
          <div class="section-title" data-aos="fade-up" data-aos-delay="200">
            <h2>Resume</h2>
            <p>
              Discover my academic journey, professional experiences, and key accomplishments that define my expertise and passion in the field of technology.
            </p>
          </div>
          <div class="row">
            
            <div class="col-lg-6" data-aos="fade-up">
              
              <h3 class="resume-title">Summary</h3>
              <div class="resume-item pb-0">
                <h4>Nadhif Fauzil Adhim</h4>
                <p><em>An undergraduate student majoring in Computer Science at Universitas Amikom Yogyakarta, passionate about Information Technology (IT), web development, IoT, and machine learning. Experienced as a Lab Assistant, facilitating practical learning, assisting students with troubleshooting, and enhancing their understanding of technical concepts. Committed to continuous learning and innovation in the tech industy</em></p>
                <ul>
                  <li>Kulon Progo, Yogyakarta, 55672</li>
                  <li><a href="tel:+6285727785062">+62 8572 7785 062</a></li>
                  <li><a href="mailto:nadhifauziladhim@gmail.com">nadhifauziladhim@gmail.com</a></li>
                </ul>
              </div>
      
              <h3 class="resume-title">Achievements & Organizational</h3>
              <div class="resume-item">
                <h4>SAMSUNG INNOVATION CAMPUS batch 5</h4>
                <h5>2024</h5>
                <p><em>Samsung Innovation Campus Batch 5 AI & IoT Stage 1 - 3</em></p>
                <ul>
                  <li>Participated in the Samsung Innovation Campus Batch 5 2024. The program focused on providing an in-depth understanding of Artificial Intelligence (AI) and its practical applications. Gained knowledge on integrating AI with Internet of Things (IoT) technologies, creating smart solutions that enhance IoT devices to be more intelligent and autonomous.</li>
                </ul>
              </div>
              <div class="resume-item">
                <h4>FLS2N (National Art & Culture Competition)</h4>
                <h5>2020-2021</h5>
                <p><em>Ministry of Education and Culture Republic of Indonesia</em></p>
                <ul>
                  <li>Achieved <strong>1st place</strong> at the provincial level and <strong>8th place</strong> at the national level in the film category.</li>
                  <li>Worked collaboratively in a team to create a short film, handling scriptwriting, directing, and editing.</li>
                  <li>Developed strong storytelling and multimedia production skills through the competition.</li>
                </ul>
              </div>
              <div class="resume-item">
                <h4>STUDENT COUNCIL (OSIS) TECHNOLOGY INFORMATION</h4>
                <h5>2020-2022</h5>
                <p><em>SMA Negeri 1 Kalibawang</em></p>
                <ul>
                  <li>Developing and implementing various marketing programs, including logos, brochures, infographics, and presentations, to enhance communication between OSIS and the student .</li>
                </ul>
              </div>
            </div>
            
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
              
              <h3 class="resume-title">Education</h3>
              <div class="resume-item">
                <h4>Bachelor of Informatics</h4>
                <h5>2022 </h5>
                <p><em>Universitas Amikom Yogyakarta</em></p>
                <ul>
                  <li>GPA: 3.8/4.0</li>
                  <li>Gaining expertise in computer science principles, algorithms, and data structures.</li>
                  <li>Serving as an Assistant Lecturer, guiding students in Algorithms and Programming, Advanced Programming, Microcontrollers, Web Programming, and Database Systems.</li>
                </ul>
              </div>
              <div class="resume-item">
                <h4>STUDENT HIGH SCHOOL</h4>
                <h5>2019 - 2022</h5>
                <p><em>SMA Negeri 1 Kalibawang</em></p>
                <ul>
                  <li>Engaged in various academic subjects and extracurricular activities.</li>
                  <li>Actively participated in student organizations, developing leadership and teamwork skills.</li>
                </ul>
              </div>
              
              <h3 class="resume-title">Professional Experience</h3>
              
              <div class="resume-item">
                <h4>Technical Support</h4>
                <h5>2025</h5>
                <p><em>Universitas Amikom Yogyakarta | Unit Pelayanan Teknis</em></p>
                <ul>
                  <li>Monitored and maintained the operational stability of university systems, hardware, and network infrastructure.</li>
                  <li>Managed and troubleshot hardware and software to ensure smooth daily operations.</li>
                  <li>Provided prompt technical support to university staff and students, resolving IT-related issues effectively to minimize downtime.</li>
                </ul>
              </div>
              <div class="resume-item">
                <h4>Assistant Lecturer</h4>
                <h5>2023 - 2025</h5>
                <p><em>Universitas Amikom Yogyakarta | Forum Asisten</em></p>
                <ul>
                  <li>Lead the instruction and guidance on programming languages, focusing on Algorithms and Programming, Advanced Programming, Microcontrollers, Web Programming and Database Systems.</li>
                  <li>Crafted and delivered engaging curriculum content, tailored to these subjects, to support student learning and skill development.</li>
                  <li>Provided hands-on assistance, supervised project work, and assessed students' progress to foster a collaborative and interactive learning environment.</li>
                </ul>
              </div>
              
            </div>
            
          </div>
        </div>
      </section>
      <section id="portfolio" class="portfolio section-bg" data-aos="fade-up" data-aos-delay="200">
        <div class="container py-5">
            <div class="section-title">
                <h2>Certificate</h2>
                <p>These certificates reflect a commitment to continuous learning</p>
            </div>
            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
    
                    <div class="swiper-slide">
                        <div class="portfolio-item Web-dev featured">
                            <div class="portfolio-wrap overflow-hidden">
                                <img data-src="certificate/SertifikatAMCC.jpeg" class="img-fluid lazyload" alt="Sertifikat Keanggotaan AMCC">
                                <div class="portfolio-links">
                                    <a href="https://amcc.or.id" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Web Development Bootcamp</h4>
                                    <p class="small text-body-secondary mb-0">AMCC</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item featured">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatAsisten.jpeg" class="img-fluid lazyload" alt="Sertifikat Asisten Praktikum">
                                <div class="portfolio-links">
                                    <a href="https://forumasisten.or.id/sertifikat/4871198960f1f156a5/show" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Asisten Praktikum Algoritma & Pemrograman</h4>
                                    <p class="small text-body-secondary mb-0">Forum Asisten</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item featured">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatMikro.png" class="img-fluid lazyload" alt="Sertifikat Asisten Mikrokontroler">
                                <div class="portfolio-links">
                                    <a href="https://forumasisten.or.id/sertifikat/5601646117cee6daa5d/show" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Asisten Praktikum Mikrokontroler</h4>
                                    <p class="small text-body-secondary mb-0">Forum Asisten</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item featured">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatSBD.png" class="img-fluid lazyload" alt="Sertifikat Asisten Sistem Basis Data">
                                <div class="portfolio-links">
                                    <a href="https://forumasisten.or.id/sertifikat/707151011e6d5f4f3c8/show" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Asisten Praktikum Sistem Basis Data</h4>
                                    <p class="small text-body-secondary mb-0">Forum Asisten</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item featured IoT">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SICStage1.png" class="img-fluid lazyload" alt="Sertifikat Shell Idea Challenge Stage 1">
                                <div class="portfolio-links">
                                    <a href="#" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Samsung Innovation Campus Batch 5 AI & IoT Stage 1 - 3</h4>
                                    <p class="small text-body-secondary mb-0">Samsung Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item featured IoT">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SICStage2.png" class="img-fluid lazyload" alt="Sertifikat Shell Idea Challenge Stage 2">
                                <div class="portfolio-links">
                                    <a href="#" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Samsung Innovation Campus Batch 5 AI & IoT Stage 2 - 3</h4>
                                    <p class="small text-body-secondary mb-0">Samsung Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item featured IoT">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SICStage3.png" class="img-fluid lazyload" alt="Sertifikat Shell Idea Challenge Stage 3">
                                <div class="portfolio-links">
                                    <a href="#" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Samsung Innovation Campus Batch 5 AI & IoT Stage 3</h4>
                                    <p class="small text-body-secondary mb-0">Samsung Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatPythonAlgorithm.png" class="img-fluid lazyload" alt="Sertifikat Python & Algoritma">
                                <div class="portfolio-links">
                                    <a href="https://badgr.com/public/assertions/-5JsF-_9TjC-ITtVvv_8rg?identity__email=nadya15a3@gmail.com" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Algorithm & Data Structure</h4>
                                    <p class="small text-body-secondary mb-0">Skillvul</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item IoT">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatPythonDasar.png" class="img-fluid lazyload" alt="Sertifikat Python Dasar">
                                <div class="portfolio-links">
                                    <a href="https://badgr.com/public/assertions/fhm-f9N4RkWAtFsj1h9w7w?identity__email=nadya15a3@gmail.com" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Dasar Pemrograman Python</h4>
                                    <p class="small text-body-secondary mb-0">Skillvul</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item IoT">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatPythonLanjut.png" class="img-fluid lazyload" alt="Sertifikat Python Lanjutan">
                                <div class="portfolio-links">
                                    <a href="https://badgr.com/public/assertions/M6e1x0CoRFK9JkCoJecclw?identity__email=nadya15a3@gmail.com" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Pemrograman Python Lanjutan</h4>
                                    <p class="small text-body-secondary mb-0">Skillvul</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item IoT">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatIoT.png" class="img-fluid lazyload" alt="Sertifikat Pengenalan IoT">
                                <div class="portfolio-links">
                                    <a href="https://badgr.com/public/assertions/LK1xozEMTHSsqSI38ch93A?identity__email=nadya15a3@gmail.com" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Pengenalan Internet of Things</h4>
                                    <p class="small text-body-secondary mb-0">Skillvul</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item IoT">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatIoTFundamental.png" class="img-fluid lazyload" alt="Sertifikat IoT Fundamental">
                                <div class="portfolio-links">
                                    <a href="https://badgr.com/public/assertions/LK1xozEMTHSsqSI38ch93A?identity__email=nadya15a3@gmail.com" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Fundamental Internet of Things</h4>
                                    <p class="small text-body-secondary mb-0">Skillvul</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item IoT">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatIoTSoftware.png" class="img-fluid lazyload" alt="Sertifikat Perangkat Lunak IoT">
                                <div class="portfolio-links">
                                    <a href="https://badgr.com/public/assertions/z_YkmXG6RPuXybWMOUgUJw?identity__email=nadya15a3@gmail.com" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Perangkat Lunak IoT</h4>
                                    <p class="small text-body-secondary mb-0">Skillvul</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="swiper-slide">
                        <div class="portfolio-item Web-dev">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatFrontEnd.png" class="img-fluid lazyload" alt="Sertifikat Belajar Membuat Front-End Web untuk Pemula dari Dicoding">
                                <div class="portfolio-links">
                                    <a href="https://www.dicoding.com/certificates/2VX34365NZYQ" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Belajar Membuat Front-End Web untuk Pemula</h4>
                                    <p class="small text-body-secondary mb-0">Dicoding Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item IoT">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatIoTHealthMonitoringSystem.png" class="img-fluid lazyload" alt="Sertifikat Proyek Akhir IoT Health Monitoring System">
                                <div class="portfolio-links">
                                    <a href="https://badgr.com/public/assertions/1ey6ROu9T3C6yRBtcc1tUQ?identity__email=nadya15a3@gmail.com" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Proyek Akhir: IoT Health Monitoring</h4>
                                    <p class="small text-body-secondary mb-0">Skillvul</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item Web-dev">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatFrontEndJavascript.png" class="img-fluid lazyload" alt="Sertifikat Belajar JavaScript untuk Web Front-End dari Dicoding">
                                <div class="portfolio-links">
                                    <a href="https://www.dicoding.com/certificates/EYX4J09JWZDL" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Belajar Dasar Pemrograman JavaScript</h4>
                                    <p class="small text-body-secondary mb-0">Dicoding Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="swiper-slide">
                        <div class="portfolio-item Web-dev">
                            <div class="portfolio-wrap  overflow-hidden">
                                <img data-src="certificate/SertifikatReact.png" class="img-fluid lazyload" alt="Sertifikat Belajar React dari Dicoding">
                                <div class="portfolio-links">
                                    <a href="https://www.dicoding.com/certificates/N9ZOY11VYPG5" target="_blank">
                                        <i class="bi bi-check2-square"></i>
                                        <h6>Check Credential</h6>
                                    </a>
                                </div>
                                <div class="p-3 bg-white text-center">
                                    <h4 class="fs-6 fw-semibold mb-1">Belajar Membuat Aplikasi Web dengan React</h4>
                                    <p class="small text-body-secondary mb-0">Dicoding Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
                <div class="swiper-pagination" style="bottom:-20px; position:relative;"></div>
            </div>
        </div>
    </section>
    
    <section id="project" class="project" data-aos="fade-up" data-aos-delay="200">
      <div class="container py-5">
        <div class="section-title">
          <h2>Project</h2>
          <p>Showcasing a collection of projects that highlight my skills, creativity, and problem-solving abilities in software development, AI, and IoT.</p>
        </div>
        <div class="swiper project-slider">
          <div class="swiper-wrapper">
    
            <div class="swiper-slide project-card rounded-5">
              <div class="project-img">
                <img data-src="img/project/banner/kostifyproject.png" class="img-fluid lazyload rounded-top w-100" alt="Kostify">
              </div>
              <div class="project-content">
                <div class="d-flex align-items-center justify-content-center mb-2">
                  <img data-src="img/member/681a28fc2af5d.png" class="rounded-circle lazyload" width="20" height="20" alt="Developer" style="z-index: 2;">
                </div>
                <h4>Kostify: Cari Kost dengan Mudah</h4>
                <p>Platform digital yang dirancang untuk menyederhanakan proses pencarian dan pengelolaan indekos, membantu pengguna menemukan hunian ideal dengan cepat.</p>
                <div class="project-tech-stack my-3">
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" class="lazyload" title="Laravel" alt="Laravel Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg" class="lazyload" title="JavaScript" alt="JavaScript Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original-wordmark.svg" class="lazyload" title="MySQL" alt="MySQL Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/bootstrap/bootstrap-original.svg" class="lazyload" title="Bootstrap" alt="Bootstrap Logo" />
                </div>
                <div class="project-links">
                  <a href="https://github.com/NadhifFauzilAdhim/Kostify-Aplikasi-Cari-Kost-Native" class="btn btn-sm btn-outline-dark rounded-pill">
                    <i class="bi bi-github"></i> Source Code
                  </a>
                  <a href="https://kostify.my.id" class="btn btn-sm btn-outline-primary rounded-pill">
                    <i class="bi bi-eye"></i> Website
                  </a>
                </div>
              </div>
            </div>
    
            <div class="swiper-slide project-card rounded-5">
              <div class="project-img">
                <img data-src="img/project/banner/linksyproject.png" class="img-fluid lazyload rounded-top w-100" alt="Linksy">
              </div>
              <div class="project-content">
                <div class="d-flex align-items-center justify-content-center mb-2">
                  <img data-src="img/member/681a28fc2af5d.png" class="rounded-circle lazyload" width="20" height="20" alt="Developer" style="z-index: 2;">
                </div>
                <h4>Linksy: Smart Link Management</h4>
                <p>Solusi manajemen tautan cerdas untuk memperpendek, mengkustomisasi, dan menganalisis performa URL, ideal untuk kampanye pemasaran dan optimasi media sosial.</p>
                <div class="project-tech-stack my-3">
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" class="lazyload" title="Laravel" alt="Laravel Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original-wordmark.svg" class="lazyload" title="MySQL" alt="MySQL Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/redis/redis-original.svg" class="lazyload" title="Redis" alt="Redis Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/bootstrap/bootstrap-original.svg" class="lazyload" title="Bootstrap" alt="Bootstrap Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/googlecloud/googlecloud-original.svg" class="lazyload" title="Google Cloud" alt="Google Cloud Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/cloudflare/cloudflare-original.svg" class="lazyload" title="Cloudflare" alt="Cloudflare Logo" />
                </div>
                <div class="project-links">
                  <a href="https://linksy.site/apidocumentation" class="btn btn-sm btn-outline-dark rounded-pill">
                    <i class="bi bi-file-earmark-code"></i> Documentation
                  </a>
                  <a href="https://linksy.site" class="btn btn-sm btn-outline-primary rounded-pill">
                    <i class="bi bi-eye"></i> Website
                  </a>
                </div>
              </div>
            </div>
    
            <div class="swiper-slide project-card rounded-5">
              <div class="project-img">
                <img data-src="img/project/banner/hydroeaseproject.png" class="img-fluid lazyload rounded-top w-100" alt="HydroEase">
              </div>
              <div class="project-content">
                <div class="d-flex align-items-center justify-content-center mb-2">
                  <img data-src="img/member/681a28fc2af5d.png" class="rounded-circle lazyload" width="20" height="20" alt="Developer" style="z-index: 2;">
                  <img data-src="img/member/arip.png" class="rounded-circle lazyload" width="20" height="20" alt="Developer" style="margin-left: -5px; z-index: 1;">
                  <img data-src="img/member/ferdi.png" class="rounded-circle lazyload" width="20" height="20" alt="Developer" style="margin-left: -5px; z-index: 1;">
                  <img data-src="img/member/julian.png" class="rounded-circle lazyload" width="20" height="20" alt="Developer" style="margin-left: -5px; z-index: 1;">
                </div>
                <h4>HydroEase: Hydroponic IoT System</h4>
                <p>Sistem otomatisasi berbasis IoT untuk memonitor dan mengontrol parameter penting pada tanaman hidroponik, seperti nutrisi dan pH, demi hasil panen yang optimal.</p>
                <div class="project-tech-stack my-3">
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/arduino/arduino-original.svg" class="lazyload" title="Arduino" alt="Arduino Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mongodb/mongodb-original.svg" class="lazyload" title="MongoDB" alt="MongoDB Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/rabbitmq/rabbitmq-original.svg" class="lazyload" title="MQTT" alt="MQTT Logo" />
                </div>
                <div class="project-links">
                  <a href="https://launchinpad.com/project/hydroease-hydroponic-efficiency-automation-8dafb66" class="btn btn-sm btn-outline-dark rounded-pill">
                    <i class="bi bi-file-earmark-code"></i> Documentation
                  </a>
                </div>
              </div>
            </div>
    
            <div class="swiper-slide project-card rounded-5">
              <div class="project-img">
                <img data-src="img/project/banner/focuseyeproject.png" class="img-fluid lazyload rounded-top w-100" alt="FocusEye Project">
              </div>
              <div class="project-content">
                <div class="d-flex align-items-center justify-content-center mb-2">
                  <img data-src="img/member/681a28fc2af5d.png" class="rounded-circle lazyload" width="20" height="20" alt="Developer" style="z-index: 2;">
                </div>
                <h4>FocusEye: Pantau Fokus, Raih Prestasi</h4>
                <p>Aplikasi cerdas berbasis AI untuk memantau tingkat fokus secara real-time dalam berbagai situasi, mulai dari belajar, bekerja, hingga aktivitas sehari-hari.</p>
                <div class="project-tech-stack my-3">
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tensorflow/tensorflow-original.svg" class="lazyload" title="TensorFlow" alt="TensorFlow Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/kotlin/kotlin-original.svg" class="lazyload" title="Kotlin" alt="Kotlin Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg" class="lazyload" title="Laravel" alt="Laravel Logo" />
                  <img data-src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/sqlite/sqlite-original.svg" class="lazyload" title="SQLite" alt="SQLite Logo" />
                </div>
                <div class="project-links">
                  <a href="https://github.com/NadhifFauzilAdhim/FocusEyeApp.git" class="btn btn-sm btn-outline-dark rounded-pill">
                    <i class="bi bi-github"></i> Source Code
                  </a>
                  <a href="https://linksy.site/focuseye_apps_download" class="btn btn-sm btn-outline-primary rounded-pill">
                    <i class="bi bi-eye"></i> Apps
                  </a>
                </div>
              </div>
            </div>
          </div>
          <style></style>
          <div class="swiper-pagination" style="bottom:-20px; position:relative;"></div>
        </div>
      </div>
    </section>

    <style>
      .project-tech-stack {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        justify-content: center;
        align-items: center;
        min-height: 40px;
      }
    
      .project-tech-stack img {
        height: 32px;
        width: auto;
        filter: grayscale(30%);
        transition: filter 0.3s ease, transform 0.3s ease;
      }
    
      .project-tech-stack img:hover {
        filter: grayscale(0%);
        transform: scale(1.1);
      }
    </style>
   
    <section id="blog-section" class="blog section-bg">
      <div class="container-fluid py-5">
          <div class="container" data-aos="fade-up">
            <div class="section-title" data-aos="fade-up" data-aos-delay="200">
              <h2>Last Blog Post</h2>
            </div>
              @if($posts->count() > 0)
                  <!-- Swiper Container -->
                  <div class="swiper blogSwiper">
                      <div class="swiper-wrapper">
                          @foreach ($posts as $item)
                          <div class="swiper-slide bg-transparent" style="box-shadow: none">
                              <div class="blog-item h-100 d-flex flex-column rounded-5 overflow-hidden mt-1 mb-3 shadow bg-transparent">
                                  <div class="blog-img position-relative" style="height: 200px; overflow: hidden;">
                                      @if($item->image)
                                          <img data-src="{{ asset('public/' . $item->image) }}" class="img-fluid w-100 h-100 object-fit-cover lazyload" alt="">
                                      @else
                                          <img data-src="{{ $item->category->image ? $item->category->image : asset('img/programmer_text_2.jpg') }}" class="img-fluid w-100 h-100 object-fit-cover lazyload" alt="Category Image">
                                      @endif
                                      <div class="blog-categiry py-2 px-4">
                                          <a href="/blog?category={{ $item->category->slug }}">
                                              <span class="text-white">{{ $item->category->name }}</span>
                                          </a>
                                      </div>
                                  </div>
                                  <div class="blog-content p-4 d-flex flex-column flex-grow-1 bg-white">
                                      <div class="d-flex align-items-center mb-3">
                                          <img data-src="{{ asset('public/' . $item->author->avatar) }}" class="rounded-circle me-2 lazyload" width="40" height="40" alt="Author Image">
                                          <div class="small">
                                              <a href="/blog?author={{ $item->author->username }}" class="text-dark text-decoration-none fw-bold">
                                                  {{ $item->author->name }}
                                              </a>
                                              <div class="d-flex text-muted small gap-3">
                                                <div>
                                                    <i class="bi bi-clock-history"></i> {{ $item['created_at']->diffForHumans() }}
                                                </div>
                                                <div>
                                                    <i class="bi bi-eye"></i> {{ $item['views'] }} views
                                                </div>
                                            </div>
                                          </div>
                                      </div>
                                      <a href="/blog/{{ $item['slug'] }}" class="h5 text-decoration-none text-dark fw-bold d-block mb-2 text-truncate" style="max-width: 100%;">
                                          {{ Str::limit(strip_tags($item['title']), 80) }}
                                      </a>
                                      <p class="text-muted flex-grow-1">{{ $item['excerpt'] }}</p>
                                      <div class="d-flex justify-content-between mt-auto">
                                          <a href="/blog/{{ $item['slug'] }}" class="btn p-0 fw-bold">Read more <i class="bi bi-arrow-right"></i></a>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          @endforeach
                      </div>
                      <div class="swiper-pagination"></div>
                  </div>
              @else
                  <div class="text-center w-100">
                      <h1 class="home__title">Nampaknya tidak ada &#129300;</h1>
                      <p class="home__description">Cek kembali kata kunci yang anda cari</p>
                  </div>
              @endif
          </div>
      </div>
  </section>
  <section id="testimonials" class="testimonials ">
    <div class="container py-5">
      <div class="section-title" data-aos="fade-up" data-aos-delay="200">
        <h2>Arabis Group Member</h2>
        <p>Arabis Group is a team of computer science students who are driven by passion and share a common objective of personal growth and making significant contributions to the field of information technology. As a group, we strive to create a dynamic environment where members can learn, collaborate, and excel in their respective areas of interest within the realm of technology. We firmly believe that by coming together, we can achieve far greater heights than we could individually.</p>
      </div>

      <div class="testimonials-slider " data-aos="fade-up" data-aos-delay="300">
        <div class="swiper-wrapper">
          <div class="swiper-slide member-card">
            <div class="testimonial-item" data-aos="fade-up">
              <img data-src="img/member/681a28fc2af5d.png" class="testimonial-img lazyload" alt="">
              <h3>Nadhif Fauzil Adhim</h3>
              <h4>Backend Developer</h4>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide member-card">
            <div class="testimonial-item" data-aos="fade-up" data-aos-delay="100">
              <img data-src="img/member/ferdi.png" class="testimonial-img lazyload" alt="">
              <h3>Dwi Ferdiyanto</h3>
              <h4>Informatics Student</h4>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide member-card">
            <div class="testimonial-item" data-aos="fade-up" data-aos-delay="200">
              <img data-src="img/member/julian.png" class="testimonial-img lazyload" alt="">
              <h3>Julian Kiyosaki H</h3>
              <h4>Mobile Developer</h4>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide member-card">
            <div class="testimonial-item" data-aos="fade-up" data-aos-delay="300">
              <img data-src="img/member/aji.png" class="testimonial-img lazyload" alt="">
              <h3>Muhajir Faturrahman</h3>
              <h4>Multimedia</h4>
            </div>
          </div><!-- End testimonial item -->

          <div class="swiper-slide member-card">
            <div class="testimonial-item" data-aos="fade-up" data-aos-delay="400">

              <img data-src="img/member/arip.png" class="testimonial-img lazyload" alt="">
              <h3>Rif'aa Surososastro</h3>
              <h4>Informatics Student</h4>
            </div>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>

    </div>
  </section><!-- End Testimonials Section -->
      <!-- ======= Contact Section ======= -->
      <section id="contact" class="contact section-bg">
        <div class="container py-5">
  
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
                  <p><a href="mailto:nadhifauziladhim@gmail.com">nadhifauziladhim@gmail.com</a></p>
                </div>
  
                <div class="phone">
                  <i class="bi bi-phone"></i>
                  <h4>Call:</h4>
                  <p><a href="tel:+6285727785062">+62 8572 7785 062"></a></p>
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