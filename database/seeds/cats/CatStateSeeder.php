<?php

//namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CatStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('cat_states')->insert([
            ['capital' => 'Aguascalientes' ,'name' => 'Aguascalientes','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Ensenada' ,'name' => 'Baja California','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Baja California Sur','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Campeche','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Coahuila','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Colima','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Chiapas','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Ciudad Juárez' ,'name' => 'Chihuahua','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Ciudad de México' ,'name' => 'Ciudad de México','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Gómez Palacio' ,'name' => 'Durango','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Celaya' ,'name' => 'Guanajuato','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Acapulco' ,'name' => 'Guerrero','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Hidalgo','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Guadalajara' ,'name' => 'Jalisco','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Estado de México' ,'name' => 'México','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Morelia' ,'name' => 'Michoacan','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Cuernavaca' ,'name' => 'Morelos','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Nayarit','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Monterrey' ,'name' => 'Nuevo León','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Oaxaca','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Puebla','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Queretaro','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Cancún' ,'name' => 'Quintana Roo','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'San Luis Potosi','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Culiacán' ,'name' => 'Sinaloa','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Hermosillo' ,'name' => 'Sonora','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Tabasco','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Tamaulipas','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Tlaxcala','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Córdoba' ,'name' => 'Veracruz','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => 'Mérida' ,'name' => 'Yucatan','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
            ['capital' => '' ,'name' => 'Zacatecas','isActive' => 1, 'created_at'=> Carbon::now(),'updated_at' => Carbon::now() ],
        ]);


    }
}
