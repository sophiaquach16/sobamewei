<?php
namespace App\Classes\TDG;
class TransactionTDG{
    private $conn;
    public function __construct() {
        $this->conn = new MySQLConnection();
    }
//    public function findAll($userId) {
//        //$queryString = 'SELECT * FROM ElectronicSpecification JOIN ElectronicType ON ElectronicType.id = ElectronicSpecification.ElectronicType_id JOIN ElectronicItem ON ElectronicSpecification.id = ElectronicItem.ElectronicSpecification_id';
//        $queryString = 'SELECT * FROM ElectronicSpecification';
//        $eSDataList = $this->conn->directQuery($queryString);
//
//        foreach ($eSDataList as &$eSData)
//        {
//            //dd($eSData);
//            $queryString = 'SELECT *
//            FROM Purchase
//            WHERE ';
//            $parameters = array('ElectronicSpec_id' => $eSData->id, 'customer_id' => $userId);
//            //For each key, (ex: id, email, etc.), we build the query
//            foreach ($parameters as $key => $value)
//            {
//                $queryString .= $key . ' = :' . $key;
//                $queryString .= ' AND ';
//            }
//            //We delete the last useless ' AND '
//            $queryString = substr($queryString, 0, -5);
//            //We send to MySQLConnection the associative array, to bind values to keys
//            //Please mind that stdClass and associative arrays are not the same data structure, althought being both based on the big family of hashtables
//            $eIPurchasedDataList = $this->conn->query($queryString, $parameters);
//            //dd($eIDataList);
//            $eSData->electronicItemsPurchased = $eIPurchasedDataList;
//        }
//        // dd($eIPurchasedDataList);
//        return $eSDataList;
//    }
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

    public function findAllWithSpec($purchaseList){
        foreach ($purchaseList as &$singleItem){
        $queryString = 'SELECT *
            FROM ELectronicSpecification
            WHERE ';
        $parameters = array('id' => $singleItem->ElectronicSpec_id);
            //For each key, (ex: id, email, etc.), we build the query
            foreach ($parameters as $key => $value)
            {
                $queryString .= $key . ' = :' . $key;
                $queryString .= ' AND ';
            }
            //We delete the last useless ' AND '
            $queryString = substr($queryString, 0, -5);
            //We send to MySQLConnection the associative array, to bind values to keys
            //Please mind that stdClass and associative arrays are not the same data structure, althought being both based on the big family of hashtables
            $eSDataList = $this->conn->query($queryString, $parameters);
            $eSDataList = json_decode(json_encode($eSDataList), true);
            //dd($eSDataList);
            foreach ($eSDataList[0] as $eachAttribute => $value){
                $singleItem->$eachAttribute = $value;
            }

        }
        return $purchaseList;


    }

}