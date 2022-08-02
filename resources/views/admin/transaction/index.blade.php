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
        <h4>Transaksi</h4>
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
                        {{-- <th class="text-white">Ongkir</th> --}}
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

<div class="modal fade" id="ModalProcess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalProcessLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalProcessLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.transaction.process') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
              Apakah anda yakin ingin mengkonfirmasi pesanan ini?
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

  <div class="modal fade" id="ModalDelivered" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ModalDeliveredLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalDeliveredLabel">Konfirmasi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.transaction.delivered') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
              Apakah anda yakin ingin mengirim pesanan ini?
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
        <form action="{{ route('admin.transaction.reject') }}" method="POST">
        <div class="modal-body">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="">
            <div class="alert alert-warning">
              Apakah anda yakin ingin menolak pesanan ini?
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
                data: 'created_at',
                name: 'created_at'
            },
            // {
            //     data: 'shipping_cost',
            //     name: 'shipping_cost'
            // },
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

    $(document).on('click','#data-with-datatable .btn--process', function(e){
        e.preventDefault();
        $('#ModalProcess [name="id"]').val($(this).data('id'))
    })
    
    $(document).on('click','#data-with-datatable .btn--delivered', function(e){
        e.preventDefault();
        $('#ModalDelivered [name="id"]').val($(this).data('id'))
    })
    
    $(document).on('click','#data-with-datatable .btn--reject', function(e){
        e.preventDefault();
        $('#ModalReject [name="id"]').val($(this).data('id'))
    })

</script>
@endsection