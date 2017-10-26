<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\TDG\MySQLConnection;

class SyncDatabase extends Command
{
    private $conn;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->conn = new MySQLConnection();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $queryString = file_get_contents('databaseScript.sql');

        $this->conn->directQuery($queryString);
    }
}
