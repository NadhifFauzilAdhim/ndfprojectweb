<x-layout>
    <x-slot:title>{{ $title ?? 'Sebuah Titik Balik' }}</x-slot:title>

    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(15px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            :root {
                --dark-bg: #1a1d24;
                --card-bg: #242833;
                --text-primary: #e0e0e0;
                --text-secondary: #a0a0a0;
                --accent-color: #00c9b7;
                --timer-color: #ff4d4d;
                --border-color: #3a3f4c;
            }

            body {
                font-family: 'Open Sans', sans-serif;
                background-color: var(--dark-bg);
                color: var(--text-primary);
                line-height: 1.6;
                animation: fadeIn 0.8s ease-out;
                padding-top: 30px;
                padding-bottom: 30px;
            }

            .modern-wrapper {
                max-width: 760px;
                margin: auto;
                background-color: var(--card-bg);
                padding: 25px 35px 35px 35px;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3), 0 0 0 1px var(--border-color); /* Shadow modern + border halus */
            }

            .page-title-header {
                background: linear-gradient(120deg, var(--accent-color), #00a798);
                color: #ffffff;
                font-family: 'Poppins', sans-serif;
                border-radius: 8px; 
                padding: 25px 20px;
                margin-bottom: 30px; 
            }

            .page-title-header h1 {
                font-weight: 700;
                font-size: 2.1rem;
                margin-bottom: 0;
                text-shadow: 1px 1px 3px rgba(0,0,0,0.2);
            }

            .video-embed-card {
                border-radius: 8px;
                overflow: hidden; 
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }

            .ratio iframe {
            }

            #timecount {
                font-family: 'Poppins', sans-serif;
                font-weight: 600;
                color: var(--timer-color);
                font-size: 2rem;
                letter-spacing: 0.5px;
            }

            .timer-caption {
                font-family: 'Poppins', sans-serif;
                font-weight: 300; 
                color: var(--text-secondary);
                font-size: 0.95rem;
                margin-bottom: 5px; 
            }

            .message-zone {
                padding: 25px 0px; 
                margin-top: 30px;
                border-top: 1px solid var(--border-color);
            }

            .message-zone h3 {
                font-family: 'Poppins', sans-serif;
                font-weight: 600;
                color: var(--accent-color);
                font-size: 1.6rem;
                margin-bottom: 20px;
                text-align: center;
            }

            .message-zone p {
                font-family: 'Open Sans', sans-serif;
                font-size: 0.98rem;
                color: var(--text-secondary);
                text-align: justify;
                margin-bottom: 1.2rem;
            }
            .message-zone p strong { 
                color: var(--text-primary);
                font-weight: 600;
            }

            .image-display-area img {
                max-width: 100%;
                height: auto; 
                max-height: 260px;
                object-fit: cover;
                border-radius: 6px;
                border: 1px solid var(--border-color);
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                margin: 10px auto 15px auto;
                display: block;
            }
            .image-display-area small {
                color: var(--text-secondary);
                font-size: 0.85rem;
            }

            @media (min-width: 768px) {
                .message-flex-container {
                    display: flex;
                    align-items: flex-start;
                    gap: 30px;
                }
                .message-text-block {
                    flex: 3;
                }
                .image-display-container {
                    flex: 2;
                    margin-top: 5px; 
                }
            }
            .carousel-item img {
                height: 280px; 
                object-fit: cover; 
                border-radius: 6px; 
            }

            .carousel-caption {
                background-color: rgba(0, 0, 0, 0.5); 
                border-radius: 6px;
                padding: 10px 15px; 
            }
            .carousel-caption h5 {
                font-family: 'Poppins', sans-serif; 
                font-weight: 600;
                margin-bottom: 0.3rem;
            }
            .carousel-caption p {
                font-family: 'Open Sans', sans-serif; 
                font-size: 0.9rem;
                margin-bottom: 0;
            }

            .carousel-indicators [data-bs-target] {
                background-color: var(--accent-color, #00c9b7); 
            }
            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                background-color: rgba(0,0,0,0.3); 
                border-radius: 50%; 
                padding: 10px; 
            }
        </style>
    </head>

    <div class="modern-wrapper">
        <div class="page-title-header text-center">
            <h1 class="mb-0">Pada Akhirnya, Kau Menemukan Ini.</h1>
        </div>

        <div class="video-embed-card"> <div class="ratio ratio-16x9">
                <iframe
                    src="https://www.youtube.com/embed/c-GWcx2Hsto?si=nljU0mKm_kIWC57u" title="Sebuah Jejak yang Tertinggal"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allowfullscreen>
                </iframe>
            </div>
        </div>

        <div class="mt-4 pt-2 text-center"> <p class="timer-caption">Waktu terus berjalan sejak kau memilih arah yang berbeda:</p>
            <h2 id="timecount"></h2> </div>

        <div class="message-zone">
            <h3>Bab yang Harus Ditutup</h3>
            <div class="message-flex-container">
                <div class="message-text-block">
                    <p>
                        Dulu, kukira "kita" adalah cerita tanpa akhir. Ternyata, setiap cerita punya bab terakhir, dan kau memilih untuk menulisnya lebih cepat, dengan tokoh utama yang baru. Halaman ini? Anggap saja monolog terakhirku, caraku berdamai dengan bab yang kau tutup sepihak.
                    </p>
                    <p>
                        Entah kau akan mengerti, menyesal, atau mungkin tak peduli sama sekali. Itu hakmu. Tapi waktu tak pernah berhenti untuk siapapun. Semoga pilihanmu membawamu pada apa yang kau cari. Aku? Aku akan menemukan bahagiaku sendiri, dengan atau tanpamu di sisi.
                    </p>
                </div>
                <div class="image-display-container">
                    <div id="memoryCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#memoryCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#memoryCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#memoryCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('img/nothing.jpg') }}" class="d-block w-100" alt="Kenangan Pertama">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>First Meet, 2022</h5>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/lastmeet.png') }}" class="d-block w-100" alt="Kenangan Ketiga">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Last Meet, 2023</h5>
                                </div>
                            </div>
                        </div>
                
                        <button class="carousel-control-prev" type="button" data-bs-target="#memoryCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#memoryCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTimeCount() {
            const startDate = new Date("2023-02-28T00:00:00");
            const now = new Date();
            const diff = now - startDate;

            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            document.getElementById("timecount").innerText = `${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik`;
        }
        setInterval(updateTimeCount, 1000);
        updateTimeCount();
    </script>
</x-layout>