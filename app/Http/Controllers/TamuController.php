<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use App\Models\Guru;
use App\Models\JenisKunjungan;
use Illuminate\Http\Request;

class TamuController extends Controller
{
    public function index()
    {
        $tamu = Tamu::with(["guru", "jenisKunjungan", "createdBy"])
            ->whereNull("deleted_at")
            ->orderBy("created_at", "desc")
            ->get();

        return view("tamu.index", compact("tamu"));
    }

    public function create()
    {
        $guru = Guru::all();
        $jenisKunjungan = JenisKunjungan::all();
        return view("tamu.create", compact("guru", "jenisKunjungan"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama" => "required|string|max:255",
            "telepon" => "required|string|max:50",
            "status" => "required|string|max:100",
            "id_jenis" => "required|exists:jenis_kunjungan,id_jenis",
            "tujuan" => "required|string",
            "guru_tujuan" => "nullable|exists:guru,id_guru",
            "alamat" => "required|string",
            "tanggal_kunjungan" => "required|date",
            "waktu_masuk" => "required",
        ]);

        $tamu = Tamu::create([
            "nama" => $request->nama,
            "telepon" => $request->telepon,
            "status" => $request->status,
            "id_jenis" => $request->id_jenis,
            "tujuan" => $request->tujuan,
            "guru_tujuan" => $request->guru_tujuan,
            "alamat" => $request->alamat,
            "keterangan" => $request->keterangan,
            "tanggal_kunjungan" => $request->tanggal_kunjungan,
            "waktu_masuk" => $request->waktu_masuk,
            "created_by" => session("user_id"),
        ]);

        // Log aktivitas
        log_activity(
            "Menambah data tamu: {$tamu->nama}",
            "tamu",
            $tamu->id_tamu,
        );

        return redirect()
            ->route("tamu.index")
            ->with("success", "Data tamu berhasil ditambahkan");
    }

    public function edit($id)
    {
        $tamu = Tamu::findOrFail($id);
        $guru = Guru::all();
        $jenisKunjungan = JenisKunjungan::all();
        return view("tamu.edit", compact("tamu", "guru", "jenisKunjungan"));
    }

    public function update(Request $request, $id)
    {
        $tamu = Tamu::findOrFail($id);

        $request->validate([
            "nama" => "required|string|max:255",
            "telepon" => "required|string|max:50",
            "status" => "required|string|max:100",
            "id_jenis" => "required|exists:jenis_kunjungan,id_jenis",
            "tujuan" => "required|string",
            "guru_tujuan" => "nullable|exists:guru,id_guru",
            "alamat" => "required|string",
            "tanggal_kunjungan" => "required|date",
        ]);

        $tamu->update($request->all());

        // Log aktivitas
        log_activity(
            "Mengupdate data tamu: {$tamu->nama}",
            "tamu",
            $tamu->id_tamu,
        );

        return redirect()
            ->route("tamu.index")
            ->with("success", "Data tamu berhasil diupdate");
    }

    /**
     * Hard delete - Menghapus data tamu secara permanen
     */
    public function destroy($id)
    {
        try {
            $tamu = Tamu::where("id_tamu", $id)->firstOrFail();

            // Simpan nama untuk pesan
            $namaTamu = $tamu->nama;

            // Hard delete - hapus permanen
            $tamu->delete();

            // Log aktivitas
            log_activity("Menghapus data tamu: {$namaTamu}", "tamu", $id);

            return redirect()
                ->route("tamu.index")
                ->with(
                    "success",
                    "Data tamu {$namaTamu} berhasil dihapus secara permanen",
                );
        } catch (\Exception $e) {
            return redirect()
                ->route("tamu.index")
                ->with(
                    "error",
                    "Gagal menghapus data tamu: " . $e->getMessage(),
                );
        }
    }

    /**
     * Bulk delete - Hapus multiple tamu sekaligus
     */
    public function bulkDelete(Request $request)
    {
        try {
            $ids = $request->input("ids", []);

            if (empty($ids)) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Tidak ada data yang dipilih",
                    ],
                    400,
                );
            }

            $count = Tamu::whereIn("id_tamu", $ids)->delete();

            // Log aktivitas bulk delete
            log_activity("Bulk delete: Menghapus {$count} data tamu sekaligus");

            return response()->json([
                "success" => true,
                "message" => "{$count} data tamu berhasil dihapus",
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Gagal menghapus data: " . $e->getMessage(),
                ],
                500,
            );
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $tamu = Tamu::findOrFail($id);
        $tamu->update([
            "status_kunjungan" => $request->status_kunjungan,
            "waktu_keluar" =>
                $request->status_kunjungan == "selesai"
                    ? now()->format("H:i:s")
                    : null,
        ]);

        // Log aktivitas update status
        log_activity(
            "Update status kunjungan tamu {$tamu->nama} menjadi: {$request->status_kunjungan}",
            "tamu",
            $tamu->id_tamu,
        );

        return back()->with("success", "Status kunjungan berhasil diupdate");
    }
}
