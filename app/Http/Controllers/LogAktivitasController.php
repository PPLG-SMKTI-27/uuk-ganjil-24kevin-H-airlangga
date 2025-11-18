<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LogAktivitasController extends Controller
{
    /**
     * Display list of activity logs
     */
    public function index(Request $request)
    {
        $query = LogAktivitas::with(["pengguna.peran"]);

        // Filter by user
        if ($request->filled("user_id")) {
            $query->where("id_pengguna", $request->user_id);
        }

        // Filter by date range
        if ($request->filled("date_from")) {
            $query->whereDate("created_at", ">=", $request->date_from);
        }
        if ($request->filled("date_to")) {
            $query->whereDate("created_at", "<=", $request->date_to);
        }

        // Filter by activity keyword
        if ($request->filled("keyword")) {
            $query->where("aktivitas", "like", "%" . $request->keyword . "%");
        }

        // Filter by table
        if ($request->filled("tabel")) {
            $query->where("tabel_terkait", $request->tabel);
        }

        // Order by newest first
        $logs = $query->orderBy("created_at", "desc")->paginate(20);

        // Get all users for filter dropdown
        $users = Pengguna::with("peran")->get();

        // Get unique tables for filter
        $tables = LogAktivitas::select("tabel_terkait")
            ->distinct()
            ->whereNotNull("tabel_terkait")
            ->pluck("tabel_terkait");

        return view("log-aktivitas.index", compact("logs", "users", "tables"));
    }

    /**
     * Get recent activities for dashboard widget
     */
    public function recent()
    {
        $logs = LogAktivitas::with(["pengguna.peran"])
            ->orderBy("created_at", "desc")
            ->limit(10)
            ->get();

        return view("log-aktivitas.widget", compact("logs"));
    }

    /**
     * Delete old logs (cleanup)
     */
    public function cleanup(Request $request)
    {
        try {
            $days = $request->input("days", 30); // Default 30 hari
            $date = Carbon::now()->subDays($days);

            $count = LogAktivitas::where("created_at", "<", $date)->delete();

            return redirect()
                ->route("log-aktivitas.index")
                ->with(
                    "success",
                    "Berhasil menghapus {$count} log aktivitas yang lebih dari {$days} hari",
                );
        } catch (\Exception $e) {
            return redirect()
                ->route("log-aktivitas.index")
                ->with("error", "Gagal menghapus log: " . $e->getMessage());
        }
    }

    /**
     * Export logs to CSV
     */
    public function export(Request $request)
    {
        $query = LogAktivitas::with(["pengguna.peran"]);

        // Apply same filters as index
        if ($request->filled("user_id")) {
            $query->where("id_pengguna", $request->user_id);
        }
        if ($request->filled("date_from")) {
            $query->whereDate("created_at", ">=", $request->date_from);
        }
        if ($request->filled("date_to")) {
            $query->whereDate("created_at", "<=", $request->date_to);
        }
        if ($request->filled("keyword")) {
            $query->where("aktivitas", "like", "%" . $request->keyword . "%");
        }

        $logs = $query->orderBy("created_at", "desc")->get();

        $filename = "log-aktivitas-" . date("Y-m-d-His") . ".csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($logs) {
            $file = fopen("php://output", "w");

            // Header CSV
            fputcsv($file, [
                "Waktu",
                "User",
                "Role",
                "Aktivitas",
                "Tabel",
                "IP Address",
            ]);

            // Data
            foreach ($logs as $log) {
                Carbon::setLocale("id");
                $waktu = Carbon::parse($log->created_at)
                    ->timezone("Asia/Makassar")
                    ->format("d/m/Y H:i:s");

                fputcsv($file, [
                    $waktu,
                    $log->pengguna ? $log->pengguna->nama : "Unknown",
                    $log->pengguna && $log->pengguna->peran
                        ? $log->pengguna->peran->nama_peran
                        : "-",
                    $log->aktivitas,
                    $log->tabel_terkait ?? "-",
                    $log->ip_address ?? "-",
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
