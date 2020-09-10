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
                'elaborated' => 'Homero Piedras',
                'revised' => 'Pedro Dominguez',
                'authorized' => 'Raul Juárez',
                'received' => null,
                'viewed' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'name' => 'Baja Contable',
                'elaborated' => 'Christian Garay',
                'revised' => 'Adrian Nuñe',
                'authorized' => 'Manuel Rojo',
                'received' => null,
                'viewed' => 'Iván Perdomo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'name' => 'Transferencia Primaria',
                'elaborated' => 'Pablo',
                'revised' => 'Juan',
                'authorized' => 'Marcela',
                'received' => 'Marcos Pineiro',
                'viewed' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'name' => 'Transferencia Secundaria',
                'elaborated' => 'Monica',
                'revised' => 'Pedro',
                'authorized' => 'Thiago',
                'received' => 'Maria',
                'viewed' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
