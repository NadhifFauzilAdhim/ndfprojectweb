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
                <img src="{{ asset('img/project/nprojectlogoblue.png') }}" style="width: 250px;" alt="logo">
              </a>
              @if (session('success'))
              <div class="alert alert-success text-center">
                {{ session('success') }}
              </div>
              @endif
              @error('loginfeedback')
              <div class="alert alert-danger text-center">
                {{ $message }}
              </div>
              @enderror
              <p class="text-center">Masukkan Email dan Password yang terdaftar</p>
              <form action="/login" method="POST">
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
                <div class="mb-4">
                  <label class="form-label" for="password">Password</label>
                  <input type="password" id="password" name="password" placeholder="Masukan Password"
                    class="form-control" required />
                  <div id="forgotpassword" class="form-text"><a href="/forgot-password" class="text-danger">Lupa
                      Password?</a></div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-4">
                  <div class="form-check">
                    <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label text-dark" for="flexCheckChecked">
                      Remember this Device
                    </label>
                  </div>
                  <a class="text-primary fw-bold" href="/forgotpassword">Forgot Password ?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 fs-4 mb-4">Log In</button>
                <div class="d-flex align-items-center justify-content-center">
                  <p class="fs-4 mb-0 fw-bold">Belum Punya Akun?</p>
                  <a class="text-primary fw-bold ms-2" href="/register">Create new</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</x-authlayout>
