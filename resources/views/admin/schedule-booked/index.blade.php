@extends('layouts.admin.index')
@section('content')

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

<div class="row mb-3">
    <div class="col-md-6">
        <h4>Perjanjian</h4>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data-with-datatable">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white" width="30px">No</th>
                        <th class="text-white">Tanggal</th>
                        <th class="text-white">Jam</th>
                        <th class="text-white">Total</th>
                        <th class="text-white">Pembayaran</th>
                        <th class="text-white">Status</th>
                        <th class="text-white" width="250px">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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

    var datatable = $('#data-with-datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: false,
        lengthChange: true,
        pageLength: 10,
        destroy: true,
        bFilter: true,
        ajax: {
            url: "{{ Request::url() }}",
            type: "GET"
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                width: "30px"
            },
            {
                data: 'date',
                name: 'date'
            },
            {
                data: 'time',
                name: 'time'
            },
            {
                data: 'total',
                name: 'total'
            },
            {
                data: 'payment_method',
                name: 'payment_method'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action'
            }
        ],
    });

    $(document).on('click','#data-with-datatable .btn--approve', function(e){
        e.preventDefault();
        $('#ModalApprove [name="id"]').val($(this).data('id'))
    })
    
    $(document).on('click','#data-with-datatable .btn--reject', function(e){
        e.preventDefault();
        $('#ModalReject [name="id"]').val($(this).data('id'))
    })

    $(document).on('click','#data-with-datatable .btn--payment-proof', function(e){
        e.preventDefault();
        $('#ModalUploadPaymentProof [name="id"]').val($(this).data('id'))
        $('#ModalUploadPaymentProof .payment-view').attr('src',$(this).data('paymentproof'))
    })

</script>
@endsection