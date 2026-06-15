<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Activity;
use App\Models\Absensi;
use App\Models\AbsensiDetail;
use App\Models\Nilai;
use App\Models\GuruMengajar;
use App\Models\Jurnal;
use App\Models\Mapel;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
    {
        if (auth()->user()->role == 'guru') {

            $guru = Guru::where('user_id', auth()->id())
                ->first();

            $mengajar = GuruMengajar::with([
                'kelas',
                'mapel'
            ])
            ->where('guru_id', $guru->id)
            ->get();

            $totalKelas = $mengajar
                ->pluck('kelas_id')
                ->unique()
                ->count();

            $totalMapel = $mengajar
                ->pluck('mapel_id')
                ->unique()
                ->count();

            $kelasIds = $mengajar
                ->pluck('kelas_id')
                ->unique();

            $totalSiswa = Siswa::whereIn(
                'kelas_id',
                $kelasIds
            )->count();

            $materiTerakhir = Jurnal::with('kelas')
                ->where('guru_id', $guru->id)
                ->latest()
                ->first();

            $totalJurnal = Jurnal::where(
                'guru_id',
                $guru->id
            )->count();

            return view('dashboard', compact(
                'mengajar',
                'totalKelas',
                'totalMapel',
                'totalSiswa',
                'materiTerakhir',
                'totalJurnal'
            ));
        }

        $total_siswa = Siswa::count();

        $hadir = AbsensiDetail::where('status', 'hadir')
            ->whereHas('absensi', function ($q) {
                $q->whereDate('tanggal', now());
            })
            ->count();

        $total_absensi = Absensi::whereDate(
            'tanggal',
            now()
        )->count();

        $persen_hadir = $total_absensi > 0
            ? round(($hadir / $total_siswa) * 100)
            : 0;

        $total_nilai = Nilai::count();

        return view('dashboard', [
            'total_siswa'      => Siswa::count(),
            'total_guru'       => Guru::count(),
            'total_kelas'      => Kelas::count(),
            'total_mapel'      => Mapel::count(),
            'total_mengajar'   => GuruMengajar::count(),
        ]);
    }

    public function latestActivity()
    {
        $data = Activity::latest()
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    public function developer()
    {
        $developers = [
            [
                'nama' => 'Pengembang 1',
                'role' => 'Pengembang Ide & Aplikasi Pertama',
                'deskripsi' => 'Menginisiasi dan membangun versi awal sistem Sapa Guru sebagai fondasi utama aplikasi.',
                'foto' => 'storage/foto/dev1.jpg',
                'color' => 'indigo'
            ],
            [
                'nama' => 'Pengembang 2',
                'role' => 'Pengembang Aplikasi Terbaru',
                'deskripsi' => 'Mengembangkan dan menyempurnakan sistem menjadi lebih modern, cepat, dan interaktif.',
                'foto' => 'storage/foto/dev2.jpg',
                'color' => 'emerald'
            ]
        ];

        return view('about.developer', compact('developers'));
    }
    
    public function about()
{
    $developers = [
        [
            'nama' => 'Pengembang Pertama',
            'role' => 'Ide & Aplikasi Awal',
            'deskripsi' => 'Perancang konsep awal sistem Sapa Guru yang menjadi fondasi utama aplikasi.',
            'foto' => 'storage/foto/dev1.jpg',
            'color' => 'indigo'
        ],
        [
            'nama' => 'Pengembang Kedua',
            'role' => 'Pengembang Versi Terbaru',
            'deskripsi' => 'Mengembangkan ulang sistem dengan fitur modern, performa tinggi, dan UI/UX yang lebih baik.',
            'foto' => 'storage/foto/dev2.jpg',
            'color' => 'emerald'
        ]
    ];

    return view('about', compact('developers'));
}
}
