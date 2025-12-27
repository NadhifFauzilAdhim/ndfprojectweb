<x-layout>
    <x-slot:title>Discord Lookup</x-slot:title>

    <style>
        /* --- Root Variables --- */
        :root {
            --discord-primary: #5865F2;
            --discord-dark: #4752C4;
            --discord-bg: #f8f9fa;
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Nunito', sans-serif;
            color: #334155;
        }

        /* --- Hero Section --- */
        .hero-section {
            background: linear-gradient(135deg, var(--discord-primary) 0%, var(--discord-dark) 100%);
            padding: 3rem 0 5rem;
            border-bottom-left-radius: 2.5rem;
            border-bottom-right-radius: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: -3rem;
        }
        
        .hero-pattern {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.5;
        }

        /* --- Components --- */
        .card-hover {
            transition: all 0.3s ease;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background: white;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(88, 101, 242, 0.15);
        }

        /* Avatar Styling */
        .avatar-wrapper {
            position: relative;
            width: 130px;
            height: 130px;
            margin: -65px auto 1rem;
        }
        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 6px solid white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            background: #fff;
        }
        .avatar-deco {
            position: absolute;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 135%; height: 135%;
            pointer-events: none;
        }

        /* Profile Header inside Card */
        .profile-banner-mini {
            height: 100px;
            border-radius: 1rem 1rem 0 0;
            background-color: #e2e8f0;
            background-size: cover;
            background-position: center;
        }

        /* Widget Stats */
        .widget-stat {
            background: #fff;
            border-radius: 1rem;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e2e8f0;
            transition: 0.2s;
        }
        .widget-stat:hover {
            border-color: var(--discord-primary);
            background: #f8fafc;
        }
        .widget-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--discord-primary);
            background: rgba(88, 101, 242, 0.1);
        }

        /* Search Input */
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
        .btn-search {
            border-radius: 50px;
            background: white;
            color: var(--discord-primary);
            font-weight: 800;
            border: none;
        }
        .btn-search:hover { background: #f1f5f9; color: var(--discord-dark); }
        
        /* Download Button Style */
        .btn-download-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            background: #f1f5f9;
            color: #64748b;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .btn-download-sm:hover {
            background: #e2e8f0;
            color: #334155;
            transform: translateY(-1px);
        }

        /* Animation */
        .fade-in-up { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(20px); }
        @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }

        /* Asset Preview */
        .color-swatch {
            height: 80px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.1);
        }
    </style>

    <div class="hero-section">
        <div class="hero-pattern"></div>
        <div class="container position-relative z-2">
            <div class="row justify-content-center text-center">
                <div class="col-lg-7">
                    <div class="mb-4">
                        <svg class="mb-3" width="60" height="60" viewBox="0 0 127 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M107.701 8.16388C99.6385 4.54229 90.9669 1.95679 81.936 0.264789C81.8288 0.245053 81.7188 0.301323 81.6666 0.398939C80.5601 2.30232 79.3512 4.82195 78.5132 6.84524C69.0494 5.48003 59.6358 5.48003 50.2882 6.84524C49.4614 4.81069 48.2413 2.30232 47.1236 0.398939C47.0714 0.298507 46.9614 0.245053 46.8542 0.264789C37.812 1.95679 29.1404 4.54229 21.0892 8.16388C21.0188 8.19483 20.9708 8.25672 20.9539 8.32988C4.5779 32.228 0.232657 55.6729 2.45524 78.4357C2.47213 78.5707 2.54529 78.6945 2.65219 78.7761C13.3853 86.4801 23.7508 88.8258 33.996 89.1438C34.1142 89.1466 34.2267 89.0763 34.283 88.9722C36.6322 85.8344 38.7476 82.511 40.5929 79.0305C40.6716 78.8814 40.5788 78.7042 40.4128 78.6423C37.0084 77.4045 33.7428 75.8754 30.6366 74.089C30.4003 73.9539 30.3806 73.6191 30.6057 73.4531C31.2585 72.9748 31.9029 72.4824 32.5275 71.976C32.6175 71.9029 32.7441 71.8944 32.8426 71.9479C52.7932 80.9157 76.0792 80.9157 95.8239 71.9479C95.9223 71.8888 96.0489 71.9001 96.1418 71.976C96.7663 72.4824 97.4107 72.9748 98.0635 73.4531C98.2886 73.6191 98.2689 73.9539 98.0326 74.089C94.9264 75.8754 91.6496 77.4045 88.2452 78.6423C88.0792 78.7042 87.9863 78.8842 88.065 79.0305C89.9215 82.511 92.0369 85.8344 94.3749 88.9722C94.4312 89.0763 94.5437 89.1495 94.6619 89.1438C104.921 88.8258 115.286 86.4801 126.008 78.7761C126.115 78.6945 126.188 78.5679 126.205 78.4357C128.846 51.5275 121.731 28.3245 107.673 8.32988C107.656 8.25672 107.608 8.19765 107.701 8.16388ZM42.4883 64.2274C36.3155 64.2274 31.2557 58.649 31.2557 51.7997C31.2557 44.9504 36.1749 39.3719 42.4883 39.3719C48.8576 39.3719 53.7209 44.9785 53.6646 51.7997C53.6646 58.649 48.717 64.2274 42.4883 64.2274ZM86.0798 64.2274C79.907 64.2274 74.8472 58.649 74.8472 51.7997C74.8472 44.9504 79.7664 39.3719 86.0798 39.3719C92.4491 39.3719 97.3124 44.9785 97.2561 51.7997C97.2561 58.649 92.3085 64.2274 86.0798 64.2274Z" fill="white"/>
                        </svg>
                        <h1 class="fw-bold">Discord Lookup</h1>
                    </div>
                    
                    <form action="{{ route('discord.lookup') }}" method="GET" class="position-relative">
                        <div class="input-group">
                            <input type="text" name="user_id" 
                                   class="form-control form-control-lg search-glass" 
                                   placeholder="Tempel User ID disini (Contoh: 14008...)" 
                                   value="{{ request('user_id') }}" required autocomplete="off">
                            <button class="btn btn-search px-4 ms-2" type="submit">CARI</button>
                        </div>
                    </form>

                    @if($error)
                        <div class="alert alert-danger mt-3 rounded-4 border-0 shadow-sm d-inline-flex align-items-center animate__animated animate__shakeX">
                            <i class="bi bi-exclamation-octagon-fill me-2 fs-5"></i> {{ $error }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container pb-5" style="min-height: 50vh;">
        
        @if(!isset($userData))
            <div class="text-center mt-5 text-muted fade-in-up" style="animation-delay: 0.1s;">
                <i class="bi bi-search fs-1 text-primary opacity-25"></i>
                <p class="mt-3 fw-semibold">Silakan masukkan ID Discord untuk melihat analisis profil.</p>
            </div>
        @endif

        @if(isset($userData) && $userData)
        <div class="row g-4 mt-2">
            
            <div class="col-lg-4 fade-in-up" style="animation-delay: 0.1s;">
                <div class="card card-hover h-100 overflow-hidden">
                    @php
                        $bannerBg = $userData['banner'] ? "url('{$userData['banner']}')" : ($userData['bannerColor'] ? $userData['bannerColor'] : '#e2e8f0');
                    @endphp
                    <div class="profile-banner-mini" style="background: {{ $bannerBg }};"></div>
                    
                    <div class="card-body text-center px-4 pb-5 pt-0">
                        <div class="avatar-wrapper">
                            <img src="{{ $userData['avatar'] }}" class="profile-img" alt="Avatar">
                            @if($userData['avatarDecoration'])
                                <img src="{{ $userData['avatarDecoration'] }}" class="avatar-deco" alt="Decoration">
                            @endif
                        </div>

                        <div class="mb-3">
                            <a href="{{ $userData['avatar'] }}?size=1024" target="_blank" class="btn-download-sm">
                                <i class="bi bi-download"></i> Simpan Avatar HD
                            </a>
                        </div>

                        <h3 class="fw-bold text-dark mb-0">{{ $userData['global_name'] ?? 'No Name' }}</h3>
                        <div class="d-flex justify-content-center align-items-center gap-2 mt-1">
                            <span class="text-muted fw-semibold">{{ '@' . $userData['username'] }}</span>
                            @if($userData['isBot'])
                                <span class="badge bg-primary rounded-pill px-2">BOT</span>
                            @endif
                        </div>

                        <div class="my-4 border-bottom"></div>

                        <div class="d-flex justify-content-center flex-wrap gap-2">
                            @if($userData['nitroType']['value'] > 0)
                                <img src="{{ $userData['nitroType']['icon'] }}" width="30" height="30" data-bs-toggle="tooltip" title="{{ $userData['nitroType']['description'] }}" class="hover-scale">
                            @endif
                            @foreach($userData['flags'] as $flag)
                                <img src="{{ $flag['icon'] }}" width="30" height="30" data-bs-toggle="tooltip" title="{{ $flag['name'] }}" class="hover-scale">
                            @endforeach
                            
                            @if(empty($userData['flags']) && $userData['nitroType']['value'] == 0)
                                <small class="text-muted fst-italic">Tidak ada badge publik</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="row g-4">
                    
                    <div class="col-12 fade-in-up" style="animation-delay: 0.2s;">
                        <div class="card card-hover p-4">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-bar-chart-fill text-primary me-2"></i> Detail Akun
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="widget-stat">
                                        <div>
                                            <div class="text-muted small fw-bold text-uppercase">Discord ID</div>
                                            <div class="fw-bold text-dark font-monospace user-select-all">{{ $userData['id'] }}</div>
                                        </div>
                                        <div class="widget-icon">
                                            <i class="bi bi-fingerprint"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="widget-stat">
                                        <div>
                                            <div class="text-muted small fw-bold text-uppercase">Dibuat Pada</div>
                                            <div class="fw-bold text-dark">{{ $userData['creationDate'] }}</div>
                                        </div>
                                        <div class="widget-icon">
                                            <i class="bi bi-calendar-check"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="widget-stat">
                                        <div>
                                            <div class="text-muted small fw-bold text-uppercase">Tipe Akun</div>
                                            <div class="fw-bold text-dark">{{ $userData['isBot'] ? 'Robot / App' : 'Manusia' }}</div>
                                        </div>
                                        <div class="widget-icon">
                                            <i class="bi {{ $userData['isBot'] ? 'bi-robot' : 'bi-person' }}"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="widget-stat">
                                        <div>
                                            <div class="text-muted small fw-bold text-uppercase">Status Nitro</div>
                                            <div class="fw-bold text-dark">{{ $userData['nitroType']['value'] > 0 ? 'Aktif' : 'Non-Aktif' }}</div>
                                        </div>
                                        <div class="widget-icon" style="color: #ec4899; background: rgba(236, 72, 153, 0.1);">
                                            <i class="bi bi-rocket-takeoff"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 fade-in-up" style="animation-delay: 0.3s;">
                        <div class="card card-hover p-4">
                            <h5 class="fw-bold mb-4 d-flex align-items-center">
                                <i class="bi bi-images text-primary me-2"></i> Aset Visual
                            </h5>

                            <div class="row g-4">
                                <div class="col-md-8">
                                    <label class="small text-muted fw-bold mb-2">BANNER PROFILE</label>
                                    @if($userData['banner'])
                                        <div class="rounded-4 shadow-sm" style="height: 140px; background: url('{{ $userData['banner'] }}') center/cover;"></div>
                                        <div class="mt-2 text-end">
                                            <a href="{{ $userData['banner'] }}?size=1024" target="_blank" class="small text-decoration-none fw-bold text-primary">
                                                <i class="bi bi-cloud-arrow-down-fill me-1"></i> Download Banner HD
                                            </a>
                                        </div>
                                    @else
                                        <div class="rounded-4 bg-light border d-flex align-items-center justify-content-center text-muted" style="height: 140px;">
                                            <span><i class="bi bi-image-alt"></i> Tidak ada banner gambar</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class="small text-muted fw-bold mb-2">WARNA TEMA</label>
                                    @php
                                        $colorHex = $userData['bannerColor'] 
                                            ? $userData['bannerColor'] 
                                            : ($userData['accentColor'] ? '#'.dechex($userData['accentColor']) : '#5865F2');
                                    @endphp
                                    <div class="color-swatch" style="background-color: {{ $colorHex }};">
                                        <span class="font-monospace">{{ strtoupper($colorHex) }}</span>
                                    </div>
                                    <div class="mt-2 small text-muted text-center">Hex Code</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endif
    </div>

    <script>
        // Initialize Bootstrap Tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
</x-layout>