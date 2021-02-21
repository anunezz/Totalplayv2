<?php
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FirstSesionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('first_sesions')->insert([
            [ 'user_id' => 1, 'created_at' => Carbon::now(),'updated_at' => Carbon::now()],
        ]);
    }
}
