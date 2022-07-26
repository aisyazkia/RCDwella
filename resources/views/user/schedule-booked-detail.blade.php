@extends('layouts.home.index')
@section('content')
<div class="py-5">
    <div class="container mt-5">
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
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="bg-primary text-white">
                                            <tr class="main-hading">
                                                <th class="text-white">Treatment</th>
                                                <th class="text-white">Harga</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <div style="max-height: 300px;overflow-y:auto">
                                        <table class="table" id="detail-product--data">
                                            <tbody class="bg-light">
                                                @foreach ($detail->detail as $item)
                                                    <tr>
                                                        <td>{{ $item->treatment->name }}</td>
                                                        <td>Rp{{ number_format($item->price,0,',','.') }}</td>
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
                                        $status_name = 'Menunggu Dibayar';
                                        $action = '
                                        <button class="btn btn-danger btn--cancel ms-1" data-id="'.$detail->id.'" data-bs-toggle="modal" data-bs-target="#ModalScheduleBookedCancel">Batal</button>';
                                    if($detail->payment->name != "COD")
                                    {
                                        $action .= '<button class="btn btn-secondary btn--payment-proof ms-1" data-id="'.$detail->id.'" data-payment="'.$detail->payment->name.'" data-paymentcontent="'.$detail->payment->content.'" data-bs-toggle="modal" data-bs-target="#ModalUploadPaymentProof">Upload Bukti</button>';
                                    }

                                    if($detail->payment_proof_status == '1')
                                    {
                                        $status = 'bg-info';
                                        $status_name = 'Proses pengecekan';
                                        $action = '';
                                    }elseif($detail->payment_proof_status == '2')
                                    {
                                        $status = 'bg-success';
                                        $status_name = 'Dibayar';
                                        $action = '';
                                    }

                                    }elseif($detail->status == 'APPROVE')
                                    {
                                        $status = 'bg-info';
                                        $status_name = 'Disetujui';
                                        $action = '
                                        <button class="btn btn-success ms-1 btn--done" data-id="'.$detail->id.'" data-bs-toggle="modal" data-bs-target="#ModalDone">Berikan Testimoni</button>';
                                    }elseif($detail->status == 'SUCCESS')
                                    {
                                        $status = 'bg-success';
                                        $status_name = 'Selesai';
                                        $action = '';
                                    }elseif($detail->status == 'REJECT')
                                    {
                                        $status = 'bg-danger';
                                        $status_name = 'Ditolak';
                                        $action = '';
                                    }elseif($detail->status == 'CANCEL')
                                    {
                                        $status = 'bg-danger';
                                        $status_name = 'Dibatalkan';
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
                                            <li class="list-group-item border-top border-secondary d-flex justify-content-between text-dark"><span class="title--subtotal-pay">Yang harus dibayar</span><span class="transaction--subtotal-pay">Rp{{ number_format($detail->total,0,',','.') }}</span></li>
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

<div class="modal fade" id="ModalUploadPaymentProof" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalUploadPaymentProofLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalUploadPaymentProofLabel">Upload Bukti Bayar</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('user.profile.history.booked.payment.upload') }}" enctype="multipart/form-data" method="POST">
        <div class="modal-body">
            @csrf
            <input type="hidden" name="id" value="">
            <h4 class="mb-1"><b class="payment-method"></b></h4>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="text-dark payment-content"></div>
                </div>
            </div>
            <div class="mb-3">
              <label for="filePaymentProof" class="form-label">Bukti Bayar</label>
              <input class="form-control" name="payment_proof" type="file" id="filePaymentProof">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Upload</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="ModalScheduleBookedCancel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalScheduleBookedCancelLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalScheduleBookedCancelLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('user.profile.history.booked.cancel') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
              Apakah anda yakin ingin membatalkan janji ini?
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
  
  <div class="modal fade" id="ModalDone" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalDoneLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalDoneLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('user.profile.history.booked.done') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <label for="">Rating</label>
            <div class="star--rating">
              <div class="star--rating-item">
                <i class="fas fa-star fa-2x"></i>
              </div>
              <div class="star--rating-item">
                <i class="fas fa-star fa-2x"></i>
              </div>
              <div class="star--rating-item">
                <i class="fas fa-star fa-2x"></i>
              </div>
              <div class="star--rating-item">
                <i class="fas fa-star fa-2x"></i>
              </div>
              <div class="star--rating-item">
                <i class="fas fa-star fa-2x"></i>
              </div>
              <input type="text" name="rating" class="star--rating-input d-none" value="0" hidden>
              @error('rating')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
            </div>
            <div class="mb-3">
              <label for="">Testimoni</label>
              <textarea name="comment" rows="2" class="form-control" placeholder="Masukkan testimoni"></textarea>
              @error('comment')
                      <small class="text-danger">{{ $message }}</small>
                    @enderror
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
@section('css')
<style>
    .star--rating {
        display: flex;
        gap: .5rem;
        margin: .5rem;
    }

    .star--rating .star--rating-item {
        color: #dedede;
        cursor: pointer;
    }
    .star--rating .star--rating-item.active {
        color: #ffe100;
    }
</style>
@endsection
@section('js')
<script>
    $(document).on('click','.btn--payment-proof', function(e){
        e.preventDefault();
        $('#ModalUploadPaymentProof [name="id"]').val($(this).data('id'))
        $('#ModalUploadPaymentProof .payment-method').html($(this).data('payment'))
        $('#ModalUploadPaymentProof .payment-content').html($(this).data('paymentcontent'))
    })
    $(document).on('click','.btn--done', function(e){
        e.preventDefault();
        $('#ModalDone [name="id"]').val($(this).data('id'))
    })
    $(document).on('click','.btn--cancel', function(e){
        e.preventDefault();
        $('#ModalScheduleBookedCancel [name="id"]').val($(this).data('id'))
    })
    $(document).on('click', '.star--rating .star--rating-item', function(){
        let ratingId = $(this).index()+1
        $('.star--rating .star--rating-item').removeClass('active')
        $(this).addClass('active')
        $(this).prevAll().addClass('active')
        $(this).parent().find('.star--rating-input').val(ratingId)
    })
</script>
@endsection