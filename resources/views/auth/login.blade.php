@extends('layouts.auth')
@section('content')
  <div class="container d-flex align-items-center" style="height: 100vh;min-height:580px;">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center align-items-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4">Sign-in</p>

                @if (session('success'))
                    <div class="alert alert-success">
                      {{ session('success') }}
                    </div>
                @endif

                @if ($errors->has('error'))
                    <div class="alert alert-danger">
                      {{ $errors->first('error') }}
                    </div>
                @endif

                <form class="mx-1 mx-md-4" action="{{ route('auth.login.send') }}" method="post">

                  @csrf

                  <div class="mb-3">
                    <label class="form-label" for="form3Example1c">Email</label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="fas fa-user fa-lg fa-fw"></i>
                      </span>
                      <input name="email" type="email" id="form3Example1c" class="form-control" value="{{ old('email') }}" />
                    </div>
                    @error('email')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="mb-3">
                    <label class="form-label" for="form3Example4c">Password</label>
                    <div class="input-group">
                      <span class="input-group-text">
                        <i class="fas fa-lock fa-lg fa-fw"></i>
                      </span>
                      <input name="password" type="password" id="form3Example4c" class="form-control" />
                    </div>
                    @error('password')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>

                  <div class="d-flex justify-content-center mx-1 mb-3 mb-lg-4">
                    <button type="submit" class="btn btn-primary ">Login</button>
                  </div>

                  <p class="text-center">
                    <span>Belum punya akun?</span>
                    <a href="{{ url('register') }}">
                      <span>Buat Akun</span>
                    </a>
                  </p>

                </form>

              </div>
              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                <img src="img/gallery/regis.png"
                  class="img-fluid" alt="Sample image">

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection