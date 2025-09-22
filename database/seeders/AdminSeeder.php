<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
   
    public function run(): void
    {
        User::create ([
            'name' => 'Ikan Teri Abu-abu',
            'email' => 'admin1@admin.gov',
            'password' => bcrypt('admin1')
        ]);
    }
}
