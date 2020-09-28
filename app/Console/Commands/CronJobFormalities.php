<?php

namespace App\Console\Commands;

use App\Mail\MailFormalities;
use Illuminate\Console\Command;
use \Illuminate\Support\Facades\Mail;

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
        echo "Se ejecuta el cron job:";
        $data = "pasando variables para la vista";
        Mail::to('adriann@sre.gob.mx')->send(new MailFormalities($data));
        \Log::info("Este es un mensaje de CronJobFormalities desde el log:");
    }
}
