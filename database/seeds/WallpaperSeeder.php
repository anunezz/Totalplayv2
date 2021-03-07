<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WallpaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wallpapers')->insert([
            ['isColor' => 1, 'isActive' => 1 ,"color" => "#25B69A", 'created_at' => Carbon::now(),'updated_at' => Carbon::now()]
        ]);
    }
}
