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
            ['id' => 9, 'name' => 'Dirección General de Acrvo Histórico Diplomático', 'determinant' => 'AHD', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
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
            ['id' => 21, 'name' => 'Dirección General para Asuntos Espciales', 'determinant' => 'DAE', 'crated_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
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


            //Unidades Administrativas que faltan....

            ['id' => 34, 'name' => 'Secretaría Particular', 'determinant' => 'SPR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 35, 'name' => 'Comisión de personal del servicio exterior mexicano', 'determinant' => 'DCP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 36, 'name' => 'Centro de enlace diplomático', 'determinant' => 'CED', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 37, 'name' => 'Dirección general de coordinación política', 'determinant' => 'DEP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 38, 'name' => 'Instituto Matias Romero', 'determinant' => 'IMR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 39, 'name' => 'Subsecretaría de relaciones exteriores', 'determinant' => 'SSRE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 40, 'name' => 'Subsecretaría para América del norte', 'determinant' => 'SSAN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 41, 'name' => 'Instituto de los mexicanos en el exterior', 'determinant' => 'IME', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 42, 'name' => 'Sección mexicana de la comisión internacional de límites y aguas entre México y Estados Unidos', 'determinant' => 'CEU', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 43, 'name' => 'Subsecretaría para América latina y el caribe', 'determinant' => 'SSAL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 44, 'name' => 'Sección mexicana de la comisión internacional de límites y aguas entre México y Guatemala y entre México y Belice', 'determinant' => 'CGB', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 45, 'name' => 'Subsecretaría para asuntos multilaterales y derechos humanos', 'determinant' => 'SSMH', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 46, 'name' => 'Unidad de administración y finanzas', 'determinant' => 'UAF', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 47, 'name' => 'Agencia Mexicana de cooperación internacional para el desarrollo', 'determinant' => 'AMI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 48, 'name' => 'Dirección general de cooperación educativa y cultural', 'determinant' => 'CEC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 49, 'name' => 'Dirección general de cooperación y promoción económica internacional', 'determinant' => 'PEI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 50, 'name' => 'Dirección general de cooperación y relaciones económicas bilaterales', 'determinant' => 'REB', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 51, 'name' => 'Dirección general de cooperación técnica y científica', 'determinant' => 'CTC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 52, 'name' => 'Dirección general del proyecyo integración y desarrollo de Mesoamérica', 'determinant' => 'IDM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 53, 'name' => 'Dirección general de planeación y cooperación económica internacional', 'determinant' => 'PCI', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            //Delegaciones Metropolitanas

            ['id' => 54, 'name' => 'Delegación Álvaro Obregón', 'determinant' => 'AOM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 55, 'name' => 'Delegación Benito Juárez', 'determinant' => 'BJM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 56, 'name' => 'Delegación Cuajimalpa de Morelos', 'determinant' => 'CUA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 57, 'name' => 'Delegación Cuauhtemoc', 'determinant' => 'CUM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 58, 'name' => 'Delegación Gustavo A. Madero', 'determinant' => 'GAM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 59, 'name' => 'Delegación Iztacalco', 'determinant' => 'IZT', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 60, 'name' => 'Delegación Iztapalapa', 'determinant' => 'IZP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 61, 'name' => 'Delegación Miguel Hidalgo', 'determinant' => 'MHM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 62, 'name' => 'Delegación Naucalpan, Estado de México', 'determinant' => 'EMN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 63, 'name' => 'Delegación Tlalpan', 'determinant' => 'TLM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 64, 'name' => 'Delegación Venustiano Carranza', 'determinant' => 'VEM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 65, 'name' => 'Edificio Tlatelolco, Plaza Juárez', 'determinant' => 'TCO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            //Delegaciones Foráneas

            ['id' => 66, 'name' => 'Delegación Acapulco, Guerrero', 'determinant' => 'ACP', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 67, 'name' => 'Delegación Aguascalientes, Aguascalientes', 'determinant' => 'AGS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 68, 'name' => 'Delegación Campeche, Campeche', 'determinant' => 'CAM', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 69, 'name' => 'Delegación Cancún, Quintana Roo', 'determinant' => 'CUN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 70, 'name' => 'Delegación Chihuahua, Chihuahua', 'determinant' => 'CHH', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 71, 'name' => 'Delegación Ciudad Juárez, Chihuahua', 'determinant' => 'CJU', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 72, 'name' => 'Delegación Ciudad Victoria, Tamaulipas', 'determinant' => 'CVT', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 73, 'name' => 'Delegación Colima, Colima', 'determinant' => 'DCO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 74, 'name' => 'Delegación Cuernavaca, Morelos', 'determinant' => 'DMO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 75, 'name' => 'Delegación Culiacán, Sinaloa', 'determinant' => 'SIA', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 76, 'name' => 'Delegación Durango, Durango', 'determinant' => 'DUR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 77, 'name' => 'Delegación Guadalajara, Jalisco', 'determinant' => 'JAL', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 78, 'name' => 'Delegación Hermosillo, Sonora', 'determinant' => 'SON', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 79, 'name' => 'Delegación Jalapa, Veracruz', 'determinant' => 'VER', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 80, 'name' => 'Delegación La Paz, Baja California Sur', 'determinant' => 'BCS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 81, 'name' => 'Delegación León, Guanajuato', 'determinant' => 'LEO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 82, 'name' => 'Delegación Mérida, Yucatan', 'determinant' => 'YUC', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 83, 'name' => 'Delegación Mexicali, Baja California', 'determinant' => 'BCN', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 84, 'name' => 'Delegación Monterrey, Nuevo León', 'determinant' => 'NLE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 85, 'name' => 'Delegación Morelia, Michoacán', 'determinant' => 'MOR', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 86, 'name' => 'Delegación Oaxaca, Oaxaca', 'determinant' => 'OAX', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 87, 'name' => 'Delegación Pachuca, Hidalgo', 'determinant' => 'HGO', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 88, 'name' => 'Delegación Puebla, Puebla', 'determinant' => 'PUE', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
//            ['id' => 33, 'name' => '', 'determinant' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

        ]);
    }
}
