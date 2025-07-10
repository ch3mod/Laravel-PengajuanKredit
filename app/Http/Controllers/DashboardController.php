<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PengajuanKredit;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Dasar
        $user = auth()->user();
        $totalProducts = Product::count();
        $totalNasabah = Nasabah::count();
        $totalPengajuan = PengajuanKredit::count();

        // Statistik BI Checking
        $biCheckingStats = Nasabah::select('bi_checking', DB::raw('count(*) as total'))
            ->groupBy('bi_checking')
            ->pluck('total', 'bi_checking');

        // Statistik Status Pengajuan
        $statusPengajuan = PengajuanKredit::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Statistik Keuangan
        $totalPengajuanDana = PengajuanKredit::sum('jumlah_pengajuan');
        $totalAccDana = PengajuanKredit::sum('jumlah_acc');
        $avgPengajuan = PengajuanKredit::avg('jumlah_pengajuan');

        // Data Pengajuan per Bulan
        $pengajuanPerBulan = PengajuanKredit::selectRaw('
        DATE_FORMAT(tanggal_pengajuan, "%Y-%m") as periode,
        COUNT(*) as total_pengajuan,
        SUM(jumlah_pengajuan) as total_dana_pengajuan,
        SUM(jumlah_acc) as total_dana_acc,
        COUNT(CASE WHEN status = "approved" THEN 1 END) as total_approved
    ')
            ->groupBy('periode')
            ->orderBy('periode')
            ->get();

        // Data Produk dengan Statistik
        $products = Product::withCount(['pengajuanKredit as total_pengajuan'])
            ->withSum('pengajuanKredit', 'jumlah_pengajuan')
            ->withSum('pengajuanKredit', 'jumlah_acc')
            ->get();

        return view('index', compact(
            'totalProducts',
            'totalNasabah',
            'totalPengajuan',
            'biCheckingStats',
            'statusPengajuan',
            'totalPengajuanDana',
            'totalAccDana',
            'avgPengajuan',
            'pengajuanPerBulan',
            'products',
            'user'
        ));
    }
}
