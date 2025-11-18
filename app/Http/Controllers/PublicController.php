<?php

namespace App\Http\Controllers;

use App\Models\Tamu;
use App\Models\Guru;
use App\Models\JenisKunjungan;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        return view('public.landing');
    }

    public function formKunjungan()
    {
        $guru = Guru::orderBy('nama_guru', 'asc')->get();
        $jenisKunjungan = JenisKunjungan::all();
        return view('public.form-kunjungan', compact('guru', 'jenisKunjungan'));
    }

    public function storeKunjungan(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:50',
            'status' => 'required|string|max:100',
            'id_jenis' => 'required|exists:jenis_kunjungan,id_jenis',
            'tujuan' => 'required|string',
            'guru_tujuan' => 'nullable|exists:guru,id_guru',
            'alamat' => 'required|string',
            'tanggal_kunjungan' => 'required|date',
            'waktu_masuk' => 'required',
        ]);

        Tamu::create([
            'nama' => $request->nama,
            'telepon' => $request->telepon,
            'status' => $request->status,
            'id_jenis' => $request->id_jenis,
            'tujuan' => $request->tujuan,
            'guru_tujuan' => $request->guru_tujuan,
            'alamat' => $request->alamat,
            'keterangan' => $request->keterangan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'waktu_masuk' => $request->waktu_masuk,
            'status_kunjungan' => 'proses',
            'created_by' => null, // Dari public form
        ]);

        return redirect()
            ->route('public.success')
            ->with('success', 'Pengajuan kunjungan berhasil dikirim. Silakan tunggu konfirmasi dari pihak sekolah.');
    }

    public function success()
    {
        return view('public.success');
    }
}
