@extends('layouts.admin.index')
@section('content')

<div class="row mb-3">
    <div class="col-md-6">
        <h4>Dashboard</h4>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm bg-white">
                <div class="card-body d-flex align-items-center px-0 py-2">
                    <div class="w-25 px-3 bg-primary d-flex align-items-center justify-content-center py-4 ms-n2 rounded">
                        <i class="fa fa-users fa-2x text-white"></i>
                    </div>
                    <div class="w-75 flex-1 p-3">
                        <h4 class="text-dark text-muted">Total Pengguna</h4>
                        <div class="text-start">
                            <h2 class="text-dark fw-bold mb-0">{{ $user_count }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm bg-white">
                <div class="card-body d-flex align-items-center px-0 py-2">
                    <div class="w-25 px-3 bg-primary d-flex align-items-center justify-content-center py-4 ms-n2 rounded">
                        <i class="fa fa-box fa-2x text-white"></i>
                    </div>
                    <div class="w-75 flex-1 p-3">
                        <h4 class="text-dark text-muted">Total Treatment</h4>
                        <div class="text-start">
                            <h2 class="text-dark fw-bold mb-0">{{ $treatment_count }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm bg-white">
                <div class="card-body d-flex align-items-center px-0 py-2">
                    <div class="w-25 px-3 bg-primary d-flex align-items-center justify-content-center py-4 ms-n2 rounded">
                        <i class="fa fa-chart-line fa-2x text-white"></i>
                    </div>
                    <div class="w-75 flex-1 p-3">
                        <h4 class="text-dark text-muted">Total Transaksi</h4>
                        <div class="text-start">
                            <h2 class="text-dark fw-bold mb-0">{{ $transaction_count }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm bg-white">
                <div class="card-body d-flex align-items-center px-0 py-2">
                    <div class="w-25 px-3 bg-primary d-flex align-items-center justify-content-center py-4 ms-n2 rounded">
                        <i class="fa fa-chart-line fa-2x text-white"></i>
                    </div>
                    <div class="w-75 flex-1 p-3">
                        <h4 class="text-dark text-muted">Pemasukan Treatment</h4>
                        <div class="text-start">
                            <h2 class="text-dark fw-bold mb-0">Rp{{ number_format($treatment_total,0,',','.') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm bg-white">
                <div class="card-body d-flex align-items-center px-0 py-2">
                    <div class="w-25 px-3 bg-primary d-flex align-items-center justify-content-center py-4 ms-n2 rounded">
                        <i class="fa fa-chart-line fa-2x text-white"></i>
                    </div>
                    <div class="w-75 flex-1 p-3">
                        <h4 class="text-dark text-muted">Pemasukan Produk</h4>
                        <div class="text-start">
                            <h2 class="text-dark fw-bold mb-0">Rp{{ number_format($product_total,0,',','.') }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4>Treatment Per Bulan</h4>
                    <canvas id="treatmentPerMonth"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4>Produk Per Bulan</h4>
                    <canvas id="productPerMonth"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('vendor/chart.js/dist/chart.min.js') }}"></script>
<script>
    const ctx = document.getElementById('treatmentPerMonth').getContext('2d');
    const treatmentPerMonth = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ],
            datasets: [{
                label: '# Treatment Per Bulan',
                data: {!! json_encode($treatment_graph) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctx2 = document.getElementById('productPerMonth').getContext('2d');
    const productPerMonth = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: [
                'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember',
            ],
            datasets: [{
                label: '# Treatment Per Bulan',
                data:{!! json_encode($product_graph) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endsection