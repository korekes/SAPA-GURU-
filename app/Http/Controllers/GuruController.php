<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('user');

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            })->orWhere('nip', 'like', "%{$request->search}%");
        }

        $guru = $query->latest()->get();

        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nip' => 'required|numeric|unique:users,nip',
            'mapel' => 'nullable',
        ]);

        // 1. SIMPAN KE USERS
        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip, // tetap di sini
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        // 2. SIMPAN KE GURUS
        Guru::create([
            'user_id' => $user->id,
            'mapel' => $request->mapel,
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Guru berhasil ditambahkan');
    }

    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        return view('guru.show', compact('guru'));
    }

    public function edit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        // update user
        $guru->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip, // pindah ke sini
        ]);
    
        // update guru
        $guru->update([
            'mapel' => $request->mapel,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);

        $guru->user()->delete(); // 🔥 hapus user juga
        $guru->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
