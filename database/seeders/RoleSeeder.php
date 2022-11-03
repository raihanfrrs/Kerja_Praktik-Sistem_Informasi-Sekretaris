<?php

namespace Database\Seeders;

use App\Models\role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            [
                'role' => 'Sekretaris Jurusan'
            ],
            [
                'role' => 'CSR'
            ],
            [
                'role' => 'Koordinator Skripsi'
            ],
            [
                'role' => 'KATU'
            ]
        ];

        foreach($role as $key => $value){
            role::create($value);
        }
    }
}
