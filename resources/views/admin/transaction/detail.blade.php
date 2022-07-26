@extends('layouts.admin.index')
@section('content')
<div class="card border-0">
    <div class="card-body">
        <p class="mb-4"><span class="text-primary font-italic me-1">Detail</span> Perjanjian
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
                            $action = '';
                            $status = 'bg-secondary';
                            $status_name = 'Tidak diketahui';
                            if($detail->status == 'PENDING')
                            {
                                $status = 'bg-warning';
                                $status_name = 'Menunggu di proses';
                                $action = '<a href="'.route('admin.transaction.show',$detail->id).'" class="btn btn-info mb-1">Detail</a>
                                    
                                <button class="btn btn-success btn--process ms-1 mb-1" data-id="'.$detail->id.'" data-bs-toggle="modal" data-bs-target="#ModalProcess">Proses</button>

                                <button class="btn btn-danger btn--reject ms-1" data-id="'.$detail->id.'" data-bs-toggle="modal" data-bs-target="#ModalReject">Tolak</button>';

                            }elseif($detail->status == 'PROCESS')
                            {
                                $status = 'bg-info';
                                $status_name = 'Diproses';
                                $action = '<a href="'.route('admin.transaction.show',$detail->id).'" class="btn btn-info">Detail</a>
                                <button class="btn btn-success btn--delivered ms-1 mb-1" data-id="'.$detail->id.'" data-bs-toggle="modal" data-bs-target="#ModalDelivered">Kirim</button>';
                            }elseif($detail->status == 'DELIVERED')
                            {
                                $status = 'bg-success';
                                $status_name = 'Dikirim';
                            }elseif($detail->status == 'RECEIVED')
                            {
                                $status = 'bg-success';
                                $status_name = 'Diterima';
                            }elseif($detail->status == 'SUCCESS')
                            {
                                $status = 'bg-success';
                                $status_name = 'Selesai';
                            }elseif($detail->status == 'CANCEL')
                            {
                                $status = 'bg-danger';
                                $status_name = 'Dibatalkan';
                            }elseif($detail->status == 'REJECTED')
                            {
                                $status = 'bg-danger';
                                $status_name = 'Ditolak';
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


<div class="modal fade" id="ModalUploadPaymentProof" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalUploadPaymentProofLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalUploadPaymentProofLabel">Konfirmasi Pembayaran</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.schedule-booked.payment-confirm') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <div class="border rounded-sm overflow-hidden mb-3">
                <img src="{{ asset('img/logo.png') }}" alt="" width="80%" class="payment-view">
            </div>
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
                Apakah anda yakin ingin mengkonfirmasi pembayaran ini?
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Konfirmasi</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<div class="modal fade" id="ModalApprove" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalApproveLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalApproveLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.schedule-booked.approve') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
              Apakah anda yakin ingin mengkonfirmasi janji ini?
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

<div class="modal fade" id="ModalReject" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalRejectLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalRejectLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.schedule-booked.approve') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
              Apakah anda yakin ingin menolak janji ini?
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
    
    $(document).on('click','.btn--approve', function(e){
        e.preventDefault();
        $('#ModalApprove [name="id"]').val($(this).data('id'))
    })
    
    $(document).on('click','.btn--reject', function(e){
        e.preventDefault();
        $('#ModalReject [name="id"]').val($(this).data('id'))
    })

    $(document).on('click','.btn--payment-proof', function(e){
        e.preventDefault();
        $('#ModalUploadPaymentProof [name="id"]').val($(this).data('id'))
        $('#ModalUploadPaymentProof .payment-view').attr('src',$(this).data('paymentproof'))
    })

</script>
@endsection