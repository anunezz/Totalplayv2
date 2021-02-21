<?php

//namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CatProfileSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_profiles')->insert([
            ['name' => 'Administrador', "created_at" => Carbon::now(), "updated_at" => Carbon::now()  ],
            ['name' => 'Capturista', "created_at" => Carbon::now(), "updated_at" => Carbon::now()  ]
        ]);
    }
}
