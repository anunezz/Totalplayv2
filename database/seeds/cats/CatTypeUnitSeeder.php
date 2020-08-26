<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatTypeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_type_units')->insert([
            ['id' => 1, 'name' => 'Unidades Administrativas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'name' => 'Delegaciones Metropolitanas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 3, 'name' => 'Delegaciones Foráneas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 4, 'name' => 'Embajadas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 5, 'name' => 'Consulados', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 6, 'name' => 'Misiones', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 7, 'name' => 'Secciones Consulares', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 8, 'name' => 'Oficinas de Enlace', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 9, 'name' => 'Oficinas especiales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),]
        ]);
    }
}
