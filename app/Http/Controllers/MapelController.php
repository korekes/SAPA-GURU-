<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\GuruMengajar;
use Illuminate\Http\Request;
use App\Imports\MapelImport;
use Maatwebsite\Excel\Facades\Excel;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = Mapel::latest()->get();

        return view('mapel.index', compact('mapel'));
    }

    public function create()
    {
        $guru  = Guru::with('user')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('mapel.create', compact('guru', 'kelas'));
    }

    /**
     * Simpan mapel baru DAN sekaligus buat relasi guru_mengajar
     * (guru + mapel + kelas) supaya bisa langsung dipakai di drag & drop jadwal.
     *
     * Catatan: tabel fisik bernama 'guru_mengajar' (tunggal) —
     * model GuruMengajar sudah benar mengarah ke sana, tidak perlu diubah.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required|string|max:255',
            'guru_id'    => 'required|exists:guru,id',
            'kelas_id'   => 'required|exists:kelas,id',
        ]);

        // Cari mapel yang sudah ada (hindari duplikat nama mapel),
        // atau buat baru kalau belum ada.
        $mapel = Mapel::firstOrCreate([
            'nama_mapel' => $request->nama_mapel,
        ]);

        // Cek dulu supaya tidak dobel kombinasi guru+mapel+kelas yang sama
        $sudahAda = GuruMengajar::where('guru_id', $request->guru_id)
            ->where('mapel_id', $mapel->id)
            ->where('kelas_id', $request->kelas_id)
            ->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->withErrors([
                    'guru_id' => 'Kombinasi guru, mapel, dan kelas ini sudah pernah didaftarkan.',
                ]);
        }

        // Ini bagian yang sebelumnya HILANG di versi awal —
        // tanpa baris ini, tabel guru_mengajar tidak pernah terisi.
        GuruMengajar::create([
            'guru_id'  => $request->guru_id,
            'mapel_id' => $mapel->id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Mata pelajaran & penugasan guru berhasil disimpan.');
    }

    public function destroy($id)
    {
        Mapel::findOrFail($id)->delete();

        return back();
    }

    public function show($id)
    {
        $mapel = Mapel::with([
            'mengajar.guru.user',
            'mengajar.kelas',
        ])->findOrFail($id);

        return view('mapel.show', compact('mapel'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new MapelImport, $request->file('file'));

        return redirect()
            ->route('mapel.index')
            ->with('success', 'Data mapel berhasil diimport');
    }
}