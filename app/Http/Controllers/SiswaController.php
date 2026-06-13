<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        $siswa = $query->with('kelas')->get();

        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required|unique:siswas',
            'kelas_id' => 'required'
        ]);

        Siswa::create($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan');
    }

    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::all();
        return view('siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nama' => 'required',
            'nis' => 'required|unique:siswas,nis,' . $siswa->id,
            'kelas_id' => 'required'
        ]);

        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return back()->with('success', 'Data siswa dihapus');
    }

    public function show($id)
    {
        $siswa = Siswa::with('absensiDetails.absensi')->findOrFail($id);

        return view('siswa.show', compact('siswa'));
    }

    public function importCsv(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file')->getRealPath();
        $handle = fopen($file, 'r');

        // skip header
        fgetcsv($handle, 1000, ',');

        $success = 0;
        $failed = [];

        while (($row = fgetcsv($handle, 1000, ',')) !== false) {

            $row = array_map('trim', $row);
            $row = array_pad($row, 5, null);

            [$no_absen, $nama, $nis, $kelas_raw, $jk] = $row;

            if (!$no_absen || !$nama || !$nis || !$kelas_raw || !$jk) {
                continue;
            }

            $kelas = Kelas::where('nama_kelas', $kelas_raw)->first();

            if (!$kelas) {
                continue;
            }

            Siswa::updateOrCreate(
                [
                    'no_absen' => $no_absen,
                    'kelas_id' => $kelas->id
                ],
                [
                    'nama' => $nama,
                    'nis' => $nis,
                    'jenis_kelamin' => strtoupper($jk)
                ]
            );
        }

        fclose($handle);

        return redirect()->route('siswa.index')
        ->with([
            'success' => "$success data berhasil diimport",
            'failed' => $failed
        ]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(
            new SiswaImport,
            $request->file('file')
        );

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil diimport');
    }
}