@extends('layouts.auth')
@section('content')
  <div class="container d-flex align-items-center" style="height: 100vh;min-height:580px;">
    <div class="row d-flex justify-content-center align-items-center ">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row align-items-center justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4">Sign up</p>

                <form action="{{ route('auth.register.send') }}" method="post" class="mx-1 mx-md-4">

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

                  @csrf

                  <div class="mb-3">
                    <label class="form-label" for="form3Example1c">Your Name</label>
                    <input name="name" type="text" id="form3Example1c" class="form-control" value="{{ old('name') }}"/>
                    @error('name')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
                  </div>
                  
                  <div class="mb-3">
                      <label class="form-label" for="form3Example3c">Your Email</label>
                      <input name="email" type="email" id="form3Example3c" class="form-control"  value="{{ old('email') }}"/>
                      @error('email')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>
                  
                  <div class="mb-3">
                      <label class="form-label" for="formPhone">Your Phone</label>
                      <input name="phone" type="text" id="formPhone" class="form-control" value="{{ old('phone') }}" />
                      @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>
                  
                  <div class="mb-3">
                      <label class="form-label" for="formPhone">Your Address</label>
                      <textarea name="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                      @error('address')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>

                  <div class="mb-3">
                      <label class="form-label" for="form3Example4c">Password</label>
                      <input name="password" type="password" id="form3Example4c" class="form-control" />
                      @error('password')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>

                  <div class="mb-3">
                      <label class="form-label" for="form3Example4cd">Repeat your password</label>
                      <input name="password_confirmation" type="password" id="form3Example4cd" class="form-control" />
                      @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>

                  <div class="form-check d-flex justify-content-center mb-3">
                    <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3c" checked required/>
                    <label class="form-check-label" for="form2Example3">
                      I agree all statements in <a href="#!">Terms of service</a>
                    </label>
                  </div>

                  <div class="d-flex justify-content-center mx-1 mb-3 mb-lg-4">
                    <button type="submit" class="btn btn-primary">Register</button>
                  </div>

                  <p class="text-center">
                    <span>Punya akun?</span>
                    <a href="{{ url('login') }}">
                      <span>Masuk</span>
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