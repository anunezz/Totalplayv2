<?php

//namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CatPromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_promotions')->insert([
            //Home
            // Double play regional
            ["type" => 1,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/residencial/40mb.png", "name" => "40 megas", "color" => "#d2a545", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/residencial/80mb_mas.png", "name" => "80 megas más", "color" => "#d2a545", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/residencial/150mb.png", "name" => "150 megas", "color" => "#789ab0", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/residencial/250mb_mas.png", "name" => "250 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/residencial/500mb_mas.png", "name" => "500 megas más", "color" => "#6d5c96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            //Triple play regional
            ["type" => 1,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/residencial/40mb.png", "name" => "40 megas", "color" => "#d2a545", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/residencial/80mb_mas.png", "name" => "80 megas más", "color" => "#d2a545", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/residencial/150mb.png", "name" => "150 megas", "color" => "#789ab0", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/residencial/250mb_mas.png", "name" => "250 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/residencial/500mb_mas.png", "name" => "500 megas más", "color" => "#6d5c96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            //Double play fronterizo
            ["type" => 1,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/fronterizo/40mb.png", "name" => "40 megas", "color" => "#d2a545", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/fronterizo/80mb_mas.png", "name" => "80 megas más", "color" => "#d2a545", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/fronterizo/150mb.png", "name" => "150 megas", "color" => "#789ab0", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/fronterizo/250mb_mas.png", "name" => "250 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/home/Doble_Play/fronterizo/500mb_mas.png", "name" => "500 megas más", "color" => "#6d5c96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            //Triple play fronterizo
            ["type" => 1,"frontier" => true, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/fronterizo/40mb.png", "name" => "40 megas", "color" => "#d2a545", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => true, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/fronterizo/80mb_mas.png", "name" => "80 megas más", "color" => "#d2a545", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => true, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/fronterizo/150mb.png", "name" => "150 megas", "color" => "#789ab0", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => true, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/fronterizo/250mb_mas.png", "name" => "250 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            ["type" => 1,"frontier" => true, "triple_double" => true ,"url"=>"img/publico/promociones/home/Triple_Play/fronterizo/500mb_mas.png", "name" => "500 megas más", "color" => "#6d5c96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],


            //Amazon
            // Double play regional
            // ["type" => 2,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/residencial/40mb.png", "name" => "40 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/residencial/80mb.png", "name" => "80 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/residencial/150mb.png", "name" => "150 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/residencial/250mb.png", "name" => "250 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/residencial/500mb.png", "name" => "500 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            // Double play fronterizo
            // ["type" => 2,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/fronterizo/40mb.png", "name" => "40 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/fronterizo/80mb.png", "name" => "80 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/fronterizo/150mb.png", "name" => "150 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/fronterizo/250mb.png", "name" => "250 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/amazon/Doble_Play/fronterizo/500mb.png", "name" => "500 megas", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            // Triple play regional
            // ["type" => 2,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/amazon/Triple_Play/residencial/40mb_mas.png", "name" => "40 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/amazon/Triple_Play/residencial/80mb_mas.png", "name" => "80 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/amazon/Triple_Play/residencial/150mb_mas.png", "name" => "150 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/amazon/Triple_Play/residencial/250mb_mas.png", "name" => "250 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/amazon/Triple_Play/residencial/500mb_mas.png", "name" => "500 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            // Triple play fronterizo
            // ["type" => 2,"frontier" => true, "triple_double" => true,"url"=>"img/publico/promociones/amazon/Triple_Play/fronterizo/40mb_mas.png", "name" => "40 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => true, "triple_double" => true,"url"=>"img/publico/promociones/amazon/Triple_Play/fronterizo/80mb_mas.png", "name" => "80 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => true, "triple_double" => true,"url"=>"img/publico/promociones/amazon/Triple_Play/fronterizo/150mb_mas.png", "name" => "150 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => true, "triple_double" => true ,"url"=>"img/publico/promociones/amazon/Triple_Play/fronterizo/250mb_mas.png", "name" => "250 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 2,"frontier" => true, "triple_double" => true ,"url"=>"img/publico/promociones/amazon/Triple_Play/fronterizo/500mb_mas.png", "name" => "500 megas más", "color" => "#427b96", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            //Netflix
            // Double play regional
            // ["type" => 3,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/residencial/40mb.png", "name" => "40 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/residencial/80mb.png", "name" => "80 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/residencial/150mb.png", "name" => "150 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/residencial/250mb.png", "name" => "250 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => false, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/residencial/500mb.png", "name" => "500 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            // Double play fronterizo
            // ["type" => 3,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/fronterizo/40mb.png", "name" => "40 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/fronterizo/80mb.png", "name" => "80 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/fronterizo/150mb.png", "name" => "150 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/fronterizo/250mb.png", "name" => "250 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => true, "triple_double" => false ,"url"=>"img/publico/promociones/netflix/Doble_Play/fronterizo/500mb.png", "name" => "500 megas", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            // Triple play regional
            // ["type" => 3,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/netflix/Triple_Play/residencial/40mb_mas.png", "name" => "40 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/netflix/Triple_Play/residencial/80mb_mas.png", "name" => "80 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/netflix/Triple_Play/residencial/150mb_mas.png", "name" => "150 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/netflix/Triple_Play/residencial/250mb_mas.png", "name" => "250 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => false, "triple_double" => true ,"url"=>"img/publico/promociones/netflix/Triple_Play/residencial/500mb_mas.png", "name" => "500 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],

            // Triple play fronterizo
            // ["type" => 3,"frontier" => true, "triple_double" => true,"url"=>"img/publico/promociones/netflix/Triple_Play/fronterizo/40mb_mas.png", "name" => "40 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => true, "triple_double" => true,"url"=>"img/publico/promociones/netflix/Triple_Play/fronterizo/80mb_mas.png", "name" => "80 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => true, "triple_double" => true,"url"=>"img/publico/promociones/netflix/Triple_Play/fronterizo/150mb_mas.png", "name" => "150 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => true, "triple_double" => true ,"url"=>"img/publico/promociones/netflix/Triple_Play/fronterizo/250mb_mas.png", "name" => "250 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
            // ["type" => 3,"frontier" => true, "triple_double" => true ,"url"=>"img/publico/promociones/netflix/Triple_Play/fronterizo/500mb_mas.png", "name" => "500 megas más", "color" => "#b44742", "description" => "", "isActive" => 1, "created_at" => Carbon::now(), "updated_at" => Carbon::now()],
        ]);
    }
}
