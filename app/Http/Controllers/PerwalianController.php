<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class PerwalianController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $kelas = Kelas::where('wali_kelas', $user->name)->first();

        return view('perwalian.index', compact('kelas'));
    }
}