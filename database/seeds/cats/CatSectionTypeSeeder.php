<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSectionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_section_types')->insert([
            ['id' => 1, 'name' => 'Comunes', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'name' => 'Sustantivas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
        ]);
    }
}
