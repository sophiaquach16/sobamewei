<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-24
 * Time: 4:07 PM
 */

namespace app\Classes\Core;


interface iTransactionCatalog
{
    public function setTransactionList($transactionData);

    public function getTransactionByItemId($it_id);

    public function getTransactionList();

    public function getTransactionListForUser($user_id);

    public function getTransactionObjectByItemId($item_id);

    public function getTransactionsByUserIdAndTimestamp($user_id, $timestamp);
}