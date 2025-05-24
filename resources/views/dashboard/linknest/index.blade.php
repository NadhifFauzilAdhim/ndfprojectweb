<x-dashlayout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <div class="text-center px-4 py-5 rounded-4 shadow-lg bg-white" style="max-width: 600px;">
            <!-- Animated Icon -->
            <div class="icon-wrapper mb-4">
                <i class="fas fa-tools fa-4x text-primary animate-float"></i>
            </div>

            <!-- Title & Text -->
            <h1 class="display-5 fw-bold mb-3 animate-fade-in">{{ $title }}</h1>
            <h3 class="text-muted mb-4 animate-fade-in delay-1">
                <i class="fas fa-hammer me-2"></i>Under Construction
            </h3>
            <p class="lead text-muted mb-4 animate-fade-in delay-2">
                Maaf, fitur ini sedang dalam pengembangan. Tim kami sedang bekerja keras untuk menyelesaikannya secepatnya!
            </p>

            <!-- Progress Bar -->
            <div class="progress mb-4 animate-fade-in delay-3" style="height: 8px;">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                     role="progressbar" 
                     style="width: 75%" 
                     aria-valuenow="75" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
            </div>

            <!-- Back Button -->
            <a href="/dashboard" class="btn btn-primary btn-lg px-5 animate-fade-in delay-4">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    <style>
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
            opacity: 0;
        }
        
        .delay-1 { animation-delay: 0.3s; }
        .delay-2 { animation-delay: 0.6s; }
        .delay-3 { animation-delay: 0.9s; }
        .delay-4 { animation-delay: 1.2s; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes fadeIn {
            to { opacity: 1; }
        }
    </style>

</x-dashlayout>