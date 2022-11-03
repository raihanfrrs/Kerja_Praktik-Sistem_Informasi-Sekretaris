<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'username' => 'raihanfarras123',
                'password' => bcrypt('test123'),
                'level' => 'mahasiswa'
            ],
            [
                'username' => 'bethelsando123',
                'password' => bcrypt('test123'),
                'level' => 'dosen'
            ],
            [
                'username' => 'danu123',
                'password' => bcrypt('test123'),
                'level' => 'superadmin'
            ]
        ];

        foreach($user as $key => $value){
            User::create($value);
        }
    }
}
