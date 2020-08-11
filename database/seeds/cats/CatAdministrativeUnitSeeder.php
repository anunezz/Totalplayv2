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
            ['id' => 1, 'name' => 'Consultoría Jurídica', 'determinant' => 'CJA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'name' => 'Dirección General de Asuntos Jurídicos', 'determinant' => 'ASJ', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 3, 'name' => 'Dirección General del Servicio Exterior y de Recursos Humanos', 'determinant' => 'DSE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 4, 'name' => 'Dirección General de Programación, Organización y Presupuesto', 'determinant' => 'POP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 5, 'name' => 'Sindicato Nacional de Trabajadores de la Secretaría de Relaciones Exteriores', 'determinant' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 6, 'name' => 'Dirección General de Bienes Inmuebles y Recursos Materiales', 'determinant' => 'IRM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 7, 'name' => 'Dirección General de Protocolo', 'determinant' => 'PRO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 8, 'name' => 'Dirección General de Tecnologías de Información e Innovación', 'determinant' => 'TIN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 9, 'name' => 'Dirección General de Acervo Histórico Diplomático', 'determinant' => 'AHD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 10, 'name' => 'Dirección General de Comunicación Social', 'determinant' => 'DCS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 11, 'name' => 'Jefatura de la Oficina del Canciller', 'determinant' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 12, 'name' => 'Coordinación General de Asesores', 'determinant' => 'CGA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 13, 'name' => 'Coordinación de Asesores de Oficialía Mayor', 'determinant' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 14, 'name' => 'De aplicación general', 'determinant' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 15, 'name' => 'Unidad de Transparencia', 'determinant' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 16, 'name' => 'Dirección General para Asia-Pacifico', 'determinant' => 'DAP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 17, 'name' => 'Dirección General para Europa', 'determinant' => 'DGE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 18, 'name' => 'Dirección General para África y Medio Oriente', 'determinant' => 'AMO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 19, 'name' => 'Dirección General para América Latina y el Caribe', 'determinant' => 'ALC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 20, 'name' => 'Dirección General para América del Norte', 'determinant' => 'DAN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 21, 'name' => 'Dirección General para Asuntos Especiales', 'determinant' => 'DAE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 22, 'name' => 'CILA Norte', 'determinant' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 23, 'name' => 'CILA Sur', 'determinant' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 24, 'name' => 'Dirección General de Servicios Consulares', 'determinant' => 'DSC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 25, 'name' => 'Dirección General de Derechos Humanos y Democracia', 'determinant' => 'DDH', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 26, 'name' => 'Dirección General para la Organización de las Naciones Unidas', 'determinant' => 'DNU', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 27, 'name' => 'Dirección General para Temas Globales', 'determinant' => 'TEL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 28, 'name' => 'Dirección General de Organismos y Mecanismos Regionales', 'determinant' => 'ORA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 29, 'name' => 'Dirección General de Vinculación con las Organizaciones de la Sociedad Civil', 'determinant' => 'VOS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 30, 'name' => 'Dirección General de Protección a Mexicanos en el Exterior', 'determinant' => 'PME', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 31, 'name' => 'Representaciones de México en el exterior', 'determinant' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 32, 'name' => 'Dirección General de Delegaciones', 'determinant' => 'DGD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 33, 'name' => 'Delegaciones Locales y Foráneas', 'determinant' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

        ]);
    }
}
