<x-layout>
    <x-slot:title>Developer Tools Hub</x-slot:title>

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Nunito', sans-serif;
        }

        /* Hero Section */
        .tools-header {
            background: linear-gradient(135deg, #0f172a 0%, #334155 100%);
            padding: 4rem 0 5rem;
            color: white;
            border-bottom-left-radius: 3rem;
            border-bottom-right-radius: 3rem;
            margin-bottom: -3rem;
            position: relative;
            overflow: hidden;
        }

        .header-pattern {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.3;
        }

        /* Tool Card */
        .tool-card {
            background: white;
            border: none;
            border-radius: 1.5rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            height: 100%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
        }

        .tool-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .tool-icon-wrapper {
            width: 64px;
            height: 64px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }

        .tool-card:hover .tool-icon-wrapper {
            transform: scale(1.1) rotate(5deg);
        }

        .btn-tool-action {
            margin-top: auto; /* Push button to bottom */
            background-color: #f1f5f9;
            color: #334155;
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-weight: 700;
            width: 100%;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .tool-card:hover .btn-tool-action {
            background-color: #0f172a;
            color: white;
        }

        .badge-floating {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 0.7rem;
            padding: 0.35rem 0.65rem;
            border-radius: 2rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }
    </style>

    <div class="tools-header">
        <div class="header-pattern"></div>
        <div class="container text-center position-relative z-2">
            <span class="badge bg-white bg-opacity-10 border border-white border-opacity-25 rounded-pill px-3 py-2 mb-3 fw-bold text-uppercase tracking-wider">
                ✨ Utility Hub
            </span>
            <h1 class="display-4 fw-bold mb-3">Explore Our Tools</h1>
            <p class="lead text-white-50 mx-auto" style="max-width: 600px;">
                Kumpulan alat bantu developer dan utility untuk mempermudah pekerjaan digital Anda sehari-hari.
            </p>
        </div>
    </div>

    <div class="container pb-5" style="margin-top: 1rem;">
        <div class="row g-4">
            
            @foreach($tools as $tool)
            <div class="col-md-6 col-lg-4">
                <a href="{{ $tool['route'] === '#' ? '#' : route($tool['route']) }}" class="text-decoration-none text-dark">
                    <div class="tool-card p-4">
                        
                        @if($tool['badge'])
                            <span class="badge badge-floating" 
                                  style="background-color: {{ $tool['badge'] == 'COMING SOON' ? '#e2e8f0' : $tool['color'] . '20' }}; 
                                         color: {{ $tool['badge'] == 'COMING SOON' ? '#64748b' : $tool['color'] }}">
                                {{ $tool['badge'] }}
                            </span>
                        @endif

                        <div class="tool-icon-wrapper" style="background-color: {{ $tool['color'] }}15; color: {{ $tool['color'] }};">
                            <i class="bi {{ $tool['icon'] }}"></i>
                        </div>

                        <h4 class="fw-bold mb-2">{{ $tool['name'] }}</h4>
                        <p class="text-muted small mb-4 flex-grow-1" style="line-height: 1.6;">
                            {{ $tool['description'] }}
                        </p>

                        @if($tool['route'] !== '#')
                            <button class="btn-tool-action">
                                Buka Tool <i class="bi bi-arrow-right"></i>
                            </button>
                        @else
                             <button class="btn-tool-action opacity-50" disabled style="cursor: not-allowed;">
                                Segera Hadir
                            </button>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach

        </div>
    </div>

</x-layout>