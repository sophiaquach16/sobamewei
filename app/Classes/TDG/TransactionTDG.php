<?php
namespace App\Classes\TDG;
class TransactionTDG{
    private $conn;
    public function __construct() {
        $this->conn = new MySQLConnection();
    }

public function findAllTransactions(){

    $queryString = 'SELECT * FROM Transaction';
    $eIPurchasedDataList = $this->conn->directQuery($queryString);
    return $eIPurchasedDataList;
}

    public function findAll($userId){
        $queryString = 'SELECT *
            FROM Transaction
            WHERE ';
            $parameters = array('customer_id' => $userId);
            //For each key, (ex: id, email, etc.), we build the query
            foreach ($parameters as $key => $value)
            {
                $queryString .= $key . ' = :' . $key;
                $queryString .= ' AND ';
            }
        //We delete the last useless ' AND '
        $queryString = substr($queryString, 0, -5);
        $eIPurchasedDataList = $this->conn->query($queryString, $parameters);
        //dd($eIPurchasedDataList);
        $eIPurchasedDataListWithSpec=$this->findAllWithSpec($eIPurchasedDataList);
        //dd($eIPurchasedDataListWithSpec);
        return $eIPurchasedDataListWithSpec;
    }



}