<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_sections')->insert([
            ['id' => 1, 'name' => 'Legislación', 'code' => '01C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'name' => 'Asuntos jurídicos', 'code' => '02C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 3, 'name' => 'Programación, organización y presupuestación', 'code' => '03C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 4, 'name' => 'Recursos humanos', 'code' => '04C', 'cat_type_id' => 1,  'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 5, 'name' => 'Recursos financieros', 'code' => '05C', 'cat_type_id' => 1,  'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 6, 'name' => 'Recursos materiales y obra pública', 'code' => '06C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 7, 'name' => 'Servicios generales', 'code' => '07C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 8, 'name' => 'Tecnologías y servicios de la información', 'code' => '08C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 9, 'name' => 'Comunicación social', 'code' => '09C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 10, 'name' => 'Control y auditoría de actividades públicas', 'code' => '10C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 11, 'name' => 'Planeación, información, evaluación y políticas', 'code' => '11C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 12, 'name' => 'Transparencia y acceso a la información', 'code' => '12C', 'cat_type_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 13, 'name' => 'Conducción de la política exterior de México', 'code' => 'O1S', 'cat_type_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 14, 'name' => 'Actuación internacional del Gobierno de la República', 'code' => '02S', 'cat_type_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 15, 'name' => 'Protección y asistencia a connacionales y extranjeros', 'code' => '03S', 'cat_type_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
        ]);
    }
}
