document.addEventListener('DOMContentLoaded', function() {
    const replyLinks = document.querySelectorAll('.reply');

    replyLinks.forEach(function(link) {
      link.addEventListener('click', function() {
        const commentId = this.getAttribute('data-comment-id');
        const replyForm = document.getElementById(`reply-form-${commentId}`);

        // Toggle visibility of the reply form
        if (replyForm.classList.contains('d-none')) {
          replyForm.classList.remove('d-none');
        } else {
          replyForm.classList.add('d-none');
        }
      });
    });
  });