@extends('main')

@section('container')
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card w-100 position-relative overflow-hidden">
                <div class="px-4 py-3 border-bottom">
                    <h4 class="card-title mb-0">Nasabah Table</h4>
                    <br>
                    <button type="button" class="btn bg-success-subtle text-success" data-bs-toggle="modal"
                        data-bs-target="#registrasi-nasabah">Registrasi Nasabah</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive mb-4 border rounded-1">
                        <table id="myTable" class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">#</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">No. Registrasi</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">No. KTP</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Nama</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Alamat</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">No. Telepon</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Bi Checking</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Jumlah Pengajuan Kredit</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Aksi</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Pengajuan Kredit</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($nasabahs as $nasabah)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $nasabah->no_registrasi }}</td>
                                        <td> {{ $nasabah->no_ktp }}</td>
                                        <td>{{ $nasabah->nama }}</td>
                                        <td>{{ $nasabah->alamat }}</td>
                                        <td>{{ $nasabah->no_telepon }}</td>

                                        <td>
                                            <span
                                                class="badge
                            @if ($nasabah->bi_checking == 'Lancar') bg-success
                            @elseif($nasabah->bi_checking == 'Dalam Pengawasan Khusus') bg-warning
                            @elseif($nasabah->bi_checking == 'Kurang Lancar') bg-danger
                            @elseif($nasabah->bi_checking == 'Diragukan') bg-danger
                            @elseif($nasabah->bi_checking == 'Macet') bg-dark @endif
                        ">
                                                {{ $nasabah->bi_checking }}
                                            </span>
                                        </td>
                                        <td>{{ $nasabah->pengajuan_kredit_count }}</td>
                                        {{-- <td>
                                            <button class="btn bg-warning-subtle text-warning" data-bs-toggle="modal"
                                                data-bs-target="#edit-modal-{{ $nasabah->id }}">
                                                <i class="fs-4 ti ti-edit"></i>Ubah</button>
                                            @if (!$nasabah->pengajuanKredit()->exists())
                                                <form id="delete-form-{{ $nasabah->id }}"
                                                    action="{{ route('nasabah.destroy', $nasabah->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn bg-danger-subtle text-danger"
                                                        onclick="confirmDelete({{ $nasabah->id }})">
                                                        <i class="fs-4 ti ti-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @else
                                                <button class="btn bg-secondary-subtle text-secondary" disabled>
                                                    Tidak Bisa Dihapus
                                                </button>
                                            @endif
                                        </td> --}}
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
                                                        <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                                            data-bs-target="#edit-modal-{{ $nasabah->id }}">
                                                            <i class="fa fa-edit me-2"></i> Ubah
                                                        </button>
                                                    </li>
                                                    @if (!$nasabah->pengajuanKredit()->exists())
                                                        <li>
                                                            <form id="delete-form-{{ $nasabah->id }}"
                                                                action="{{ route('nasabah.destroy', $nasabah->id) }}" method="POST"
                                                                style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="dropdown-item text-danger"
                                                                    onclick="confirmDelete({{ $nasabah->id }})">
                                                                    <i class="fa fa-trash me-2"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <button class="dropdown-item text-secondary" disabled>
                                                                <i class="fa fa-ban me-2"></i> Tidak Bisa Dihapus
                                                            </button>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </td>

                                        <td>
                                            @if (in_array($nasabah->bi_checking, ['Lancar', 'Dalam Pengawasan Khusus']))
                                                <a href="{{ route('pengajuan.createWithNasabah', $nasabah->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Buat Pengajuan Kredit
                                                </a>
                                            @else
                                                <button class="btn btn-secondary btn-sm" onclick="showAlert()">
                                                    Buat Pengajuan Kredit
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('nasabah.create')
        @include('nasabah.edit')

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        <script>
            function confirmDelete(nasabahId) {
                event.preventDefault(); // Mencegah form langsung dikirim
                Swal.fire({
                    title: "Yakin ingin menghapus?",
                    text: "Data produk akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus!",
                    cancelButtonText: "Batalkan"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${nasabahId}`).submit();
                    }
                });
            }

            function showAlert() {
                alert("BI Checking tidak memenuhi syarat untuk mengajukan kredit.");
            }
        </script>
    @endsection
