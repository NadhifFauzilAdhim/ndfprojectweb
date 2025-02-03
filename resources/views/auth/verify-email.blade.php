<x-authlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
      data-sidebar-position="fixed" data-header-position="fixed">
      <div
        class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
          <div class="row justify-content-center w-100">
            <div class="col-md-8 col-lg-6 col-xxl-3">
              <div class="card mb-0">
                <div class="card-body">
                    @if (session()->has('resendsuccess'))
                  <div class="alert alert-success d-flex align-items-center justify-content-center" role="alert">  
                    <div>
                        {{ session('resendsuccess') }}
                    </div>
                  </div>
                  @endif
                  <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                    <img src="{{ asset('img/verifylogo.jpg') }}" alt="" width="200px">
                  </a>
                  <h5 class="text-center">Email Verifikasi Dikirimkan ke {{ Auth::user()->email }}</h5>
                  <div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">Tidak Menerima Email?</p>
                    <form action="/email/verification-notification" method="POST">
                        @csrf
                        <button type="sumbit" class="btn btn-outline-warning">Resend</button>
                    </form>
                     
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


</x-authlayout>

