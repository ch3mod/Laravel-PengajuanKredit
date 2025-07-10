@extends('main')

@section('container')
<div class="body-wrapper">
    <div class="container-fluid">
        <div class="card w-100 position-relative overflow-hidden">
            <div class="px-4 py-3 border-bottom">
                <h4 class="card-title mb-0">Laporan Table</h4>
                <br>
                <!-- Form Filter -->
                <form action="{{ route('laporan.nasabah') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="bi_checking">Filter BI Checking:</label>
                            <select name="bi_checking" id="bi_checking" class="form-control">
                                <option value="">-- Semua --</option>
                                <option value="Lancar" {{ request('bi_checking') == 'Lancar' ? 'selected' : '' }}>Lancar</option>
                                <option value="Dalam Pengawasan Khusus" {{ request('bi_checking') == 'Dalam Pengawasan Khusus' ? 'selected' : '' }}>Dalam Pengawasan Khusus</option>
                                <option value="Kurang Lancar" {{ request('bi_checking') == 'Kurang Lancar' ? 'selected' : '' }}>Kurang Lancar</option>
                                <option value="Diragukan" {{ request('bi_checking') == 'Diragukan' ? 'selected' : '' }}>Diragukan</option>
                                <option value="Macet" {{ request('bi_checking') == 'Macet' ? 'selected' : '' }}>Macet</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="status">Filter Status Pengajuan:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">-- Semua --</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="belum_ada" {{ request('status') == 'belum_ada' ? 'selected' : '' }}>Belum Memiliki Putusan Kredit</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary form-control">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive mb-4 border rounded-1">
                    <table id="myTable" class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th>#</th>
                                <th>No Registrasi</th>
                                <th>Nama</th>
                                <th>BI Checking</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nasabahs as $nasabah)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $nasabah->no_registrasi }}</td>
                                    <td>{{ $nasabah->nama }}</td>
                                    <td>{{ $nasabah->bi_checking }}</td>
                                    <td>
                                        @if(request('status') && request('status') != 'belum_ada')
                                            {{ request('status') }}
                                        @elseif($nasabah->pengajuanKredit->count() > 0)
                                            {{ $nasabah->pengajuanKredit->first()->status }}
                                        @else
                                            Belum Memiliki Putusan Kredit
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Aksi
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('laporan.show', $nasabah->id) }}">
                                                        <i class="fa fa-eye me-2"></i> Lihat Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('laporan.cetak-single', $nasabah->id) }}">
                                                        <i class="fa fa-print me-2"></i> Cetak PDF
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <a href="{{ route('laporan.cetak', ['bi_checking' => request('bi_checking'), 'status' => request('status')]) }}" class="btn btn-danger">Cetak PDF Hasil Filter</a>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

