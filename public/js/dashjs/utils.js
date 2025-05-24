document.addEventListener("DOMContentLoaded", function () {
    if (!localStorage.getItem("hasVisited")) {
        showIntroModal();
        localStorage.setItem("hasVisited", "true");
    } else if (!localStorage.getItem("hasSeenPromo")) {
        showPromoModal();
        localStorage.setItem("hasSeenPromo", "true");
    }
});

document.getElementById('linkform').addEventListener('submit', function () {
    const btn = document.getElementById('linkSubmitBtn');
    const spinner = document.getElementById('linkBtnSpinner');
    const btnText = document.getElementById('linkBtnText');

    btn.disabled = true;
    spinner.classList.remove('d-none');
    btnText.textContent = 'Loading...';
});

function showIntroModal() {
    let modalHTML = `
        <div class="modal fade" id="introModal" tabindex="-1" aria-labelledby="introModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="introModalLabel">Selamat Datang di Linksy!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="/img/illustration.webp" width="300" alt="Linksy Logo" class="justify-content-center d-block mx-auto mb-3">
                        <p><strong>Linksy</strong> adalah solusi cerdas untuk <b>manajemen, pemendekan, dan pelacakan link</b>.</p>
                        <p>Optimalkan tautanmu dengan mudah dan tingkatkan efisiensi digitalmu!</p>
                        <ul class="feature-list list-unstyled text-start">
                            <li>✅ <b>Track Every Click</b> - Lacak setiap klik dengan analitik mendalam.</li>
                            <li>✅ <b>Customizable Links</b> - Buat tautan unik dengan branded URLs & custom slugs.</li>
                            <li>✅ <b>Secure Links</b> - Lindungi URL dengan enkripsi canggih dan kata sandi.</li>
                            <li>✅ <b>Seamless Management</b> - Atur dan kelola tautan dengan dasbor intuitif.</li>
                            <li>✅ <b>Comprehensive Reports</b> - Akses laporan mendalam untuk memahami audiens.</li>
                            <li>✅ <b>Lightning-Fast Shortening</b> - Buat tautan pendek dalam hitungan detik.</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mulai Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML("beforeend", modalHTML);
    var introModal = new bootstrap.Modal(document.getElementById('introModal'));
    introModal.show();
}

function showPromoModal() {
    let modalHTML = `
        <div class="modal fade" id="promoModal" tabindex="-1" aria-labelledby="promoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="promoModalLabel">🎉 Fitur Baru: Share Link!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body text-center">
                        <p>✨ Sekarang Anda bisa dengan mudah membagikan tautan ke teman dan keluarga langsung dari aplikasi!</p>
                        <p>🚀 Coba sekarang!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirmPromo" data-bs-dismiss="modal">Oke, Mengerti!</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML("beforeend", modalHTML);
    var promoModal = new bootstrap.Modal(document.getElementById('promoModal'));
    promoModal.show();
}

