<?php
/**
 * Created by PhpStorm.
 * User: Mel
 * Date: 2018-02-24
 * Time: 3:17 PM
 */

namespace app\Classes\Core;


interface iElectronicSpecification
{
    public function addElectronicItem($electronicItemData);

    public function deleteElectronicItem($id);

    public function getModelNumber();

    public function get();

    public function getElectronicItems();

    public function getId();

    public function getImage();

    public function reserveFirstAvailableEI($userId, $expiry);

    public function set($data);

    public function setImage($image);

    public function unsetUserAndExpiry($userId);

}