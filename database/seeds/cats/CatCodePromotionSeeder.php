<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CatCodePromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_code_promotions')->insert([
            [
                'id' => 1,
                'name' => 'f1-5b63-b9e1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // [
            //     'id' => 2,
            //     'name' => 'f2-5b63-b9e1',
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'id' => 3,
            //     'name' => 'f3-5b63-b9e1',
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ],
            // [
            //     'id' => 4,
            //     'name' => 'f4-5b63-b9e1',
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now(),
            // ]
        ]);
    }
}
