<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
            [
                'id'                => 1,
                'username'          =>'hpiedras',
                'mail'              =>'hpiedras@sre.gob.mx',
                'job'               =>'TIN',
                'cat_profile_id'    => 1,
                'name'              => 'Homero',
                'firstName'         => 'Piedras',
                'secondName'        => 'Rodríguez',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 2,
                'username'          =>'pdominguez',
                'mail'              =>'pdominguez@sre.gob.mx',
                'job'               =>'TIN',
                'cat_profile_id'    => 1,
                'name'              => 'Pedro',
                'firstName'         => 'Domínguez',
                'secondName'        => 'Díaz',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 3,
                'username'          =>'adriann',
                'mail'              =>'adriann@sre.gob.mx',
                'job'               =>'TIN',
                'cat_profile_id'    => 1,
                'name'              => 'Adrian',
                'firstName'         => 'Nuñez',
                'secondName'        => 'Alanis',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 4,
                'username'          =>'iperdomo',
                'mail'              =>'iperdomo@sre.gob.mx',
                'job'               =>'TIN',
                'cat_profile_id'    => 1,
                'name'              => 'Ivan',
                'firstName'         => 'Perdomo',
                'secondName'        => 'Gomez',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
            [
                'id'                => 5,
                'username'          => 'rjuarez',
                'mail'              =>'rjuarez@sre.gob.mx',
                'job'               =>'SSRE',
                'cat_profile_id'    => 1,
                'name'              => 'Raúl Alberto',
                'firstName'         => 'Juárez',
                'secondName'        => 'Caballero',
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ],
        ]);

    }
}
