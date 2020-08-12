<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSubseriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_subseries')->insert([
            ['id' => 1, 'cat_series_id' => 18, 'name' => 'Personal del Servicio Exterior Mexicano', 'code' => '04C.03.01', 'codeSubseries' => '01', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'cat_series_id' => 18, 'name' => 'Personal de prestación de servicios profesionales por honorarios', 'code' => '04C.03.02', 'codeSubseries' => '02', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 3, 'cat_series_id' => 18, 'name' => 'Personal de la Cancillería', 'code' => '04C.03.03', 'codeSubseries' => '03', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 4, 'cat_series_id' => 31, 'name' => 'Radicaciones a las Representaciones de México en el Exterior', 'code' => '05C.03.01', 'codeSubseries' => '01', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 5, 'cat_series_id' => 31, 'name' => 'Control de viáticos de la Cancillería', 'code' => '05C.03.02', 'codeSubseries' => '02', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 6, 'cat_series_id' => 31, 'name' => 'Control de viáticos del Servicio Exterior Mexicano ', 'code' => '05C.03.03', 'codeSubseries' => '03', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 7, 'cat_series_id' => 31, 'name' => 'Control de menaje de casa, gastos de instalación y pasajes', 'code' => '05C.03.04', 'codeSubseries' => '04', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 8, 'cat_series_id' => 34, 'name' => 'Cuentas por liquidar certificadas de gastos de inversión', 'code' => '05C.06.01', 'codeSubseries' => '01', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 9, 'cat_series_id' => 42, 'name' => 'Licitación pública', 'code' => '06C.04.01', 'codeSubseries' => '01', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 10, 'cat_series_id' => 42, 'name' => 'Invitación a cuando menos tres personas', 'code' => '06C.04.02', 'codeSubseries' => '02', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 11, 'cat_series_id' => 42, 'name' => 'Adjudicación directa', 'code' => '06C.04.03', 'codeSubseries' => '03', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 12, 'cat_series_id' => 48, 'name' => 'Control del patrimonio artístico', 'code' => '06C.17.01', 'codeSubseries' => '01', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 13, 'cat_series_id' => 78, 'name' => 'Sistema de control interno institucional', 'code' => '10C.02.01', 'codeSubseries' => '01', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 14, 'cat_series_id' => 78, 'name' => 'Administración de riesgos institucionales', 'code' => '10C.02.02', 'codeSubseries' => '02', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 15, 'cat_series_id' => 78, 'name' => 'Comité de control y desempeño institucional', 'code' => '10C.02.03', 'codeSubseries' => '03', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 16, 'cat_series_id' => 98, 'name' => 'Control de ingresos', 'code' => '01S.11.01', 'codeSubseries' => '01', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 17, 'cat_series_id' => 98, 'name' => 'Control de rotaciones', 'code' => '01S.11.02', 'codeSubseries' => '02', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 18, 'cat_series_id' => 98, 'name' => 'Control de evaluación y ascensos', 'code' => '01S.11.03', 'codeSubseries' => '03', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 19, 'cat_series_id' => 98, 'name' => 'Control de asuntos disciplinarios', 'code' => '01S.11.04', 'codeSubseries' => '04', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 20, 'cat_series_id' => 98, 'name' => 'Control de prestaciones', 'code' => '01S.11.05', 'codeSubseries' => '05', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 21, 'cat_series_id' => 98, 'name' => 'Control administrativo en la Representación ', 'code' => '01S.11.06', 'codeSubseries' => '06', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 22, 'cat_series_id' => 98, 'name' => 'Personal asimilado al Servicio Exterior Mexicano', 'code' => '01S.11.07', 'codeSubseries' => '07', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 23, 'cat_series_id' => 101, 'name' => 'Gestión de acuerdos, acciones y programas de cooperación cultural, educativa, técnica, científica y de derechos humanos', 'code' => '02S.03.01', 'codeSubseries' => '01', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 24, 'cat_series_id' => 101, 'name' => 'Fortalecimiento de las relaciones comerciales, económicas y turísticas', 'code' => '02S.03.02', 'codeSubseries' => '02', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 25, 'cat_series_id' => 101, 'name' => 'Actuaciones ante Organismos y Mecanismos Internacionales y Regionales', 'code' => '02S.03.03', 'codeSubseries' => '03', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 26, 'cat_series_id' => 108, 'name' => 'Servicios, trámites y documentación', 'code' => '03S.04.01', 'codeSubseries' => '01', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 27, 'cat_series_id' => 108, 'name' => 'Asistencia jurídica', 'code' => '03S.04.02', 'codeSubseries' => '02', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 28, 'cat_series_id' => 108, 'name' => 'Asistencia de protección', 'code' => '03S.04.03', 'codeSubseries' => '03', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

        ]);
    }
}
