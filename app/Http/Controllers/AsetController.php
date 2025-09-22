<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class AsetController extends Controller
{
    // --- Index ---
    public function index()
    {
        $asets = Aset::orderBy('created_at', 'desc')->paginate(5);
        return view('aset.aset', compact('asets'));
    }

    // --- Create ---
    public function create()
    {
        return view('aset.create');
    }

    // --- Store ---
    public function store(Request $request)
    {
        // Debug kalau masih error
        // dd($request->all());

        // Validasi input
        $validated = $request->validate([
            'namaAset' => 'required|string|max:64',
            'tipeAset' => 'required|string|in:Furnitur,Elektronik,Dekorasi,Lainnya',
            'tipeLainnya' => 'nullable|string|max:32',
            'fotoAset' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:8192',
        ]);

        // Tentukan tipe aset
        $tipe = $validated['tipeAset'] === 'Lainnya' && !empty($validated['tipeLainnya'])
        ? $validated['tipeLainnya']
        : $validated['tipeAset'];

        // Generate kode aset
        $kodeAset = $this->generateKodeAset($validated['namaAset'], $tipe);

        // Upload foto
        if ($request->hasFile('fotoAset')) {
            $fotoPath = $request->file('fotoAset')->store('foto_aset', 'public');
        } else {
            $fotoPath = 'foto_aset/placeholder.png';
        }
    

        // Simpan data
        Aset::create([
            'nama_aset' => $validated['namaAset'],
            'tipe_aset' => $tipe,
            'kode_aset' => $kodeAset,
            'foto_aset' => $fotoPath,
        ]);

        return redirect()->route('aset.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    // --- Generate kode aset ---
    private function generateKodeAset($tipe, $nama)
    {
        $prefixTipe = strtoupper(substr($tipe, 0, 1));
        $words = explode(' ', $nama);

        if (count($words) >= 2) {
            $prefixNama = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            $prefixNama = strtoupper(substr($nama, 0, 2));
        }

        $kode = $prefixTipe . '-' . $prefixNama;

        // Jika sudah ada → gunakan variasi huruf terakhir
        if (Aset::where('kode_aset', $kode)->exists()) {
            $prefixNama = strtoupper(substr($words[0], 0, 1) . substr(end($words), -1));
            $kode = $prefixTipe . '-' . $prefixNama;
        }

        return $kode;
    }
    public function show($id)
{
    try {
        $asetId = Crypt::decrypt($id);
    } catch (\Exception $e) {
        abort(404, 'ID tidak valid');
    }

    $aset = Aset::findOrFail($asetId);

    return view('aset.detail', compact('aset'));
}

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

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            return redirect()->route('aset.index')->with('error', 'ID tidak valid.');
        }

        $aset = Aset::findOrFail($id);

        // validasi
        $validated = $request->validate([
            'namaAset'   => 'required|string|max:64',
            'tipeAset'  => 'required|string|in:Furnitur,Elektronik,Dekorasi,Lainnya',
            'tipeLainnya'=> 'nullable|required_if:jenisAset,Lainnya|string|max:64',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:8192',
        ]);

        // update nama + jenis
        $aset->nama_aset  = $validated['namaAset'];
        $aset->tipe_aset = ($validated['tipeAset'] === 'Lainnya')
            ? $validated['tipeLainnya']
            : $validated['tipeAset'];

        // foto baru?
        if ($request->hasFile('foto')) {
            // hapus lama jika bukan placeholder
            if ($aset->foto_aset && $aset->foto_aset !== 'foto_aset/placeholder.png') {
                Storage::disk('public')->delete($aset->foto_aset);
            }

            // simpan baru
            $path = $request->file('foto')->store('foto_aset', 'public');
            $aset->foto_aset = $path;
        }

        $aset->save();

        return redirect()->route('aset.index', Crypt::encrypt($aset->id))
            ->with('success', 'Data aset berhasil diperbarui.');
    }

    public function destroy($encryptedId)
{
    try {
        $id = Crypt::decrypt($encryptedId);
    } catch (\Exception $e) {
        return redirect()->route('aset.index')->with('error', 'ID tidak valid.');
    }

    $aset = Aset::findOrFail($id);

    // hapus foto jika ada dan bukan placeholder
    if ($aset->foto_aset && $aset->foto_aset !== 'foto_aset/placeholder.png') {
        Storage::disk('public')->delete($aset->foto_aset);
    }

    $aset->delete();

    return redirect()->route('aset.index')->with('success', 'Data aset berhasil dihapus.');
}
}
