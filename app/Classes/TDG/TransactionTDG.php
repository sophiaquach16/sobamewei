<?php

namespace App\Classes\TDG;

use Hash;

class TransactionTDG {

    public $conn;

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

    function addTransaction($transaction, $timeStamp)//electronic item
    {

        $parameters = new \stdClass();
        $parameters->ElectronicSpec_id=$transaction->get()->ElectronicSpec_id;
        $parameters->item_id=$transaction->get()->item_id;
        $parameters->serialNumber=$transaction->get()->serialNumber;
        $parameters->timestamp=$timeStamp;
        $parameters->customer_id=$transaction->get()->customer_id;
        //dd($parameters);
        $queryString = 'INSERT INTO Transaction SET ';
        foreach ($parameters as $key => $value) {
            if ($value !== null) {
                $queryString .= $key . ' = :' . $key;
                $queryString .= ' , ';
            }
        }
//We delete the last useless ' , '
        $queryString = substr($queryString, 0, -2);
        //dd($queryString);
        return $this->conn->query($queryString, $parameters);
    }


    public function deleteTransaction($transaction){
        $queryString = 'DELETE FROM Transaction WHERE ';
        $queryString .= 'item_id' . ' = :' . 'item_id';

        $parameters = new \stdClass();
        $parameters->item_id = $transaction->get()->item_id;

        return $this->conn->query($queryString, $parameters);
    }
}
