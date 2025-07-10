<!-- Template PDF yang Ditingkatkan (laporan.pdf.blade.php) -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Nasabah</title>
    <style>
        /* Reset dan pengaturan dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
            background-color: #fff;
            padding: 20px;
        }

        /* Header dengan logo dan detail lembaga */
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #1a5276;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            height: 100px;
            margin-right: 15px;
        }

        .institution-info {
            flex-grow: 1;
        }

        .institution-info h1 {
            color: #1a5276;
            font-size: 18px;
            margin-bottom: 3px;
        }

        .institution-info p {
            color: #566573;
            font-size: 11px;
            margin: 2px 0;
        }

        .doc-title {
            text-align: center;
            margin: 20px 0;
            color: #1a5276;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .print-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 11px;
            color: #566573;
        }

        /* Styling untuk filter informasi */
        .filter-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f9f9f9;
            border-left: 3px solid #1a5276;
            font-style: normal;
            font-size: 11px;
        }

        /* Tabel yang lebih modern */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #e5e5e5;
        }

        th, td {
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        th {
            background-color: #1a5276;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background-color: #f2f7fb;
        }

        tr:hover {
            background-color: #e8f4fc;
        }

        /* Status warna */
        .status-approved {
            color: #27ae60;
            font-weight: bold;
        }

        .status-pending {
            color: #f39c12;
            font-weight: bold;
        }

        .status-rejected {
            color: #e74c3c;
            font-weight: bold;
        }

        /* Footer dengan halaman dan tanda tangan */
        .footer {
            margin-top: 30px;
            border-top: 1px solid #e5e5e5;
            padding-top: 15px;
        }

        .summary-info {
            margin-bottom: 15px;
            font-size: 11px;
        }

        .signature-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 50px;
        }

        .signature {
            text-align: center;
            margin-left: 20px;
        }

        .signature .line {
            border-bottom: 1px solid #333;
            width: 150px;
            margin: 40px auto 10px auto;
        }

        .page-number {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #7f8c8d;
        }
        .page-number:after {
        content: "" counter(page);
    }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            opacity: 0.03;
            color: #1a5276;
            z-index: -1;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="watermark">Confidential</div>

    <div class="header-container">
        <div class="logo-container">
            <img src="assets/images/logos/bank_kerta.jpeg" alt="Logo Perusahaan" class="logo">
            <div class="institution-info">
                <h1>PT. NAMA PERUSAHAAN ANDA</h1>
                <p>Jl. Alamat Lengkap Perusahaan No. 123, Kota, Kode Pos</p>
                <p>Telp: (021) 1234-5678 | Email: info@perusahaananda.com</p>
                <p>www.perusahaananda.com</p>
            </div>
        </div>
    </div>

    <div class="doc-title">
        <h2>Laporan Detail Nasabah</h2>
    </div>

    <div class="print-info">
        <p>No. Registrasi: {{ $nasabah->no_registrasi }}</p>
        <p>Nama Nasabah: {{ strtoupper($nasabah->nama) }}</p>
        <p>Alamat: {{ $nasabah->alamat }}</p>
        <p>No. Telepon: {{ $nasabah->no_telepon }}</p>
        <p>BI Checking: <span class="{{ $nasabah->bi_checking == 'Lancar' ? 'status-approved' : 'status-rejected' }}">{{ $nasabah->bi_checking }}</span></p>
    </div>

    <table class="table text-center">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 8%;">Tgl Pengajuan</th>
                <th style="width: 12%;">Produk</th>
                <th style="width: 12%;">Jumlah Pengajuan</th>
                <th style="width: 12%;">Jumlah ACC</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nasabah->pengajuanKredit as $index => $pengajuan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d-m-Y') }}</td>
                    <td>{{ $pengajuan->product->nama_produk ?? 'silantap' }}</td>
                    <td>Rp {{ number_format($pengajuan->jumlah_pengajuan, 0, ',', '.') }}</td>
                    <td>
                        @if ($pengajuan->jumlah_acc)
                            Rp {{ number_format($pengajuan->jumlah_acc, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($pengajuan->status == 'approved')
                            <span class="badge bg-success">APPROVED</span>
                        @elseif($pengajuan->status == 'rejected')
                            <span class="badge bg-danger">REJECTED</span>
                        @elseif($pengajuan->status == 'pending')
                            <span class="badge bg-warning text-dark">PENDING</span>
                        @else
                            <span class="badge bg-secondary">{{ strtoupper($pengajuan->status) }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="summary-info">
        <p><strong>Ringkasan:</strong></p>
        <p>Total Pengajuan: Rp {{ number_format($totalPengajuan, 0, ',', '.') }}</p>
        <p>Total ACC: Rp {{ number_format($totalAcc, 0, ',', '.') }}</p>
        <p>Persentase ACC: {{ number_format($ratioAcc, 2) }}%</p>
        <p>Jumlah Pengajuan Pending: {{ $statusCounts['pending'] }}</p>
        <p>Jumlah Pengajuan approved: {{ $statusCounts['approved'] }}</p>
        <p>Jumlah Pengajuan rejected: {{ $statusCounts['rejected'] }}</p>
    </div>

    <div class="signature-container">
        <div class="signature">
            <p>Dibuat oleh:</p>
            <div class="line"></div>
            <p>{{ auth()->user()->name ?? 'Administrator' }}</p>
        </div>
    </div>
</body>

</html>
