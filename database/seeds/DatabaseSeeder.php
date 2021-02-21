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
            UsersTableSeeder::class,
            FirstSesionSeeder::class,
            CatStateSeeder::class,
            CatCitySeeder::class,
            CatPromotionSeeder::class,
        ]);
    }
}
