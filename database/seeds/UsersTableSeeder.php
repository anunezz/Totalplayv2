<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['id' => 1, 'username' =>'hpiedras', 'cat_profile_id' => 1, 'cat_unit_id' => null, 'name' => 'Homero', 'firstName' => 'Piedras', 'secondName' => 'Rodríguez', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'username' =>'pdominguez', 'cat_profile_id' => 1, 'cat_unit_id' => null, 'name' => 'Pedro', 'firstName' => 'Domínguez', 'secondName' => 'Díaz', 'created_at' => Carbon::now(), 'updated_at'=> Carbon::now(),],
            ['id' => 3, 'username' =>'adriann', 'cat_profile_id' => 1, 'cat_unit_id' => null, 'name' => 'Adrian', 'firstName' => 'Nuñez', 'secondName' => 'Alanis', 'created_at' => Carbon::now(),'updated_at' => Carbon::now(),],
            ['id' => 4, 'username' =>'iperdomo', 'cat_profile_id' => 1, 'cat_unit_id' => null, 'name' => 'Ivan', 'firstName' => 'Perdomo', 'secondName' => 'Gomez', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 5, 'username' => 'rjuarez', 'cat_profile_id' => 1, 'cat_unit_id' => null, 'name' => 'Raúl Alberto', 'firstName' => 'Juárez', 'secondName' => 'Caballero', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 6, 'username' => 'jventura', 'cat_profile_id' => 1, 'cat_unit_id' => null, 'name' => 'Julián', 'firstName' => 'Ventura', 'secondName' => 'Valero', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            [
                'id' => 7,
                'username' =>'lmorenor',
                'cat_profile_id' => 1,
                'cat_unit_id' => null,
                'name' => 'Laura Beatriz',
                'firstName' => 'Moreno',
                'secondName' => 'Rodríguez',
                'created_at' => Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'id' => 8,
                'username' =>'gsierra',
                'cat_profile_id' => 1,
                'cat_unit_id' => null,
                'name' => 'Guillermo',
                'firstName' => 'Sierra',
                'secondName' => 'Araujo',
                'created_at' => Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'id' => 9,
                'username' =>'festradah',
                'cat_profile_id' => 1,
                'cat_unit_id' => null,
                'name' => 'Francisco Javier',
                'firstName' => 'Estrada',
                'secondName' => 'Herrera',
                'created_at' => Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'id' => 10,
                'username' =>'jalvarezg',
                'cat_profile_id' => 1,
                'cat_unit_id' => null,
                'name' => 'José Antonio',
                'firstName' => 'Álvarez',
                'secondName' => 'Gómez',
                'created_at' => Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'id' => 11,
                'username' =>'sergiomr',
                'cat_profile_id' => 1,
                'cat_unit_id' => null,
                'name' => 'Sergio',
                'firstName' => 'Martínez',
                'secondName' => 'Rivera',
                'created_at' => Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'id' => 12,
                'username' =>'gerardom',
                'cat_profile_id' => 1,
                'cat_unit_id' => null,
                'name' => 'Gerardo',
                'firstName' => 'Martínez',
                'secondName' => 'Reyes',
                'created_at' => Carbon::now(),
                'updated_at'=> Carbon::now(),
            ],
            [
                'id'                => 13,
                'username'          => 'cgaray',
                'cat_profile_id' => 1,
                'cat_unit_id' => null,
                'name'              => 'Christian',
                'firstName'         => 'Garay',
                'secondName'        => 'Barrita',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'               => 14,
                'username'         => 'alagunas',
                'cat_profile_id'   => 1,
                'cat_unit_id' => null,
                'name'             => 'Ana Gloria',
                'firstName'        => 'Lagunas',
                'secondName'       => 'González',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'id'               => 15,
                'username'         => 'ezarate',
                'cat_profile_id'   => 1,
                'cat_unit_id' => null,
                'name'             => 'Elia Berenice',
                'firstName'        => 'Zárate',
                'secondName'       => 'Riofrío',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'id'               => 16,
                'username'         => 'jcastror',
                'cat_profile_id'   => 1,
                'cat_unit_id' => null,
                'name'             => 'José Alfredo',
                'firstName'        => 'Castro',
                'secondName'       => 'Reyes',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'id'               => 17,
                'username'         => 'jcastillol',
                'cat_profile_id'   => 1,
                'cat_unit_id' => null,
                'name'             => 'José Abel',
                'firstName'        => 'Castillo',
                'secondName'       => 'López',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'id'               => 18,
                'username'         => 'mcabrera',
                'cat_profile_id'   => 1,
                'cat_unit_id' => null,
                'name'             => 'Jesús',
                'firstName'        => 'Cabrera',
                'secondName'       => 'Gutiérrez',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],
            [
                'id'               => 19,
                'username'         => 'vdejesusl',
                'cat_profile_id'   => 1,
                'cat_unit_id'      => null,
                'name'             => 'Victor Paulino',
                'firstName'        => 'de Jesús',
                'secondName'       => 'López',
                'created_at'       => Carbon::now(),
                'updated_at'       => Carbon::now(),
            ],

        ]);

    }
}
