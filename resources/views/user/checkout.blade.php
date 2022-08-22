@extends('layouts.home.index')
@section('content')
<div class="container mt-4">
  <div class="py-5 text-center">
    <h2>Checkout</h2>
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
  <form action="{{ route('user.checkout.store') }}" method="POST">
    @csrf
    <div class="row">
      <div class="col-md-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <p class="mb-4"><span class="text-success font-italic me-1">Detail</span>
            </p>
            <div class="row mb-3">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="mb-2" for="form-name">Nama</label>
                  <input type="text" name="name" class="form-control" id="form-name" placeholder="Nama" value="{{ old('name')? old('name') : $user->name }}">
                  @error('name')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="mb-2" for="form-phone">No Telepon</label>
                  <input type="text" name="phone" class="form-control" id="form-phone" placeholder="No Telepon" value="{{ old('phone')? old('phone') : $user->phone }}">
                  @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="mb-2" for="form-email">Email</label>
                      <input type="email" name="email" class="form-control" id="form-email" placeholder="Email" value="{{ old('email')? old('email') : $user->email }}">
                      @error('email')
                        <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <label for="">Alamat</label>
                <textarea name="address" rows="2" class="form-control" placeholder="Masukkan alamat lengkap">{{ old('address') }}</textarea>
                @error('address')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="col-sm-6">
                <div class="mb-3 mt-3">
                  <label class="mb-2" for="form-ongkir">Ongkos Kirim</label>
                  <input type="number" name="ongkir" class="form-control" placeholder="Masukkan Ongkos kirim" value="">
                  @error('ongkir')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
                </div>
              </div>
              <div class="col-sm-3 mt-5">
                  <button class="btn btn-info btn-block"> <a href="/ongkir" style="color: aliceblue">Cek Ongkir</a> </button>
              </div>
              {{-- <div class="col-md-12">
                <label for="">Ongkir</label>
                <input type="number" name="ongkir" class="form-control" placeholder="Masukkan Ongkos kirim">
                @error('ongkir')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div> --}}
            </div>
            <div class="row">
              <div class="col-md-12">
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
                              {{ $item->qty }}
                            </td>
                            <td>
                              Rp{{ number_format($item->product->price*$item->qty,0,',','.') }}
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
            </div>
          </div>
        </div>
        
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <div class="col-md-12">
              <div class="row mb-3">
                <div class="col-12">
                  <label for="" class="mb-2">Metode Pembayaran</label>
                  <p>Silahkan cek ongkos kirim dan menuliskannya pada kolom ongkos kirim jika memilih metode pembayaran Transfer</p>
                  <div class="mb-3">
                    @error('payment_method')
                    <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                    {{-- <h4 class="mb-0 fw-bold">COD</h4>
                    <span class="text-muted">
                      Silahkan lakukan pembayaran ditempat
                    </span> --}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class=" mb-3">
                @foreach ($payment_method as $payment)
                <div class="col-md-3">
                  <textarea hidden class="payment-content-{{ $payment->id }}">{{ $payment->content }}</textarea>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment_method" id="paymentMethod{{ $payment->id }}" value="{{ $payment->id }}" {{ old('payment_method') == $payment->id? 'checked' : '' }}>
                    <label class="form-check-label" for="paymentMethod{{ $payment->id }}">
                      &nbsp; {{ $payment->name }}
                    </label>
                  </div>
                </div>
                @endforeach
              </div>
              <div class="payment-transfer-content"></div>
              {{-- <div class="mb-2">
                <label for="" class="mb-1 fw-bold">Kurir</label>
                <select name="courier" class="form-control select2" data-placeholder="Pilih Kurir">
                  <option value="">-- Pilih Kurir --</option>
                  <option value="1">Ambil Sendiri Rp0</option>
                  <option value="2">Gosend Rp{{ number_format(env('SHIPPING_COST'),0,',','.') }}</option>
                </select>
                @error('courier')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
              </div> --}}
              <input type="number" class="d-none" id="total-all-input" hidden="hidden" value="{{ $subtotal }}">
              {{-- <div class="mb-2 d-flex align-items-center justify-content-between">
                <label for="">Subtotal</label>
                <div class="fw-bold">Rp{{ number_format($subtotal,0,',','.') }}</div>
              </div> --}}
              <div class="mb-3 d-flex align-items-center justify-content-between">
                <label for="">Total</label>
                <div class="fw-bold" id="total-all">Rp{{ number_format($subtotal,0,',','.') }}</div>
              </div>
              <div class="text-end">
                <button type="submit" onsubmit="return confirm('Apakah anda yakin ingin membuat pesanan ini?')" class="btn btn-success d-block w-100">Buat Pesanan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@section('js')
<script>
  $(document).on('change','[name="payment_method"]',function(){
    let contentTf = $('.payment-content-'+$(this).val()).val()
    $('.payment-transfer-content').html(contentTf)
  })
  $(document).on('input','[name="ongkir"]', function(){
    let total = $('#total-all-input').val()
    $('#total-all').html('Rp'+toIdr(parseInt(total)+parseInt($(this).val())))

  })
  // $(document).on('change','[name="courier"]', function(e){
  //   let total =0
  //   $('#total-all').html('Rp'+toIdr(total))
    // let total = $('#total-all-input').val()
    // if($(this).val() == '2')
    // {
    //   $('#total-all').html('Rp'+toIdr(parseInt(total)+parseInt({{ env('SHIPPING_COST',5000) }})))
    // }else if($(this).val() == '1'){
    //   $('#total-all').html('Rp'+toIdr(total))
    // }else{
    //   $('#total-all').html('Rp'+toIdr(total))
    // }
  // })
</script>
@endsection