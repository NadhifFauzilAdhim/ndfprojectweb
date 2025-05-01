$(document).ready(function () {
    $('#generate-summary-btn').on('click', function () {
        const btn = $(this);
        const linkId = btn.data('link-id');
        const loadingIndicator = $('#summary-loading');
        const resultDiv = $('#summary-result');

        // Reset state
        btn.prop('disabled', true);
        loadingIndicator.removeClass('d-none');
        resultDiv.empty().removeClass('alert-danger');

        $.ajax({
            url: `/dashboard/link/${linkId}/summary`,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                loadingIndicator.addClass('d-none');
                btn.prop('disabled', false);

                if (response.success) {
                    const stats = response.stats || {};
                    const summaryData = {
                        total: stats.total || 0,
                        locations: stats.locations || 'Tidak tercatat',
                        lastVisit: stats.last_visit || 'Belum ada',
                        summary: response.summary || 'Tidak ada ringkasan yang tersedia',
                        recommendations: response.recommendations || 'Pertimbangkan untuk membagikan link ke platform lain untuk meningkatkan jangkauan.'
                    };

                    const summaryCard = `
                        <div class="summary-card position-relative">
                            <button class="btn btn-sm btn-light copy-btn" title="Salin ke Clipboard">
                                <i class="bi bi-clipboard"></i>
                            </button>
                            
                            <div class="d-flex gap-2 flex-wrap mb-4">
                                <div class="stats-badge">
                                    <i class="bi bi-people me-1"></i>Total Kunjungan: ${summaryData.total}
                                </div>
                                <div class="stats-badge">
                                    <i class="bi bi-geo-alt me-1"></i>Lokasi: ${summaryData.locations}
                                </div>
                                <div class="stats-badge">
                                    <i class="bi bi-clock-history me-1"></i>Terakhir: ${summaryData.lastVisit}
                                </div>
                            </div>
                            
                            <h6 class="section-heading">Analisis Pola</h6>
                            <p class="text-muted lh-base mb-4">${summaryData.summary}</p>
                            
                            <h6 class="section-heading">Rekomendasi Strategis</h6>
                            <div class="alert alert-light border">
                                ${summaryData.recommendations}
                            </div>
                        </div>
                    `;

                    resultDiv.html(summaryCard);

                    // Add copy functionality
                    resultDiv.find('.copy-btn').on('click', function() {
                        const copyButton = $(this);
                        navigator.clipboard.writeText(summaryData.summary)
                            .then(() => {
                                copyButton.html('<i class="bi bi-check2 me-1"></i>Tersalin!');
                                setTimeout(() => {
                                    copyButton.html('<i class="bi bi-clipboard"></i>');
                                }, 2000);
                            })
                            .catch(err => {
                                console.error('Gagal menyalin:', err);
                            });
                    });

                } else {
                    resultDiv.html(`
                        <div class="alert alert-danger border-danger d-flex align-items-center">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            ${response.message || 'Terjadi kesalahan saat memproses permintaan'}
                        </div>
                    `);
                }
            },
            error: function (xhr) {
                loadingIndicator.addClass('d-none');
                btn.prop('disabled', false);
                resultDiv.html(`
                    <div class="alert alert-danger border-danger d-flex align-items-center">
                        <i class="bi bi-x-circle-fill me-2"></i>
                        Terjadi kesalahan koneksi - ${xhr.statusText || 'Server tidak merespon'}
                    </div>
                `);
                console.error('Error:', xhr.responseText);
            }
        });
    });
});