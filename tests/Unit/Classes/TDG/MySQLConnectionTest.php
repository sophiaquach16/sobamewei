<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Classes\TDG\MySQLConnection;

class MySQLConnectionTest extends TestCase{
    public function setUp(){
        $this->connection = new MySQLConnection();
        $query = "INSERT INTO User VALUES(
            '9999',
            'example_firstname',
            'example_lastname',
            'example_email@gmail.com',
            '514-555-5555',
            '0',
            'example_addr',
            'example_pass',
            'example_token'
        )";
        $this->connection->directQuery($query);     
    }
    
    public function tearDown(){
        $query = "DELETE FROM User WHERE firstname='example_firstname'";
        $this->connection->directQuery($query); 
    }

    public function testQuerySuccess(){
        $query ="SELECT * FROM User WHERE id='9999'";
        $parameters = array();
        $result = $this->connection->query($query, $parameters);
        $this->assertNotFalse($result);
    }
}
