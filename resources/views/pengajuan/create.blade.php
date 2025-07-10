@extends('main')

@section('container')

    <div class="body-wrapper">
        <div class="container-fluid">

            <div class="card w-100 position-relative overflow-hidden">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="px-4 py-3 border-bottom">
                <h4 class="card-title mb-0">Form Pengajuan Kredit Baru</h4>
            </div>
            <div class="card-body">
                <form class="needs-validation" novalidate action="{{ route('pengajuan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="nasabah_id" value="{{ $nasabah->id }}">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="no_registrasi">No. Registrasi</label>
                            <input type="text" class="form-control" id="no_registrasi"
                                value="{{ $nasabah->no_registrasi }}" disabled>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="no_ktp">No. KTP</label>
                            <input type="text" class="form-control" id="no_ktp" value="{{ $nasabah->no_ktp }}"
                                disabled>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="nama">Nama Nasabah</label>
                            <input type="text" class="form-control" id="nama" value="{{ $nasabah->nama }}" disabled>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" rows="3" disabled>{{ $nasabah->alamat }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="no_telepon">No. Telepon</label>
                            <input type="text" class="form-control" id="no_telepon" value="{{ $nasabah->no_telepon }}"
                                disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="bi_checking">Bi Checking</label>
                            <input type="text" class="form-control" id="bi_checking" value="{{ $nasabah->bi_checking }}"
                                disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="jumlah_tanggungan">Jumlah Tanggungan</label>
                            <select class="form-control @error('jumlah_tanggungan') is-invalid @enderror" 
                                    name="jumlah_tanggungan" id="jumlah_tanggungan" required>
                                <option value="">Pilih Jumlah Tanggungan</option>
                                @for ($i = 1; $i <= 15; $i++)
                                    <option value="{{ $i }}" {{ old('jumlah_tanggungan') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            @error('jumlah_tanggungan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="jumlah_pemasukan">Jumlah Pemasukan</label>
                            <input type="text" class="form-control @error('jumlah_pemasukan') is-invalid @enderror"
                                name="jumlah_pemasukan" id="jumlah_pemasukan" min="0" step="0.01"
                                value="{{ old('jumlah_pemasukan') }}" required>
                            @error('jumlah_pemasukan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="jumlah_pengeluaran">Jumlah Pengeluaran</label>
                            <input type="text" class="form-control @error('jumlah_pengeluaran') is-invalid @enderror"
                                name="jumlah_pengeluaran" id="jumlah_pengeluaran" min="0" step="0.01"
                                value="{{ old('jumlah_pengeluaran') }}" required>
                            @error('jumlah_pengeluaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tanggal_pengajuan">Tanggal Pengajuan</label>
                            <input type="date" class="form-control" name="tanggal_pengajuan" id="tanggal_pengajuan"
                                required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="product_id">Pilih Produk</label>
                            <select name="product_id" id="product_id" class="form-control" required>
                                <option value="" selected disabled>Pilih Produk</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="jaminan">Jaminan</label>
                            <select class="form-control" name="jaminan" id="jaminan" required>
                                <option value="" disabled selected>Pilih Jaminan</option>
                                <option value="SK Kontrak">SK Kontrak</option>
                                <option value="Ijazah">Ijazah</option>
                            </select>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="jumlah_pengajuan">Jumlah Pengajuan</label>
                            <input type="text" class="form-control currency-input" name="jumlah_pengajuan"
                                id="jumlah_pengajuan" placeholder="Masukkan Jumlah Pengajuan" required
                                oninput="calculateJumlahDisetujui()">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="jumlah_tenor">Jumlah Tenor</label>
                            <select name="jumlah_tenor" id="jumlah_tenor" class="form-control" required>
                                <option value="" selected disabled>Pilih Jumlah Tenor</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }} Tahun</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="jumlah_acc">Jumlah Disetujui</label>
                            <input type="text" class="form-control currency-input" id="jumlah_acc"
                                placeholder="Jumlah Disetujui" readonly>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-3" type="submit">Ajukan Kredit</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function formatRupiah(angka, prefix) {
                let number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah ? (prefix ? 'Rp ' + rupiah : rupiah) : '';
            }

            function setupFormatting(inputId) {
                let input = document.getElementById(inputId);
                input.addEventListener("keyup", function(e) {
                    this.value = formatRupiah(this.value, false);
                });

                input.addEventListener("blur", function(e) {
                    this.value = this.value ? 'Rp ' + this.value : '';
                });

                input.addEventListener("focus", function(e) {
                    this.value = this.value.replace('Rp ', '');
                });
            }

            setupFormatting("jumlah_pemasukan");
            setupFormatting("jumlah_pengeluaran");
        });
    </script>


@endsection
