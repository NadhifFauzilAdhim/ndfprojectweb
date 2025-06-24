document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.reveal-ip-provider-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const ipAddress = this.dataset.ip;
            const cardBody = this.closest('.card-body');
            const infoDiv = cardBody.querySelector('.ip-provider-info');

            if (!infoDiv) {
                console.error('Error: ip-provider-info div not found.');
                return;
            }

            infoDiv.style.display = 'block';
            infoDiv.innerHTML = '<div class="spinner-border spinner-border-sm text-primary" role="status"><span class="visually-hidden">Loading...</span></div> Loading IP provider info...';
            this.style.display = 'none';

            fetch(`https://idnic.rdap.apnic.net/ip/${ipAddress}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    let providerName = 'N/A';
                    let providerDescription = 'N/A';

                    if (data.name) {
                        providerName = data.name;
                    }

                    if (data.remarks && data.remarks.length > 0 && data.remarks[0].description) {
                        providerDescription = data.remarks[0].description.join(', ');
                    }

                    infoDiv.innerHTML = `<strong>Provider:</strong> ${providerName}<br><strong>Description:</strong> ${providerDescription}`;
                })
                .catch(error => {
                    console.error('Error fetching IP provider data:', error);
                    infoDiv.innerHTML = `<span class="text-danger">Error: Could not retrieve provider info.</span>`;
                });
        });
    });
});