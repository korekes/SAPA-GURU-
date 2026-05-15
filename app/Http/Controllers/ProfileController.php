<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        // update data
        $user->name = $request->name;
        if ($request->filled('nip')) {
            $user->nip = $request->nip;
        }

        // upload foto
        if ($request->hasFile('foto')) {

            // hapus foto lama (opsional)
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }

            // simpan foto baru
            $path = $request->file('foto')->store('foto-profile', 'public');

            // simpan ke DB
            $user->foto = $path;
        }

        $request->file('foto')->store('foto-profile', 'public');
        $user->save();

        return back()->with('success', 'Profile berhasil diupdate');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
