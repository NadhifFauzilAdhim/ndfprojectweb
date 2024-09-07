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
                <a href="/" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('img/reset-password.jpg') }}" style="width: 200px;" alt="logo">
                </a>
                @if (session('status'))
                <div class="alert alert-success text-center">
                  {{ session('status') }}
                </div>
                @endif
                <h3 class="text-center">Reset Password</h3>
                <p class="text-center">Masukkan Email Yang Terdaftar</p>
                <form action="/forgot-password" method="POST">
                  @csrf
                  <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                      placeholder="Email address" autofocus required />
                    @error('email')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  
                  <button type="submit" class="btn btn-primary w-100 py-2 fs-4 mb-4">Send Reset Link</button>
                  
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </x-authlayout>
  