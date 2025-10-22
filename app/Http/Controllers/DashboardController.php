<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ruangan;
use App\Models\Aset;
use App\Models\User;
use App\Models\AsetRuangan;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {

        $totalRuangan = Ruangan::count();
        $totalAset = Aset::count();
        $totalAdmin = User::count();
     

        $kondisiData = AsetRuangan::Select('kondisi', DB::raw('COUNT(*) as total'))
        ->groupBy('kondisi')
        ->pluck('total', 'kondisi')
        ->toArray();

        $kondisiData = array_merge ([
            'Baik' => 0,
            'Rusak Ringan' => 0,
            'Rusak Berat' => 0
        ], $kondisiData);


        $tipeData = Aset::select('tipe_aset', DB::raw('COUNT(*) as total'))
        ->groupBy('tipe_aset')
        ->pluck('total', 'tipe_aset')
        ->toArray();

        $tipeData = array_merge([
            'Furnitur' => 0,
            'Elektronik' => 0,
            'Dekorasi' => 0,
            'Lainnya' => 0
        ], $tipeData);

        $recentLogs = ActivityLog::latest()->take(5)->get();

        
        return view('dashboard.dashboard', compact(
            'totalRuangan',
            'totalAset',
            'totalAdmin',
            'kondisiData',
            'tipeData',
            'recentLogs'
        ));
    }

  
  
    
}



