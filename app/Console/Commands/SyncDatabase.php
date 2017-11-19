<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Classes\TDG\MySQLConnection;
use PDO;

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
        $connectionString = 'mysql:host='.env('DB_HOST').';dbname='.env('DB_DATABASE').';charset=utf8';
        $conn = new PDO(
            $connectionString,
            env('DB_USERNAME'),
            env('DB_PASSWORD')
        );

        $queryString = file_get_contents('docker/mariadb/init.sql');

        $stmt = $conn->prepare($queryString);

        $stmt->execute();
    }
}
