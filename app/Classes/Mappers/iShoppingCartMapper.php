<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 2018-02-24
 * Time: 3:05 PM
 */

namespace App\Classes\Mappers;


interface iShoppingCartMapper
{

    public function addToCart($eSId, $userId, $expiry);
    public function removeFromCart($eSId, $userId);
    public function updateEI($eI);
    public function viewCart();
}