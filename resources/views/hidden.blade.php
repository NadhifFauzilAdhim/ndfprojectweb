<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">Yeah you found it</h5>
            </div>
            <div class="card-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="https://www.youtube.com/embed/c-GWcx2Hsto?si=GTEh0R3ZIsJjI7RO" 
                        title="YouTube video player" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            
        </div>
    </div>
</x-layout>