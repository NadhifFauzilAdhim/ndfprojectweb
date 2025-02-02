<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-info text-white text-center py-4">
                <h1 class="mb-0">Yeah, You Found It!</h1>
            </div>
            <div class="card-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="https://www.youtube.com/embed/c-GWcx2Hsto?si=GTEh0R3ZIsJjI7RO" 
                        title="YouTube video player" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        referrerpolicy="strict-origin-when-cross-origin" 
                        allowfullscreen
                        class="rounded-bottom">
                    </iframe>
                </div>
            </div>
        </div>
        <div class="mt-4 text-center">
            <p class="text-muted fs-5">I've been waiting for</p>
            <h2 id="timecount" class="text-danger fw-bold"></h2>
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