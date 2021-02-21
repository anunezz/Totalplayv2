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
            ['id' => 1, 'username' =>'adriann', 'cat_profile_id' => 1, 'name' => 'Adrian', 'firstName' => 'Nuñez', 'secondName' => 'Alanis','email' => 'adriann@gmail.com', 'password' => bcrypt('adrian90'), 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
        ]);

    }
}
