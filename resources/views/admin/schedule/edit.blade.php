@extends('layouts.admin.index')
@section('content')
<div class="row mb-3">
    <div class="col-md-6">
        <h4>Edit Jadwal Praktek</h4>
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
                <form action="{{ route('admin.schedule.update', $detail->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="" class="form-label">Hari</label>
                        <select name="day" id="" class="form-control select2" data-placeholder="Pilih hari">
                            <option value=""></option>
                            <option value="1" {{ $detail->day == '1'? 'selected' : '' }}>Senin</option>
                            <option value="2" {{ $detail->day == '2'? 'selected' : '' }}>Selasa</option>
                            <option value="3" {{ $detail->day == '3'? 'selected' : '' }}>Rabu</option>
                            <option value="4" {{ $detail->day == '4'? 'selected' : '' }}>Kamis</option>
                            <option value="5" {{ $detail->day == '5'? 'selected' : '' }}>Jumat</option>
                            <option value="6" {{ $detail->day == '6'? 'selected' : '' }}>Sabtu</option>
                            <option value="7" {{ $detail->day == '7'? 'selected' : '' }}>Minggu</option>
                        </select>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Jam Praktik</label>
                        <div class="row" id="time-contents">
                            @foreach ($detail->detail as $item)
                                <div class="col-md-4 time--items mb-3">
                                    <div class="input-group">
                                        <input name="time[]" type="time" class="form-control" value="{{ date('H:i',strtotime($item->time)) }}">
                                        @if ($loop->iteration > 1)
                                        <div class="input-group-text p-0">
                                            <button type="button" class="btn btn-danger rounded-0 remove-item"><i class="fa fa-times"></i></button>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
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