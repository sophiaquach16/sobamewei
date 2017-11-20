<?php

namespace App\Classes\TDG;

use Hash;

class TransactionTDG {

    private $conn;

    public function __construct() {
        $this->conn = new MySQLConnection();
    }

    /**
     *
     * @param type $parameters "Associative array with the SQL field and the wanted value. Ex: $parameter['id'] = 4; $parameter['email'] = 'admin@admin.com';
     */


    public function findAll() {

        $queryString = 'SELECT * FROM Transaction';

        $transactionDataList = $this->conn->directQuery($queryString);

        return $transactionDataList;
    }


}
