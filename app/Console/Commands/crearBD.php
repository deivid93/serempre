<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class crearBD extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:database {cotejamiento?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creacion Base de Datos';

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
        try {
            if($this->argument('cotejamiento') != null){
                $cotejamiento = $this->argument('cotejamiento');
                switch ($cotejamiento){
                    case 'utf8':
                        $cot = "CHARACTER SET utf8 COLLATE utf8_general_ci";
                        break;
                    case 'utf8-unicode':
                        $cot = "CHARACTER SET utf8 COLLATE utf8_unicode_ci";
                        break;
                    case 'utf8mb4':
                        $cot = "CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
                        break;
                    case 'utf8mb4-unicode':
                        $cot = "CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
                        break;

                    default:
                        $cot = "CHARACTER SET utf8 COLLATE utf8_general_ci";
                        break;
                }
            }else{
                $cot = "CHARACTER SET utf8 COLLATE utf8_general_ci";
            }
            $BD = DB::connection(env('DB_CONNECTION'))
                ->select("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =". "'".env('DB_DATABASE')."'");
                if(empty($BD)){
                    DB::connection(env('DB_CONNECTION'))->select('CREATE DATABASE '. env('DB_DATABASE') .' '.$cot);
                }else{
                    $this->error("Error, la base de datos " . env('DB_DATABASE') . " ya existe ! ");
                }
        }catch (Exception $e){
            $this->error($e->getMessage());

        }
    }
}
