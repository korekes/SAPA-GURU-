<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Activity;
use App\Models\AbsensiDetail;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function index(Kelas $kelas)
    {
        $absensi = Absensi::with('details')
            ->where('kelas_id', $kelas->id)
            ->latest()
            ->get();

        return view('absensi.index', compact('kelas', 'absensi'));
    }

    public function create(Kelas $kelas)
    {
        $siswa = $kelas->siswa;

        return view('absensi.create', compact('kelas', 'siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'tanggal' => 'required|date',
        ]);

        // 1. buat absensi header
        $absensi = Absensi::create([
            'kelas_id' => $request->kelas_id,
            'guru_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'mapel' => $request->mapel,
        ]);

        // 2. simpan detail siswa
        foreach ($request->status as $siswa_id => $status) {
            AbsensiDetail::create([
                'absensi_id' => $absensi->id,
                'siswa_id' => $siswa_id,
                'status' => $status,
                'keterangan' => $request->keterangan[$siswa_id] ?? null,
            ]);
        }


        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Presensi ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return redirect()->route('absensi.kelas', $request->kelas_id)
            ->with('success', 'Absensi berhasil disimpan');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->details()->delete();

        $absensi->delete();

        return redirect()
            ->route('absensi.kelas', $absensi->kelas_id)
            ->with('success', 'Data absensi dihapus');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'absensi_id' => 'required',
            'siswa_id' => 'required',
            'status' => 'required',
        ]);

        $detail = AbsensiDetail::updateOrCreate(
            [
                'absensi_id' => $request->absensi_id,
                'siswa_id' => $request->siswa_id,
            ],
            [
                'status' => $request->status
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status updated',
            'data' => $detail
        ]);
    }

    public function rekap($absensi_id)
    {
        $absensi = Absensi::with('details.siswa')->findOrFail($absensi_id);

        $hadir = $absensi->details->where('status', 'hadir')->count();
        $izin  = $absensi->details->where('status', 'izin')->count();
        $sakit = $absensi->details->where('status', 'sakit')->count();
        $alfa  = $absensi->details->where('status', 'alfa')->count();

        $nilai = 100;
        $nilai -= ($izin * 15);
        $nilai -= ($sakit * 15);
        $nilai -= ($alfa * 25);
        $nilai = max(0, $nilai);

        return view('absensi.rekap', compact(
            'absensi', 'hadir', 'izin', 'sakit', 'alfa', 'nilai'
        ));
    }

    public function edit($id)
    {
        $absensi = Absensi::with('details.siswa')->findOrFail($id);
        $kelas = $absensi->kelas;

        return view('absensi.edit', compact('absensi', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
        ]);

        // update header
        $absensi->update([
            'tanggal' => $request->tanggal,
            'mapel' => $request->mapel,
        ]);

        // update detail
        foreach ($request->status as $siswa_id => $status) {
            AbsensiDetail::updateOrCreate(
                [
                    'absensi_id' => $absensi->id,
                    'siswa_id' => $siswa_id,
                ],
                [
                    'status' => $status,
                    'keterangan' => $request->keterangan[$siswa_id] ?? null,
                ]
            );
        }

        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Update Presensi ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return redirect()->route('absensi.kelas', $absensi->kelas_id)
            ->with('success', 'Absensi berhasil diupdate');
    }

    public function latestActivity()
    {
        $data = Activity::latest()
            ->limit(10)
            ->get();

        return response()->json($data);
    }
}