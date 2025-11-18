<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $statistik = [
            "total_tamu" => Tamu::whereNull("deleted_at")->count(),
            "tamu_hari_ini" => Tamu::whereNull("deleted_at")
                ->whereDate("tanggal_kunjungan", today())
                ->count(),
            "tamu_bulan_ini" => Tamu::whereNull("deleted_at")
                ->whereMonth("tanggal_kunjungan", now()->month)
                ->whereYear("tanggal_kunjungan", now()->year)
                ->count(),
            "kunjungan_proses" => Tamu::whereNull("deleted_at")
                ->where("status_kunjungan", "proses")
                ->count(),
            "kunjungan_selesai" => Tamu::whereNull("deleted_at")
                ->where("status_kunjungan", "selesai")
                ->count(),
            "kunjungan_dibatalkan" => Tamu::whereNull("deleted_at")
                ->where("status_kunjungan", "dibatalkan")
                ->count(),
            "total_guru" => Guru::count(),
        ];

        // Persentase Status Kunjungan
        $total_kunjungan =
            $statistik["total_tamu"] > 0 ? $statistik["total_tamu"] : 1;
        $persentase_status = [
            "selesai" => round(
                ($statistik["kunjungan_selesai"] / $total_kunjungan) * 100,
                1,
            ),
            "proses" => round(
                ($statistik["kunjungan_proses"] / $total_kunjungan) * 100,
                1,
            ),
            "dibatalkan" => round(
                ($statistik["kunjungan_dibatalkan"] / $total_kunjungan) * 100,
                1,
            ),
        ];

        // Tamu Terbaru (10 terakhir)
        $tamu_terbaru = Tamu::with(["guru", "jenisKunjungan"])
            ->whereNull("deleted_at")
            ->orderBy("created_at", "desc")
            ->limit(10)
            ->get();

        // Data untuk Chart - Kunjungan 7 hari terakhir
        $chart_data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = Tamu::whereNull("deleted_at")
                ->whereDate("tanggal_kunjungan", $date)
                ->count();

            $chart_data[] = [
                "tanggal" => $date->format("d M"),
                "jumlah" => $count,
            ];
        }

        // Perbandingan dengan bulan lalu
        $tamu_bulan_lalu = Tamu::whereNull("deleted_at")
            ->whereMonth("tanggal_kunjungan", now()->subMonth()->month)
            ->whereYear("tanggal_kunjungan", now()->subMonth()->year)
            ->count();

        $perbandingan_bulan = 0;
        if ($tamu_bulan_lalu > 0) {
            $perbandingan_bulan = round(
                (($statistik["tamu_bulan_ini"] - $tamu_bulan_lalu) /
                    $tamu_bulan_lalu) *
                    100,
                1,
            );
        } elseif ($statistik["tamu_bulan_ini"] > 0) {
            $perbandingan_bulan = 100;
        }

        // Perbandingan dengan kemarin
        $tamu_kemarin = Tamu::whereNull("deleted_at")
            ->whereDate("tanggal_kunjungan", today()->subDay())
            ->count();

        $perbandingan_hari = 0;
        if ($tamu_kemarin > 0) {
            $perbandingan_hari = round(
                (($statistik["tamu_hari_ini"] - $tamu_kemarin) /
                    $tamu_kemarin) *
                    100,
                1,
            );
        } elseif ($statistik["tamu_hari_ini"] > 0) {
            $perbandingan_hari = 100;
        }

        // Jenis Kunjungan Terpopuler
        $jenis_populer = Tamu::select("id_jenis", DB::raw("count(*) as total"))
            ->whereNull("deleted_at")
            ->groupBy("id_jenis")
            ->orderBy("total", "desc")
            ->with("jenisKunjungan")
            ->limit(5)
            ->get();

        // Guru yang paling banyak dikunjungi
        $guru_populer = Tamu::select(
            "guru_tujuan",
            DB::raw("count(*) as total"),
        )
            ->whereNull("deleted_at")
            ->whereNotNull("guru_tujuan")
            ->groupBy("guru_tujuan")
            ->orderBy("total", "desc")
            ->with("guru")
            ->limit(5)
            ->get();

        return view(
            "dashboard",
            compact(
                "statistik",
                "persentase_status",
                "tamu_terbaru",
                "chart_data",
                "perbandingan_bulan",
                "perbandingan_hari",
                "jenis_populer",
                "guru_populer",
            ),
        );
    }
}
