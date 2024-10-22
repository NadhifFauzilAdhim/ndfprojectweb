var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button that triggered the modal
    var linkId = button.getAttribute('data-id'); // Extract info from data-* attributes
    var form = deleteModal.querySelector('#deleteForm');
    form.action = '/dashboard/link/' + linkId; // Set the form action to include the link ID
});

var editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var linkId = button.getAttribute('data-id');
    var targetUrl = button.getAttribute('data-target-url');
    
    // Set form action dynamically
    var form = editModal.querySelector('#editForm');
    form.action = '/dashboard/link/' + linkId;

    // Set the input value dynamically
    var input = editModal.querySelector('#editTargetUrl');
    input.value = targetUrl;
});

function copyFunction(slug) {
  var copyText = document.getElementById("linkInput-" + slug);
  copyText.select();
  copyText.setSelectionRange(0, 99999); 
  navigator.clipboard.writeText(copyText.value).then(function() {
    alert("Copied the text: " + copyText.value);
  }).catch(function(error) {
    console.error("Error copying text: ", error);
  });
}