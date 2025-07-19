/**
 * @param {jQuery} targetElement 
 * @param {string} htmlString 
 * @param {function} onComplete 
 */
function typeWriter(targetElement, htmlString, onComplete) {
    targetElement.empty(); 
    const tempDiv = $('<div>').html(htmlString).contents(); 

    let i = 0;
    function processNode() {
        if (i >= tempDiv.length) {
            if (onComplete) onComplete();
            return;
        }
        
        const node = tempDiv[i];
        let j = 0;

        if (node.nodeType === 1) { 
            const element = $(`<${node.tagName.toLowerCase()}>`);
            targetElement.append(element);
            typeWriter(element, $(node).html(), () => {
                i++;
                processNode();
            });
        } else if (node.nodeType === 3) {
            const text = node.nodeValue;
            function typeChar() {
                if (j < text.length) {
                    targetElement.append(text.charAt(j));
                    j++;
                    setTimeout(typeChar, 5); 
                } else {
                    i++;
                    processNode();
                }
            }
            typeChar();
        } else { 
            i++;
            processNode();
        }
    }
    processNode();
}

$(document).ready(function () {
    $('#generate-summary-btn').on('click', function () {
        const btn = $(this);
        const linkId = btn.data('link-id');
        const loadingIndicator = $('#summary-loading');
        const resultDiv = $('#summary-result');

        btn.prop('disabled', true);
        loadingIndicator.removeClass('d-none');
        resultDiv.empty().removeClass('summary-card');

        $.ajax({
            url: `/dashboard/link/${linkId}/summary`,
            method: 'GET',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                loadingIndicator.addClass('d-none');

                if (response.success) {
                    const stats = response.stats || {};
                    const summaryData = {
                        total: stats['Total Kunjungan'] || 0,
                        locations: stats['Lokasi Terbanyak'] || 'Tidak tercatat',
                        lastVisit: stats['5 Kunjungan Terakhir'] && stats['5 Kunjungan Terakhir'][0] ? stats['5 Kunjungan Terakhir'][0].Waktu : 'Belum ada',
                    };

                    const summaryCardShell = `
                        <div class="position-relative">
                            <button class="btn btn-sm btn-light copy-btn" title="Salin ke Clipboard" style="display: none;">
                                <i class="bi bi-clipboard"></i>
                            </button>
                            <div class="d-flex gap-2 flex-wrap mb-4">
                                <div class="stats-badge"><i class="bi bi-people me-1"></i>Total Kunjungan: ${summaryData.total}</div>
                                <div class="stats-badge"><i class="bi bi-geo-alt me-1"></i>Lokasi: ${summaryData.locations}</div>
                                <div class="stats-badge"><i class="bi bi-clock-history me-1"></i>Terakhir: ${summaryData.lastVisit}</div>
                            </div>
                            <div id="ai-analysis-content"></div>
                        </div>`;
                    
                    resultDiv.addClass('summary-card').html(summaryCardShell);
                    const aiContentDiv = $('#ai-analysis-content');

                    typeWriter(aiContentDiv, response.summary, function() {
                        btn.prop('disabled', false); 
                        resultDiv.find('.copy-btn').fadeIn(); 

                        resultDiv.find('.copy-btn').on('click', function() {
                            const copyButton = $(this);
                            const textToCopy = resultDiv.find('#ai-analysis-content').text().trim();
                            
                            navigator.clipboard.writeText(textToCopy).then(() => {
                                copyButton.html('<i class="bi bi-check2"></i> Tersalin!');
                                setTimeout(() => {
                                    copyButton.html('<i class="bi bi-clipboard"></i>');
                                }, 2000);
                            });
                        });
                    });

                } else {
                    resultDiv.html(`<div class="alert alert-warning">${response.message || 'Gagal membuat ringkasan.'}</div>`);
                    btn.prop('disabled', false);
                }
            },
            error: function (xhr) {
                loadingIndicator.addClass('d-none');
                btn.prop('disabled', false);
                resultDiv.html(`<div class="alert alert-danger">Error: ${xhr.statusText || 'Tidak bisa terhubung ke server.'}</div>`);
            }
        });
    });
});