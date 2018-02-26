<?php

namespace App\Classes\TDG;

use Auth;

class ShoppingCartTDG
{

    public $conn;

    public function __construct()
    {
        $this->conn = new MySQLConnection();
    }

    /*
    function updateEI($eIId, $userId, $expiry) {
        $queryString = "UPDATE ElectronicItem SET User_id = '$userId', expiryForUser= '$expiry' WHERE id= '$eIId'";
        return $this->conn->directQuery($queryString);
    }
     */

    function updateEI($eI)
    {
      $currentExpiryDate = $eI->get()->expiryForUser;
      if ($currentExpiryDate == '') {
        $currentExpiryDate = 'NULL';
      } else {
        $currentExpiryDate = "'".$currentExpiryDate."'";
      }
      $queryString = "UPDATE ElectronicItem SET User_id = " . $eI->get()->User_id . ", expiryForUser= " . $currentExpiryDate . " WHERE id= " . $eI->get()->id;
      return $this->conn->directQuery($queryString);
    }

    function findAllEIFromUser($userId)
    {
        /*
         * SELECT left_tbl.*
  FROM left_tbl LEFT JOIN right_tbl ON left_tbl.id = right_tbl.id
  WHERE right_tbl.id IS NULL;
         */
        //dd(Auth::check());
        $queryString = "SELECT ElectronicItem.id, serialNumber, ElectronicSpecification_id, User_id, expiryForUser FROM ElectronicItem  JOIN User ON ElectronicItem.User_id = User.id WHERE User.id = " . $userId;
        $eIsData = $this->conn->directQuery($queryString);

        foreach ($eIsData as $key => $value) {
            if (strtotime($eIsData[$key]->expiryForUser) < strtotime(date("Y-m-d H:i:s"))) {
                unset($eIsData[$key]);
            }
        }
        return $eIsData;
    }
}
?>
