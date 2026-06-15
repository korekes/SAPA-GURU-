<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\GuruMengajar;
use App\Imports\JadwalImport;
use Maatwebsite\Excel\Facades\Excel;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwal = Jadwal::with([
            'mengajar.guru.user',
            'mengajar.mapel',
            'mengajar.kelas',
        ])
        ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
        ->orderBy('jam_mulai')
        ->get()
        ->groupBy('hari');

        return view('jadwal.index', compact('jadwal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mengajar = GuruMengajar::with([
            'guru.user',
            'mapel',
            'kelas',
        ])->get();

        $kelas = Kelas::orderBy('nama_kelas')->get();

        // Susun data mengajar per kelas untuk drag & drop (JSON)
        $mengajarPerKelas = [];
        foreach ($mengajar as $m) {
            $namaKelas = $m->kelas->nama_kelas;
            if (!isset($mengajarPerKelas[$namaKelas])) {
                $mengajarPerKelas[$namaKelas] = [];
            }
            $mengajarPerKelas[$namaKelas][] = [
                'id'    => $m->id,
                'mapel' => $m->mapel->nama_mapel,
                'guru'  => $m->guru->user->name,
                'kelas' => $namaKelas,
            ];
        }

        return view('jadwal.create', compact(
            'mengajar',
            'kelas',
            'mengajarPerKelas',
        ));
    }

    /**
     * Store a newly created resource in storage (manual form).
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required|after:jam_mulai',
            'guru_mengajar_id'  => 'required|exists:guru_mengajars,id',
        ]);

        $mengajar = GuruMengajar::findOrFail($request->guru_mengajar_id);

        // Cek bentrok jadwal kelas & waktu
        $bentrok = Jadwal::where('hari', $request->hari)
            ->whereHas('mengajar', fn($q) => $q->where('kelas_id', $mengajar->kelas_id))
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]);
            })
            ->exists();

        if ($bentrok) {
            return back()
                ->withInput()
                ->withErrors(['bentrok' => 'Jadwal bentrok dengan jadwal lain di kelas yang sama.']);
        }

        Jadwal::create([
            'guru_mengajar_id' => $mengajar->id,
            'hari'             => $request->hari,
            'jam_mulai'        => $request->jam_mulai,
            'jam_selesai'      => $request->jam_selesai,
        ]);

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Store jadwal via drag & drop (AJAX / JSON).
     */
    public function drop(Request $request)
    {
        $request->validate([
            'items'                 => 'required|array|min:1',
            'items.*.guru_mengajar_id' => 'required|exists:guru_mengajars,id',
            'items.*.hari'          => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'items.*.jam_mulai'     => 'required',
            'items.*.jam_selesai'   => 'required',
        ]);

        $saved  = 0;
        $errors = [];

        foreach ($request->items as $i => $item) {
            $mengajar = GuruMengajar::find($item['guru_mengajar_id']);

            // Cek bentrok
            $bentrok = Jadwal::where('hari', $item['hari'])
                ->whereHas('mengajar', fn($q) => $q->where('kelas_id', $mengajar->kelas_id))
                ->where(function ($q) use ($item) {
                    $q->whereBetween('jam_mulai', [$item['jam_mulai'], $item['jam_selesai']])
                      ->orWhereBetween('jam_selesai', [$item['jam_mulai'], $item['jam_selesai']]);
                })
                ->exists();

            if ($bentrok) {
                $errors[] = "Baris " . ($i + 1) . ": bentrok di {$item['hari']} {$item['jam_mulai']}–{$item['jam_selesai']}";
                continue;
            }

            Jadwal::create([
                'guru_mengajar_id' => $item['guru_mengajar_id'],
                'hari'             => $item['hari'],
                'jam_mulai'        => $item['jam_mulai'],
                'jam_selesai'      => $item['jam_selesai'],
            ]);

            $saved++;
        }

        return response()->json([
            'success' => true,
            'saved'   => $saved,
            'errors'  => $errors,
        ]);
    }

    /**
     * Import jadwal dari file Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:10240',
        ]);

        try {
            Excel::import(new JadwalImport, $request->file('file'));

            return redirect()
                ->route('jadwal.index')
                ->with('success', 'Jadwal berhasil diimport dari Excel.');
        } catch (\Exception $e) {
            return back()->withErrors(['import' => 'Gagal import: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jadwal = Jadwal::with([
            'mengajar.guru.user',
            'mengajar.mapel',
            'mengajar.kelas',
        ])->findOrFail($id);

        return view('jadwal.show', compact('jadwal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwal   = Jadwal::findOrFail($id);
        $mengajar = GuruMengajar::with(['guru.user', 'mapel', 'kelas'])->get();

        return view('jadwal.edit', compact('jadwal', 'mengajar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'hari'              => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required|after:jam_mulai',
            'guru_mengajar_id'  => 'required|exists:guru_mengajars,id',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->only([
            'hari', 'jam_mulai', 'jam_selesai', 'guru_mengajar_id',
        ]));

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Jadwal::findOrFail($id)->delete();

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}