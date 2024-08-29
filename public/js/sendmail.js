var btn = document.getElementById('btn-submit');
btn.addEventListener('click', function (e) {
  e.preventDefault();
  var name = document.getElementById('name').value;
  var email = document.getElementById('email').value;
  var subject = document.getElementById('subject').value;
  var message = document.getElementById('message').value;

  var body = 'Name: ' + name + '<br/> Email: ' + email + '<br/> Subject: ' + subject +
    '<br/> Message: ' + message;

  Email.send({
    SecureToken: "835533b4-e3f1-4f31-b1a6-71bbd361a843",
    To: 'analyticgames@gmail.com',
    From: "nadya.15.a3@gmail.com",
    Subject: "Contact Message",
    Body: body
  }).then(function (message) {
    const toastLiveExample = new bootstrap.Toast(document.getElementById('liveToastMailSend'));

    if (message === 'OK') {
      toastLiveExample.show();
    } else {
      var errorMessageBox = document.querySelector('.error-message');
      errorMessageBox.textContent = 'Error sending message. Please try again.';
      toastLiveExample.show();
    }
  });
});
