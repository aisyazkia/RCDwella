@extends('layouts.home.index')
@section('content')
<div class="container pt-5">
  <section id="produk">
    <div class="section-title mt-3">
      <h2>Produk</h2>
    </div>
    <div class="album py-1">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
        @foreach ($product as $item)
          <div class="col">
            <div class="card shadow-sm overflow-hidden">
              <div class="card-body px-0 pt-0">
                <img src="{{ url($item->image) }}" alt="" width="100%">
              </div>
              <div class="card-body">
                <h5>{{ $item->name }}</h5>
                <p class="card-text">{{ $item->description }}</p>
              </div>
              <div class="card-footer">
                <form action="{{ route('user.cart.store') }}" method="POST">
                  @csrf
                  <input type="text" name="id" value="{{ $item->id }}" hidden>
                  <button type="submit" class="btn btn-primary d-block w-100"><i class="fa fa-plus"></i> Tambahkan ke keranjang</button>
                </form>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
</div>
@endsection