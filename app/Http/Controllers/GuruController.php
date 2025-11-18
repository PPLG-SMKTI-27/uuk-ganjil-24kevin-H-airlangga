<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Tamu;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::orderBy("nama_guru", "asc")->get();
        return view("guru.index", compact("guru"));
    }

    public function create()
    {
        return view("guru.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama_guru" => "required|string|max:255",
            "nip" => "required|string|max:50|unique:guru,nip",
        ]);

        $guru = Guru::create([
            "nama_guru" => $request->nama_guru,
            "nip" => $request->nip,
        ]);

        // Log aktivitas
        log_activity(
            "Menambah data guru: {$guru->nama_guru}",
            "guru",
            $guru->id_guru,
        );

        return redirect()
            ->route("guru.index")
            ->with("success", "Data guru berhasil ditambahkan");
    }

    public function show($id)
    {
        $guru = Guru::where("id_guru", $id)->firstOrFail();
        return view("guru.show", compact("guru"));
    }

    public function edit($id)
    {
        $guru = Guru::where("id_guru", $id)->firstOrFail();
        return view("guru.edit", compact("guru"));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::where("id_guru", $id)->firstOrFail();

        $request->validate([
            "nama_guru" => "required|string|max:255",
            "nip" =>
                "required|string|max:50|unique:guru,nip," . $id . ",id_guru",
        ]);

        $guru->update([
            "nama_guru" => $request->nama_guru,
            "nip" => $request->nip,
        ]);

        // Log aktivitas
        log_activity(
            "Mengupdate data guru: {$guru->nama_guru}",
            "guru",
            $guru->id_guru,
        );

        return redirect()
            ->route("guru.index")
            ->with("success", "Data guru berhasil diupdate");
    }

    public function destroy($id)
    {
        try {
            $guru = Guru::where("id_guru", $id)->firstOrFail();

            // Check if guru has related tamu
            $tamuCount = Tamu::where("guru_tujuan", $id)->count();

            if ($tamuCount > 0) {
                return redirect()
                    ->route("guru.index")
                    ->with(
                        "error",
                        "Tidak dapat menghapus guru {$guru->nama_guru} karena masih memiliki {$tamuCount} data kunjungan tamu. Silakan hapus atau pindahkan data tamu terlebih dahulu.",
                    );
            }

            // If no related tamu, safe to delete
            $namaGuru = $guru->nama_guru;
            $guru->delete();

            // Log aktivitas
            log_activity("Menghapus data guru: {$namaGuru}", "guru", $id);

            return redirect()
                ->route("guru.index")
                ->with("success", "Data guru {$namaGuru} berhasil dihapus");
        } catch (\Exception $e) {
            return redirect()
                ->route("guru.index")
                ->with(
                    "error",
                    "Gagal menghapus data guru: " . $e->getMessage(),
                );
        }
    }

    /**
     * Check if guru can be deleted
     */
    public function checkDelete($id)
    {
        try {
            $guru = Guru::where("id_guru", $id)->firstOrFail();
            $tamuCount = Tamu::where("guru_tujuan", $id)->count();

            return response()->json([
                "success" => true,
                "can_delete" => $tamuCount === 0,
                "tamu_count" => $tamuCount,
                "guru_name" => $guru->nama_guru,
                "message" =>
                    $tamuCount > 0
                        ? "Guru ini memiliki {$tamuCount} data kunjungan tamu"
                        : "Guru dapat dihapus",
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Guru tidak ditemukan",
                ],
                404,
            );
        }
    }

    /**
     * Reassign tamu to another guru before deleting
     */
    public function reassignAndDelete(Request $request, $id)
    {
        try {
            $guru = Guru::where("id_guru", $id)->firstOrFail();
            $newGuruId = $request->input("new_guru_id");

            // Validate new guru exists
            if ($newGuruId) {
                $newGuru = Guru::where("id_guru", $newGuruId)->firstOrFail();

                // Reassign all tamu to new guru
                Tamu::where("guru_tujuan", $id)->update([
                    "guru_tujuan" => $newGuruId,
                ]);

                $tamuCount = Tamu::where("guru_tujuan", $newGuruId)
                    ->where("guru_tujuan", "!=", $id)
                    ->count();
            } else {
                // Set guru_tujuan to NULL
                Tamu::where("guru_tujuan", $id)->update([
                    "guru_tujuan" => null,
                ]);
            }

            // Now safe to delete guru
            $namaGuru = $guru->nama_guru;
            $guru->delete();

            // Log aktivitas reassign and delete
            $logMessage = $newGuruId
                ? "Menghapus guru {$namaGuru} dan memindahkan tamu ke guru lain"
                : "Menghapus guru {$namaGuru} dan set guru_tujuan tamu menjadi NULL";
            log_activity($logMessage, "guru", $id);

            $message = $newGuruId
                ? "Data guru {$namaGuru} berhasil dihapus dan tamu dipindahkan ke guru lain"
                : "Data guru {$namaGuru} berhasil dihapus dan data tamu diupdate";

            return redirect()->route("guru.index")->with("success", $message);
        } catch (\Exception $e) {
            return redirect()
                ->route("guru.index")
                ->with(
                    "error",
                    "Gagal menghapus data guru: " . $e->getMessage(),
                );
        }
    }
}
