@extends('layouts.home.index')
@section('content')
  <section style="background-color: #eee;">
    <div class="container py-5">

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
                  <form action="{{ route('user.profile.image.update') }}" method="POST" enctype="multipart/form-data">
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
              <form action="{{ route('user.profile.update',auth()->id()) }}" method="POST">
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
      <div class="row">
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-body">
              <p class="mb-4"><span class="text-primary font-italic me-1">Riwayat</span> Perjanjian
              </p>
              <div class="table-responsive">
                <table class="table" id="booked--history-table">
                  <thead class="bg-primary text-light">
                    <tr>
                      <th class="text-white" width="30px">No</th>
                      <th class="text-white">Tanggal</th>
                      <th class="text-white">Jam</th>
                      <th class="text-white">Total</th>
                      <th class="text-white">Pembayaran</th>
                      <th class="text-white">Status</th>
                      <th class="text-white">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($schedule_booked as $key)
                     @php
                     /*
                      PENDING
                      PAID
                      APPROVE
                      REJECT
                      SUCCESS
                     */
                         $status = 'bg-secondary';
                         $status_name = 'Tidak diketahui';
                         $action = '-';
                         if($key->status == 'PENDING')
                         {
                          $status = 'bg-warning';
                          $status_name = 'Menunggu Dibayar';
                          $action = '<a href="'.route('user.profile.history.booked.detail',$key->id).'" class="btn btn-info">Detail</a>
                          <button class="btn btn-danger btn--cancel ms-1" data-id="'.$key->id.'" data-bs-toggle="modal" data-bs-target="#ModalScheduleBookedCancel">Batal</button>';
                          if($key->payment->name != "COD")
                          {
                            $action .= '<a href="'.$key->payment_url.'" class="btn btn-warning ms-1" target="blank">Bayar</a>';
                          }

                          if($key->payment_proof_status == '1')
                          {
                            $status = 'bg-info';
                            $status_name = 'Proses pengecekan';
                            $action = '<a href="'.route('user.profile.history.booked.detail',$key->id).'" class="btn btn-info">Detail</a>';
                          }elseif($key->payment_proof_status == '2')
                          {
                            $status = 'bg-success';
                            $status_name = 'Dibayar';
                            $action = '<a href="'.route('user.profile.history.booked.detail',$key->id).'" class="btn btn-info">Detail</a>';
                          }

                         }elseif($key->status == 'APPROVE')
                         {
                          $status = 'bg-info';
                          $status_name = 'Disetujui';
                          $action = '<a href="'.route('user.profile.history.booked.detail',$key->id).'" class="btn btn-info">Detail</a>
                          <button class="btn btn-success ms-1 btn--done" data-id="'.$key->id.'" data-bs-toggle="modal" data-bs-target="#ModalDone">Berikan Testimoni</button>';
                         }elseif($key->status == 'SUCCESS')
                         {
                          $status = 'bg-success';
                          $status_name = 'Selesai';
                          $action = '<a href="'.route('user.profile.history.booked.detail',$key->id).'" class="btn btn-info">Detail</a>';
                         }elseif($key->status == 'REJECT')
                         {
                          $status = 'bg-danger';
                          $status_name = 'Ditolak';
                          $action = '<a href="'.route('user.profile.history.booked.detail',$key->id).'" class="btn btn-info">Detail</a>';
                        }elseif($key->status == 'CANCEL')
                        {
                          $status = 'bg-danger';
                          $status_name = 'Dibatalkan';
                          $action = '<a href="'.route('user.profile.history.booked.detail',$key->id).'" class="btn btn-info">Detail</a>';
                         }
                     @endphp
                      <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{{ date('d M Y',strtotime($key->date)) }}</td>
                        <td>{{ date('H:i',strtotime($key->time)) }}</td>
                        <td>Rp{{ number_format($key->total,0,',','.') }}</td>
                        <td>{{ $key->payment->name }}</td>
                        <td><span class="badge {{ $status }}">{{ $status_name }}</span></td>
                        <td>
                          {!! $action !!}                          
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card mb-4">
            <div class="card-body">
              <p class="mb-4"><span class="text-primary font-italic me-1">Riwayat</span> Transaksi
              </p>
              <div class="table-responsive">
                <table class="table" id="transaction--history-table">
                  <thead class="bg-primary text-light">
                    <tr>
                      <th class="text-white" width="30px">No</th>
                      <th class="text-white">Tanggal Pemesanan</th>
                      <th class="text-white">Ongkir</th>
                      <th class="text-white">Total</th>
                      <th class="text-white">Status</th>
                      <th class="text-white">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($transaction as $key)
                    @php
                      /*
                        'PENDING',
                        'DELIVERED',
                        'RECEIVED',
                        'REJECT',
                        'CANCEL',
                        'SUCCESS'
                      */
                          $status = 'bg-secondary';
                          $status_name = 'Tidak diketahui';
                          $action = '-';
                          if($key->status == 'PENDING')
                          {
                            $status = 'bg-warning';
                            $status_name = 'Menunggu di proses';
                            $action = '<a href="'.route('user.profile.history.transaction.detail',$key->id).'" class="btn btn-info">Detail</a>
                            <button class="btn btn-danger btn--cancel ms-1" data-id="'.$key->id.'" data-bs-toggle="modal" data-bs-target="#TransactionModalCancel">Batal</button>';

                          }elseif($key->status == 'PROCESS')
                          {
                            $status = 'bg-info';
                            $status_name = 'Diproses';
                            $action = '<a href="'.route('user.profile.history.transaction.detail',$key->id).'" class="btn btn-info">Detail</a>';
                          }elseif($key->status == 'DELIVERED')
                          {
                            $status = 'bg-success';
                            $status_name = 'Dikirim';
                            $action = '<a href="'.route('user.profile.history.transaction.detail',$key->id).'" class="btn btn-info">Detail</a>
                            <button class="btn btn-success  btn--received ms-1" data-id="'.$key->id.'" data-bs-toggle="modal" data-bs-target="#TransactionModalReceived">Terima Pesanan</button>';
                          }elseif($key->status == 'RECEIVED')
                          {
                            $status = 'bg-success';
                            $status_name = 'Diterima';
                            $action = '<a href="'.route('user.profile.history.transaction.detail',$key->id).'" class="btn btn-info">Detail</a>
                            <button class="btn btn-success ms-1 btn--done" data-id="'.$key->id.'" data-bs-toggle="modal" data-bs-target="#TransactionModalDone">Selesai</button>';
                          }elseif($key->status == 'SUCCESS')
                          {
                            $status = 'bg-success';
                            $status_name = 'Selesai';
                            $action = '<a href="'.route('user.profile.history.transaction.detail',$key->id).'" class="btn btn-info">Detail</a>';
                          }elseif($key->status == 'CANCEL')
                          {
                            $status = 'bg-danger';
                            $status_name = 'Dibatalkan';
                            $action = '<a href="'.route('user.profile.history.transaction.detail',$key->id).'" class="btn btn-info">Detail</a>';
                          }elseif($key->status == 'REJECTED')
                          {
                            $status = 'bg-danger';
                            $status_name = 'Ditolak';
                            $action = '<a href="'.route('user.profile.history.transaction.detail',$key->id).'" class="btn btn-info">Detail</a>';
                          }
                      @endphp
                      <tr>
                        <th>1</th>
                        <td>{{ date('d M Y',strtotime($key->created_at)) }}</td>
                        <td>Rp{{ number_format($key->shipping_cost,0,',','.') }}</td>
                        <td>Rp{{ number_format($key->total,0,',','.') }}</td>
                        <td><span class="badge {{ $status }}">{{ $status_name }}</span></td>
                        <td>
                          {!! $action !!}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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
        <form action="{{ route('user.profile.history.transaction.done') }}" method="POST">
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
@section('css')
<link rel="stylesheet" href="{{ asset('') }}vendor/DataTables/datatables.min.css" />
<style>
  .page-link {
    position: relative;
    display: block;
    color: #0d6efd;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
  }
  @media (prefers-reduced-motion: reduce) {
    .page-link {
      transition: none;
    }
  }
  .page-link:hover {
    z-index: 2;
    color: #0a58ca;
    background-color: #e9ecef;
    border-color: #dee2e6;
  }
  .page-link:focus {
    z-index: 3;
    color: #0a58ca;
    background-color: #e9ecef;
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
  }

  .page-item:not(:first-child) .page-link {
    margin-left: -1px;
  }
  .page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
  }
  .page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
  }

  .page-link {
    padding: 0.375rem 0.75rem;
  }

  .page-item:first-child .page-link {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
  }
  .page-item:last-child .page-link {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
  }

  .pagination-lg .page-link {
    padding: 0.75rem 1.5rem;
    font-size: 1.25rem;
  }
  .pagination-lg .page-item:first-child .page-link {
    border-top-left-radius: 0.3rem;
    border-bottom-left-radius: 0.3rem;
  }
  .pagination-lg .page-item:last-child .page-link {
    border-top-right-radius: 0.3rem;
    border-bottom-right-radius: 0.3rem;
  }

  .pagination-sm .page-link {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }
  .pagination-sm .page-item:first-child .page-link {
    border-top-left-radius: 0.2rem;
    border-bottom-left-radius: 0.2rem;
  }
  .pagination-sm .page-item:last-child .page-link {
    border-top-right-radius: 0.2rem;
    border-bottom-right-radius: 0.2rem;
  }
  ul.pagination{
      display: flex;
      list-style: none;
  }

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
<script src="{{ asset('') }}vendor/DataTables/datatables.min.js"></script>
<script>
  $('#booked--history-table').DataTable()
  $('#transaction--history-table').DataTable()

  $(document).on('click','#booked--history-table .btn--payment-proof', function(e){
    e.preventDefault();
    $('#ModalUploadPaymentProof [name="id"]').val($(this).data('id'))
    $('#ModalUploadPaymentProof .payment-method').html($(this).data('payment'))
    $('#ModalUploadPaymentProof .payment-content').html($(this).data('paymentcontent'))
  })
  $(document).on('click','#booked--history-table .btn--cancel', function(e){
    e.preventDefault();
    $('#ModalScheduleBookedCancel [name="id"]').val($(this).data('id'))
  })
  $(document).on('click','#booked--history-table .btn--done', function(e){
    e.preventDefault();
    $('#ModalDone [name="id"]').val($(this).data('id'))
  })


  $(document).on('click','#transaction--history-table .btn--cancel', function(e){
    e.preventDefault();
    $('#TransactionModalCancel [name="id"]').val($(this).data('id'))
  })
  $(document).on('click','#transaction--history-table .btn--received', function(e){
    e.preventDefault();
    $('#TransactionModalReceived [name="id"]').val($(this).data('id'))
  })
  $(document).on('click','#transaction--history-table .btn--done', function(e){
    e.preventDefault();
    $('#TransactionModalDone [name="id"]').val($(this).data('id'))
  })

  $(document).on('click', '.star--rating .star--rating-item', function(){
    let ratingId = $(this).index()+1
    $('.star--rating .star--rating-item').removeClass('active')
    $(this).addClass('active')
    $(this).prevAll().addClass('active')
    $(this).parent().find('.star--rating-input').val(ratingId)
  })

  // $(document).on('mouseleave', '.star--rating', function(){    
  //   $('.star--rating .star--rating-item').removeClass('active')
  //   $(this).find('.star--rating-input').val(0)
  // })

</script>
@endsection