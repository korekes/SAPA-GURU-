<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Activity;
use App\Models\Kelas;
use App\Models\NilaiFormatif;
use App\Models\NilaiUts;
use App\Models\NilaiAktif;
use App\Models\NilaiSikap;
use App\Models\NilaiUas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Kelas $kelas)
    {
        return view('nilai.index', compact('kelas'));
    }

    public function create()
    {
        $siswa = Siswa::all();
        return view('nilai.create', compact('siswa'));
    }

    private function getPredikat($nilai)
    {
        if ($nilai >= 86) return 'Sangat Baik';
        if ($nilai >= 71) return 'Baik';
        if ($nilai >= 56) return 'Cukup';
        return 'Perlu Bimbingan';
    }

    public function storeSikap(Request $request)
    {
        foreach ($request->keaktifan as $siswa_id => $nilai_keaktifan) {

            $total_keaktifan = array_sum($nilai_keaktifan);
            $nilai_keaktifan_final = $total_keaktifan * 5; // contoh scaling

            $total_sikap = array_sum($request->sikap[$siswa_id]);
            $nilai_sikap_final = $total_sikap * 5;

            // predikat
            $predikat_keaktifan = $this->getPredikat($nilai_keaktifan_final);
            $predikat_sikap = $this->getPredikat($nilai_sikap_final);

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                    'type' => 'sikap'
                ],
                [
                    'nilai_keaktifan' => $nilai_keaktifan_final,
                    'predikat_keaktifan' => $predikat_keaktifan,
                    'nilai_sikap' => $nilai_sikap_final,
                    'predikat_sikap' => $predikat_sikap,
                ]
            );
        }

        return back()->with('success', 'Nilai sikap berhasil disimpan');
    }

    public function keaktifan(Kelas $kelas)
    {
        $nilai = NilaiAktif::where('kelas_id', $kelas->id)
            ->get()
            ->keyBy('siswa_id'); // 🔥 penting

        return view('nilai.keaktifan', compact('kelas', 'nilai'));
    }
    public function perilaku(Kelas $kelas)
    {
        $nilai = NilaiSikap::where('kelas_id', $kelas->id)
            ->get()
            ->keyBy('siswa_id'); // 🔥 penting

        return view('nilai.perilaku', compact('kelas', 'nilai'));
    }

    public function storeKeaktifan(Request $request)
    {
        foreach ($request->nilai as $siswa_id => $nilaiArray) {

            $total = array_sum($nilaiArray);
            $nilai = $total * 5;

            if ($nilai >= 86) $predikat = 'Sangat Baik';
            elseif ($nilai >= 71) $predikat = 'Baik';
            elseif ($nilai >= 56) $predikat = 'Cukup Baik';
            else $predikat = 'Perlu Bimbingan';

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                    'jenis' => 'keaktifan'
                ],
                [
                    'nilai' => $nilai,
                    'predikat' => $predikat
                ]
            );
        }
        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Nilai Keaktifan ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return redirect()->route('nilai.sikap', $request->kelas_id)->with('success', 'Nilai keaktifan berhasil disimpan');
    }

    public function saveAjax(Request $request)
    {
        $guru = Auth::user()->guru; // 🔥 ambil dari relasi guru

        foreach ($request->nilai as $siswa_id => $nilaiArray) {

            $total = array_sum($nilaiArray);
            $final = $total * 5;

            Nilai::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                    'jenis' => 'keaktifan'
                ],
                [
                    'nilai' => $final,
                    'guru_id' => $guru->id,
                    'detail_nilai' => json_encode($nilaiArray)
                ]
            );
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function absensi(Kelas $kelas)
    {
        $siswa = $kelas->siswa;

        $data = [];

        foreach ($siswa as $s) {

            $details = \App\Models\AbsensiDetail::where('siswa_id', $s->id)
                ->whereHas('absensi', function ($q) use ($kelas) {
                    $q->where('kelas_id', $kelas->id);
                })
                ->get();

            $hadir = $details->where('status', 'hadir')->count();
            $izin  = $details->where('status', 'izin')->count();
            $sakit = $details->where('status', 'sakit')->count();
            $alfa  = $details->where('status', 'alfa')->count();

            // hitung nilai
            $nilai = 100 - ($izin * 15) - ($sakit * 15) - ($alfa * 25);

            // batas minimal
            $nilai = max(0, $nilai);

            // 🔥 RULE BARU: kalau alfa >= 3 → max 77
            if ($alfa >= 3) {
                $nilai = 77;
            }

            $data[] = [
                'nama' => $s->nama,
                'hadir' => $hadir,
                'izin' => $izin,
                'sakit' => $sakit,
                'alfa' => $alfa,
                'nilai' => $nilai,
            ];
        }

        return view('nilai.absensi', compact('kelas', 'data'));
    }

    public function sikap(Kelas $kelas)
    {
        $siswa = $kelas->siswa;

        return view('nilai.sikap', compact('kelas', 'siswa'));
    }

    public function akademik(Kelas $kelas)
    {
        $guru = Auth::user()->guru;

        // 🔥 ambil daftar BAB
        $babList = NilaiFormatif::where('kelas_id', $kelas->id)
            ->where('guru_id', $guru->id)
            ->select('bab')
            ->distinct()
            ->pluck('bab');

        // 🔥 data rekap (punya kamu)
        $data = [];

        foreach ($kelas->siswa as $s) {

            $formatif = NilaiFormatif::where('siswa_id', $s->id)
                ->where('kelas_id', $kelas->id)
                ->avg('nilai');

            $uts = NilaiUts::where('siswa_id', $s->id)
                ->where('kelas_id', $kelas->id)
                ->value('nilai') ?? 0;

            $uas = NilaiUas::where('siswa_id', $s->id)
                ->where('kelas_id', $kelas->id)
                ->value('nilai') ?? 0;

            $sumatif = ($uts + $uas) / 2;
            $rapor = ($formatif + $sumatif) / 2;

            $data[] = [
                'nama' => $s->nama,
                'formatif_avg' => round($formatif, 1),
                'uts' => $uts,
                'uas' => $uas,
                'sumatif_avg' => round($sumatif, 1),
                'rapor' => round($rapor, 1),
            ];
        }

        return view('nilai.akademik', compact('kelas', 'data', 'babList'));
    }

    public function inputAkademik(Kelas $kelas)
    {
        return view('nilai.akademik_input', compact('kelas'));
    }

    public function inputFormatif(Kelas $kelas, $bab)
    {
        $guru = Auth::user()->guru;

        $nilai = NilaiFormatif::where('kelas_id', $kelas->id)
            ->where('guru_id', $guru->id)
            ->where('bab', $bab)
            ->pluck('nilai', 'siswa_id');


        return view('nilai.formatif.input', compact('kelas', 'bab', 'nilai'));
    }

    public function createFormatif(Kelas $kelas)
    {
        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Nilai Formatif ' . $kelas->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo',
        ]);

        return view('nilai.formatif.create', compact('kelas'));
    }

    public function formatif(Kelas $kelas, $bab)
    {
        $guru = Auth::user()->guru;

        $nilai = NilaiFormatif::where('kelas_id', $kelas->id)
            ->where('guru_id', $guru->id)
            ->where('bab', $bab)
            ->pluck('nilai', 'siswa_id');

        return view('nilai.input-formatif', compact('kelas', 'nilai', 'bab'));
    }
    public function formatifList(Kelas $kelas)
    {
        $nilai = NilaiFormatif::where('kelas_id', $kelas->id)
            ->where('guru_id', Auth::user()->guru->id)
            ->with('siswa')
            ->get()
            ->groupBy('bab');

        return view('nilai.formatif.list', compact('kelas', 'nilai'));
    }
    public function formatifShow(Kelas $kelas, $bab)
    {
        $guru = Auth::user()->guru;

        $nilai = NilaiFormatif::where('kelas_id', $kelas->id)
            ->where('guru_id', $guru->id)
            ->where('bab', $bab)
            ->with('siswa')
            ->get();

        return view('nilai.formatif.show', compact('kelas', 'bab', 'nilai'));
    }
    public function storeFormatif(Request $request)
    {
        $request->validate([
            'bab' => 'required|string',
            'nilai.*' => 'required|integer|min:0|max:100'
        ]);

        $guru = Auth::user()->guru;

        foreach ($request->nilai as $siswa_id => $nilai) {

            NilaiFormatif::create([
                'siswa_id' => $siswa_id,
                'kelas_id' => $request->kelas_id,
                'guru_id' => $guru->id,
                'bab' => $request->bab,
                'nilai' => $nilai
            ]);
        }

        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Nilai Formatif ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return back()->with('success', 'Nilai formatif berhasil disimpan');
    }
    public function saveFormatifAjax(Request $request)
    {
        $guru = Auth::user()->guru;

        foreach ($request->nilai as $siswa_id => $nilai) {

            NilaiFormatif::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                    'bab' => $request->bab,
                ],
                [
                    'nilai' => $nilai,
                    'guru_id' => $guru->id
                ]
            );
        }

        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Nilai Formatif ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    
    public function uts(Kelas $kelas)
    {
        $siswa = $kelas->siswa;

        // ambil nilai yang sudah ada
        $nilai = Nilai::where('kelas_id', $kelas->id)
            ->where('jenis', 'uts')
            ->get()
            ->keyBy('siswa_id');

        return view('nilai.uts', compact('kelas', 'siswa', 'nilai'));
    }

    public function storeUts(Request $request)
    {
        $request->validate([
            'nilai.*' => 'required|integer|min:0|max:100'
        ]);

        $guru = Auth::user()->guru;

        foreach ($request->nilai as $siswa_id => $nilai) {

            NilaiUts::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                ],
                [
                    'nilai' => $nilai,
                    'guru_id' => $guru->id
                ]
            );
        }

        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Nilai UTS ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return back()->with('success', 'Nilai UTS tersimpan');
    }
    public function saveUtsAjax(Request $request)
    {
        $guru = Auth::user()->guru;

        foreach ($request->nilai as $siswa_id => $nilai) {

            NilaiUts::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                ],
                [
                    'nilai' => $nilai,
                    'guru_id' => $guru->id
                ]
            );
        }

        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Nilai UTS ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);


        return response()->json(['success' => true]);
    }

    public function uas(Kelas $kelas)
    {
        $siswa = $kelas->siswa;

        $nilai = Nilai::where('kelas_id', $kelas->id)
            ->where('jenis', 'uas')
            ->get()
            ->keyBy('siswa_id');

        
        return view('nilai.uas', compact('kelas', 'siswa', 'nilai'));
    }

    public function storeUas(Request $request)
    {
        $request->validate([
            'nilai.*' => 'required|integer|min:0|max:100'
        ]);

        $guru = Auth::user()->guru;

        foreach ($request->nilai as $siswa_id => $nilai) {

            NilaiUas::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                ],
                [
                    'nilai' => $nilai,
                    'guru_id' => $guru->id
                ]
            );
        }

        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Nilai UAS ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return back()->with('success', 'Nilai UAS tersimpan');
    }
    public function saveUasAjax(Request $request)
    {
        $guru = Auth::user()->guru;

        foreach ($request->nilai as $siswa_id => $nilai) {

            NilaiUas::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                ],
                [
                    'nilai' => $nilai,
                    'guru_id' => $guru->id
                ]
            );
        }

        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Nilai UAS ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);


        return response()->json(['success' => true]);
    }


    public function saveKeaktifanAjax(Request $request)
    {
        $guru = Auth::user()->guru;

        foreach ($request->nilai as $siswa_id => $nilaiArray) {

            $diskusi     = $nilaiArray[0] ?? 0;
            $inisiatif   = $nilaiArray[1] ?? 0;
            $kerjasama   = $nilaiArray[2] ?? 0;
            $komunikasi  = $nilaiArray[3] ?? 0;
            $tugas       = $nilaiArray[4] ?? 0;

            $total = $diskusi + $inisiatif + $kerjasama + $komunikasi + $tugas;
            $final = $total * 5;

            NilaiAktif::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                ],
                [
                    'guru_id'   => $guru->id,
                    'diskusi'   => $diskusi,
                    'inisiatif' => $inisiatif,
                    'kerjasama' => $kerjasama,
                    'komunikasi'=> $komunikasi,
                    'tugas'     => $tugas,
                    'nilai'     => $final,
                ]
            );
        }

        Activity::create([
            'judul' => 'Input Nilai Keaktifan ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return response()->json(['success' => true]);
    }

    public function savePerilakuAjax(Request $request)
    {
        $guru = Auth::user()->guru;

        foreach ($request->nilai as $siswa_id => $nilaiArray) {

            $disiplin        = $nilaiArray[0] ?? 0;
            $kejujuran       = $nilaiArray[1] ?? 0;
            $tanggung_jawab  = $nilaiArray[2] ?? 0;
            $kemandirian     = $nilaiArray[3] ?? 0;
            $kepedulian      = $nilaiArray[4] ?? 0;

            $total = $disiplin + $kejujuran + $tanggung_jawab + $kemandirian + $kepedulian;
            $final = $total * 5;

            NilaiSikap::updateOrCreate(
                [
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $request->kelas_id,
                ],
                [
                    'guru_id'        => $guru->id,
                    'disiplin'       => $disiplin,
                    'kejujuran'      => $kejujuran,
                    'tanggung_jawab' => $tanggung_jawab,
                    'kemandirian'    => $kemandirian,
                    'kepedulian'     => $kepedulian,
                    'nilai'          => $final,
                ]
            );
        }

        Activity::create([
            'user_id' => Auth::id(),
            'judul' => 'Input Nilai Perilaku ' . Kelas::find($request->kelas_id)->nama,
            'description' => 'Guru ' . Auth::user()->name,
            'icon' => 'indigo'
        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function latestActivity()
    {
        $data = Activity::latest()
            ->limit(3)
            ->get();

        return response()->json($data);
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();
        return back()->with('success', 'Nilai dihapus');
    }
}