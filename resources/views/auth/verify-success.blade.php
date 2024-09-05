<x-authlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">a
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('img/verifysuccess.jpg') }}" alt="" width="200px">
                </a>
                <h5 class="text-center mb-4">Your Email has been verified <i class="bi bi-patch-check-fill text-primary"></i></h5>
                <div class="d-flex align-items-center justify-content-center pb-4">
                  <a href="/" class="btn btn-primary">Back to Home</a>    
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-authlayout>
