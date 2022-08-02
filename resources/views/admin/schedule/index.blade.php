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
        <h4>Jadwal Praktik</h4>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.schedule.create') }}" class="btn btn-success">
            <i class="fa fa-plus"></i>
            Tambah
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="data-with-datatable">
                <thead class="bg-primary">
                    <tr>
                        <th class="text-white" width="30px">No</th>
                        <th class="text-white">Hari</th>
                        <th class="text-white">Jam Buka</th>
                        <th class="text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
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
                data: 'day',
                name: 'day'
            },
            {
                data: null,
                name: 'time',
                render: function(data){
                    let content = '<ul>'
                    $.each(data.time, function(i,key){
                      content += `<li>${key}</li>`  
                    })
                    return content
                }
            },
            {
                data: 'action',
                name: 'action'
            }
        ],
    });

</script>
@endsection