<x-authlayout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <div class="page-wrapper min-vh-100 d-flex align-items-center justify-content-center bg-light auth-background">
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card border-0 shadow-lg overflow-hidden loginblury-background rounded-5">
            <div class="text-dark text-center pt-4">
                <a href="/" class="text-decoration-none">
                <img src="{{ asset('img/linksy-ndfproject.png') }}" alt="logo" class="img-fluid" style="max-height: 70px;">
                </a>
                <h3 class="mt-3 mb-0">Create an Account</h3>
                <p class="mb-0">Sign up to get started</p>
                @if(@session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (@session('error'))
                    <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endsession
            </div>

            <div class="card-body ">
                <form method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="mb-4">
                    <label class="form-label small mb-2">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-person-vcard text-primary"></i>
                        </span>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Full Name" required value="{{ old('name') }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label small mb-2">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-person-fill-check text-primary"></i>
                        </span>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username" required value="{{ old('username') }}">
                        @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label small mb-2">Email Address</label>
                    <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-envelope-fill text-primary"></i>
                    </span>
                    <input type="email" class="form-control rounded-end @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" required value="{{ old('email') }}">
                    <div class="invalid-feedback">
                        @error('email') {{ $message }} @else Please enter valid email @enderror
                    </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label small mb-2">Password</label>
                    <div class="input-group">
                    <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-lock-fill text-primary"></i>
                    </span>
                    <input type="password" class="form-control rounded-end @error('password') is-invalid @enderror" name="password" placeholder="••••••••" required>
                    </div>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-person-plus me-2"></i>Sign Up
                    </button>
                </div>

                <div class="position-relative my-4">
                    <hr>
                    <div class="position-absolute top-50 start-50 translate-middle bg-white px-3 small">OR</div>
                </div>

                <div class="text-center">
                    <p class="small mb-0">Already have an account? 
                    <a href="/login" class="text-decoration-none text-primary fw-semibold">Sign in</a>
                    </p>
                </div>
                </form>
            </div>

            <div class="card-footer bg-transparent text-center pt-1">
                <div class="d-flex gap-3 justify-content-center">
                <a href="#" class="btn btn-outline-secondary btn-icon rounded-circle">
                    <i class="bi bi-google"></i>
                </a>
                <a href="#" class="btn btn-outline-secondary btn-icon rounded-circle">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="#" class="btn btn-outline-secondary btn-icon rounded-circle">
                    <i class="bi bi-github"></i>
                </a>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</x-authlayout>
