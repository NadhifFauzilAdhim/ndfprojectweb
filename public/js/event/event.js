document.addEventListener('DOMContentLoaded', function () {
    // When the share button is clicked, show the modal and populate the URL
    document.querySelectorAll('.share-btn').forEach(button => {
        button.addEventListener('click', function () {
            const eventLink = this.getAttribute('data-event-link');
            const modalUrlInput = document.getElementById('shareEventUrl');
            const whatsappShareBtn = document.getElementById('shareWhatsapp');
            const xShareBtn = document.getElementById('shareX');

            // Set the event link in the modal input field
            modalUrlInput.value = eventLink;

            // Set the WhatsApp and X share links
            whatsappShareBtn.href = `https://wa.me/?text=${encodeURIComponent('Check out this event: ' + eventLink)}`;
            xShareBtn.href = `https://x.com/intent/tweet?text=${encodeURIComponent('Check out this event: ' + eventLink)}`;
        });
    });
});
