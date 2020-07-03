<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CatProfileSeeder::class,
            CatTransactionTypeSeeder::class,

            UsersTableSeeder::class,


            CatConsulateSeeder::class,
        ]);
    }
}
