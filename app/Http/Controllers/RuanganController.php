<?php

namespace App\Http\Controllers;

use App\Models\AsetRuangan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $ruangans = Ruangan::orderBy('created_at', 'asc')->paginate(5);
        $search = $request->input('search');

        $ruangans = Ruangan::when($search, function ($query, $search) {
            $query->where('nama_ruangan', 'like', "%{$search}%")
                  ->orWhere('deskripsi_ruangan', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'asc')
        ->paginate(5);
        return view('ruangan.ruangan', compact('ruangans'));
    }

    public function create()
    {
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_ruangan'      => 'required|string|max:128|unique:ruangans,nama_ruangan',
            'deskripsi_ruangan' => 'nullable|string',
            'penanggung_jawab'  => 'required|string|max:64',
        ]);

        Ruangan::create($validated);

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

   

public function show($id)
{
    try {
        $ruanganId = Crypt::decrypt($id);
    } catch (\Exception $e) {
        abort(404, 'ID tidak valid');
    }

    
    $ruangan = Ruangan::findOrFail($ruanganId);


    $aset = AsetRuangan::select('aset_id', 'kondisi', DB::raw('COUNT(*) as total'))
    ->where('ruangan_id', $ruanganId)
    ->groupBy('aset_id', 'kondisi')
    ->with('aset') 
    ->paginate(5); 

    return view('ruangan.detail', compact('ruangan', 'aset'));
}


    public function edit($encryptedId)
    {
        try {
            $ruanganId = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid');
        }

        $ruangan = Ruangan::findOrFail($ruanganId);

        return view('ruangan.edit', compact('ruangan', 'encryptedId')); 
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $ruanganId = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            return redirect()->route('ruangan.index')->with('error', 'ID tidak valid.');
        }

        $ruangan = Ruangan::findOrFail($ruanganId);

        $validated = $request->validate([
            'nama_ruangan'      => 'required|string|max:128|unique:ruangans,nama_ruangan,' . $ruanganId,
            'deskripsi_ruangan' => 'nullable|string',
            'penanggung_jawab'  => 'required|string|max:64',
        ]);

        $ruangan->update($validated);

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function deleteConfirm($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            return redirect()->route('ruangan.index')->with('error', 'ID tidak valid.');
        }
    
        $ruangan = Ruangan::findOrFail($id);
    
        return view('ruangan.delete', compact('ruangan', 'encryptedId'));
    }
    
    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            return redirect()->route('ruangan.index')->with('error', 'ID tidak valid.');
        }
    
        $ruangan = Ruangan::findOrFail($id);
    
      
        $ruangan->delete();
    
        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil dihapus.');
    }
    

    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $ruangans = Ruangan::query()
            ->where('nama_ruangan', 'like', "%{$keyword}%")
            ->orWhere('penanggung_jawab', 'like', "%{$keyword}%")
            ->orderBy('created_at', 'asc')
            ->paginate(5);

        return view('ruangan.ruangan', compact('ruangans', 'keyword'));
    }
}


