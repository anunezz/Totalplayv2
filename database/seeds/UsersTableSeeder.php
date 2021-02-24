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
            ['id' => 1, 'username' =>'adriann',  'cat_profile_id' => 1, 'name' => 'Adrian1', 'firstName' => 'Nuñez', 'secondName' => 'Alanis','email' => 'adriann@gmail.com',  'password' => bcrypt('adrian90'), 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['id' => 2, 'username' =>'adriann2', 'cat_profile_id' => 2, 'name' => 'Adrian2', 'firstName' => 'Nuñez', 'secondName' => 'Alanis','email' => 'adriann2@gmail.com', 'password' => bcrypt('adrian90'), 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['id' => 3, 'username' =>'adriann3', 'cat_profile_id' => 3, 'name' => 'Adrian3', 'firstName' => 'Nuñez', 'secondName' => 'Alanis','email' => 'adriann3@gmail.com', 'password' => bcrypt('adrian90'), 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
            ['id' => 4, 'username' =>'adriann4', 'cat_profile_id' => 4, 'name' => 'Adrian4', 'firstName' => 'Nuñez', 'secondName' => 'Alanis','email' => 'adriann4@gmail.com', 'password' => bcrypt('adrian90'), 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
        ]);

    }
}
