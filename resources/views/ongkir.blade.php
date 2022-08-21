<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cek Ongkos Kirim</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="card mt-5">
            <form action="{{ url('/ongkir') }}" class="form-horizontal" role="form" method="POST">
                @csrf
                <div class="card-body">
                    <h3 style="text-align: center">Cek Ongkos Kirim</h3>
                    <h6 style="margin-top: 30px">Mengirim ke</h6>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Provinsi Tujuan</label>
                                <select name="province_destination" class="form-control" holder>
                                    <option value="">Pilih Provinsi</option>
                                    @foreach ($provinces as $province => $value)
                                    <option value="{{ $province }}"> {{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="">Kota Tujuan</label>
                                <select name="city_destination" class="form-control" >
                                    <option>Pilih Kota</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-sm-3">
                            <select name="" id="" class="form-control" holder>Pilih Kurir</select>
                        </div> --}}
                        <div class="col-sm-3 mt-4">
                            <button type="submit" class="btn btn-info btn-block">Hitung Ongkir</button>
                        </div>
                        <div class="col-sm-3 mt-4">
                            <button class="btn btn-success d-block"><a href="/checkout" style="color: aliceblue">Kembali ke halaman checkout</a></button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- <div class="row">
                <div class="col">
                    @foreach ($cekongkir as $cost => $value)
                    
                    @endforeach
                </div>
            </div> --}}
        </div>
    </div>






    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('select[name="province_destination"]').on('change', function(){
                let provinceId = $(this).val();
                if(provinceId) {
                    jQuery.ajax({
                        url: '/ongkir/province/'+provinceId+'/cities',
                        type: "GET",
                        dataType: "json",
                        success:function(data){
                            $('select[name="city_destination"]').empty();
                            $.each(data, function(key, value){
                                $('select[name="city_destination"]').append('<option value="'+ key +'">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="city_destination"]').empty();
                }
            });
        });
    </script>
</body>
</html>