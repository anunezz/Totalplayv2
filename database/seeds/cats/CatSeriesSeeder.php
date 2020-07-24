<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatSeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cat_series')->insert([
            ['id' => 1, 'cat_section_id' => 1, 'name' => 'Programas y proyectos en materia de legislación', 'code' => '01C.02', 'AT' => 3, 'AC' => 2, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 2, 'cat_section_id' => 1, 'name' => 'Instrumentos jurídicos consensuales (convenios, bases de colaboración, acuerdos, etc.)', 'code' => '01C.10', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 3, 'cat_section_id' => 1, 'name' => 'Diario Oficial de la Federación (publicaciones en el)', 'code' => '01C.13', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 4, 'cat_section_id' => 2, 'name' => 'Registro y certificación de firmas', 'code' => '02C.03', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 5, 'cat_section_id' => 2, 'name' => 'Actuaciones y representaciones en materia legal', 'code' => '02C.05', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 6, 'cat_section_id' => 2, 'name' => 'Asistencia, consulta y asesorías', 'code' => '02C.06', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 7, 'cat_section_id' => 2, 'name' => 'Juicios contra la dependencia', 'code' => '02C.08', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 8, 'cat_section_id' => 2, 'name' => 'Juicios de la dependencia', 'code' => '02C.09', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 9, 'cat_section_id' => 2, 'name' => 'Amparos', 'code' => '02C.10', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 10, 'cat_section_id' => 3, 'name' => 'Programa anual de inversiones', 'code' => '03C.04', 'AT' => 2, 'AC' => 4, 'total' => 6, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 11, 'cat_section_id' => 3, 'name' => 'Integración y dictamen de manuales de organización', 'code' => '03C.11', 'AT' => 3, 'AC' => 2, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 12, 'cat_section_id' => 3, 'name' => 'Integración y dictamen de manuales, normas y lineamientos de procesos y procedimientos', 'code' => '03C.12', 'AT' => 3, 'AC' => 2, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 13, 'cat_section_id' => 3, 'name' => 'Acciones de modernización administrativa', 'code' => '03C.13', 'AT' => 1, 'AC' => 4, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 14, 'cat_section_id' => 3, 'name' => 'Programas y proyectos en materia de presupuestación', 'code' => '03C.18', 'AT' => 1, 'AC' => 4, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 15, 'cat_section_id' => 3, 'name' => 'Evaluación y control del ejercicio presupuestal', 'code' => '03C.20', 'AT' => 1, 'AC' => 4, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 16, 'cat_section_id' => 3, 'name' => 'Comité de mejora regulatoria interna', 'code' => '03C.21', 'AT' => 1, 'AC' => 4, 'total' => 5, 'cat_selection_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 17, 'cat_section_id' => 4, 'name' => 'Programas y proyectos en materia de recursos humanos', 'code' => '04C.02', 'AT' => 3, 'AC' => 5, 'total' => 8, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 18, 'cat_section_id' => 4, 'name' => 'Expediente único de personal', 'code' => '04C.03', 'AT' => 2, 'AC' => 23, 'total' => 25, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 19, 'cat_section_id' => 4, 'name' => 'Registro y control de puestos y plazas', 'code' => '04C.04', 'AT' => 1, 'AC' => 5, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 20, 'cat_section_id' => 4, 'name' => 'Nómina de pago de personal', 'code' => '04C.05', 'AT' => 3, 'AC' => 2, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 21, 'cat_section_id' => 4, 'name' => 'Reclutamiento y selección de personal', 'code' => '04C.06', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 22, 'cat_section_id' => 4, 'name' => 'Control de asistencia (vacaciones, descansos y licencias, incapacidades, etc.)', 'code' => '04C.08', 'AT' => 2, 'AC' => 10, 'total' => 12, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 23, 'cat_section_id' => 4, 'name' => 'Estímulos y recompensas', 'code' => '04C.11', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 24, 'cat_section_id' => 4, 'name' => 'Afiliaciones al Instituto de Seguridad y Servicios Sociales de los Trabajadores del Estado', 'code' => '04C.15', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 25, 'cat_section_id' => 4, 'name' => 'Control de prestaciones en materia económica (FONAC, Sistema de Ahorro para el Retiro, Seguros, etc.)', 'code' => '04C.16', 'AT' => 2, 'AC' => 10, 'total' => 12, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 26, 'cat_section_id' => 4, 'name' => 'Relaciones laborales (comisiones mixtas, sindicato nacional de trabajadores al servicio del estado, condiciones laborales)', 'code' => '04C.20', 'AT' => 2, 'AC' => 2, 'total' => 4, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 27, 'cat_section_id' => 4, 'name' => 'Servicios sociales y culturales y de seguridad e higiene en el trabajo', 'code' => '04C.21', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 28, 'cat_section_id' => 4, 'name' => 'Capacitación continua y desarrollo profesional del personal de las áreas administrativas', 'code' => '04C.22', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 29, 'cat_section_id' => 4, 'name' => 'Servicio social de áreas administrativas', 'code' => '04C.23', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 30, 'cat_section_id' => 4, 'name' => 'Comité de ética y de prevención de conflictos de interés', 'code' => '04C.29', 'AT' => 4, 'AC' => 1, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 31, 'cat_section_id' => 5, 'name' => 'Gastos o egresos por partida presupuestal', 'code' => '05C.03', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 32, 'cat_section_id' => 5, 'name' => 'Ingresos', 'code' => '05C.04', 'AT' => 1, 'AC' => 4, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 33, 'cat_section_id' => 5, 'name' => 'Libros contables', 'code' => '05C.05', 'AT' => 3, 'AC' => 9, 'total' => 12, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 34, 'cat_section_id' => 5, 'name' => 'Registros contables (glosa)', 'code' => '05C.06', 'AT' => 3, 'AC' => 9, 'total' => 12, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 35, 'cat_section_id' => 5, 'name' => 'Asignación y optimización de recursos financieros', 'code' => '05C.12', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 36, 'cat_section_id' => 5, 'name' => 'Cuentas por liquidar certificadas', 'code' => '05C.14', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 37, 'cat_section_id' => 5, 'name' => 'Transferencias de presupuesto', 'code' => '05C.15', 'AT' => 1, 'AC' => 4, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 38, 'cat_section_id' => 5, 'name' => 'Control de cheques', 'code' => '05C.22', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 39, 'cat_section_id' => 5, 'name' => 'Conciliaciones', 'code' => '05C.23', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 40, 'cat_section_id' => 5, 'name' => 'Fondo rotatorio (revolvente)', 'code' => '05C.27', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 41, 'cat_section_id' => 6, 'name' => 'Programas y proyectos en materia de recursos materiales,  obra pública, conservación y mantenimiento', 'code' => '06C.02', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 42, 'cat_section_id' => 6, 'name' => 'Adquisiciones', 'code' => '06C.04', 'AT' => 5, 'AC' => 5, 'total' => 10, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 43, 'cat_section_id' => 6, 'name' => 'Control de contratos', 'code' => '06C.06', 'AT' => 5, 'AC' => 5, 'total' => 10, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 44, 'cat_section_id' => 6, 'name' => 'Seguros y fianzas', 'code' => '06C.07', 'AT' => 5, 'AC' => 5, 'total' => 10, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 45, 'cat_section_id' => 6, 'name' => 'Conservación y mantenimiento de la infraestructura física', 'code' => '06C.13', 'AT' => 1, 'AC' => 2, 'total' => 3, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 46, 'cat_section_id' => 6, 'name' => 'Registro de proveedores y contratistas', 'code' => '06C.14', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 47, 'cat_section_id' => 6, 'name' => 'Arrendamientos', 'code' => '06C.15', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 48, 'cat_section_id' => 6, 'name' => 'Inventario físico y control de bienes muebles', 'code' => '06C.17', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 49, 'cat_section_id' => 6, 'name' => 'Inventario físico y control de bienes inmuebles', 'code' => '06C.18', 'AT' => 6, 'AC' => 6, 'total' => 12, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 50, 'cat_section_id' => 6, 'name' => 'Almacenamiento, control y distribución de bienes muebles', 'code' => '06C.19', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 51, 'cat_section_id' => 6, 'name' => 'Control y seguimiento de obras y remodelaciones', 'code' => '06C.22', 'AT' => 5, 'AC' => 5, 'total' => 10, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 52, 'cat_section_id' => 6, 'name' => 'Comités y subcomités de adquisiciones, arrendamientos y servicios', 'code' => '06C.23', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 53, 'cat_section_id' => 6, 'name' => 'Comité de enajenación de bienes muebles e inmuebles', 'code' => '06C.24', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 54, 'cat_section_id' => 6, 'name' => 'Comité de obra pública', 'code' => '06C.25', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 55, 'cat_section_id' => 7, 'name' => 'Servicios básicos (energía eléctrica, agua, predial, etc.)', 'code' => '07C.03', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 56, 'cat_section_id' => 7, 'name' => 'Servicios especializados de mensajería', 'code' => '07C.10', 'AT' => 3, 'AC' => 1, 'total' => 4, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 57, 'cat_section_id' => 7, 'name' => 'Mantenimiento, conservación e instalación de mobiliario', 'code' => '07C.11', 'AT' => 1, 'AC' => 2, 'total' => 3, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 58, 'cat_section_id' => 7, 'name' => 'Control de parque vehicular', 'code' => '07C.13', 'AT' => 1, 'AC' => 2, 'total' => 3, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 59, 'cat_section_id' => 7, 'name' => 'Control de combustible', 'code' => '07C.14', 'AT' => 1, 'AC' => 2, 'total' => 3, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 60, 'cat_section_id' => 7, 'name' => 'Control de servicios en auditorios y salas', 'code' => '07C.15', 'AT' => 5, 'AC' => 10, 'total' => 15, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 61, 'cat_section_id' => 7, 'name' => 'Protección civil', 'code' => '07C.16', 'AT' => 1, 'AC' => 2, 'total' => 3, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 62, 'cat_section_id' => 8, 'name' => 'Desarrollo e infraestructura de telecomunicaciones', 'code' => '08C.04', 'AT' => 3, 'AC' => 5, 'total' => 8, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 63, 'cat_section_id' => 8, 'name' => 'Desarrollo e infraestructura del portal de internet de la dependencia', 'code' => '08C.05', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 64, 'cat_section_id' => 8, 'name' => 'Desarrollo informático', 'code' => '08C.09', 'AT' => 3, 'AC' => 4, 'total' => 7, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 65, 'cat_section_id' => 8, 'name' => 'Seguridad informática', 'code' => '08C.10', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 66, 'cat_section_id' => 8, 'name' => 'Desarrollo de sistemas', 'code' => '08C.11', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 67, 'cat_section_id' => 8, 'name' => 'Administración y servicios de archivo', 'code' => '08C.16', 'AT' => 2, 'AC' => 7, 'total' => 9, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 68, 'cat_section_id' => 8, 'name' => 'Administración y servicios de bibliotecas', 'code' => '08C.18', 'AT' => 1, 'AC' => 1, 'total' => 2, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 69, 'cat_section_id' => 8, 'name' => 'Administración y servicios de otros centros documentales', 'code' => '08C.19', 'AT' => 1, 'AC' => 1, 'total' => 2, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 70, 'cat_section_id' => 8, 'name' => 'Productos para la divulgación de servicios', 'code' => '08C.24', 'AT' => 1, 'AC' => 1, 'total' => 2, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 71, 'cat_section_id' => 8, 'name' => 'Servicios y productos en internet o intranet', 'code' => '08C.25', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 72, 'cat_section_id' => 9, 'name' => 'Programas y proyectos en materia de comunicación social', 'code' => '09C.02', 'AT' => 5, 'AC' => 3, 'total' => 8, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 73, 'cat_section_id' => 9, 'name' => 'Material multimedia', 'code' => '09C.04', 'AT' => 15, 'AC' => 15, 'total' => 30, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 74, 'cat_section_id' => 9, 'name' => 'Publicidad institucional', 'code' => '09C.05', 'AT' => 5, 'AC' => 3, 'total' => 8, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 75, 'cat_section_id' => 9, 'name' => 'Boletines informativos para medios', 'code' => '09C.07', 'AT' => 6, 'AC' => 10, 'total' => 16, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 76, 'cat_section_id' => 9, 'name' => 'Agencias periodísticas, de noticias, reporteros y articulistas, cadenas televisivas y otros medios de comunicación social', 'code' => '09C.09', 'AT' => 6, 'AC' => 10, 'total' => 16, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 77, 'cat_section_id' => 9, 'name' => 'Comparecencias ante el poder legislativo', 'code' => '09C.13', 'AT' => 1, 'AC' => 1, 'total' => 2, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 78, 'cat_section_id' => 10, 'name' => 'Programas y proyectos en materia de control y auditoría', 'code' => '10C.02', 'AT' => 4, 'AC' => 5, 'total' => 9, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 79, 'cat_section_id' => 10, 'name' => 'Seguimiento a la aplicación en medidas o recomendaciones', 'code' => '10C.06', 'AT' => 3, 'AC' => 5, 'total' => 8, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 80, 'cat_section_id' => 10, 'name' => 'Entrega–recepción', 'code' => '10C.15', 'AT' => 3, 'AC' => 5, 'total' => 8, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 81, 'cat_section_id' => 10, 'name' => 'Libros blancos', 'code' => '10C.16', 'AT' => 3, 'AC' => 5, 'total' => 8, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 82, 'cat_section_id' => 11, 'name' => 'Programas y proyectos en materia de información y evaluación', 'code' => '11C.04', 'AT' => 1, 'AC' => 2, 'total' => 3, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 83, 'cat_section_id' => 11, 'name' => 'Informe de labores', 'code' => '11C.16', 'AT' => 1, 'AC' => 1, 'total' => 2, 'cat_selection_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 84, 'cat_section_id' => 12, 'name' => 'Comité de transparencia', 'code' => '12C.05', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 85, 'cat_section_id' => 12, 'name' => 'Solicitudes de acceso a la información', 'code' => '12C.06', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 86, 'cat_section_id' => 12, 'name' => 'Portal de transparencia', 'code' => '12C.07', 'AT' => 2, 'AC' => 3, 'cat_selection_id' => 3, 'total' => 5, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 87, 'cat_section_id' => 12, 'name' => 'Sistemas de datos personales', 'code' => '12C.10', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 88, 'cat_section_id' => 13, 'name' => 'Disposiciones en materia de política exterior de México', 'code' => '01S.01', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 89, 'cat_section_id' => 13, 'name' => 'Programas y proyectos en materia de política exterior de México', 'code' => '01S.02', 'AT' => 3, 'AC' => 4, 'total' => 7, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 90, 'cat_section_id' => 13, 'name' => 'Ampliación de la presencia diplomática de México en el mundo', 'code' => '01S.03', 'AT' => 1, 'AC' => 2, 'total' => 3, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 91, 'cat_section_id' => 13, 'name' => 'Celebración de tratados, acuerdos, convenios y convenciones internacionales', 'code' => '01S.04', 'AT' => 2, 'AC' => 10, 'total' => 12, 'cat_selection_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 92, 'cat_section_id' => 13, 'name' => 'Intervención en foros, comisiones, congresos, conferencias y exposiciones internacionales', 'code' => '01S.05', 'AT' => 3, 'AC' => 3, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 93, 'cat_section_id' => 13, 'name' => 'Defensa de los intereses de México en litigios internacionales', 'code' => '01S.06', 'AT' => 2, 'AC' => 4, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 94, 'cat_section_id' => 13, 'name' => 'Atención de los asuntos de Estado internacionales', 'code' => '01S.07', 'AT' => 2, 'AC' => 4, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 95, 'cat_section_id' => 13, 'name' => 'Atención de los asuntos de Estado interiores', 'code' => '01S.08', 'AT' => 7, 'AC' => 3, 'total' => 10, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 96, 'cat_section_id' => 13, 'name' => 'Coordinación de las acciones que realicen las dependencias del gobierno federal en el extranjero', 'code' => '01S.09', 'AT' => 2, 'AC' => 2, 'total' => 4, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 97, 'cat_section_id' => 13, 'name' => 'Sesiones de la Comisión Consultiva de Política Exterior', 'code' => '01S.10', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 98, 'cat_section_id' => 13, 'name' => 'Comisión de Personal del Servicio Exterior Mexicano', 'code' => '01S.11', 'AT' => 2, 'AC' => 10, 'total' =>12 , 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 99, 'cat_section_id' => 14, 'name' => 'Disposiciones en materia de actuación internacional del Gobierno de la República', 'code' => '02S.01', 'AT' => 1, 'AC' => 4, 'total' => 5, 'cat_selection_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 100, 'cat_section_id' => 14, 'name' => 'Programas y proyectos en materia de actuación internacional del Gobierno de la República', 'code' => '02S.02', 'AT' => 1, 'AC' => 4, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 101, 'cat_section_id' => 14, 'name' => 'Cooperación internacional para el desarrollo ', 'code' => '02S.03', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 102, 'cat_section_id' => 14, 'name' => 'Acreditación del Cuerpo Diplomático, Consular y Funcionarios de los Organismos Internacionales con Sede y Representación ante el Gobierno de México', 'code' => '02S.04', 'AT' => 3, 'AC' => 2, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 103, 'cat_section_id' => 14, 'name' => 'Promoción y defensa de los intereses de México en el exterior, en los ámbitos multilateral, bilateral y regional', 'code' => '02S.05', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 104, 'cat_section_id' => 14, 'name' => 'Gestión de acciones protocolarias', 'code' => '02S.06', 'AT' => 5, 'AC' => 10, 'total' => 15, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

            ['id' => 105, 'cat_section_id' => 15, 'name' => 'Disposiciones en materia de protección y asistencia a connacionales y extranjeros', 'code' => '03S.01', 'AT' => 2, 'AC' => 4, 'total' => 6, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 106, 'cat_section_id' => 15, 'name' => 'Programas y proyectos en materia de protección y asistencia a connacionales y extranjeros', 'code' => '03S.02', 'AT' => 2, 'AC' => 3, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 107, 'cat_section_id' => 15, 'name' => 'Formalización y consolidación de la red de delegaciones en territorio nacional y representaciones de México en el exterior', 'code' => '03S.03', 'AT' => 3, 'AC' => 2, 'total' => 5, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 108, 'cat_section_id' => 15, 'name' => 'Servicio consular y migratorio', 'code' => '03S.04', 'AT' => 3, 'AC' => 6, 'total' => 9, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 109, 'cat_section_id' => 15, 'name' => 'Sesiones del Comité para la Asistencia a Casos de Protección Consular que requieren apoyos económicos', 'code' => '03S.05', 'AT' => 3, 'AC' => 4, 'total' => 7, 'cat_selection_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 110, 'cat_section_id' => 15, 'name' => 'Expedición de pasaportes ', 'code' => '03S.06', 'AT' => 1, 'AC' => 1, 'total' => 2, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 111, 'cat_section_id' => 15, 'name' => 'Legalización de firmas de documentos públicos ', 'code' => '03S.07', 'AT' => 1, 'AC' => 1, 'total' => 2, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 112, 'cat_section_id' => 15, 'name' => 'Expedición de documentos de identidad y viaje a extranjeros', 'code' => '03S.08', 'AT' => 1, 'AC' => 1, 'total' => 2, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['id' => 113, 'cat_section_id' => 15, 'name' => 'Servicio delegacional', 'code' => '03S.09', 'AT' => 1, 'AC' => 1, 'total' => 2, 'cat_selection_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],

        ]);
    }
}
