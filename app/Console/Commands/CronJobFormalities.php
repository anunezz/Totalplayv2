<?php

namespace App\Console\Commands;

use App\Mail\MailFormalities;
use Illuminate\Console\Command;
use \Illuminate\Support\Facades\Mail;
use App\Http\Models\Formalities;
use App\User;

class CronJobFormalities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'formalities:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'El CronJobFormalities se ejecuto correctamente.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $Formalities = Formalities::get();
        foreach ($Formalities as $item) {

            // $item->type_report baja documental = 1
            // $item->type_report baja contable = 2
            // $item->type_report transferencia primaria = 3
            // $item->type_report transferencia secundaria = 4

            // $item->type_selection eliminacion = 1
            // $item->type_selection conservacion = 2
            // $item->type_selection muestreo = 3
            // $item->type_selection cualidad de la muestra = 4
            $serie = $item->serie()->first();
            $total = date("Y-m-d", strtotime($item->close_date . "+ ".$serie->total." year"));

            if( strtotime( date("Y-m-d") ) > strtotime( $total )  ){

                if($item->type_selection === 3 && $item->unit_id !== 4 ){ //Validar baja documental
                    //echo "baja documental muestreo sin dgpop: \n";
                    $item->type_report = 1;
                }

                if($item->type_selection === 3 && $item->unit_id === 4 ){ //Validar baja contable
                    //echo "baja contable muestreo dgpop: \n";
                    $item->type_report = 2;
                }

                if($item->type_selection === 1 && $item->unit_id !== 4 ){ //Validar baja documental
                   // echo "baja documental eliminacion: \n";
                    $item->type_report = 1;
                }

                if($item->type_selection === 1 && $item->unit_id === 4 ){ //Validar baja contable
                   // echo "baja contable eliminacion: \n";
                    $item->type_report = 2;
                }

                if($item->type_selection === 4 ){ //Validar transferencia secundaria
                    //echo "cualidad de la muestra tras secundaria: \n";
                    $item->type_report = 4;
                }

                if( $item->email_notify === 0 ){
                    $data = [ 'title'=>$item->title,"sort_code"=> $item->sort_code ];

                    //Responsable
                    $user_unit = $item->unit()->first();
                    $cat_responsible_id = $user_unit->cat_responsible_id;
                    if( $cat_responsible_id !== null ){
                        $responsible_name = User::where('cat_profile_id','<>',1)
                        ->where('id','=',$cat_responsible_id )
                        ->first();
                        if( !is_null( $responsible_name ) ){
                            echo "Responsable:   ".$responsible_name->username."\n";
                            Mail::to($responsible_name->username.'@sre.gob.mx')->send(new MailFormalities($data));
                        }
                    }

                    //Usuario
                    $cat_user_id = $user_unit->cat_user_id;
                    if( $cat_user_id !== null  ){
                        $user = User::where('cat_profile_id','<>',1)
                        ->where('id','=', $cat_user_id )
                        ->first();
                        if( !is_null( $user ) ){
                            echo "USUARIO:   ".$user->username."\n";
                            Mail::to($user->username.'@sre.gob.mx')->send(new MailFormalities($data));
                        }
                    }

                    //Administradores
                    $admin = User::where('cat_profile_id','=',1)->get();
                    foreach ($admin as $itm) {
                        echo "aDMINISTRADOR:   ".$itm->username."\n";
                        Mail::to($itm->username.'@sre.gob.mx')->send(new MailFormalities($data));
                    }

                    $item->email_notify = 1;
                }

            }

            if($item->type_selection === 2 ){ //Validar conservacion
                //echo "Fechas registro: ".$item->close_date."\n\n";
                $serie = $item->serie()->first();

                $AT = date("Y-m-d", strtotime($item->close_date . "+ ".$serie->AT." year"));
                $AC = date("Y-m-d", strtotime($AT . "+ ".$serie->AC." year"));

                // echo "-----------------------------------------------------\n";
                // echo "fecha hoy: ".date("Y-m-d")."\n";
                // echo "fecha cierre: ".$item->close_date."\n";
                // echo "fecha AT: ".$AT."\n";
                // echo "fecha AC: ".$AC."\n";

                if( (strtotime( date("Y-m-d") ) > strtotime( $AT )) && ( strtotime( date("Y-m-d") ) < strtotime( $AC ) )  ){
                    //echo "conservacion tras PRIMARIA: \n";
                    $item->type_report = 3;
                }

                if(
                    ( strtotime( date("Y-m-d") ) > strtotime( $AT ) )
                    &&
                    ( strtotime( date("Y-m-d") ) > strtotime( $AC ) )

                ){
                    //echo "conservacion tras SECUNDARIA: \n";
                    $item->type_report = 4;
                }

            }


            $item->save();

        }


        //Mail::to('adriann@sre.gob.mx')->send(new MailFormalities($data));
        \Log::info("Este es un mensaje de CronJobFormalities desde el log:");
    }
}
