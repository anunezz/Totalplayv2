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
            ['id' => 6, 'username' => 'jventura', 'cat_profile_id' => 2, 'cat_unit_id' => 39, 'name' => 'Julián', 'firstName' => 'Ventura', 'secondName' => 'Valero', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

        ]);

    }
}
