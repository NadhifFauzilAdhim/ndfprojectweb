const title = document.querySelector('#title');
      const slug = document.querySelector('#slug');
      const dropArea = document.getElementById('drop-area');
      const fileInput = document.getElementById('image');
      const imgPreview = document.getElementById('imgPreview');
      const progressBar = document.getElementById('progressBar');
      const progressWrapper = document.getElementById('progressWrapper');
      const postForm = document.getElementById('postForm');

      // Generate slug from title
      title.addEventListener('change', function() {
          fetch('/dashboard/posts/checkSlug?title=' + title.value)
              .then(response => response.json())
              .then(data => slug.value = data.slug);
      });

      // Drag and Drop Events
      dropArea.addEventListener('dragover', (event) => {
          event.preventDefault();
          dropArea.classList.add('bg-light');
      });

      dropArea.addEventListener('dragleave', (event) => {
          event.preventDefault();
          dropArea.classList.remove('bg-light');
      });

      dropArea.addEventListener('drop', (event) => {
          event.preventDefault();
          dropArea.classList.remove('bg-light');
          const files = event.dataTransfer.files;
          if (files.length) {
              fileInput.files = files;
              previewImage();
          }
      });

      dropArea.addEventListener('click', () => {
          fileInput.click();
      });

      // Image Preview Function
      function previewImage() {
          const image = fileInput.files[0];
          const oFReader = new FileReader();

          if (image) {
              imgPreview.style.display = 'block';
              oFReader.readAsDataURL(image);

              oFReader.onload = function(oFREvent) {
                  imgPreview.src = oFREvent.target.result;
              };
          }
      }

      // AJAX File Upload with Progress Bar
      postForm.addEventListener('submit', function(event) {
          event.preventDefault();
          const formData = new FormData(postForm);

          const xhr = new XMLHttpRequest();
          xhr.open('POST', postForm.action, true);

          // Show progress bar
          progressWrapper.style.display = 'block';

          xhr.upload.onprogress = function(event) {
              if (event.lengthComputable) {
                  const percentComplete = Math.round((event.loaded / event.total) * 100);
                  progressBar.style.width = percentComplete + '%';
                  progressBar.textContent = percentComplete + '%';
              }
          };

          xhr.onload = function() {
              if (xhr.status === 200) {
                  // Upload complete
                  alert('Upload successful!');
                  progressWrapper.style.display = 'none';
                  progressBar.style.width = '0%';
                  progressBar.textContent = '0%';
                  postForm.reset();
                  imgPreview.style.display = 'none';
              } else {
                  // Upload failed
                  alert('Upload failed, please try again.');
              }
          };

          xhr.onerror = function() {
              // Network error
              alert('Upload failed due to a network error.');
          };

          xhr.send(formData);
      });