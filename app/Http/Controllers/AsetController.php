<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class AsetController extends Controller
{
    // --- Index ---
    public function index(Request $request)
    {
        $asets = Aset::orderBy('created_at', 'asc')->paginate(5);
        $search = $request->input('search');

        $asets = Aset::when($search, function ($query, $search) {
            $query->where('nama_aset', 'like', "%{$search}%")
                  ->orWhere('tipe_aset', 'like', "%{$search}%")
                  ->orWhere('kode_aset', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'asc')
        ->paginate(5);
    
        return view('aset.aset', compact('asets', 'search'));
       
        
    }

    // --- Create ---
    public function create()
    {
        return view('aset.create');
    }

    // --- Store ---
    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaAset'    => 'required|string|max:64|unique:asets,nama_aset',
            'tipeAset'    => 'required|string|in:Furnitur,Elektronik,Dekorasi,Lainnya',
            'tipeLainnya' => 'nullable|string|max:64',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:8192',
        ]);

        $tipe = $validated['tipeAset'] === 'Lainnya' && !empty($validated['tipeLainnya'])
            ? $validated['tipeLainnya']
            : $validated['tipeAset'];

        $kodeAset = $this->generateUniqueKodeAset($validated['namaAset'], $tipe);

        $fotoPath = $request->hasFile('foto')
            ? $request->file('foto')->store('foto_aset', 'public')
            : 'foto_aset/placeholder.png';

        Aset::create([
            'nama_aset' => $validated['namaAset'],
            'tipe_aset' => $tipe,
            'kode_aset' => $kodeAset,
            'foto_aset' => $fotoPath,
        ]);

        return redirect()->route('aset.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    // --- Show ---
    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid');
        }

        $aset = Aset::findOrFail($id);
        return view('aset.detail', compact('aset'));
    }

    // --- Edit ---
    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid.');
        }

        $aset = Aset::findOrFail($id);
        return view('aset.edit', compact('aset', 'encryptedId'));
    }

    // --- Update ---
    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            return redirect()->route('aset.index')->with('error', 'ID tidak valid.');
        }

        $aset = Aset::findOrFail($id);

        $validated = $request->validate([
            'namaAset'    => 'required|string|max:64|unique:asets,nama_aset,' . $id,
            'tipeAset'    => 'required|string|in:Furnitur,Elektronik,Dekorasi,Lainnya',
            'tipeLainnya' => 'nullable|required_if:tipeAset,Lainnya|string|max:64',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:8192',
        ]);

        $aset->nama_aset = $validated['namaAset'];
        $aset->tipe_aset = ($validated['tipeAset'] === 'Lainnya')
            ? $validated['tipeLainnya']
            : $validated['tipeAset'];

        $aset->kode_aset = $this->generateUniqueKodeAset(
            $validated['namaAset'],
            $aset->tipe_aset,
            $id // exclude dirinya sendiri
        );

        if ($request->hasFile('foto')) {
            if ($aset->foto_aset && $aset->foto_aset !== 'foto_aset/placeholder.png') {
                Storage::disk('public')->delete($aset->foto_aset);
            }
            $aset->foto_aset = $request->file('foto')->store('foto_aset', 'public');
        }

        $aset->save();

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil diperbarui.');
    }

    // --- Destroy ---
    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            return redirect()->route('aset.index')->with('error', 'ID tidak valid.');
        }

        $aset = Aset::findOrFail($id);

        if ($aset->foto_aset && $aset->foto_aset !== 'foto_aset/placeholder.png') {
            Storage::disk('public')->delete($aset->foto_aset);
        }

        $aset->delete();

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil dihapus.');
    }

    // --- Generate kode aset unik ---
    private function generateUniqueKodeAset(string $namaAset, string $tipeAset, int $excludeId = null): string
    {
        $prefixTipe = strtoupper(substr($tipeAset, 0, 1));

        $words = preg_split('/\s+/', trim($namaAset));
        if (count($words) === 1) {
            $basePrefix = strtoupper(substr($words[0], 0, 2));
        } else {
            $basePrefix = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        $baseKode = $prefixTipe . '-' . $basePrefix;
        $kode = $baseKode;
        $counter = 1;

        while (
            Aset::where('kode_aset', $kode)
                ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $kode = $baseKode . '-' . str_pad($counter, 2, '0', STR_PAD_LEFT); // F-MB-01, F-MB-02
            $counter++;
        }

        return $kode;
    }
}
