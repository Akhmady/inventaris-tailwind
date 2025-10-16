<?php
namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\AsetRuangan;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Pagination\LengthAwarePaginator;

class AsetRuanganController extends Controller
{
    public function create($encryptedId, Request $request)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID ruangan tidak valid');
        }

       
        $ruangan = Ruangan::findOrFail($id);

       

        $asets = Aset::select('id','nama_aset','tipe_aset','kode_aset', 'foto_Aset')->paginate(6);
        return view('ruangan.aset.create', compact('ruangan', 'asets', 'encryptedId'));
    }

  

   

    public function store(Request $request, $encryptedId)
    {
        try {
            $ruangan_id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID ruangan tidak valid');
        }
    
        // Validasi input
        $request->validate([
            'asets' => 'required|array|min:1',
            'asets.*.aset_id' => 'required|exists:asets,id',
            'asets.*.jumlah' => 'required|integer|min:1',
            'asets.*.kondisi' => 'required|string|in:Baik,Rusak Ringan,Rusak Berat',
        ]);
    
        // Loop setiap baris aset
        foreach ($request->asets as $asetData) {
            $aset = Aset::findOrFail($asetData['aset_id']);
            $jumlah = $asetData['jumlah'];
            $kondisi = $asetData['kondisi'];
    
            for ($i = 0; $i < $jumlah; $i++) {
                $latestId = AsetRuangan::max('id') ?? 0;
    
                AsetRuangan::create([
                    'aset_id' => $asetData['aset_id'],
                    'ruangan_id' => $ruangan_id,
                    'kondisi' => $kondisi,
                    'kode_aset' => $aset->kode_aset . '-' . ($latestId + 1),
                ]);
            }
        }
    
        return redirect()
            ->route('ruangan.show', Crypt::encrypt($ruangan_id))
            ->with('success', 'Aset berhasil ditambahkan ke ruangan.');
    }
    
    public function editGroup($encryptedRuanganId, $asetId, $kondisi)
    {
        try {
            $ruangan_id = Crypt::decrypt($encryptedRuanganId);
        } catch (\Exception $e) {
            abort(404, 'ID ruangan tidak valid');
        }
    
        $ruangan = Ruangan::findOrFail($ruangan_id);
        $asetMaster = Aset::findOrFail($asetId);
    
        $asetRuangans = AsetRuangan::where('ruangan_id', $ruangan_id)
            ->where('aset_id', $asetId)
            ->where('kondisi', $kondisi)
            ->orderBy('id', 'asc')
            ->get();
    
        return view('ruangan.aset.edit', [
            'ruangan' => $ruangan,
            'asetRuangans' => $asetRuangans,
            'asetMaster' => $asetMaster,
            'kondisi' => $kondisi,
        ]);
    }
    
    
    
    public function updateGroup(Request $request, $encryptedRuanganId, $asetId, $kondisi)
    {
        try {
            $ruangan_id = Crypt::decrypt($encryptedRuanganId);
        } catch (\Exception $e) {
            abort(404, 'ID ruangan tidak valid');
        }
    
        // Ambil semua aset ruangan yang termasuk dalam grup ini
        $asetRuangans = AsetRuangan::where('ruangan_id', $ruangan_id)
            ->where('aset_id', $asetId)
            ->where('kondisi', $kondisi)
            ->get();
    
        // Validasi input dari form
        $validated = $request->validate([
            'kondisi' => 'required|array',
            'kondisi.*' => 'required|string|in:Baik,Rusak Ringan,Rusak Berat',
        ]);
    
        // Loop setiap unit yang dikirim dari form
        foreach ($validated['kondisi'] as $id => $newCondition) {
            $unit = $asetRuangans->where('id', $id)->first();
            if ($unit && $unit->kondisi !== $newCondition) {
                $unit->kondisi = $newCondition;
                $unit->save();
            }
        }
    
        return redirect()
            ->route('ruangan.show', Crypt::encrypt($ruangan_id))
            ->with('success', 'Kondisi aset berhasil diperbarui.');
    }
    

    public function destroy($encryptedRuanganId, $id)
    {
        try {
            $ruangan_id = Crypt::decrypt($encryptedRuanganId);
        } catch (\Exception $e) {
            abort(404, 'ID ruangan tidak valid');
        }
    
        $asetRuangan = AsetRuangan::where('ruangan_id', $ruangan_id)
            ->where('id', $id)
            ->first();
    
        if (!$asetRuangan) {
            abort(404, 'Aset tidak ditemukan');
        }
    
        // Simpan data sebelum dihapus
        $asetId = $asetRuangan->aset_id;
        $kondisi = $asetRuangan->kondisi;
    
        $asetRuangan->delete();
    
        // Arahkan kembali ke halaman edit grup yang sama
        return redirect()
            ->route('ruangan.aset.edit', [
                'ruangan' => $encryptedRuanganId,
                'aset' => $asetId,
                'kondisi' => $kondisi,
            ])
            ->with('success', 'Aset berhasil dihapus.');
    }
    
    
    

}
