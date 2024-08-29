<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kostify | {{ $title }}</title>
    <meta name="author" content="Kostify" />
    <link href="{{ asset('img/favicon.ico') }}" rel="icon"> 
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/auth.css') }}" rel="stylesheet">
</head>
<body style="background-image:url('img/banner.png');">
  <section class="h-100 gradient-form ">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">
                  <div class="text-center">
                    <img src="{{ asset('img/authlogo.png') }}"
                      style="width: 185px;" alt="logo">
                  </div>
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
                  <div class="text-center">
                    <p>Masukan Email dan Password yang terdaftar</p>
                  </div>
                  <form action="/login" method="POST">
                    @csrf 
                    <div class="form-outline mb-4">
                      <label class="form-label" for="email">Email</label>
                      <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email address" autofocus required/>
                        @error('email')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                    </div>  
                    <div class="form-outline mb-4">
                      <label class="form-label" for="password">Password</label>
                      <input type="password" id="password" name="password" placeholder="Masukan Password" class="form-control " autofocus required/>
                      <div id="frogotpassword" class="form-text"><a href="/forgotpassword" class="text-danger">Lupa Password?</a></div>
                    </div>
                    <div class="text-center pt-1 mb-5 pb-1">
                      <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="sumbit">Log
                        in</button>
                    </div>
                    <div class="d-flex align-items-center justify-content-center pb-4">
                      <p class="mb-0 me-2">Belum Punya Akun?</p>
                      <a href="">
                        <button type="button" class="btn btn-outline-warning">Create new</button>
                      </a>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-lg-6 d-flex align-items-center ">
                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                    <img class="mb-4" src="{{ asset('img/loginicon.jpg') }}" alt="" width="400px">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
</body>
</html>