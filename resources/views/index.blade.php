@extends('main')
@section('container')
    <div class="body-wrapper">
        <div class="container-fluid">
            <!-- Statistik Overview -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Nasabah</h5>
                            <h2 class="mb-0">{{ number_format($totalNasabah) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Pengajuan</h5>
                            <h2 class="mb-0">{{ number_format($totalPengajuan) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Dana Diajukan</h5>
                            <h2 class="mb-0">Rp {{ number_format($totalPengajuanDana) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Dana Disetujui</h5>
                            <h2 class="mb-0">Rp {{ number_format($totalAccDana) }}</h2>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Grafik -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Statistik Pengajuan Kredit</h5>
                            <select class="form-select" style="width: auto;" id="filterPeriode">
                                <option value="6">6 Bulan Terakhir</option>
                                <option value="12">1 Tahun Terakhir</option>
                            </select>
                        </div>
                        <div class="card-body">
                            <div id="grafikPengajuan" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Status BI Checking dan Status Pengajuan -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Status BI Checking</h5>
                        </div>
                        <div class="card-body">
                            <div id="biCheckingChart" style="height: 400px;"></div> <!-- Tempat Grafik -->
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Status Pengajuan</h5>
                        </div>
                        <div class="card-body">
                            <div id="statusPengajuanChart" style="height: 400px;"></div> <!-- Tempat Grafik -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabel Produk -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Detail Produk SILANTAP</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Total Pengajuan</th>
                                            <th>Total Dana Diajukan</th>
                                            <th>Total Dana Disetujui</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ number_format($product->total_pengajuan) }}</td>
                                                <td>Rp {{ number_format($product->pengajuan_kredit_sum_jumlah_pengajuan) }}
                                                </td>
                                                <td>Rp {{ number_format($product->pengajuan_kredit_sum_jumlah_acc) }}</td>
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
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($pengajuanPerBulan);

            const options = {
                series: [{
                    name: 'Total Pengajuan',
                    data: chartData.map(item => item.total_pengajuan)
                }, {
                    name: 'Total Disetujui',
                    data: chartData.map(item => item.total_approved)
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: chartData.map(item => item.periode)
                },
                yaxis: {
                    title: {
                        text: 'Jumlah Pengajuan'
                    }
                },
                fill: {
                    opacity: 1
                }
            };

            const chart = new ApexCharts(document.querySelector("#grafikPengajuan"), options);
            chart.render();


            // Data Status BI Checking
            const biCheckingData = @json($biCheckingStats);
            const biCheckingLabels = Object.keys(biCheckingData);
            const biCheckingValues = Object.values(biCheckingData);
        
            // Data Status Pengajuan
            const statusPengajuanData = @json($statusPengajuan);
            const statusPengajuanLabels = Object.keys(statusPengajuanData);
            const statusPengajuanValues = Object.values(statusPengajuanData);
        
            // Chart Status BI Checking
            const biCheckingChart = new ApexCharts(document.querySelector("#biCheckingChart"), {
                series: biCheckingValues,
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: biCheckingLabels,
                legend: {
                    position: 'bottom'
                }
            });
            biCheckingChart.render();
        
            // Chart Status Pengajuan
            const statusPengajuanChart = new ApexCharts(document.querySelector("#statusPengajuanChart"), {
                series: statusPengajuanValues,
                chart: {
                    type: 'pie',
                    height: 350
                },
                labels: statusPengajuanLabels,
                legend: {
                    position: 'bottom'
                }
            });
            statusPengajuanChart.render();
        });
    </script>
   
@endsection
