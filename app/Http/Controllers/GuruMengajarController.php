<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\GuruMengajar;
use Illuminate\Http\Request;

class GuruMengajarController extends Controller
{
    public function index()
    {
        $mengajar = GuruMengajar::with([
            'guru.user',
            'kelas',
            'mapel'
        ])->latest()->get();

        return view('mengajar.index', compact('mengajar'));
    }

    public function create()
    {
        return view('mengajar.create', [
            'guru' => Guru::with('user')->get(),
            'kelas' => Kelas::all(),
            'mapel' => Mapel::all()
        ]);
    }

    public function store(Request $request)
    {
        GuruMengajar::create([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
        ]);

        return redirect()->route('mengajar.index');
    }

    public function destroy($id)
    {
        GuruMengajar::findOrFail($id)->delete();

        return back();
    }
}