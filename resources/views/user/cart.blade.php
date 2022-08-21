@extends('layouts.home.index')
@section('content')
<div class="container pt-5">
  <section id="produk">
    <div class="section-title mt-3">
      <h2>Keranjang</h2>
    </div>
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
    <div class="card mb-4">
      <div class="card-body">
        <p class="mb-4"><span class="text-success font-italic me-1">Keranjang</span>
        </p>
        <div class="table-responsive">
          <table class="table" id="booked--history-table">
            <thead class="bg-success text-light">
              <tr>
                <th class="text-white" width="30px">No.</th>
                <th class="text-white" width="250px">Produk</th>
                <th class="text-white">Harga</th>
                <th class="text-white" width="200px">Jumlah</th>
                <th class="text-white">Total</th>
                <th class="text-white">#</th>
              </tr>
            </thead>
            <tbody>
              @if (count($carts))
                @foreach ($carts as $item)
                  <tr>
                    <td>{{ $loop->iteration }}.</td>
                    <td>
                      <div class="d-flex align-items-center">
                        <img src="{{ $item->product->image? asset($item->product->image) : asset('img/gallery/gallery-2.jpg') }}" alt="" width="100px">
                        <span class="ms-3">{{ $item->product->name }}</span>
                      </div>
                    </td>
                    <td>
                      Rp{{ number_format($item->product->price,0,',','.') }}
                    </td>
                    <td>
                      <form action="{{ route('user.cart.update',$item->id) }}" class="input-group" method="POST">
                        @csrf
                        @method('put')
                        <input type="number" name="qty" class="form-control" value="{{ $item->qty }}" min="1">
                        <button type="submit" class="btn btn-sm btn-success input-group-btn">Simpan</button>
                      </form>
                    </td>
                    <td>
                      Rp{{ number_format($item->product->price*$item->qty,0,',','.') }}
                    </td>
                    <td>
                      <form action="{{ route('user.cart.destroy',$item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus produk dari keranjang?')"><i class="fa fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6" align="center">
                    Belum ada Keranjang
                  </td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
      <div class="card-body">
        <div class="text-end">
          <ul class="list-unstyled">
              <li class="mb-2">Subtotal <span class="ms-3 fw-bold">Rp{{ number_format($subtotal,0,',','.') }}</span></li>
          </ul>
          <div class="button5">
              <a href="{{ route('user.checkout.index') }}" class="btn btn-success">Checkout</a>
          </div>
      </div>
      </div>
    </div>
  </section>
</div>
@endsection