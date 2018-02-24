<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-24
 * Time: 3:32 PM
 */

namespace app\Classes\Core;


interface iShoppingCart
{
    public function addEIToCart($ei);

    public function getEIList();

    public function setEIList($eIListData);

    public function updateEIList();

}