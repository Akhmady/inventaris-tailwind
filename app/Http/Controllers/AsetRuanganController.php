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
    
    
    


}
