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
            $serie = $item->serie()->first();
            echo $item->opening_date."\n";
            // echo $serie->AT."\n";
            // echo $serie->AC."\n";
            // echo $serie->total."\n";
            $AT = date("Y-m-d", strtotime($item->opening_date . "+ ".$serie->AT." year"));
            $AC = date("Y-m-d", strtotime($AT . "+ ".$serie->AC." year"));

            //inicio
            if( strtotime( date("Y-m-d") ) >= strtotime( $AT )  ){
                echo "Fecha actual: ".date("Y-m-d")."mayor que Fecha trans primaria".$AT;
            }else {
                echo "Fecha actual: ".date("Y-m-d")."menor que Fecha trans primaria".$AT;
            }


        }

        $data = "pasando variables para la vista";
       // Mail::to('adriann@sre.gob.mx')->send(new MailFormalities($data));
        \Log::info("Este es un mensaje de CronJobFormalities desde el log:");
    }
}
