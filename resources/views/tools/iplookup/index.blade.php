<x-layout>
    <x-slot:title>IP Geolocation</x-slot:title>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <style>
        /* --- Styles Konsisten --- */
        :root {
            --primary: #10b981; /* Emerald Green Theme */
            --primary-dark: #059669;
        }

        .hero-section {
            background: linear-gradient(135deg, #064e3b 0%, #10b981 100%);
            padding: 3rem 0 5rem;
            color: white;
            border-bottom-left-radius: 2.5rem;
            border-bottom-right-radius: 2.5rem;
            margin-bottom: -3rem;
            position: relative;
        }
        
        /* Map Container */
        #map {
            height: 350px;
            width: 100%;
            border-radius: 1rem;
            z-index: 1;
        }

        .card-hover {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background: white;
            transition: transform 0.2s;
        }

        .info-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }
        
        .info-value {
            font-weight: 600;
            color: #1e293b;
            font-size: 1rem;
        }

        .flag-lg {
            width: 60px;
            height: auto;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .search-glass {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
        }
        .search-glass::placeholder { color: rgba(255, 255, 255, 0.7); }
        .search-glass:focus {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            box-shadow: none;
            border-color: rgba(255, 255, 255, 0.5);
        }
    </style>

    <div class="hero-section">
        <div class="container position-relative z-2 text-center">
            <div class="mb-4">
                <i class="bi bi-globe-americas fs-7 mb-2 d-block"></i>
                <h1 class="fw-bold">IP Geolocation</h1>
                <p class="opacity-75">Lacak lokasi fisik, negara, dan detail ISP dari alamat IP publik.</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="{{ route('ip.lookup') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="ip" 
                                   class="form-control form-control-lg search-glass" 
                                   placeholder="Masukkan IP Address (Contoh: 8.8.8.8)" 
                                   value="{{ request('ip') }}" required autocomplete="off">
                            <button class="btn btn-light rounded-pill px-4 ms-2 fw-bold text-success" type="submit">LACAK</button>
                        </div>
                    </form>
                    
                    @if($error)
                        <div class="alert alert-danger mt-3 rounded-4 border-0 small">
                            <i class="bi bi-exclamation-circle me-1"></i> {{ $error }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5" style="min-height: 50vh; margin-top: 1rem;">
        
        @if(isset($data))
        <div class="row g-4">
            
            <div class="col-lg-4">
                <div class="card card-hover h-100 p-4">
                    <div class="text-center mb-4">
                        <img src="{{ $data['location']['country_flag'] }}" class="flag-lg mb-3" alt="Flag">
                        <h2 class="fw-bold mb-0">{{ $data['ip'] }}</h2>
                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 mt-2">
                             {{ $data['location']['country_code3'] }}
                        </span>
                    </div>

                    <hr class="opacity-10 my-4">

                    <div class="vstack gap-3">
                        <div>
                            <div class="info-label">Negara</div>
                            <div class="info-value">
                                {{ $data['location']['country_emoji'] }} {{ $data['location']['country_name_official'] }}
                            </div>
                        </div>
                        <div>
                            <div class="info-label">Wilayah / Kota</div>
                            <div class="info-value">
                                {{ $data['location']['state_prov'] }}, {{ $data['location']['city'] }}
                            </div>
                        </div>
                        <div>
                            <div class="info-label">Kode Pos</div>
                            <div class="info-value font-monospace">{{ $data['location']['zipcode'] }}</div>
                        </div>
                         <div>
                            <div class="info-label">Benua</div>
                            <div class="info-value">{{ $data['location']['continent_name'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="vstack gap-4">
                    
                    <div class="card card-hover p-1 overflow-hidden">
                        <div id="map"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card card-hover p-3 h-100 d-flex flex-row align-items-center gap-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-3">
                                    <i class="bi bi-cash-stack fs-4"></i>
                                </div>
                                <div>
                                    <div class="info-label">Mata Uang</div>
                                    <div class="info-value">
                                        {{ $data['currency']['name'] }} ({{ $data['currency']['symbol'] }})
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-hover p-3 h-100 d-flex flex-row align-items-center gap-3">
                                <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-3">
                                    <i class="bi bi-telephone fs-4"></i>
                                </div>
                                <div>
                                    <div class="info-label">Kode Telepon</div>
                                    <div class="info-value">{{ $data['country_metadata']['calling_code'] }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                             <div class="card card-hover p-3 h-100 d-flex flex-row align-items-center gap-3">
                                <div class="bg-info bg-opacity-10 text-info p-3 rounded-3">
                                    <i class="bi bi-translate fs-4"></i>
                                </div>
                                <div>
                                    <div class="info-label">Bahasa</div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @foreach($data['country_metadata']['languages'] as $lang)
                                            <span class="badge bg-light text-dark border">{{ $lang }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @else
            <div class="text-center mt-5 pt-4 text-muted">
                <i class="bi bi-search fs-1 opacity-25"></i>
                <p class="mt-2">Masukkan IP Address untuk melihat lokasi pada peta.</p>
            </div>
        @endif
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    
    @if(isset($data))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var lat = {{ $data['location']['latitude'] }};
            var lng = {{ $data['location']['longitude'] }};
            
            // Inisialisasi Peta
            var map = L.map('map').setView([lat, lng], 13);

            // Tambahkan Tile Layer (OpenStreetMap)
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Tambahkan Marker
            L.marker([lat, lng]).addTo(map)
                .bindPopup('<b>{{ $data['location']['city'] }}</b><br>{{ $data['location']['country_name'] }}')
                .openPopup();
        });
    </script>
    @endif

</x-layout>