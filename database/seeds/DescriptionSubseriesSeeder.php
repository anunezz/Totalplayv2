<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DescriptionSubseriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('description_subseries')->insert([

            ['cat_description_id' => 20, 'cat_subserie_id' => 1],
            ['cat_description_id' => 20, 'cat_subserie_id' => 2],
            ['cat_description_id' => 20, 'cat_subserie_id' => 3],

            ['cat_description_id' => 34, 'cat_subserie_id' => 4],
            ['cat_description_id' => 35, 'cat_subserie_id' => 5],
            ['cat_description_id' => 36, 'cat_subserie_id' => 6],
            ['cat_description_id' => 37, 'cat_subserie_id' => 7],

            ['cat_description_id' => 41, 'cat_subserie_id' => 8],

            ['cat_description_id' => 49, 'cat_subserie_id' => 9],
            ['cat_description_id' => 49, 'cat_subserie_id' => 10],
            ['cat_description_id' => 49, 'cat_subserie_id' => 11],
            ['cat_description_id' => 59, 'cat_subserie_id' => 12],

            ['cat_description_id' => 89, 'cat_subserie_id' => 13],
            ['cat_description_id' => 89, 'cat_subserie_id' => 14],
            ['cat_description_id' => 89, 'cat_subserie_id' => 15],

            ['cat_description_id' => 119, 'cat_subserie_id' => 16],
            ['cat_description_id' => 119, 'cat_subserie_id' => 17],
            ['cat_description_id' => 119, 'cat_subserie_id' => 18],
            ['cat_description_id' => 119, 'cat_subserie_id' => 19],
            ['cat_description_id' => 119, 'cat_subserie_id' => 20],
            ['cat_description_id' => 120, 'cat_subserie_id' => 21],
            ['cat_description_id' => 121, 'cat_subserie_id' => 22],

            ['cat_description_id' => 125, 'cat_subserie_id' => 23],
            ['cat_description_id' => 126, 'cat_subserie_id' => 24],
            ['cat_description_id' => 127, 'cat_subserie_id' => 25],
            ['cat_description_id' => 128, 'cat_subserie_id' => 25],
            ['cat_description_id' => 129, 'cat_subserie_id' => 25],
            ['cat_description_id' => 130, 'cat_subserie_id' => 25],

            ['cat_description_id' => 140, 'cat_subserie_id' => 26],
            ['cat_description_id' => 141, 'cat_subserie_id' => 26],
            ['cat_description_id' => 142, 'cat_subserie_id' => 27],
            ['cat_description_id' => 143, 'cat_subserie_id' => 28],
            ['cat_description_id' => 144, 'cat_subserie_id' => 28],
            ['cat_description_id' => 145, 'cat_subserie_id' => 28],




        ]);
    }
}
