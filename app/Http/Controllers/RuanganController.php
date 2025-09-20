<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Crypt;
// use App\Models\Ruangan;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        // Dummy data
        $dummyData = [['id' => 1, 'namaRuangan' => 'Ruang Rapat', 'penanggungJawab' => 'Fulan'], ['id' => 2, 'namaRuangan' => 'Ruang Server', 'penanggungJawab' => 'Ani'], ['id' => 3, 'namaRuangan' => 'Ruang Direktur', 'penanggungJawab' => 'Andi'], ['id' => 4, 'namaRuangan' => 'Ruang HRD', 'penanggungJawab' => 'Siti'], ['id' => 5, 'namaRuangan' => 'Ruang Marketing', 'penanggungJawab' => 'Joko'], ['id' => 6, 'namaRuangan' => 'Ruang Keuangan', 'penanggungJawab' => 'Rina'], ['id' => 7, 'namaRuangan' => 'Ruang Arsip', 'penanggungJawab' => 'Tono'], ['id' => 8, 'namaRuangan' => 'Ruang Meeting', 'penanggungJawab' => 'Ayu'], ['id' => 9, 'namaRuangan' => 'Ruang Lobi', 'penanggungJawab' => 'Budi']];

        if ($request->has('q')) {
            $query = strtolower($request->q);
            $dummyData = array_filter($dummyData, function ($item) use ($query) {
                return str_contains(strtolower($item['namaRuangan']), $query) ||
                       str_contains(strtolower($item['penanggungJawab']), $query);
            });
        }
        // Pagination manual
        $collection = collect($dummyData);
        $perPage = 5;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $collection->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $ruangan = new LengthAwarePaginator($currentItems, $collection->count(), $perPage, $currentPage, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);

        $ruangan->withPath(route('ruangan.index'));

        // DB versi (aktifkan nanti)
        // $ruangan = \App\Models\Ruangan::paginate(10);

        session(['ruangan' => $dummyData]);
        
        return view('ruangan.ruangan', compact('ruangan'));

       
    }

    public function create()
    {
        return view('ruangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaRuangan' => 'required|string|max:255|unique:ruangans,namaRuangan',
            'penanggungJawab' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        // DB versi (aktifkan nanti)
        // \App\Models\Ruangan::create($request->all());

        return redirect()->route('ruangan.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function show($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid');
        }

        // Dummy data Ruangan
        $ruanganList = [['id' => 1, 'namaRuangan' => 'Ruang Rapat', 'penanggungJawab' => 'Fulan', 'deskripsi' => 'Ruangan khusus rapat internal dan eksternal.'], ['id' => 2, 'namaRuangan' => 'Ruang Server', 'penanggungJawab' => 'Ani', 'deskripsi' => 'Ruangan penyimpanan server dan perangkat jaringan.']];

        $ruangan = collect($ruanganList)->firstWhere('id', $id);

        if (!$ruangan) {
            abort(404, 'Ruangan tidak ditemukan');
        }

        // Dummy data aset

        $asetRuangan = [['id' => 1, 'namaAset' => 'Meja Bundar', 'tipeAset' => 'Furnitur', 'kodeAset' => 'F-MB-0001', 'kondisi' => 'Baik'], ['id' => 2, 'namaAset' => 'Meja Bundar', 'tipeAset' => 'Furnitur', 'kodeAset' => 'F-MB-0002', 'kondisi' => 'Rusak Ringan'], ['id' => 3, 'namaAset' => 'Meja Bundar', 'tipeAset' => 'Furnitur', 'kodeAset' => 'F-MB-0003', 'kondisi' => 'Baik'], ['id' => 4, 'namaAset' => 'Proyektor Epson', 'tipeAset' => 'Elektronik', 'kodeAset' => 'E-PE-0004', 'kondisi' => 'Baik']];

        // Grouping by namaAset + tipeAset + kondisi
        $groupedAset = collect($asetRuangan)
            ->groupBy(function ($item) {
                return $item['namaAset'] . '|' . $item['tipeAset'] . '|' . $item['kondisi'];
            })
            ->map(function ($group) {
                return [
                    'namaAset' => $group[0]['namaAset'],
                    'tipeAset' => $group[0]['tipeAset'],
                    'kondisi' => $group[0]['kondisi'],
                    'jumlah' => $group->count(),
                    'kodeList' => $group->pluck('kodeAset')->all(), // untuk aksi edit/hapus
                ];
            })
            ->values();
        // DB versi (aktifkan nanti)
        // $ruangan = \App\Models\Ruangan::with('aset')->findOrFail($id);

        return view('ruangan.detail', compact('ruangan', 'groupedAset'));
    }

    public function edit($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid');
        }

        // Dummy data (sementara)
        $ruangan = ['id' => $id, 'namaRuangan' => 'Dummy Ruangan', 'penanggungJawab' => 'Dummy'];

        // DB versi (aktifkan nanti)
        // $ruangan = \App\Models\Ruangan::findOrFail($id);

        return view('ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid');
        }

        $request->validate([
            'namaRuangan' => 'required|string|max:255',
            'penanggungJawab' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        // DB versi (aktifkan nanti)
        // $ruangan = \App\Models\Ruangan::findOrFail($id);
        // $ruangan->update($request->all());

        return redirect()->route('ruangan.show')->with('success', 'Detail Ruangan berhasil diperbarui');
    }

    public function deleteConfirm($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid');
        }

        // Dummy data (sementara)
        $ruangan = [
            'id' => $id,
            'namaRuangan' => 'Dummy Ruangan',
            'penanggungJawab' => 'Dummy',
            'deskripsi' => 'Ruangan dummy untuk testing delete.'
        ];

        // DB versi (aktifkan nanti)
        // $ruangan = \App\Models\Ruangan::findOrFail($id);

        return view('ruangan.delete', compact('ruangan'));
    }

    /**
     * Hapus ruangan (beserta asetnya)
     */
    public function destroy($encryptedId)
    {
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid');
        }

        // Dummy mode (sementara tidak ada operasi DB)
        // Misalnya hanya redirect sukses
        // DB versi (aktifkan nanti)
        // $ruangan = \App\Models\Ruangan::with('aset')->findOrFail($id);
        // $ruangan->aset()->delete(); // hapus semua aset di ruangan ini
        // $ruangan->delete();         // hapus ruangannya

        return redirect()
            ->route('ruangan.index')
            ->with('success', 'Ruangan (beserta asetnya) berhasil dihapus.');
    }

    public function search(Request $request)
{
    $keyword = $request->get('q'); // nama parameter bebas, pakai 'q'
    
    $ruangan = collect(session('ruangan', [])) // sementara masih data dummy
        ->filter(function ($r) use ($keyword) {
            return stripos($r['namaRuangan'], $keyword) !== false;
        })
        ->values();

    return response()->json($ruangan);
}
}


