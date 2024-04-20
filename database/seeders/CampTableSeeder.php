<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Camps;

class CampTableSeeder extends Seeder
{
    public function run(): void
    {
        $camps = 
        [
            [
            'title' => 'Gila Belajar',
            'slug' => 'gila belajar',
            'price' => 280,
            'created_at' => date('Y-m-d H:i:s', time()),
            'updated_at' => date('Y-m-d H:i:s', time()),
            ],
            [
                'title' => 'Baru Mulai',
                'slug' => 'baru mulai',
                'price' => 140,
                'created_at' => date('Y-m-d H:i:s', time()),
                'updated_at' => date('Y-m-d H:i:s', time()),
            ]
        ];

        // cara pertama
        // foreach($camps as $key => $camp){
        //     Camps::create($camp);
        // }
        // cara kedua
        Camps::insert($camps);
    }
}
