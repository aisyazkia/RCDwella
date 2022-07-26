@extends('layouts.admin.index')
@section('content')
<div class="container">
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
    <div class="row mb-4">
        <div class="col-lg-5">
          <div class="card mb-4">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <img src="{{ asset($user->image) }}" alt="avatar"
                class="rounded-circle img-fluid" width="100%">
                </div>
                <div class="col-md-8">
                  <form action="{{ route('admin.profile.image.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                      <label for="formFile" class="form-label">Foto</label>
                      <input class="form-control" type="file" name="image" id="formFile" accept="image/jpg,image/png">
                      @error('image')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="text-end">
                      <button type="submit" class="btn btn-info">Ubah</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="card mb-4">
            <div class="card-body">
              <form action="{{ route('admin.profile.update',auth()->id()) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Nama</p>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-sm-3">
                    <p class="mb-0">Email</p>
                  </div>
                  <div class="col-sm-9">
                    <p class="text-muted mb-0">{{ $user->name }}</p>
                  </div>
                </div>
                <hr>
                <div class="row mb-3">
                  <div class="col-sm-3">
                    <p class="mb-0">No Telepon</p>
                  </div>
                  <div class="col-sm-9">
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone? $user->phone : '' }}">
                    @error('phone')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                  </div>
                </div>
                <div class="text-end">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection