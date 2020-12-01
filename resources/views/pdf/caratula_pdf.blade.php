<?php

function fecha($value,$action){
    $value = preg_split("/[-]+/", $value);
    switch ($action) {
        case 'anio':
        {

            $value = $value[0];
            break;
        }
        case 'mes':
        {
            $months = [ ['id'=> '01','name' => 'Enero'],
                        ['id'=> '02','name' => 'Febrero'],
                        ['id'=> '03','name' => 'Marzo'],
                        ['id'=> '04','name' => 'Abril'],
                        ['id'=> '05','name' => 'Mayo'],
                        ['id'=> '06','name' => 'Junio'],
                        ['id'=> '07','name' => 'Julio'],
                        ['id'=> '08','name' => 'Agosto'],
                        ['id'=> '09','name' => 'Septiembre'],
                        ['id'=> '10','name' => 'Octubre'],
                        ['id'=> '11','name' => 'Noviembre'],
                        ['id'=> '12','name' => 'Diciembre']
                    ];

                foreach ($months as $i) {
                    if($i['id'] === $value[1]){
                        $value = $i['name'];
                    }
                }
            break;
        }
        case 'dia':
        {
            $value = $value[2];
            break;
        }

        default:
        {
            $value = null;
            break;
        }
    }
    return $value;
}

function TraditionDocumentary($val){
    switch ($val) {
        case 1:
        {
            $val = "Copia";
        break;
        }
        case 2:
        {
            $val = "Original";
        break;
        }
        case 3:
        {
            $val = "Original y copia";
        break;
        }
        default:
        {
            $val = "";
        break;
        }

    }
    return $val;
}

function Format($val){
    switch ($val) {
        case 1:
        {
            $val = "Electrónico";
        break;
        }
        case 2:
        {
            $val = "Físico";
        break;
        }
        default:
        {
            $val = "";
        break;
        }

    }
    return $val;
}

    $Administrativo = array_search('Administrativo', array_column( $results['primarivalues'], 'name') ) === false ? '-':'X';
    $Legal          = array_search('Legal', array_column( $results['primarivalues'], 'name') ) === false ? '-':'X';
    $Fiscal         = array_search('Fiscal', array_column( $results['primarivalues'], 'name') ) === false ? '-':'X';
    $Contable       = array_search('Contable', array_column( $results['primarivalues'], 'name') ) === false ? '-':'X';

function question_one($action,$value){
    if($action === true ){
        $value = ( $value === 1 )? 'X': '';
    }else{
        $value = ( $value === 0 )? 'X': '';
    }
    return $value;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caratula</title>

    <style>
        table {
            font-size: 11.5px;
        }

        .rotar {
            width: 1000px;
            height: 20px;
            transform: rotate(270deg);
            margin: 470px 0px 0px -490px;
            z-index: 1000;
        }

        .container {
            position: fixed;
            margin: 170px 0px 0px 30px;
        }

    </style>

</head>
<body>

    <div style="width: 100%;">
        {{-- <h4>Carátula de expediente</h4>
        <hr> --}}
    </div>

    <div class="container">

        <div style="height: 20px;"></div>

        <table style="width:100%; border-collapse:collapse; font-weight: 600;" border='1'> <!-- Lo cambiaremos por CSS -->
            <tr>
                <td rowspan="2" align="center" WIDTH="80"
                style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Productor/a <b></strong>
                </td>
                <td WIDTH="100" align="center">Unidad administrativa</td>
                <td align="center"> {{ $results['unidad'] }} </td>
            </tr>
            <tr>
                <td WIDTH="100" align="center">Área generadora</td>
                <td align="center"> {{$results['generating_area'] }} </td>
            </tr>
        </table>

        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse; font-weight: 600;" border='1'>
            <tr>
                <td rowspan="5" align="center" WIDTH="80"
                style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Nivel de descripción documental <b></strong>
                </td>
                <td WIDTH="47.5" align="center" style="background-color: #F6F6F6;" >Fondo</td>
                <td WIDTH="49.5" align="center">SRE</td>
                <td align="center">Secretaría de Relaciones Exteriores</td>
            </tr>
            <tr>
                <td WIDTH="47.5" align="center" style="background-color: #F6F6F6;">Sección</td>
                <td WIDTH="49.5" align="center"> {{ $results['section'] }} </td>
                <td align="center"> {{ $results['sectionName'] }} </td>
            </tr>
            <tr>
                <td WIDTH="47.5" align="center" style="background-color: #F6F6F6;">Serie</td>
                <td WIDTH="49.5" align="center"> {{ $results['serieCode'] }} </td>
                <td align="center"> {{ $results['serieName'] }} </td>
            </tr>
            <tr>
                <td WIDTH="47.5" align="center" style="background-color: #F6F6F6;">Subserie</td>
                <td WIDTH="49.5" align="center"> {{ $results['subserieCode'] }} </td>
                <td align="center"> {{ $results['subserieName'] }} </td>
            </tr>
            <tr>
                <td WIDTH="47.5" align="center" style="background-color: #F6F6F6;">Expediente</td>
                <td WIDTH="49.5" align="center">1</td>
                <td align="center"></td>
            </tr>
        </table>

        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse; text-align: center;" border='1'> <!-- Lo cambiaremos por CSS -->
            <tr>
                <td rowspan="2" align="center" WIDTH="80"
                style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Código de referencia <b></strong>
                </td>
                <td rowspan="2" WIDTH="47.5" align="center">Clasificación Archivística </td>
                <td style="border-right-style: none; font-size: 22px; font-weight: 1000;">SRE.</td>
                <td colspan="5" style="border-left-style: none; font-size: 22px; font-weight: 1000;">{{ $results['codeOfReference'] }} </td>
                <td style="font-size: 22px; font-weight: 1000;"> {{ $results['legajo'] }} </td>
            </tr>
            <tr>
                <td>Fondo (.)</td>
                <td>Sección (.)</td>
                <td>Serie (.)</td>
                <td>Subserie (/)</td>
                <td>Año inicio (-) y cierre/</td>
                <td>Consecutivo</td>
                <td>Legajo</td>
            </tr>
        </table>

        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse; text-align: center;" border='1'> <!-- Lo cambiaremos por CSS -->
            <tr>
                <td align="center" WIDTH="80"
                style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Título <b></strong>
                </td>
                <?php $fontTitulo = $results['title'] > 99 ? "font-size: 22px;":"font-size: 13px;"."font-weight: 1000;";  ?>
                <td style="<?php echo $fontTitulo ?>" align="center"> {{ $results['title'] }}
                </td>
            </tr>
        </table>

        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse; text-align: center;" border='1'> <!-- Lo cambiaremos por CSS -->
            <tr>
                <td align="center" WIDTH="80"
                style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Alcance y contenido (asunto) <b></strong>
                </td>
                <td align="center" style="font-weight: 600;"> {{ $results['alcance_y_contenido'] }} </td>
            </tr>
        </table>

        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse;" border='1'>
            <tr>
                <td rowspan="3" align="center" WIDTH="80"
                style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Fecha(s) <b></strong>
                </td>
                <td align="center" style="color: #545454;">Día (00)</td>
                <td align="center" style="color: #545454;">Mes (letra)</td>
                <td align="center" style="color: #545454;">Año (0000)</td>
                <td align="center" style="color: #545454;">Día (00)</td>
                <td align="center" style="color: #545454;">Mes (letra)</td>
                <td align="center" style="color: #545454;">Año (0000)</td>
            </tr>
            <tr>
                <td align="center" style="font-weight: 600;"> {{ fecha($results['opening_date'],'dia') }} </td>
                <td align="center" style="font-weight: 600;"> {{ fecha($results['opening_date'],'mes') }}</td>
                <td align="center" style="font-weight: 600;"> {{ fecha($results['opening_date'],'anio') }}</td>
                <td align="center" style="font-weight: 600;"> {{ fecha($results['close_date'],'dia') }} </td>
                <td align="center" style="font-weight: 600;"> {{ fecha($results['close_date'],'mes') }}</td>
                <td align="center" style="font-weight: 600;"> {{ fecha($results['close_date'],'anio') }}</td>
            </tr>
            <tr>
                <td colspan="3" align="center">Inicio del trámite o asunto</td>
                <td colspan="3" align="center">Cierre del trámite o asunto</td>
            </tr>
        </table>

        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse;" border='1'>
            <tr>
                <td rowspan="4" align="center" WIDTH="80"
                style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Volumen y soporte <b></strong>
                </td>
                <td align="center" style="font-weight: 600;">papel </td>
                <td align="center" style="font-weight: 600;"> <!--tamaño carta -->  {{ Format( $results['Format']) }} </td>
                <td align="center" style="font-weight: 600;"> <!-- original --> {{ TraditionDocumentary( $results['Tradition_or_documentary_form'] ) }}</td>
            </tr>
            <tr>
                <td align="center">Soporte</td>
                <td align="center">Formato</td>
                <td align="center">Tradición o forma documental</td>
            </tr>
            <tr>
                <td align="center" style="font-weight: 600;"> <!-- 01 --> {{ $results['initial_folio'] }} </td>
                <td align="center" style="font-weight: 600;"><!--180--> {{ $results['end_folio'] }} </td>
                <td align="center" style="font-weight: 600;"> <!--180--> {{ $results['fojas'] }} </td>
            </tr>
            <tr>
                <td align="center">Folio inicial</td>
                <td align="center">Folio final</td>
                <td align="center">Total Fojas útiles al cierre del expediente</td>
            </tr>
        </table>

        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse;" border='1'>
            <tr>
                <td rowspan="4" align="center" WIDTH="80" style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Características físicas y requisitos técnicos <b></strong>
                </td>
                <td rowspan="4" align="center" WIDTH="50" style="font-weight: 600;"> Electrónico </td>
                <td align="center" WIDTH="80" height="20">Vínculo a anexos</td>
                <td align="center"> N/A </td>
            </tr>
            <tr>
                <td align="center" WIDTH="80" height="20">Formato en que se captura</td>
                <td align="center"> N/A </td>
            </tr>
            <tr>
                <td align="center" WIDTH="80" height="20">Requisitos para interpretar</td>
                <td align="center"> N/A </td>
            </tr>
            <tr>
                <td align="center" WIDTH="80" height="20">Ubicación o directorio raíz</td>
                <td align="center"> N/A </td>
            </tr>
        </table>


        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse;" border='1'>
            <tr>
                <td rowspan="4" align="center" WIDTH="80" style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Valoración, selección y eliminación <b></strong>
                </td>
                <td align="center">Administrativo</td>
                <td align="center" style="font-weight: 600;"> {{ $Administrativo }} </td>
                <td align="center">Legal</td>
                <td align="center" style="font-weight: 600;">  {{ $Legal }} </td>
                <td align="center">Contable</td>
                <td align="center" style="font-weight: 600;"> {{ $Contable }} </td>
                <td align="center">Fiscal </td>
                <td align="center" style="font-weight: 600;"> {{ $Fiscal }} </td>
                <td align="center" style="font-weight: 600;"></td>
            </tr>
            <tr>
                <td align="center" colspan="9">Formato en que se captura</td>1
            </tr>
            <tr>
                <td align="center" style="font-weight: 600;">{{ $results['AC'] }}</td>
                <td align="center">años</td>
                <td align="center" style="font-weight: 600;">{{ $results['AT'] }}</td>
                <td align="center">años</td>
                <td align="center"> {{ $results['total'] }} </td>
                <td align="center" style="font-weight: 600;">2</td>
                <td align="center">AH</td>
                <td align="center" colspan="2" style="font-weight: 600;">0</td>
            </tr>
            <tr>
                <td align="center" colspan="2">Vigencia archivo de trámite</td>
                <td align="center" colspan="2">Vigencia archivo de concentración</td>
                <td align="center" colspan="5">Plazo total de conservación</td>
            </tr>
        </table>

        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse;" border='1'>
            <tr>
                <td rowspan="9" align="center" WIDTH="80" style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Condiciones de acceso
(Leyenda de clasificación de la información y/o de versión pública) <b></strong>
                </td>
                <td align="center" WIDTH="80"></td>
                <td align="center" style="font-weight: 600;">Pública</td>
                <td align="center">X</td>
                <td align="center" style="font-weight: 600;">Confidencial</td>
                <td align="center">DP</td>
                <td align="center" style="font-weight: 600;"></td>
                <td align="center">DS</td>
                <td align="center" style="font-weight: 600;"></td>
                <td align="center">Reservada</td>
                <td align="center" style="font-weight: 600;"></td>
            </tr>
            <tr>
                <td align="center" WIDTH="80">Fecha de clasificación</td>
                <td align="center" colspan="3" style="font-weight: 600;"> {{ $results['Classification_date'] }} </td>
                <td align="center" colspan="5">Versión pública</td>
                <td align="center"></td>
            </tr>
            <tr>
                <td align="center" WIDTH="80"><!--Nombre y firma del Titular de la Unidad Administrativa-->  {{ $results['name_titular'] }} </td>
                <td align="center" colspan="3">Resolución del Comité de Transparencia</td>
                <td align="center" colspan="6" style="font-weight: 600;">{{ $results['name_titular'] }} </td>
            </tr>
            <tr>
                <td align="center" WIDTH="80">Acta del Comité de Transp.</td>
                <td align="center" colspan="9" style="font-weight: 600;">{{ $results['transparency_proceedings'] }}</td>
            </tr>
            <tr>
                <td align="center" WIDTH="80">Partes restringidas </td>
                <td align="center" colspan="6" style="font-weight: 600;">{{$results['restricted_parts']}}</td>
                <td align="center">Foja(s)</td>
                <td align="center"colspan="2" style="font-weight: 600;"> {{ $results['fojas'] }} </td>
            </tr>
            <tr>
                <td align="center" WIDTH="80">Fundamento Legal</td>
                <td align="center" colspan="9" style="font-weight: 600;">{{$results['legal_basis']}}</td>
            </tr>
            <tr>
                <td align="center" WIDTH="80">Periodo de reserva</td>
                <td align="center" style="font-weight: 600;">{{ $results['reservation_period'] }}</td>
                <td align="center">años</td>
                <td align="center" colspan="2">Ampliación del plazo</td>
                <td align="center" style="font-weight: 600;">{{$results['deadline_extension']}}</td>
                <td align="center">años</td>
                <td align="center" colspan="2">No. Acta / Oficio</td>
                <td align="center" style="font-weight: 600;">{{$results['Noactaoficio']}}</td>
            </tr>
            <tr>
                <td align="center" WIDTH="80">Fecha de desclasificación</td>
                <td align="center" colspan="3" style="font-weight: 600;">{{$results['declassification_date']}}</td>
                <td align="center" colspan="3">Nombre, cargo y firma del servidor público que desclasifica</td>
                <td align="center" colspan="3" style="font-weight: 600;">{{$results['public_server']}}</td>
            </tr>
            <tr>
                <td align="center" colspan="4">Fue objeto de solicitud de acceso a información</td>
                <td align="center">SI</td>
                <td align="center" style="font-weight: 600;">{{ question_one(true , $results['question_one']) }}</td>
                <td align="center">NO</td>
                <td align="center" style="font-weight: 600;">{{ question_one(false , $results['question_one']) }}</td>
                <td align="center" colspan="2"></td>
            </tr>
        </table>

        <div style="height: 8px;"></div>

        <table style="width:100%; border-collapse:collapse; text-align: center;" border='1'> <!-- Lo cambiaremos por CSS -->
            <tr>
                <td align="center" WIDTH="80" rowspan="2"
                style="background-color: #DDDDDD; align-content: center;">
                    <strong><b> Nota(s) <b></strong>
                </td>
                <td align="center" colspan="3" height="20"></td>
            </tr>
            <tr>
                <td align="center">Nota del archivero (elaboró)</td>
                <td align="center">Fecha de elaboración</td>
                <td align="center">Reglas o normas (número de CDD)</td>
            </tr>
        </table>

        <div> AC= Archivo de concentración. AH= Archivo histórico. DP=Datos personales básicos. DS=Datos personales sensibles. </div>


    </div>

    <div style="height: 8px;"></div>

    <div class="rotar">
        Formato basado en la LFA, los LGOCAPEF, los LOCA, los LGCDIVP, el MAPF, Recomendaciones del INAI para Datos Personales, y la ISAD (G)
    </div>


</body>
</html>
