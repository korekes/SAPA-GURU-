<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal;
use App\Models\Kelas;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;


class JurnalController extends Controller
{
    public function index(Kelas $kelas)
    {
        $jurnal = Jurnal::where('kelas_id', $kelas->id)->get();

        return view('jurnal.index', compact('jurnal', 'kelas'));
    }
    // 📘 tampilkan jurnal per kelas
    public function kelas($id)
    {
        $kelas = Kelas::findOrFail($id);

        $jurnal = Jurnal::where('kelas_id', $id)
            ->latest()
            ->get();

        return view('jurnal.index', compact('kelas', 'jurnal'));
    }

    // ➕ form tambah
    public function create(Kelas $kelas)
    {
        return view('jurnal.create', compact('kelas'));
    }

    // 💾 simpan
    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'tanggal' => 'required|date',
            'materi' => 'required',
        ]);

        $guru = Auth::user()->guru;

        Jurnal::create([
            'kelas_id'   => $request->kelas_id, 
            'guru_id'    => $guru->id,
            'mapel'      => $guru->mapel,
            'tanggal'    => $request->tanggal,
            'materi'     => $request->materi,
            'kegiatan'   => $request->kegiatan,
            'tujuan_pembelajaran' => $request->tujuan_pembelajaran,
        ]);

        Activity::create([
            'judul' => 'Input Jurnal ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return redirect()
            ->route('jurnal.index', $request->kelas_id)
            ->with('success', 'Jurnal berhasil ditambahkan');
    }

    // ✏️ edit
    public function edit($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $kelas = Kelas::findOrFail($jurnal->kelas_id);

        return view('jurnal.edit', compact('jurnal', 'kelas'));
    }

    // 🔄 update
    public function update(Request $request, $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        $jurnal->update($request->all());

        Activity::create([
            'judul' => 'Update Jurnal ' . Kelas::find($request->kelas_id)->nama,
            'deskripsi' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return redirect()
            ->route('jurnal.kelas', $jurnal->kelas_id)
            ->with('success', 'Jurnal berhasil diupdate');
    }

    // 🗑️ hapus
    public function destroy($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        $kelas_id = $jurnal->kelas_id;

        $jurnal->delete();

        return redirect()
            ->route('jurnal.index', $kelas_id)
            ->with('success', 'Jurnal dihapus');
    }

    public function show($id)
    {
        $jurnal = Jurnal::with('guru', 'kelas')->findOrFail($id);

        return view('jurnal.show', compact('jurnal'));
    }

    public function latestActivity()
    {
        $data = Activity::latest()
            ->limit(10)
            ->get();

        return response()->json($data);
    }
}