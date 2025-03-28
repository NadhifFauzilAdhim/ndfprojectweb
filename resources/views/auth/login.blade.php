<x-authlayout>
  <x-slot:title>{{ $title }}</x-slot:title>
  <div class="page-wrapper min-vh-100 d-flex align-items-center justify-content-center bg-light auth-background">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card border-0 shadow-lg overflow-hidden loginblury-background rounded-5">
            <div class=" text-dark text-center pt-2">
              <a href="/" class="text-decoration-none">
                <img src="{{ asset('img/linksy-ndfproject.png') }}" alt="logo" class="img-fluid" style="max-height: 70px;">
              </a>
              <h3 class="mt-3 mb-0">Welcome Back</h3>
              <p class="mb-0">Sign in to continue</p>
            </div>
            
            <div class="card-body rounded-5">

              <div class="card-footer bg-transparent text-center pt-0">
                <div class="d-flex gap-3 justify-content-center">
                  <a href="{{ route('oauth.google') }}" class="btn btn-light border d-flex align-items-center justify-content-center gap-2 py-2 px-4 rounded-3 shadow-sm" style="text-decoration: none;">
                    <img src="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/google/google-original.svg" alt="Google Logo" width="20" height="20">
                    <span class="fw-semibold text-dark">Sign in with Google</span>
                  </a>
                </div>
              </div>
              @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                  {{ session('success') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif
              
              @error('loginfeedback')
                <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                  {{ $message }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @enderror

              <form method="POST" class="needs-validation" novalidate>
                @csrf
               
                <!-- Email Input -->
                <div class="mb-4">
                  <label class="form-label  small mb-2">Email Address</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                      <i class="bi bi-envelope-fill text-primary"></i>
                    </span>
                    <input type="email" 
                           class="form-control rounded-end @error('email') is-invalid @enderror" 
                           name="email"
                           placeholder="name@example.com"
                           required
                           autofocus>
                    <div class="invalid-feedback">
                      @error('email') {{ $message }} @else Please enter valid email @enderror
                    </div>
                  </div>
                </div>

                <!-- Password Input -->
                <div class="mb-4">
                  <label class="form-label small mb-2">Password</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                      <i class="bi bi-lock-fill text-primary"></i>
                    </span>
                    <input type="password" 
                           class="form-control rounded-end" 
                           name="password"
                           placeholder="••••••••"
                           required>
                  </div>
                  <div class="mt-2 text-end">
                    <a href="/forgot-password" class="text-decoration-none small">Forgot Password?</a>
                  </div>
                </div>
                <div class="text-center">
                  <x-turnstile data-theme="light"/>
                </div>
                <!-- Remember Me Checkbox -->
                <div class="mb-4 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label small fw-semibold" for="remember">
                      Remember me
                    </label>
                  </div>
                  <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                  </button>
                </div>
                <!-- Divider -->
                <div class="position-relative my-4">
                  <hr class="">
                  <div class="position-absolute top-50 start-50 translate-middle bg-white px-3 small ">
                    OR
                  </div>
                </div>
                <!-- Registration Link -->
                <div class="text-center">
                  <p class=" small mb-0">Don't have an account? 
                    <a href="/register" class="text-decoration-none text-primary fw-semibold">Create account</a>
                  </p>
                </div>
              </form>
            </div>
            <!-- Social Login (Optional) -->
           
          </div>
        </div>
      </div>
    </div>
  </div>
</x-authlayout>