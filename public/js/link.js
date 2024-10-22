var deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var linkId = button.getAttribute('data-id'); 
    var form = deleteModal.querySelector('#deleteForm');
    form.action = '/dashboard/link/' + linkId; 
});

var editModal = document.getElementById('editModal');
editModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var linkId = button.getAttribute('data-id');
    var targetUrl = button.getAttribute('data-target-url');
    var isActive = button.getAttribute('data-active'); 

    var form = editModal.querySelector('#editForm');
    form.action = '/dashboard/link/' + linkId;

    var input = editModal.querySelector('#editTargetUrl');
    input.value = targetUrl;

    var checkbox = editModal.querySelector('#flexSwitchCheckChecked');
    var label = editModal.querySelector('#switchLabel');
    checkbox.checked = (isActive == 1);  // Checked jika active bernilai 1
    label.textContent = checkbox.checked ? 'Active' : 'Inactive';
    checkbox.addEventListener('change', function () {
        label.textContent = checkbox.checked ? 'Active' : 'Inactive';
    });
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