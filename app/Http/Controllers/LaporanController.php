<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Models\Nasabah;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Ambil filter dari request
        $biChecking = $request->input('bi_checking');
        $status = $request->input('status');

        // Base query
        $query = Nasabah::query();

        // Filter BI Checking
        if (!empty($biChecking)) {
            $query->where('bi_checking', $biChecking);
        }

        // Filter Status Pengajuan Kredit
        if ($status === 'belum_ada') {
            // Filter nasabah yang belum memiliki pengajuan kredit
            $query->whereDoesntHave('pengajuanKredit');
        } elseif (!empty($status)) {
            // Filter berdasarkan status tertentu (pending, approved, rejected)
            $query->whereHas('pengajuanKredit', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        // PENTING: Pastikan kita mengambil semua pengajuan kredit yang terkait
        $nasabahs = $query->with('pengajuanKredit')->get();

        return view('laporan.index', compact('nasabahs', 'user'));
    }

    public function cetakNasabah(Request $request)
    {
        // Ambil filter dari request
        $biChecking = $request->input('bi_checking');
        $status = $request->input('status');

        // Base query
        $query = Nasabah::query();

        // Filter BI Checking
        if (!empty($biChecking)) {
            $query->where('bi_checking', $biChecking);
        }

        // Filter Status Pengajuan Kredit
        if ($status === 'belum_ada') {
            // Filter nasabah yang belum memiliki pengajuan kredit
            $query->whereDoesntHave('pengajuanKredit');
        } elseif (!empty($status)) {
            // Filter berdasarkan status tertentu (pending, approved, rejected)
            $query->whereHas('pengajuanKredit', function ($q) use ($status) {
                $q->where('status', $status);
            });
        }

        // Load related pengajuan kredit - IMPORTANT: Load ALL applications
        $nasabah = $query->with(['pengajuanKredit' => function ($query) use ($status) {
            // If status is set, only load applications with that status
            if (!empty($status) && $status != 'belum_ada') {
                $query->where('status', $status);
            }
            // Order by most recent first
            $query->orderBy('tanggal_pengajuan', 'desc');
        }])->get();

        // Load view 'laporan.pdf' with filtered data
        $pdf = FacadePdf::loadView('laporan.pdf', [
            'nasabah' => $nasabah,
            'filter_bi_checking' => $biChecking,
            'filter_status' => $status
        ])->setPaper('a4', 'landscape');

        // Add filter info to filename
        $fileName = 'laporan';
        if (!empty($biChecking)) {
            $fileName .= '_bi_' . str_replace(' ', '_', strtolower($biChecking));
        }
        if (!empty($status)) {
            $fileName .= '_status_' . $status;
        }
        $fileName .= '.pdf';

        return $pdf->stream($fileName);
    }

    public function show($id)
    {
        $user = auth()->user();
        // Load nasabah dengan semua pengajuan kredit dan produk terkait
        $nasabah = Nasabah::with(['pengajuanKredit' => function ($query) {
            $query->orderBy('tanggal_pengajuan', 'desc');
            $query->with('product'); // Load produk untuk setiap pengajuan
        }])->findOrFail($id);

        // Hitung total pengajuan dan total ACC
        $totalPengajuan = $nasabah->pengajuanKredit->sum('jumlah_pengajuan');
        $totalAcc = $nasabah->pengajuanKredit
    ->where('status', 'approved')
    ->sum('jumlah_acc');


        // Hitung rata-rata rasio acc terhadap pengajuan
        $ratioAcc = $totalPengajuan > 0 ? ($totalAcc / $totalPengajuan) * 100 : 0;

        // Hitung statistik status
        $statusCounts = [
            'pending' => $nasabah->pengajuanKredit->where('status', 'pending')->count(),
            'approved' => $nasabah->pengajuanKredit->where('status', 'approved')->count(),
            'rejected' => $nasabah->pengajuanKredit->where('status', 'rejected')->count(),
        ];

        // Ambil pengajuan terakhir jika ada
        $lastApplication = $nasabah->pengajuanKredit->first();

        return view('laporan.show', compact('nasabah', 'totalPengajuan', 'totalAcc', 'ratioAcc', 'statusCounts', 'lastApplication','user'));
    }

    public function cetakSingleNasabah($id)
    {
        // Load nasabah dengan semua pengajuan kredit dan produk terkait
        $nasabah = Nasabah::with(['pengajuanKredit' => function ($query) {
            $query->orderBy('tanggal_pengajuan', 'desc');
            $query->with('product'); // Load produk untuk setiap pengajuan
        }])->findOrFail($id);

        // Hitung total dan statistik
        $totalPengajuan = $nasabah->pengajuanKredit->sum('jumlah_pengajuan');
        $totalAcc = $nasabah->pengajuanKredit
    ->where('status', 'approved')
    ->sum('jumlah_acc');
        $ratioAcc = $totalPengajuan > 0 ? ($totalAcc / $totalPengajuan) * 100 : 0;

        // Statistik status
        $statusCounts = [
            'pending' => $nasabah->pengajuanKredit->where('status', 'pending')->count(),
            'approved' => $nasabah->pengajuanKredit->where('status', 'approved')->count(),
            'rejected' => $nasabah->pengajuanKredit->where('status', 'rejected')->count(),
        ];

        // Create array with just one nasabah for PDF view
        $nasabahArray = collect([$nasabah]);

        // Load detail PDF view
        $pdf = FacadePdf::loadView('laporan.detail_pdf', [
            'nasabah' => $nasabah,
            'totalPengajuan' => $totalPengajuan,
            'totalAcc' => $totalAcc,
            'ratioAcc' => $ratioAcc,
            'statusCounts' => $statusCounts
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('detail_nasabah_' . $nasabah->no_registrasi . '.pdf');
    }
}
