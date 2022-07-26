@extends('layouts.admin.index')
@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h4>Tambah Jadwal Praktek</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-6">

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

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.schedule.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Hari</label>
                        <select name="day" id="" class="form-control select2" data-placeholder="Pilih hari">
                            <option value=""></option>
                            <option value="1" {{ old('day') == '1'? 'selected' : '' }}>Senin</option>
                            <option value="2" {{ old('day') == '2'? 'selected' : '' }}>Selasa</option>
                            <option value="3" {{ old('day') == '3'? 'selected' : '' }}>Rabu</option>
                            <option value="4" {{ old('day') == '4'? 'selected' : '' }}>Kamis</option>
                            <option value="5" {{ old('day') == '5'? 'selected' : '' }}>Jumat</option>
                            <option value="6" {{ old('day') == '6'? 'selected' : '' }}>Sabtu</option>
                            <option value="7" {{ old('day') == '7'? 'selected' : '' }}>Minggu</option>
                        </select>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Jam Praktik</label>
                        <div class="row" id="time-contents">
                            <div class="col-md-4 time--items mb-3">
                                <div class="input-group">
                                    <input name="time[]" type="time" class="form-control" value="">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <button type="button" class="btn btn-primary" id="add--time-schedule"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>

    $(document).on('click','#time-contents #add--time-schedule', function(e){
        e.preventDefault();
        let lastItem = $('#time-contents .time--items').last()

        $(`<div class="col-md-4 time--items mb-3">
                <div class="input-group">
                    <input name="time[]" type="time" class="form-control">
                    <div class="input-group-text p-0">
                        <button type="button" class="btn btn-danger rounded-0 remove-item"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            </div>`).insertAfter(lastItem)

    })

    $(document).on('click','#time-contents .time--items .remove-item', function(e){
        e.preventDefault()
        $(this).parents('.time--items').remove()
    })

</script>
@endsection