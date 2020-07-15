<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatDocumentaryValiditieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_documentary_validities')->insert([
            ['id' => 1, 'name' => 'Archivo de trámite', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'name' => 'Archivo de concentación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 3, 'name' => 'Solicitud de acceso a la información', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

        ]);
    }
}
