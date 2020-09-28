<?php

use Illuminate\Database\Seeder;

class SamplingSubseriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sampling_subseries')->insert([

            ['cat_sampling_id' => 22, 'cat_subserie_id' => 9],
            ['cat_sampling_id' => 22, 'cat_subserie_id' => 10],
            ['cat_sampling_id' => 22, 'cat_subserie_id' => 11],

            ['cat_sampling_id' => 26, 'cat_subserie_id' => 12],

            ['cat_sampling_id' => 59, 'cat_subserie_id' => 16],
            ['cat_sampling_id' => 59, 'cat_subserie_id' => 17],
            ['cat_sampling_id' => 59, 'cat_subserie_id' => 18],
            ['cat_sampling_id' => 59, 'cat_subserie_id' => 19],
            ['cat_sampling_id' => 59, 'cat_subserie_id' => 20],

            ['cat_sampling_id' => 61, 'cat_subserie_id' => 23],

            ['cat_sampling_id' => 62, 'cat_subserie_id' => 24],

            ['cat_sampling_id' => 63, 'cat_subserie_id' => 25],

            ['cat_sampling_id' => 70, 'cat_subserie_id' => 26],

            ['cat_sampling_id' => 75, 'cat_subserie_id' => 21],

            ['cat_sampling_id' => 76, 'cat_subserie_id' => 22],

            ['cat_sampling_id' => 77, 'cat_subserie_id' => 27],

            ['cat_sampling_id' => 78, 'cat_subserie_id' => 28],

        ]);
    }
}
