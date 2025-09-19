<?php
namespace App\Http\Controllers;

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

        // Dummy ruangan (supaya view punya $ruangan)
        $ruangan = [
            'id' => $id,
            'namaRuangan' => 'Ruang Rapat',
            'penanggungJawab' => 'Fulan'
        ];

        // Ambil dummy aset master (mirip AsetController@index)
        $dummyAset = [
            ['nama' => 'Meja Bundar', 'tipe' => 'Furnitur'],
            ['nama' => 'Kursi Kayu', 'tipe' => 'Furnitur'],
            ['nama' => 'Lampu Gantung', 'tipe' => 'Elektronik'],
            ['nama' => 'Lukisan Dinding', 'tipe' => 'Dekorasi'],
            ['nama' => 'Rak Besi', 'tipe' => 'Furnitur'],
            ['nama' => 'Speaker Bluetooth', 'tipe' => 'Elektronik'],
            ['nama' => 'Jam Dinding', 'tipe' => 'Dekorasi'],
            ['nama' => 'Vas Bunga', 'tipe' => 'Dekorasi'],
            ['nama' => 'Proyektor', 'tipe' => 'Elektronik'],
            ['nama' => 'Papan Tulis', 'tipe' => 'Furnitur'],
        ];

        // Tambah 'kode' ke tiap item
        $data = collect($dummyAset)->map(function ($item) {
            return [
                'nama' => $item['nama'],
                'tipe' => $item['tipe'],
                'kode' => $this->generateKode($item['tipe'], $item['nama']),
            ];
        })->values();

        // Pagination manual (6 per halaman)
        $perPage = 6;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $data->slice(($page - 1) * $perPage, $perPage)->values();

        $asets = new LengthAwarePaginator(
            $currentItems,
            $data->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('ruangan.aset.create', compact('ruangan', 'asets', 'encryptedId'));
    }

    private function generateKode($tipe, $nama)
    {
        $kodeTipe = strtoupper(substr($tipe, 0, 1));

        $words = explode(' ', trim($nama));
        if (count($words) == 1) {
            $kodeNama = strtoupper(substr($words[0], 0, 2));
        } else {
            $kodeNama = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return $kodeTipe . '-' . $kodeNama;
    }

    public function edit($encRuangan, $encGroup)
    {
        try {
            $ruanganId = Crypt::decrypt($encRuangan);
            $groupIndex = Crypt::decrypt($encGroup);
        } catch (\Exception $e) {
            abort(404, 'ID tidak valid');
        }

        // --- Dummy ruangan (nanti ganti Ruangan::findOrFail($ruanganId)) ---
        $ruangan = [
            'id' => $ruanganId,
            'namaRuangan' => 'Ruang Rapat',
            'penanggungJawab' => 'Fulan',
        ];

        // --- Dummy aset per-unit (seperti sebelumnya di RuanganController@show) ---
        $asetRuangan = [
            ['id'=>1, 'namaAset'=>'Meja Bundar', 'tipeAset'=>'Furnitur', 'kodeAset'=>'F-MB-0001', 'kondisi'=>'Baik'],
            ['id'=>2, 'namaAset'=>'Meja Bundar', 'tipeAset'=>'Furnitur', 'kodeAset'=>'F-MB-0002', 'kondisi'=>'Baik'],
            ['id'=>3, 'namaAset'=>'Meja Bundar', 'tipeAset'=>'Furnitur', 'kodeAset'=>'F-MB-0003', 'kondisi'=>'Rusak Ringan'],
            ['id'=>4, 'namaAset'=>'Proyektor Epson', 'tipeAset'=>'Elektronik', 'kodeAset'=>'E-PE-0004', 'kondisi'=>'Baik'],
        ];

        // Grouping sama seperti yang dipakai di detail
        $grouped = collect($asetRuangan)
            ->groupBy(function ($item) {
                return $item['namaAset'] . '|' . $item['tipeAset'] . '|' . $item['kondisi'];
            })
            ->map(function ($group) {
                return [
                    'namaAset' => $group[0]['namaAset'],
                    'tipeAset' => $group[0]['tipeAset'],
                    'kondisi' => $group[0]['kondisi'],
                    'jumlah' => $group->count(),
                    'kodeList' => $group->pluck('kodeAset')->all(),
                    // kalau perlu simpan id list: 'idList' => $group->pluck('id')->all(),
                ];
            })
            ->values(); // koleksi berindeks 0,1,2,...

        // Pastikan groupIndex valid
        if (!isset($grouped[$groupIndex])) {
            abort(404, 'Grup aset tidak ditemukan');
        }

        $selectedGroup = $grouped[$groupIndex];

        // Expand kodeList jadi unit per kode (satu baris per kode)
        $units = collect($selectedGroup['kodeList'])->map(function ($kode) use ($selectedGroup) {
            return [
                'kode' => $kode,
                'nama' => $selectedGroup['namaAset'],
                'tipe' => $selectedGroup['tipeAset'],
                'kondisi' => $selectedGroup['kondisi'],
            ];
        })->values();

        // Kirim ke view edit (units = array unit per kode)
        return view('ruangan.aset.edit', [
            'ruangan' => $ruangan,
            'units' => $units,
            'groupIndex' => $groupIndex,
            'encRuangan' => $encRuangan,
            'encGroup' => $encGroup,
        ]);
    }

    // update() dan destroy() nanti implementasinya
}
