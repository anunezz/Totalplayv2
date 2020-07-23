<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatAdministrativeUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_administrative_units')->insert([
            ['id' => 1, 'name' => 'Consultoría Jurídica', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'name' => 'Dirección General de Asuntos Jurídicos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 3, 'name' => 'Dirección General del Servicio Exterior y de Recursos Humanos', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 4, 'name' => 'Dirección General de Programación, Organización y Presupuesto', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 5, 'name' => 'Sindicato Nacional de Trabajadores de la Secretaría de Relaciones Exteriores', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 6, 'name' => 'Dirección General de Bienes Inmuebles y Recursos Materiales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 7, 'name' => 'Dirección General de Protocolo', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 8, 'name' => 'Dirección General de Tecnologías de Información e Innovación', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 9, 'name' => 'Dirección General de Acervo Histórico Diplomático', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 10, 'name' => 'Dirección General de Comunicación Social', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 11, 'name' => 'Jefatura de la Oficina del Canciller', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 12, 'name' => 'Coordinación General de Asesores', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 13, 'name' => 'Coordinación de Asesores de Oficialía Mayor', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 14, 'name' => 'De aplicación general', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 15, 'name' => 'Unidad de Transparencia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 16, 'name' => 'Dirección General para Asia-Pacifico', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 17, 'name' => 'Dirección General para Europa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 18, 'name' => 'Dirección General para África y Medio Oriente', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 19, 'name' => 'Dirección General para América Latina y el Caribe', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 20, 'name' => 'Dirección General para América del Norte', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 21, 'name' => 'Dirección General para Asuntos Especiales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 22, 'name' => 'CILA Norte', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 23, 'name' => 'CILA Sur', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 24, 'name' => 'Dirección General de Servicios Consulares', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 25, 'name' => 'Dirección General de Derechos Humanos y Democracia', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 26, 'name' => 'Dirección General para la Organización de las Naciones Unidas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 27, 'name' => 'Dirección General para Temas Globales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 28, 'name' => 'Dirección General de Organismos y Mecanismos Regionales', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 29, 'name' => 'Dirección General de Vinculación con las Organizaciones de la Sociedad Civil', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 30, 'name' => 'Dirección General de Protección a Mexicanos en el Exterior', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 31, 'name' => 'Representaciones de México en el exterior', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 32, 'name' => 'Dirección General de Delegaciones', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 33, 'name' => 'Delegaciones Locales y Foráneas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

        ]);
    }
}
