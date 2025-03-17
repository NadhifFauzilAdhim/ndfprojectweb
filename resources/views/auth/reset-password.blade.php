<x-authlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="page-wrapper" id="main-wrapper" >
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="/" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('img/reset-password.jpg') }}" style="width: 150px;" alt="logo">
                </a>
               
                @error('email')
                <div class="alert alert-danger text-center">
                  {{ $message }}
                </div>
                @enderror
                <h3 class="text-center">Reset Password</h3>
                <form action="/reset-password" method="POST">
                  @csrf
                  <input type="hidden" name="token" value="{{ $token }}">
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
                      class="form-control @error('password') is-invalid @enderror" required />
                    @error('password')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  </div>
                  <div class="mb-4">
                    <label class="form-label" for="password_confirmation">Password Confirmation</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Masukan Password"
                      class="form-control @error('password_confirmation') is-invalid @enderror" required />
                    @error('password_confirmation')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                    @enderror
                  
                  <button type="submit" class="btn btn-primary w-100 py-2 fs-4 mb-4 mt-5">Reset Password</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </x-authlayout>
  