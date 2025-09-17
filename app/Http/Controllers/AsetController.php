<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AsetController extends Controller
{
    public function index()
    {
        // Data dummy aset
        $dummyData = [
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

        // Tambahkan kode aset
        $data = collect($dummyData)->map(function ($item) {
            $kode = $this->generateKode($item['tipe'], $item['nama']);
            return [
                'nama' => $item['nama'],
                'tipe' => $item['tipe'],
                'kode' => $kode,
            ];
        });

        // Pagination manual (5 per halaman)
        $perPage = 5;
        $currentPage = request()->input('page', 1);
        $pagedData = new LengthAwarePaginator(
            $data->forPage($currentPage, $perPage),
            $data->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        return view('aset.aset', [
            'aset' => $pagedData
        ]);
    }

    private function generateKode($tipe, $nama)
    {
        // A = huruf pertama dari tipe aset
        $kodeTipe = strtoupper(substr($tipe, 0, 1));

        // B = 2 huruf pertama nama aset
        $words = explode(' ', $nama);

        if (count($words) == 1) {
            $kodeNama = strtoupper(substr($words[0], 0, 2));
        } else {
            $kodeNama = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }

        return $kodeTipe . '-' . $kodeNama;
    }


    public function create()
    {
        return view ('aset.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'namaAset' => 'required|string|max:255|unique:asets,namaAset',
            'tipeAset' => 'required|string|in:Furnitur,Elektronik,Dekorasi,Lainnya',
            'foto' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        // $aset = new Aset();
        // $aset->namaAset = $request->input('namaAset');
        // $aset->tipeAset = $request->input('tipeAset');
        // $aset->foto = $request->input('foto');

        // $aset->save();

        return redirect()->route('aset.index')->with('success', 'Aset berhasil ditambahkan.');
    }
}
