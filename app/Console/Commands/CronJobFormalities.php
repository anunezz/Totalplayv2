<?php

namespace App\Console\Commands;

use App\Mail\MailFormalities;
use Illuminate\Console\Command;
use \Illuminate\Support\Facades\Mail;
use App\Http\Models\Formalities;

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

            if($item->type_selection === 3 && $item->unit_id !== 5 ){ //Validar baja documental
                $item->type_report = 1;
            }

            if($item->type_selection === 3 && $item->unit_id === 5 ){ //Validar baja contable
                $item->type_report = 2;
            }

            if($item->type_selection === 1 && $item->unit_id !== 5 ){ //Validar baja documental
                $item->type_report = 1;
            }

            if($item->type_selection === 1 && $item->unit_id === 5 ){ //Validar baja contable
                $item->type_report = 2;
            }

            if($item->type_selection === 4 ){ //Validar transferencia secundaria
                $item->type_report = 4;
            }

            if($item->type_selection === 2 ){ //Validar conservacion

                $serie = $item->serie()->first();
                echo $item->opening_date."\n";

                $AT = date("Y-m-d", strtotime($item->opening_date . "+ ".$serie->AT." year"));
                $AC = date("Y-m-d", strtotime($AT . "+ ".$serie->AC." year"));

                //inicio
                if( strtotime( date("Y-m-d") ) <= strtotime( $AT )  ){
                    $aux = true;
                    if(strtotime( $AT ) < strtotime( $AC ) && strtotime( $AT ) > strtotime( $AC )){
                        $item->type_report = 3;
                        $aux = false;
                    }

                    if($aux === true){
                        $item->type_report = 4;
                    }
                }

            }

            $item->save();

        }

        $data = "pasando variables para la vista";
         Mail::to('adriann@sre.gob.mx')->send(new MailFormalities($data));
        \Log::info("Este es un mensaje de CronJobFormalities desde el log:");
    }
}
