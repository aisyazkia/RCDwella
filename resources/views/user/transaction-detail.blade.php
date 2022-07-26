@extends('layouts.home.index')
@section('content')
<div class="py-5">
    <div class="container mt-5">
        <div class="card border-0">
            <div class="card-body">
                <p class="mb-4"><span class="text-primary font-italic me-1">Detail</span> Transaksi
                </p>
                <div class="row"> 
                    <div class="col-lg-8 col-12">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="mb-2 font-weight-bold text-dark">Pengguna</h5>
                                <div class="row mb-3">
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group mb-2">
                                            <div class="row">
                                                <div class="col-md-2 col-3 text-dark">
                                                    <b>Nama</b>
                                                </div>
                                                <div class="col-1 text-right">
                                                    :
                                                </div>
                                                <div class="col-8 col-md-9">
                                                    <div class="text-muted" id="address--name">{{ $detail->name }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group mb-2">
                                            <div class="row">
                                                <div class="col-md-2 col-3 text-dark">
                                                    <b>Email</b>
                                                </div>
                                                <div class="col-1 text-right">
                                                    :
                                                </div>
                                                <div class="col-8 col-md-9">
                                                    <div class="text-muted" id="address--phone">{{ $detail->email }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group mb-2">
                                            <div class="row">
                                                <div class="col-md-2 col-3 text-dark">
                                                    <b>No HP</b>
                                                </div>
                                                <div class="col-1 text-right">
                                                    :
                                                </div>
                                                <div class="col-8 col-md-9">
                                                    <div class="text-muted" id="address--phone">{{ $detail->phone }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-12">
                                        <div class="form-group mb-2">
                                            <div class="row">
                                                <div class="col-md-2 col-3 text-dark">
                                                    <b>Alamat</b>
                                                </div>
                                                <div class="col-1 text-right">
                                                    :
                                                </div>
                                                <div class="col-8 col-md-9">
                                                    <div class="text-muted" id="address--phone">{{ $detail->address }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-primary text-white">
                                            <tr class="main-hading">
                                                <th class="text-white">Produk</th>
                                                <th class="text-white">Jumlah</th>
                                                <th class="text-white">Harga</th>
                                                <th class="text-white">Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <div style="max-height: 300px;overflow-y:auto">
                                        <table class="table" id="detail-product--data">
                                            <tbody class="bg-light">
                                                @foreach ($detail->detail as $item)
                                                    <tr>
                                                        <td>{{ $item->product->name }}</td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>Rp{{ number_format($item->price,0,',','.') }}</td>
                                                        <td>Rp{{ number_format($item->total,0,',','.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="card border-0 shadow-sm mb-3 m-0">
                            <div class="card-body">
                                @php
                                    $status = 'bg-secondary';
                                    $status_name = 'Tidak diketahui';
                                    $action = '-';
                                    if($detail->status == 'PENDING')
                                    {
                                        $status = 'bg-warning';
                                        $status_name = 'Menunggu di proses';
                                        $action = '
                                        <button class="btn btn-danger btn--cancel ms-1" data-id="'.$detail->id.'" data-bs-toggle="modal" data-bs-target="#TransactionModalCancel">Batal</button>';

                                    }elseif($detail->status == 'PROCESS')
                                    {
                                        $status = 'bg-info';
                                        $status_name = 'Diproses';
                                        $action = '';
                                    }elseif($detail->status == 'DELIVERED')
                                    {
                                        $status = 'bg-success';
                                        $status_name = 'Dikirim';
                                        $action = '
                                        <button class="btn btn-success  btn--received ms-1" data-id="'.$detail->id.'" data-bs-toggle="modal" data-bs-target="#TransactionModalReceived">Terima Pesanan</button>';
                                    }elseif($detail->status == 'RECEIVED')
                                    {
                                        $status = 'bg-success';
                                        $status_name = 'Diterima';
                                        $action = '
                                        <button class="btn btn-success ms-1 btn--done" data-id="'.$detail->id.'" data-bs-toggle="modal" data-bs-target="#TransactionModalDone">Selesai</button>';
                                    }elseif($detail->status == 'SUCCESS')
                                    {
                                        $status = 'bg-success';
                                        $status_name = 'Selesai';
                                        $action = '';
                                    }elseif($detail->status == 'CANCEL')
                                    {
                                        $status = 'bg-danger';
                                        $status_name = 'Dibatalkan';
                                        $action = '';
                                    }elseif($detail->status == 'REJECTED')
                                    {
                                        $status = 'bg-danger';
                                        $status_name = 'Ditolak';
                                        $action = '';
                                    }
                                @endphp
                                <span class="">Status: </span>
                                <span class="badge {{ $status }}">{{ $status_name }}</span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h4 class="mb-2 font-weight-bold text-dark">Pembayaran</h4>
                                    <div class="content">
                                        <h4 class="mb-1"><b>{{ $detail->payment->name }}</b></h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="text-dark">{!! $detail->payment->content !!}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h5 class="mb-2 font-weight-bold text-dark">Total</h5>
                                    <div class="content">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between text-dark"><span class="title--subtotal-pay">Ongkir (GOSEND)</span><span class="transaction--subtotal-pay">Rp{{ number_format($detail->shipping_cost,0,',','.') }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between text-dark"><span class="title--subtotal-pay">Subtotal</span><span class="transaction--subtotal-pay">Rp{{ number_format($detail->detail->sum('total'),0,',','.') }}</span></li>
                                            <li class="list-group-item d-flex justify-content-between text-dark"><span class="title--subtotal-pay">Yang harus dibayar</span><span class="transaction--subtotal-pay">Rp{{ number_format($detail->total,0,',','.') }}</span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    {!! $action !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="TransactionModalCancel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="TransactionModalCancelLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="TransactionModalCancelLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('user.profile.history.transaction.cancel') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
              Apakah anda yakin ingin membatalkan pesanan ini?
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-primary">Ya</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="TransactionModalReceived" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="TransactionModalReceivedLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="TransactionModalReceivedLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('user.profile.history.transaction.received') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
              Apakah anda yakin ingin menerima pesanan ini?
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-primary">Ya</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="TransactionModalDone" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="TransactionModalDoneLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="TransactionModalDoneLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('user.profile.history.transaction.received') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
              Apakah anda yakin ingin menyelesaikan pesanan ini?
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
            <button type="submit" class="btn btn-primary">Ya</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script>
    $(document).on('click','.btn--cancel', function(e){
        e.preventDefault();
        $('#TransactionModalCancel [name="id"]').val($(this).data('id'))
    })
    $(document).on('click','.btn--received', function(e){
        e.preventDefault();
        $('#TransactionModalReceived [name="id"]').val($(this).data('id'))
    })
    $(document).on('click','.btn--done', function(e){
        e.preventDefault();
        $('#TransactionModalDone [name="id"]').val($(this).data('id'))
    })
</script>
@endsection