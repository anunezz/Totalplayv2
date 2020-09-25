<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_inventories')->insert([
            [
                'id' => 1,
                'name' => 'Baja Documental',
                'revised' => 'Laura Beatriz Moreno',
                'positionRevised' => null,
                'received' => null,
                'positionReceived' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Baja Contable',
                'revised' => 'Laura Beatriz Moreno',
                'positionRevised' => null,
                'received' => null,
                'positionReceived' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Transferencia Primaria',
                'revised' => 'Laura Beatriz Moreno',
                'positionRevised' => null,
                'received' => 'Francisco Javier Estrada Herrera',
                'positionReceived' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'Transferencia Secundaria',
                'revised' => null,
                'positionRevised' => null,
                'received' => 'Rafael Anaya',
                'positionReceived' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
