<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Kelas;
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
        $guru = Guru::with('user')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('mapel.create', compact(
            'guru',
            'kelas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required'
        ]);

        Mapel::create([
            'nama_mapel' => $request->nama_mapel
        ]);

        return redirect()->route('mapel.index');
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
            'mengajar.kelas'
        ])->findOrFail($id);

        return view('mapel.show', compact('mapel'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(
            new MapelImport,
            $request->file('file')
        );

        return redirect()
            ->route('mapel.index')
            ->with('success','Data mapel berhasil diimport');
    }
}