@extends('layouts.home.index')
@section('content')
<div class="py-5">
<div class="container mt-5">
  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <section id="appointment">
        <div class="section-title mt-3">
          <h2>Buat Perjanjian</h2>
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
  
        <form action="{{ route('user.schedule-order.store') }}" method="post" class="">
          @csrf
          <div class="row">
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
            <div class="col-md-2">
              <div class="mb-3">
                <label class="mb-2" for="form-date">Tanggal</label>
                <input type="date" name="date" class="form-control" id="form-date" placeholder="Tanggal" value="{{ old('date') }}">
                @error('date')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-md-2">
              <div class="mb-3">
                <label class="mb-2" for="form-date">Jam</label>
                <select name="time" id="" class="form-control select2">
                  <option value="">Pilih jam jadwal</option>
                  @foreach ($schedule_detail as $item)
                      <option value="{{ date('H:i',strtotime($item->time)) }}" {{ old('time') == date('H:i',strtotime($item->time))? 'selected' : '' }}>{{ date('H:i',strtotime($item->time)) }}</option>
                  @endforeach
                </select>
                @error('time')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
            </div>
            <div class="col-md-8">
              <label class="mb-2" for="">Pilih menu treatment</label>
              @error('treatment')
                <small class="text-danger mb-3 d-block">{{ $message }}</small>
              @enderror
              <div class="row mb-3">
                @foreach ($treatments as $item)
                <div class="col-md-6 mb-2">
                  <div class="form-check">
                    <input class="form-check-input" name="treatment[]" type="checkbox" data-price="{{ $item->price }}" value="{{ $item->id }}" id="treatment{{ $item->id }}" {{ in_array($item->id,old("treatment")?? [])? 'checked' : '' }}>
                    <label class="form-check-label" for="treatment{{ $item->id }}">
                      &nbsp; {{ $item->name }} (Rp{{ number_format($item->price,0,'.','.') }})
                    </label>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <div class="col-12">
              <div class="row mb-3">
                <div class="col-2">
                  <span>Total Pembayaran : </span>
                </div>
                <div class="col-6" id="payment-total">
                  Rp0
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="row mb-3">
                <div class="col-2">
                  Metode Pembayaran
                  @error('payment_method')
                    <small class="text-danger d-block">{{ $message }}</small>
                  @enderror
                </div>
                <div class="col-8">
                  <div class="row mb-3">
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
                </div>
              </div>
            </div>
          </div>
  
          <div class="text-end"><button type="submit" class="btn btn-success">Buat Janji</button></div>
        </form>
  
      </section>
    </div>
  </div>
</div>

</div>
@endsection
@section('js')
<script>

  $(document).on('change','[name="payment_method"]',function(){
    let contentTf = $('.payment-content-'+$(this).val()).val()
    $('.payment-transfer-content').html(contentTf)
  })
  
  function generateSubTotal()
  {
    let total = 0
    $('[name="treatment[]"]').each(function(i,el){
      if(el.checked){
        total += $(el).data('price')
      }      
    })
    $('#payment-total').html('Rp'+toIdr(total))
  }

  $(document).on('change','[name="treatment[]"]',function(){
    generateSubTotal()
  })

</script>
@endsection