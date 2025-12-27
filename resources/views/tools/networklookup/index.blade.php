<x-layout>
    <x-slot:title>IP WHOIS / RDAP Lookup</x-slot:title>

    <style>
        /* --- Styles --- */
        :root {
            --rdap-primary: #0891b2; /* Cyan Theme for Network Tools */
            --rdap-dark: #155e75;
        }

        .hero-section {
            background: linear-gradient(135deg, #0e7490 0%, #22d3ee 100%);
            padding: 3rem 0 5rem;
            color: white;
            border-bottom-left-radius: 2.5rem;
            border-bottom-right-radius: 2.5rem;
            margin-bottom: -3rem;
            position: relative;
        }
        
        .card-hover {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            background: white;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .label-sm {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            font-weight: 700;
            margin-bottom: 0.2rem;
        }
        
        .value-lg {
            font-weight: 600;
            color: #0f172a;
            font-size: 0.95rem;
            word-break: break-word;
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

        /* Status Badge */
        .badge-status {
            padding: 0.35em 0.8em;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-active { background: #dcfce7; color: #166534; }
        .status-inactive { background: #fee2e2; color: #991b1b; }
    </style>

    <div class="hero-section">
        <div class="container position-relative z-2 text-center">
            <div class="mb-4">
                <i class="bi bi-diagram-3-fill fs-1 mb-2 d-block fs-7"></i>
                <h1 class="fw-bold">Network WHOIS Lookup</h1>
                <p class="opacity-90">Cek pemilik jaringan, ASN, kontak teknis, dan informasi registrasi IP (RDAP).</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="{{ route('network.lookup') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="ip" 
                                   class="form-control form-control-lg search-glass" 
                                   placeholder="Masukkan IP Address (Contoh: 202.91.8.200)" 
                                   value="{{ request('ip') }}" required autocomplete="off">
                            <button class="btn btn-light rounded-pill px-4 ms-2 fw-bold text-info" type="submit">CEK IP</button>
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
        
        @if(isset($parsedData))
        <div class="row g-4">
            
            <div class="col-12">
                <div class="card card-hover p-4 border-start border-5 border-info">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <div class="label-sm text-info">NETWORK NAME</div>
                            <h2 class="fw-bold mb-0 text-dark">{{ $parsedData['net_name'] }}</h2>
                            <div class="d-flex align-items-center gap-2 mt-2">
                                <span class="badge bg-secondary"><i class="bi bi-globe me-1"></i> {{ $parsedData['country'] }}</span>
                                <span class="badge {{ str_contains(strtolower($parsedData['status']), 'active') ? 'status-active' : 'status-inactive' }} badge-status">
                                    {{ $parsedData['status'] }}
                                </span>
                                <span class="badge bg-light text-dark border">{{ $parsedData['type'] }}</span>
                            </div>
                        </div>
                        <div class="text-md-end">
                            <div class="label-sm">IP RANGE / CIDR</div>
                            <div class="fs-5 fw-bold font-monospace">{{ $parsedData['cidr'] }}</div>
                            <div class="text-muted small font-monospace">{{ $parsedData['range'] }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card card-hover h-100">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold d-flex align-items-center">
                            <i class="bi bi-building-fill text-info me-2"></i> Organisasi / Pemilik
                        </h5>
                    </div>
                    <div class="card-body p-4 vstack gap-3">
                        
                        <div>
                            <div class="label-sm">NAMA ENTITAS</div>
                            <div class="value-lg">{{ $parsedData['contact']['name'] }}</div>
                        </div>

                        <div>
                            <div class="label-sm">ALAMAT FISIK</div>
                            <div class="value-lg text-muted">
                                {!! $parsedData['contact']['address'] ?: 'Tidak tersedia' !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="label-sm">EMAIL KONTAK</div>
                                <div class="value-lg">
                                    @if($parsedData['contact']['email'] !== '-')
                                        <a href="mailto:{{ $parsedData['contact']['email'] }}" class="text-decoration-none text-info fw-bold">
                                            {{ $parsedData['contact']['email'] }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="label-sm">TELEPON</div>
                                <div class="value-lg">
                                    @if(!empty($parsedData['contact']['phone']))
                                        @foreach($parsedData['contact']['phone'] as $phone)
                                            <div>{{ $phone }}</div>
                                        @endforeach
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-2 bg-light p-3 rounded-3">
                            <div class="label-sm">DESKRIPSI / REMARKS</div>
                            @foreach($parsedData['remarks'] as $rem)
                                <div class="mb-2">
                                    <strong class="d-block small text-dark">{{ $rem['title'] }}</strong>
                                    <span class="small text-muted">{!! $rem['desc'] !!}</span>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="vstack gap-4">
                    
                    <div class="card card-hover p-4">
                        <h5 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-clock-history text-info me-2"></i> Timeline Registrasi
                        </h5>
                        <div class="vstack gap-3">
                            @foreach($parsedData['events'] as $event)
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                                <span class="fw-semibold text-secondary">{{ $event['action'] }}</span>
                                <span class="font-monospace small bg-light px-2 py-1 rounded">{{ $event['date'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card card-hover p-4">
                        <h5 class="fw-bold mb-3 d-flex align-items-center">
                            <i class="bi bi-hdd-network text-info me-2"></i> Detail Teknis
                        </h5>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="label-sm">HANDLE ID</div>
                                <div class="font-monospace small bg-light p-2 rounded">{{ $parsedData['handle'] }}</div>
                            </div>
                            <div class="col-6">
                                <div class="label-sm">WHOIS SERVER</div>
                                <div class="font-monospace small bg-light p-2 rounded">{{ $parsedData['port43'] }}</div>
                            </div>
                            <div class="col-12">
                                <div class="label-sm">IP VERSION</div>
                                <div>IPv4</div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-secondary border-0 small m-0 opacity-75">
                        <strong>Terms & Conditions:</strong><br>
                        Data ini berasal dari sumber IDNIC/APNIC. Penggunaan data tunduk pada ketentuan layanan masing-masing registrar.
                    </div>

                </div>
            </div>
            
        </div>
        @else
            <div class="text-center mt-5 pt-4 text-muted">
                <i class="bi bi-hdd-rack fs-1 opacity-25"></i>
                <p class="mt-3 fw-medium">Masukkan IP Address untuk melihat data registrasi RDAP.</p>
            </div>
        @endif
    </div>
</x-layout>