<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('pengaturan.pengaturan');
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return redirect()->back()->with('success', 'Nama admin berhasil diperbarui.');
    }
}
