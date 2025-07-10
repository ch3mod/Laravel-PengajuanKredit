@extends('main')

@section('container')
    <div class="body-wrapper">
        <div class="container-fluid">
            <!-- Header dengan tombol cetak -->
            <div class="d-flex justify-content-between align-items-center py-3">
                <div>
                    <h2 class="fw-bold mb-0">Detail Nasabah</h2>
                    <p class="text-muted mb-0">Informasi lengkap nasabah dan riwayat pengajuan kredit</p>
                </div>
                <div>
                    <a href="{{ route('laporan.cetak-single', $nasabah->id) }}" class="btn btn-primary" target="_blank">
                        <i class="ti ti-printer me-1"></i> Cetak Detail
                    </a>
                    <a href="{{ route('nasabah.dashboard') }}" class="btn btn-outline-secondary ms-2">
                        <i class="ti ti-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Informasi Dasar Nasabah -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Informasi Nasabah</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">

                                <h4 class="mt-3 mb-0">{{ $nasabah->nama }}</h4>
                                <p class="text-muted">No. Registrasi: {{ $nasabah->no_registrasi }}</p>
                                @php
                                    $statusColors = [
                                        'Lancar' => 'success',
                                        'Macet' => 'dark',
                                        'Diragukan' => 'danger',
                                        'Kurang Lancar' => 'danger',
                                        'Dalam Pengawasan Khusus' => 'warning',
                                    ];

                                    $color = $statusColors[$nasabah->bi_checking] ?? 'primary';
                                @endphp

                                <div class="d-flex justify-content-center mt-2">
                                    <span class="badge bg-{{ $color }} rounded-pill px-3 py-2">
                                        BI Checking: {{ $nasabah->bi_checking }}
                                    </span>
                                </div>

                            </div>

                            <div class="border-top pt-3">
                                <div class="mb-3">
                                    <label class="text-muted d-block">No. KTP</label>
                                    <span class="fs-5 fw-medium">{{ $nasabah->no_ktp }}</span>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted d-block">Alamat</label>
                                    <span class="fs-5 fw-medium">{{ $nasabah->alamat }}</span>
                                </div>
                                <div class="mb-3">
                                    <label class="text-muted d-block">No. Telepon</label>
                                    <span class="fs-5 fw-medium">{{ $nasabah->no_telepon }}</span>
                                </div>
                                <div class="mb-0">
                                    <label class="text-muted d-block">Terdaftar Sejak</label>
                                    <span
                                        class="fs-5 fw-medium">{{ \Carbon\Carbon::parse($nasabah->created_at)->format('d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Statistik -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Statistik Kredit</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <h6 class="text-muted mb-1">Total Pengajuan</h6>
                                        <h3 class="mb-0">{{ $nasabah->pengajuanKredit->count() }}</h3>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border rounded p-3 text-center">
                                        <h6 class="text-muted mb-1">% approved</h6>
                                        <h3 class="mb-0">
                                            {{ number_format($nasabah->pengajuanKredit->count() > 0 ? ($statusCounts['approved'] / $nasabah->pengajuanKredit->count()) * 100 : 0, 1) }}%
                                        </h3>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="border rounded p-3">
                                        <h6 class="text-muted mb-2">Status Pengajuan</h6>
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <span>Pending</span>
                                            </div>
                                            <div class="ms-auto">
                                                <span class="badge bg-warning">{{ $statusCounts['pending'] }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <span>approved</span>
                                            </div>
                                            <div class="ms-auto">
                                                <span class="badge bg-success">{{ $statusCounts['approved'] }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <span>rejected</span>
                                            </div>
                                            <div class="ms-auto">
                                                <span class="badge bg-danger">{{ $statusCounts['rejected'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Keuangan -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Ringkasan Keuangan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 border-bottom pb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Total Pengajuan</span>
                                    <span class="fw-bold fs-5">Rp {{ number_format($totalPengajuan, 0, ',', '.') }}</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                </div>
                            </div>
                            <div class="mb-3 border-bottom pb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted">Total ACC</span>
                                    <span class="fw-bold fs-5">Rp {{ number_format($totalAcc, 0, ',', '.') }}</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" style="width: {{ $ratioAcc }}%"></div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Rasio ACC</span>
                                    <span class="fw-bold fs-5">{{ number_format($ratioAcc, 1) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Pengajuan Kredit -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Riwayat Pengajuan Kredit</h5>
                            <span class="badge bg-white text-primary">{{ $nasabah->pengajuanKredit->count() }}
                                Pengajuan</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Produk</th>
                                            <th>Jaminan</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                            <th>approved</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($nasabah->pengajuanKredit as $pengajuan)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d M Y') }}
                                                </td>
                                                <td>{{ $pengajuan->product ? $pengajuan->product->nama : 'Produk tidak tersedia' }}
                                                </td>
                                                <td>{{ $pengajuan->jaminan }}</td>
                                                <td>Rp {{ number_format($pengajuan->jumlah_pengajuan, 0, ',', '.') }}</td>
                                                <td>
                                                    @if ($pengajuan->status == 'pending')
                                                        <span class="badge bg-warning text-dark">Pending</span>
                                                    @elseif($pengajuan->status == 'approved')
                                                        <span class="badge bg-success">approved</span>
                                                    @elseif($pengajuan->status == 'rejected')
                                                        <span class="badge bg-danger">rejected</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $pengajuan->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($pengajuan->status == 'approved')
                                                        Rp {{ number_format($pengajuan->jumlah_acc, 0, ',', '.') }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-3">Belum ada pengajuan kredit
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Pengajuan Terakhir -->
                    @if ($lastApplication)
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">Detail Pengajuan Terakhir</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <h6 class="mb-3 text-uppercase text-primary">Informasi Pengajuan</h6>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Tanggal Pengajuan</label>
                                            <span
                                                class="fw-medium">{{ \Carbon\Carbon::parse($lastApplication->tanggal_pengajuan)->format('d F Y') }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Produk</label>
                                            <span
                                                class="fw-medium">{{ $lastApplication->product ? $lastApplication->product->nama : 'Produk tidak tersedia' }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Jaminan</label>
                                            <span class="fw-medium">{{ $lastApplication->jaminan }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Jumlah Tanggungan</label>
                                            <span class="fw-medium">{{ $lastApplication->jumlah_tanggungan }} orang</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="mb-3 text-uppercase text-primary">Informasi Keuangan</h6>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Pemasukan</label>
                                            <span class="fw-medium">Rp
                                                {{ number_format($lastApplication->jumlah_pemasukan, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Pengeluaran</label>
                                            <span class="fw-medium">Rp
                                                {{ number_format($lastApplication->jumlah_pengeluaran, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">Pengajuan</label>
                                            <span class="fw-medium">Rp
                                                {{ number_format($lastApplication->jumlah_pengajuan, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted d-block">approved</label>
                                            <span class="fw-medium">
                                                @if ($lastApplication->jumlah_acc)
                                                    Rp {{ number_format($lastApplication->jumlah_acc, 0, ',', '.') }}
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status bar -->
                                <div class="mt-4">
                                    <h6 class="mb-3 text-uppercase text-primary">Status Pengajuan</h6>
                                    <div class="d-flex justify-content-between position-relative mt-4">
                                        <div class="position-absolute"
                                            style="top: 10px; left: 0; right: 0; height: 2px; background-color: #e9ecef; z-index: 1;">
                                        </div>

                                        <div class="text-center position-relative" style="z-index: 2;">
                                            <div class="
                                        rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2
                                        {{ $lastApplication->status == 'pending' || $lastApplication->status == 'approved' || $lastApplication->status == 'rejected' ? 'bg-success text-white' : 'bg-light text-muted' }}
                                    "
                                                style="width: 40px; height: 40px;">
                                                <i class="ti ti-file-description"></i>
                                            </div>
                                            <span class="d-block mt-1 small">Diajukan</span>
                                        </div>

                                        <div class="text-center position-relative" style="z-index: 2;">
                                            <div class="
                                        rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2
                                        {{ $lastApplication->status == 'pending' ? 'bg-warning text-dark' : ($lastApplication->status == 'approved' || $lastApplication->status == 'rejected' ? 'bg-success text-white' : 'bg-light text-muted') }}
                                    "
                                                style="width: 40px; height: 40px;">
                                                <i class="ti ti-hourglass"></i>
                                            </div>
                                            <span class="d-block mt-1 small">Diproses</span>
                                        </div>

                                        <div class="text-center position-relative" style="z-index: 2;">
                                            <div class="
                                        rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2
                                        {{ $lastApplication->status == 'approved' ? 'bg-success text-white' : ($lastApplication->status == 'rejected' ? 'bg-danger text-white' : 'bg-light text-muted') }}
                                    "
                                                style="width: 40px; height: 40px;">
                                                <i
                                                    class="ti ti-{{ $lastApplication->status == 'approved' ? 'check' : ($lastApplication->status == 'rejected' ? 'x' : 'circle') }}"></i>
                                            </div>
                                            <span class="d-block mt-1 small">Keputusan</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
