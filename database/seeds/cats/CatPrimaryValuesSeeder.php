<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatPrimaryValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_primary_values')->insert([
            ['id' => 1, 'name' => 'Administrativo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'name' => 'Legal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 3, 'name' => 'Fiscal', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 4, 'name' => 'Contable', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

        ]);
    }
}
