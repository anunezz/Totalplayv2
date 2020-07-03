<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CatConsulateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_consulates')->insert([
            ['id' => 1, 'name' => 'Nuevo México', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'name' => 'Texas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 3, 'name' => 'México en el Paso', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 4, 'name' => 'México en Houston', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 5, 'name' => 'México en Atlanta', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

        ]);}
    }

