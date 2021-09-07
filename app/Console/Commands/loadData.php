<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class loadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'loadData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrate and seeder';

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
        if($this->confirm('Estas seguro de migrar y cargar la data ?', true)){
            $this->call('migrate');
            $this->call('db:seed');
            $this->info('Carga completada con exito!');
        }
    }
}
