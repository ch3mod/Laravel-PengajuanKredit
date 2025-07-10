@foreach ($nasabahs as $nasabah)
    <div class="modal fade" id="edit-modal-{{ $nasabah->id }}" tabindex="-1"
        aria-labelledby="editModalLabel{{ $nasabah->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title">Edit Data Nasabah</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('nasabah.update', $nasabah->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="no_ktp" class="form-label">No. KTP</label>
                            <input type="text" name="no_ktp" class="form-control" id="no_ktp-{{ $nasabah->id }}"
                                value="{{ $nasabah->no_ktp }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama-{{ $nasabah->id }}"
                                value="{{ $nasabah->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat-{{ $nasabah->id }}" rows="3" required>{{ $nasabah->alamat }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No. Telepon</label>
                            <input type="text" name="no_telepon" class="form-control"
                                id="no_telepon-{{ $nasabah->id }}" value="{{ $nasabah->no_telepon }}" required>
                        </div>
                        
                        @php
                            $hasPengajuanKredit = $nasabah->pengajuanKredit()->exists();
                        @endphp

                        <div class="mb-3">
                            <label for="bi_checking" class="form-label">BI Checking</label>
                            <select name="bi_checking" class="form-control @error('bi_checking') is-invalid @enderror"
                                required data-nasabah-id="{{ $nasabah->id }}" data-has-pengajuan="{{ $hasPengajuanKredit ? '1' : '0' }}"
                                {{ $hasPengajuanKredit ? 'disabled' : '' }}>
                                <option value="">Pilih Status</option>
                                <option value="Lancar" {{ $nasabah->bi_checking == 'Lancar' ? 'selected' : '' }}>Lancar</option>
                                <option value="Dalam Pengawasan Khusus" {{ $nasabah->bi_checking == 'Dalam Pengawasan Khusus' ? 'selected' : '' }}>Dalam Pengawasan Khusus</option>
                                <option value="Kurang Lancar" {{ $nasabah->bi_checking == 'Kurang Lancar' ? 'selected' : '' }}>Kurang Lancar</option>
                                <option value="Diragukan" {{ $nasabah->bi_checking == 'Diragukan' ? 'selected' : '' }}>Diragukan</option>
                                <option value="Macet" {{ $nasabah->bi_checking == 'Macet' ? 'selected' : '' }}>Macet</option>
                            </select>
                            @error('bi_checking')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if ($hasPengajuanKredit)
                                <div class="alert alert-warning mt-2">
                                    <strong>Perhatian!</strong> Nasabah sudah memiliki pengajuan kredit, BI Checking tidak bisa diubah.
                                </div>
                            @endif

                            <div id="bi-checking-warning-{{ $nasabah->id }}" class="mt-2" style="display: none;"></div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@section('scripts')
<script>
    function handleBIChecking(selectElement) {
        const id = selectElement.getAttribute('data-nasabah-id');
        const warningDiv = document.getElementById('bi-checking-warning-' + id);
        const selectedValue = selectElement.value;
        const hasPengajuan = selectElement.getAttribute('data-has-pengajuan') === '1';

        // Reset warning
        warningDiv.style.display = 'none';
        warningDiv.innerHTML = '';

        // Jika nasabah sudah punya pengajuan kredit, disable select BI Checking
        if (hasPengajuan) {
            selectElement.setAttribute('disabled', 'disabled');
            return;
        }

        // Tambahkan peringatan jika status BI Checking berisiko
        if (['Kurang Lancar', 'Diragukan', 'Macet'].includes(selectedValue)) {
            let warningMessage = '';

            switch (selectedValue) {
                case 'Kurang Lancar':
                    warningMessage = 'Status BI Checking Kurang Lancar menandakan risiko kredit yang cukup tinggi.';
                    break;
                case 'Diragukan':
                    warningMessage = 'Status BI Checking Diragukan menandakan risiko kredit yang sangat tinggi.';
                    break;
                case 'Macet':
                    warningMessage = 'Status BI Checking Macet menandakan risiko kredit yang ekstrem.';
                    break;
            }

            warningDiv.innerHTML = `
                <div class="alert alert-danger" role="alert">
                    <strong>Peringatan!</strong> ${warningMessage}
                    Apakah Anda yakin ingin melanjutkan pengeditan data nasabah dengan status ini?
                </div>
            `;
            warningDiv.style.display = 'block';
        }
    }

    // Jalankan fungsi saat modal terbuka
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('shown.bs.modal', function () {
                const selectElement = this.querySelector('select[name="bi_checking"]');
                if (selectElement) {
                    handleBIChecking(selectElement);
                }
            });
        });

        // Tambahkan event listener saat select diubah
        document.querySelectorAll('select[name="bi_checking"]').forEach(selectElement => {
            selectElement.addEventListener('change', function() {
                handleBIChecking(this);
            });
        });
    });
</script>
@endsection
